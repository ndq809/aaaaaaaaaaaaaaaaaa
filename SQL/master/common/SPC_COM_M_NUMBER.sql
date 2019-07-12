IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_M_NUMBER]') AND type IN (N'P', N'PC'))
BEGIN
    DROP PROCEDURE [dbo].[SPC_COM_M_NUMBER]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
--
CREATE PROCEDURE [dbo].[SPC_COM_M_NUMBER]
/****************************************************************************************************
 *
 *  �����T�v�FCOMMON
 *
 *  �쐬��  �F2018/06/22
 *  �쐬��  �FANS-ASIA BINHNN
 *
 *  �X�V��  �F
 *  �X�V��  �F
 *  �X�V���e�F
 *  EXEC SPC_COM_M_NUMBER '713','','DELIVERY','f_delivery',1,
 ****************************************************************************************************/
/*�p�����[�^*/
	@P_user_cd		NVARCHAR(8)		= 0
,	@P_terminal		NVARCHAR(64)	= ''
,	@P_agent		NVARCHAR(128)	= ''
,   @P_no_div		NVARCHAR(256)	= ''		
,   @P_count		INT		    = 0				--�̔Ԏ擾�� /
,   @O_Numbering	BIGINT      = -1 OUTPUT		--�̔Ԕԍ�/numbering number (-1:�̔Ԏ��s / -2:�ԍ��R�[�h�Ȃ� / -99:TRY-CATCH�G���[)
AS
BEGIN

    DECLARE @w_transaction int = 0 --TRANZACTION ��
	--
BEGIN TRY          --TRY�J�n
    SET NOCOUNT ON --�����s���񑗐M
	--
	SELECT @w_transaction = @@TRANCOUNT
    IF @w_transaction = 0
    BEGIN
        --�Ăяo�������� -> �g�����U�N�V�����J�n
        BEGIN TRANSACTION
    END
	--
	--�����ϐ�
    DECLARE
        @W_counterNow bigint --���ݔԍ� numbering number now
    ,   @W_counterMin bigint --�ŏ��ԍ� min numberring number
    ,   @W_counterMax bigint --�ő�ԍ� max numberring number
	--
	--�ԍ��R�[�h�̑��݃`�F�b�N / exists check
    IF NOT EXISTS(
        SELECT M888.no_div
        FROM M888
        WHERE (M888.no_div = @P_no_div)
          AND (M888.delete_time IS NULL)
    )
    BEGIN
        --�̔ԃR�[�h�񑶍� / not exists
        SELECT @W_counterNow = -2
        GOTO EXIT_SPC
    END
	--
	--������ / clear
    SELECT
        @W_counterNow = -1
    ,   @W_counterMin = 1
    ,   @W_counterMax = 1
    ,   @P_count = CASE WHEN ISNULL(@P_count, 1) < 1
                        THEN 1
                        ELSE ISNULL(@P_count, 1)
                   END
	--
	--�̔ԃ}�X�^����ԍ��擾 / get numbering number
    SELECT
        @W_counterNow = M888.present_value
    ,   @W_counterMin = M888.min_value
    ,   @W_counterMax = M888.max_value
    FROM M888
    WHERE (M888.no_div = @P_no_div)
      AND (M888.delete_time IS NULL)
	--
	--���� + ���ݔԍ��C���N�������g
    SELECT
        @W_counterNow = ISNULL(@W_counterNow, 0) + 1
    ,   @W_counterMin = CASE WHEN ISNULL(@W_counterMin, 0) < 0
                             THEN 1
                             ELSE ISNULL(@W_counterMin, 0)
                        END
    ,   @W_counterMax = ISNULL(@W_counterMax, 99999999999)
    --
	--
	--�ő�l / �ŏ��l�l��
    SELECT
        @W_counterNow = CASE WHEN (@W_counterNow < @W_counterMin) THEN @W_counterMin
                             WHEN (@W_counterNow > @W_counterMax) THEN -1
                             ELSE @W_counterNow
                        END
	--�G���[����
    IF @W_counterNow = -1
    BEGIN
        --�G���[����
        GOTO EXIT_SPC
    END
	--
	--�̔ԃ}�X�^�X�V
    UPDATE M888
    SET M888.present_value		= @W_counterNow + @P_count - 1
    ,   M888.update_user		= ISNULL(@P_user_cd,  '')
    ,   M888.update_terminal	= ISNULL(@P_terminal, '')
	,   M888.update_agent		= ISNULL(@P_agent, '')
    ,   M888.update_time		= GETDATE()
    FROM M888
    WHERE (M888.no_div = @P_no_div)
    --
EXIT_SPC:
    --
    SELECT @O_Numbering = @W_counterNow
    --
    IF @w_transaction = 0
    BEGIN
        --�Ăяo�������� -> �G���[�Ȃ� -> �R�~�b�g
        COMMIT TRANSACTION
        --ROLLBACK TRANSACTION --�f�o�b�O��
    END
END TRY
--CATCH�J�n
BEGIN CATCH
    SET @O_Numbering = -99
    --
    IF @w_transaction = 0
    BEGIN
        --�Ăяo�������� -> ���[���o�b�N
        ROLLBACK TRANSACTION
    END
END CATCH
END


GO


