IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_TRANSLATION_ACT2]') AND type IN (N'P', N'PC'))
DROP PROCEDURE [dbo].[SPC_TRANSLATION_ACT2]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_TRANSLATION_ACT2]
	 @P_post_id		        NVARCHAR(15)		= ''
,	 @P_user_id				NVARCHAR(15)		= ''
,	 @P_ip					NVARCHAR(50)		= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'translation'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'phiên dịch'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'delete'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''
	,	@w_briged_id			VARCHAR(15)			= ''

	BEGIN TRANSACTION
	BEGIN TRY

	UPDATE F010 SET
		F010.del_user	=	@P_user_id
	,	F010.del_prg	=	@w_program_id
	,	F010.del_ip		=	@P_ip
	,	F010.del_date	=	@w_time
	,	F010.del_flg	=	1
	WHERE F010.post_id = @P_post_id

	UPDATE F011 SET
		F011.del_user	=	@P_user_id
	,	F011.del_prg	=	@w_program_id
	,	F011.del_ip		=	@P_ip
	,	F011.del_date	=	@w_time
	,	F011.del_flg	=	1
	WHERE F011.post_id = @P_post_id
	END TRY
	BEGIN CATCH
		DELETE FROM @ERR_TBL
		INSERT INTO @ERR_TBL
			SELECT	
				0
			,	ERROR_NUMBER()
			,	'Exception'
			,	'Error'                                                          + CHAR(13) + CHAR(10) +
				'Procedure : ' + ISNULL(ERROR_PROCEDURE(), '???')                + CHAR(13) + CHAR(10) +
				'Line : '      + ISNULL(CAST(ERROR_LINE() AS NVARCHAR(10)), '0') + CHAR(13) + CHAR(10) +
				'Message : '   + ISNULL(ERROR_MESSAGE(), 'An unexpected error occurred.')
	END CATCH
EXIT_SPC:
	--INSERT S999
	EXEC SPC_S999_ACT1 @P_user_id,@w_program_id,@w_prs_prg_nm,@w_time,@w_mode,@w_prs_key,@w_result,@w_message

	--
	IF EXISTS(SELECT 1 FROM @ERR_TBL AS ERR_TBL WHERE ERR_TBL.Data = 'Exception')
	BEGIN
		IF @@TRANCOUNT >0
		BEGIN
			ROLLBACK TRANSACTION
		END
	END
	ELSE
	BEGIN
		COMMIT TRANSACTION
	END
	--[0]

	SELECT  Id
		,	Code 
		,	Data 
		,	[Message]
	FROM @ERR_TBL
	ORDER BY Code
END
GO
