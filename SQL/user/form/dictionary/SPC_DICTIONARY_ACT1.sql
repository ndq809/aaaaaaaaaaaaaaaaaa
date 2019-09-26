IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_DICTIONARY_ACT1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_DICTIONARY_ACT1]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_DICTIONARY_ACT1]
	 @P_word_id				VARCHAR(15)		=   ''
,	 @P_my_vote				INT				=   0
,	 @P_user_id				VARCHAR(10)		=	''
,	 @P_ip					VARCHAR(20)		=	''
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
	,	@w_mode					NVARCHAR(20)		= 'vote-word'
	,	@w_rating				MONEY				= 0
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	--
	BEGIN TRANSACTION
	BEGIN TRY
		--
		IF NOT EXISTS(SELECT * FROM F008 WHERE F008.execute_div = 5 AND F008.execute_target_div = 6 AND F008.target_id = @P_word_id AND F008.user_id = @P_user_id)
		BEGIN
		INSERT INTO F008(
			target_id
		,	user_id
		,	execute_div
		,	execute_target_div
		,	remark
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
			@P_word_id
		,	@P_user_id
		,	5
		,	6
		,	@P_my_vote
		,	0
		,	@P_user_id
		,	@w_program_id
		,	@P_ip
		,	SYSDATETIME()
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL

		SET @w_rating = @P_my_vote
		END
		ELSE
		BEGIN
			DELETE F008 WHERE F008.execute_div = 5 AND F008.execute_target_div = 6 AND F008.target_id = @P_word_id AND F008.user_id = @P_user_id

			SET @w_rating = 0
		END

		UPDATE M006 SET
			M006.word_vote	= ISNULL(M006.word_vote,0) + @P_my_vote
		WHERE M006.id = @P_word_id

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

	SELECT 
		CONVERT(INT,M006.word_vote) AS rating 
	,	CONVERT(INT,@w_rating) AS mode
	FROM M006 
	WHERE 
		M006.id = @P_word_id
		AND M006.del_flg = 0
END

GO
