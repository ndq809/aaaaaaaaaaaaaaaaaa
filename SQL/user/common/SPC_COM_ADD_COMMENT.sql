IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_ADD_COMMENT]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_ADD_COMMENT]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_ADD_COMMENT]

    @P_row_id				TINYINT				= 0
,	@P_screen_div			TINYINT				= 0
,   @P_target_id   			NVARCHAR(200)		= ''
,   @P_comment_text   		NTEXT				= ''
,   @P_reply_id	    		INT					= 0
,	@P_user_id				NVARCHAR(15)		= ''
,	@P_ip					NVARCHAR(50)		= '' 
,   @P_cmt_div	    		INT					= 1

AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0
	,	@w_inserted_key		BIGINT				=	0
	,	@w_notify_id		BIGINT				=	0
	,	@w_time				DATETIME2			=	SYSDATETIME()

	BEGIN TRANSACTION
	BEGIN TRY
	
	INSERT INTO F004(
			screen_div
		,	target_id
		,	reply_id
		,	cmt_content
		,	cmt_div
		,	cmt_like
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
			@P_screen_div
		,	@P_target_id
		,	IIF(@P_reply_id=0,NULL,@P_reply_id)
		,	@P_comment_text
		,	@P_cmt_div
		,	0
		,	0
		,	@P_user_id
		,	'common'
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

		SET @w_inserted_key = scope_identity()

		--thông báo cho người viết bài
		SET @w_notify_id = (SELECT TOP 1 F002.notify_id FROM F002 WHERE F002.target_id = @P_target_id AND F002.screen_div = @P_screen_div AND F002.notify_div = 1)
		IF @w_notify_id IS NULL
		BEGIN
			INSERT INTO F002(
				get_user_id
			,	target_id
			,	screen_div
			,	notify_condition
			,	notify_div
			,	notify_count
			,	del_flg
			,	cre_user
			,	cre_prg
			,	cre_ip
			,	cre_date
			)
			SELECT
				M007.cre_user
			,	@P_target_id
			,	@P_screen_div
			,	0
			,	1
			,	0
			,	0
			,	@P_user_id
			,	'common'
			,	@P_ip
			,	@w_time
			FROM M007
			WHERE M007.post_id = @P_target_id
			AND M007.cre_user <> @P_user_id
			AND M007.record_div = 2
			AND M007.post_div = 3
			AND M007.del_flg = 0
		END
		ELSE
		BEGIN
			UPDATE F002 SET
				F002.notify_count		=	F002.notify_count + 1
			,	F002.notify_condition	=	0
			,	F002.upd_user			=	@P_user_id
			,	F002.upd_prg			=	'common'
			,	F002.upd_ip				=	@P_ip
			,	F002.upd_date			=	@w_time
			WHERE
				F002.notify_id			=	@w_notify_id
			AND F002.cre_user			<>	IIF(F002.notify_condition = 0,@P_user_id,-1)
		END
		--thông báo cho người được trả lời cmt (nếu có)
		SET @w_notify_id = (SELECT TOP 1 F002.notify_id FROM F002 WHERE F002.target_id = @P_target_id AND F002.screen_div = @P_screen_div AND F002.notify_div = 2)
		IF @w_notify_id IS NULL AND @P_reply_id != ''
		BEGIN
			INSERT INTO F002(
				get_user_id
			,	target_id
			,	screen_div
			,	notify_condition
			,	notify_div
			,	notify_count
			,	del_flg
			,	cre_user
			,	cre_prg
			,	cre_ip
			,	cre_date
			)
			SELECT
				F004.cre_user
			,	@P_target_id
			,	@P_screen_div
			,	0 
			,	2
			,	0
			,	0
			,	@P_user_id
			,	'common'
			,	@P_ip
			,	@w_time
			FROM F004
			WHERE F004.comment_id = @P_reply_id
			AND F004.cre_user <> @P_user_id
			AND F004.del_flg = 0
		END
		ELSE
		BEGIN
			UPDATE F002 SET
				F002.notify_count		=	F002.notify_count + 1
			,	F002.notify_condition	=	0
			,	F002.upd_user			=	@P_user_id
			,	F002.upd_prg			=	'common'
			,	F002.upd_ip				=	@P_ip
			,	F002.upd_date			=	@w_time
			WHERE
				F002.notify_id			=	@w_notify_id
			AND F002.cre_user			<>	IIF(F002.notify_condition = 0,@P_user_id,-1)
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
	--EXEC SPC_S999_ACT1 @P_user_id,@w_program_id,@w_prs_prg_nm,@w_time,@w_mode,@w_prs_key,@w_result,@w_message

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
	SELECT
		@P_row_id AS row_id
	,	F004.comment_id		AS comment_id
	,	'' AS reply_id
	,	F004.target_id
	,	S001.account_nm AS cre_user
	,	M001.avarta
	,	M999.content AS rank
	,	F004.cmt_content
	,	F004.cmt_div
	,	F004.cmt_like
	,	FORMAT(F004.cre_date,'dd/MM/yyyy HH:mm:ss') AS cre_date
	FROM F004
	LEFT JOIN S001
	ON F004.cre_user = S001.account_id
	LEFT JOIN M001
	ON S001.user_id = M001.user_id
	LEFT JOIN M999
	ON M999.name_div = 14
	AND S001.account_div = M999.number_id
	WHERE F004.comment_id = @w_inserted_key
	--[0]
	SELECT  Id
		,	Code 
		,	Data 
		,	[Message]
	FROM @ERR_TBL
	ORDER BY Code

	SELECT
		F002.notify_id 
	,	F002.get_user_id AS get_user_code
	,	F002.notify_condition
	,	M999.text_remark1 AS notify_content
	,	M999.text_remark2 AS notify_url
	,	S001.account_nm
	,	F002.cre_date
	,	F002.notify_count
	,	M999.num_remark1 AS notify_div
	,	S003.screen_id AS screen_code
	,	F002.screen_div
	,	F002.target_id
	FROM F002
	LEFT JOIN M999
	ON M999.name_div = 21
	AND M999.number_id = F002.notify_div
	LEFT JOIN S001 
	ON S001.account_id = IIF(F002.upd_user IS NULL,F002.cre_user,F002.upd_user)
	LEFT JOIN S003
	ON S003.remark = F002.screen_div
	WHERE IIF(F002.upd_user IS NULL,F002.cre_user,F002.upd_user) = @P_user_id
	AND (F002.cre_date = @w_time OR F002.upd_date = @w_time)
END

