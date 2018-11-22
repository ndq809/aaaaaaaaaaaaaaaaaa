IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_SOCIAL_ACT1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_SOCIAL_ACT1]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_SOCIAL_ACT1]
	 @P_post_id				VARCHAR(15)		=   ''
,	 @P_my_vote				MONEY			=   0
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
	,	@w_program_id			NVARCHAR(50)		= 'Social'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Cộng đồng'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'vote'
	,	@w_average_rating		MONEY				= 0
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	--
	BEGIN TRANSACTION
	BEGIN TRY
		--
		IF NOT EXISTS(SELECT * FROM F008 WHERE F008.execute_div = 5 AND F008.execute_target_div = 5 AND F008.target_id = @P_post_id AND F008.user_id = @P_user_id)
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
			@P_post_id
		,	@P_user_id
		,	5
		,	5
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
		END
		ELSE
		BEGIN
			IF @P_my_vote <> 0
			BEGIN
			UPDATE F008 SET
				F008.upd_user	=	@P_user_id
			,	F008.upd_prg	=	@w_program_id
			,	F008.upd_ip		=	@P_ip
			,	F008.upd_date	=	@w_time
			,	F008.remark		=	@P_my_vote
			WHERE F008.target_id = @P_post_id
			AND F008.execute_div = 5
			AND F008.execute_target_div = 5
			AND F008.user_id = @P_user_id
			END
			ELSE
			BEGIN
				DELETE FROM F008
				WHERE F008.target_id = @P_post_id
			AND F008.execute_div = 5
			AND F008.execute_target_div = 5
			AND F008.user_id = @P_user_id 
			END
		END

		SELECT @w_average_rating = AVG(CONVERT(MONEY,F008.remark)) FROM F008
		WHERE F008.execute_div = 5
		AND F008.execute_target_div = 5
		AND F008.target_id = @P_post_id

		UPDATE M007 SET
			M007.post_rating = @w_average_rating
		WHERE M007.post_id = @P_post_id

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

	SELECT @w_average_rating AS average_rating

END

GO
