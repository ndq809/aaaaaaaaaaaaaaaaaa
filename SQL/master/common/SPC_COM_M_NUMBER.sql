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
 *  処理概要：COMMON
 *
 *  作成日  ：2018/06/22
 *  作成者  ：ANS-ASIA BINHNN
 *
 *  更新日  ：
 *  更新者  ：
 *  更新内容：
 *  EXEC SPC_COM_M_NUMBER '713','','DELIVERY','f_delivery',1,
 ****************************************************************************************************/
/*パラメータ*/
	@P_user_cd		NVARCHAR(8)		= 0
,	@P_terminal		NVARCHAR(64)	= ''
,	@P_agent		NVARCHAR(128)	= ''
,   @P_no_div		NVARCHAR(256)	= ''		
,   @P_count		INT		    = 0				--採番取得数 /
,   @O_Numbering	BIGINT      = -1 OUTPUT		--採番番号/numbering number (-1:採番失敗 / -2:番号コードなし / -99:TRY-CATCHエラー)
AS
BEGIN

    DECLARE @w_transaction int = 0 --TRANZACTION 数
	--
BEGIN TRY          --TRY開始
    SET NOCOUNT ON --処理行数非送信
	--
	SELECT @w_transaction = @@TRANCOUNT
    IF @w_transaction = 0
    BEGIN
        --呼び出し元無し -> トランザクション開始
        BEGIN TRANSACTION
    END
	--
	--内部変数
    DECLARE
        @W_counterNow bigint --現在番号 numbering number now
    ,   @W_counterMin bigint --最小番号 min numberring number
    ,   @W_counterMax bigint --最大番号 max numberring number
	--
	--番号コードの存在チェック / exists check
    IF NOT EXISTS(
        SELECT M888.no_div
        FROM M888
        WHERE (M888.no_div = @P_no_div)
          AND (M888.delete_time IS NULL)
    )
    BEGIN
        --採番コード非存在 / not exists
        SELECT @W_counterNow = -2
        GOTO EXIT_SPC
    END
	--
	--初期化 / clear
    SELECT
        @W_counterNow = -1
    ,   @W_counterMin = 1
    ,   @W_counterMax = 1
    ,   @P_count = CASE WHEN ISNULL(@P_count, 1) < 1
                        THEN 1
                        ELSE ISNULL(@P_count, 1)
                   END
	--
	--採番マスタから番号取得 / get numbering number
    SELECT
        @W_counterNow = M888.present_value
    ,   @W_counterMin = M888.min_value
    ,   @W_counterMax = M888.max_value
    FROM M888
    WHERE (M888.no_div = @P_no_div)
      AND (M888.delete_time IS NULL)
	--
	--調整 + 現在番号インクリメント
    SELECT
        @W_counterNow = ISNULL(@W_counterNow, 0) + 1
    ,   @W_counterMin = CASE WHEN ISNULL(@W_counterMin, 0) < 0
                             THEN 1
                             ELSE ISNULL(@W_counterMin, 0)
                        END
    ,   @W_counterMax = ISNULL(@W_counterMax, 99999999999)
    --
	--
	--最大値 / 最小値考慮
    SELECT
        @W_counterNow = CASE WHEN (@W_counterNow < @W_counterMin) THEN @W_counterMin
                             WHEN (@W_counterNow > @W_counterMax) THEN -1
                             ELSE @W_counterNow
                        END
	--エラー検査
    IF @W_counterNow = -1
    BEGIN
        --エラーあり
        GOTO EXIT_SPC
    END
	--
	--採番マスタ更新
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
        --呼び出し元無し -> エラーなし -> コミット
        COMMIT TRANSACTION
        --ROLLBACK TRANSACTION --デバッグ時
    END
END TRY
--CATCH開始
BEGIN CATCH
    SET @O_Numbering = -99
    --
    IF @w_transaction = 0
    BEGIN
        --呼び出し元無し -> ロールバック
        ROLLBACK TRANSACTION
    END
END CATCH
END


GO


