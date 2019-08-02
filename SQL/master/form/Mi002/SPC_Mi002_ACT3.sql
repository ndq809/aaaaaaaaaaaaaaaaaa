IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_V002_ACT3]') AND type IN (N'P', N'PC'))
DROP PROCEDURE [dbo].[SPC_V002_ACT3]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_V002_ACT3]
	 @P_vocabulary_id		INT					= 0
,    @P_vocabulary_dtl_id   INT					= 0
,    @P_vocabulary_nm     	NVARCHAR(200)		= ''
,    @P_spelling     		NVARCHAR(200)		= ''
,    @P_specialized     	INT					= 0
,    @P_field     			INT					= 0
,    @P_vocabulary_div     	INT					= 0
,    @P_image     			NVARCHAR(200)		= ''
,    @P_mean    			NVARCHAR(200)		= ''
,    @P_post_audio   		NVARCHAR(200)		= ''
,    @P_xml_detail   		XML					= ''
,	 @P_user_id				NVARCHAR(15)		= ''
,	 @P_ip					NVARCHAR(50)		= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'W002'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Thêm bài viết'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'upgrage'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''
	,	@w_inserted_dtl_key		VARCHAR(15)			= ''
	,	@w_briged_id			INT					= NULL
	,	@w_increase_id			INT					= 0

	BEGIN TRANSACTION
	BEGIN TRY
	BEGIN
		SET @w_inserted_key = (SELECT TOP 1 M006.id FROM M006 WHERE M006.vocabulary_id = @P_vocabulary_id AND M006.vocabulary_dtl_id = @P_vocabulary_dtl_id)
		SELECT @w_inserted_dtl_key= ISNULL(MAX(M006.vocabulary_dtl_id),0)+ 1 FROM M006 WHERE M006.id = @w_inserted_key
		INSERT INTO M012(
			target_id
		,	target_div
		,	language1_content
		,	language2_content
		,	clap
		,	del_flg
		,	cre_user
		,	cre_prg
		,	cre_ip
		,	cre_date
		,	upd_user
		,	upd_prg
		,	upd_ip
		,	upd_date
		,	del_user
		,	del_prg
		,	del_ip
		,	del_date

		)
		SELECT
			@w_inserted_key
		,	1
		,	language1_content		=	T.C.value('@language1_content 		', 'nvarchar(MAX)')
		,	language2_content		=	T.C.value('@language2_content 		', 'nvarchar(MAX)')
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
		FROM @P_xml_detail.nodes('row') T(C)
		IF @P_post_audio = ''
		BEGIN
			SELECT @P_post_audio = M006.audio FROM M006 WHERE M006.vocabulary_id = @P_vocabulary_id AND M006.vocabulary_dtl_id = @P_vocabulary_dtl_id
		END
		INSERT INTO M006(
			vocabulary_id
		,	vocabulary_dtl_id
		,	vocabulary_nm
		,	specialized
		,	field
		,	vocabulary_div
		,	image
		,	audio
		,	mean
		,	spelling
		,	record_div
		,	del_flg
		,	cre_user
		,	cre_prg
		,	cre_ip
		,	cre_date
		,	upd_user
		,	upd_prg
		,	upd_ip
		,	upd_date
		,	del_user
		,	del_prg
		,	del_ip
		,	del_date

		)
		SELECT
			@P_vocabulary_id
		,	@w_inserted_dtl_key
		,	@P_vocabulary_nm		
		,	@P_specialized	
		,	@P_field	
		,	@P_vocabulary_div		
		,	@P_image
		,	@P_post_audio
		,	@P_mean				
		,	@P_spelling			
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

	END
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
	--[1]
	SELECT 
		@P_vocabulary_id		AS vocabulary_id
	,	@w_inserted_dtl_key AS vocabulary_dtl_id
	
END
GO
