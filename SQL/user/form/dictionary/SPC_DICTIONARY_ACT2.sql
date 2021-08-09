IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_DICTIONARY_ACT2]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_DICTIONARY_ACT2]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_DICTIONARY_ACT2]
	 @P_word_id				NVARCHAR(15)		=   ''
,	 @P_engword				NVARCHAR(MAX)		=   ''
,	 @P_word_spelling		NVARCHAR(150)		=   ''
,	 @P_word_mean			NVARCHAR(MAX)		=   ''
,	 @P_word_image			NVARCHAR(250)		=   ''
,	 @P_word_audio			NVARCHAR(250)		=   ''
,	 @P_user_id				VARCHAR(10)			=	''
,	 @P_ip					VARCHAR(20)			=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			=  SYSDATETIME()
	,   @w_prs_user_id			VARCHAR(6)			= @P_user_id
	,	@w_program_id			NVARCHAR(50)		= 'DICTONARY'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Từ điển'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'add-word'
	,	@w_id					INT					= 0
	,	@w_dtl_id				INT					= 0
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	--
	BEGIN TRANSACTION
	BEGIN TRY
		--
		SET @w_id = (SELECT M006.vocabulary_id FROM M006 WHERE M006.id = @P_word_id)
		SET @w_dtl_id = (SELECT MAX(M006.vocabulary_dtl_id) FROM M006 WHERE M006.vocabulary_id = @w_id GROUP BY M006.vocabulary_id)

		INSERT INTO M006
		SELECT 
			@w_id
		,	@w_dtl_id + 1
		,	@P_engword
		,	0
		,	999
		,	0
		,	@P_word_image
		,	@P_word_audio
		,	@P_word_mean
		,	@P_word_spelling
		,	0
		,	0
		,	0
		,	@P_user_id
		,	@w_program_id
		,	@P_ip
		,	@w_time
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL


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
	--
COMPLETE_QUERY:
	EXEC SPC_S999_ACT1 @P_user_id,@w_program_id,@w_prs_prg_nm,@w_time,@w_mode,@w_prs_key,@w_result,@w_message

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
