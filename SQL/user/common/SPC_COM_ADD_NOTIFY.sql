IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_ADD_NOTIFY]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_ADD_NOTIFY]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_ADD_NOTIFY]

	@P_screen_div			TINYINT				= 0
,   @P_target_id   			INT					= 0
,   @P_target_dtl_id    	INT					= 0
,   @P_notify_type	    	INT					= 1
,	@P_user_id				NVARCHAR(15)		= ''
,	@P_ip					NVARCHAR(50)		= '' 

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

	CREATE TABLE #NOTIFY(
		notify_id INT
	)
	--thông báo của comment
	IF @P_notify_type = 1
	BEGIN
		--thông báo cho người viết bài
		SET @w_notify_id = (SELECT TOP 1 F002.notify_id FROM F002 WHERE F002.target_id = @P_target_id AND F002.screen_div = @P_screen_div AND F002.notify_div = 1)
		IF @w_notify_id IS NULL
		BEGIN
			INSERT INTO F002 OUTPUT inserted.notify_id INTO #NOTIFY
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
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
			,	NULL
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
				F002.notify_count		=	temp.notify_count
			,	F002.notify_condition	=	0
			,	F002.upd_user			=	IIF(@P_user_id <> temp.cre_user,@P_user_id,F002.upd_user)
			,	F002.upd_prg			=	'common'
			,	F002.upd_ip				=	@P_ip
			,	F002.upd_date			=	@w_time
			OUTPUT inserted.notify_id INTO #NOTIFY
			FROM 
			(
				SELECT MAX(M007.cre_user) AS cre_user, (COUNT(DISTINCT F004.cre_user)-1) AS notify_count FROM F004
				INNER JOIN M007
				ON M007.post_id = F004.target_id
				WHERE F004.target_id = @P_target_id
				AND F004.reply_id IS NULL
				AND F004.cre_user <> M007.cre_user
				
			 ) AS temp
			WHERE 
			F002.notify_id = @w_notify_id
			
		END
		--thông báo cho người được trả lời cmt (nếu có)
		SET @w_notify_id = (SELECT TOP 1 F002.notify_id FROM F002 WHERE F002.target_id = @P_target_dtl_id AND F002.screen_div = @P_screen_div AND F002.notify_div = 2)
		IF @w_notify_id IS NULL AND @P_target_dtl_id != ''
		BEGIN
			INSERT INTO F002 OUTPUT inserted.notify_id INTO #NOTIFY
			SELECT
				F004.cre_user
			,	@P_target_dtl_id
			,	@P_screen_div
			,	0 
			,	2
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
			FROM F004
			WHERE F004.comment_id = @P_target_dtl_id
			AND F004.cre_user <> @P_user_id
			AND F004.del_flg = 0
		END
		ELSE
		BEGIN
			UPDATE F002 SET
				F002.notify_count		=	temp.notify_count
			,	F002.notify_condition	=	0
			,	F002.upd_user			=	IIF(@P_user_id <> temp.cre_user,@P_user_id,F002.upd_user)
			,	F002.upd_prg			=	'common'
			,	F002.upd_ip				=	@P_ip
			,	F002.upd_date			=	@w_time
			OUTPUT inserted.notify_id INTO #NOTIFY
			FROM 
			(
				SELECT MAX(_F004.cre_user) AS cre_user, (COUNT(DISTINCT F004.cre_user)-1) AS notify_count FROM F004
				INNER JOIN F004 _F004
				ON F004.reply_id = _F004.comment_id
				WHERE F004.target_id = @P_target_id
				AND F004.reply_id = @P_target_dtl_id
				AND F004.cre_user <> _F004.cre_user
				
			 ) AS temp
			WHERE 
			F002.notify_id = @w_notify_id
		END
	END

	--thông báo của like
	IF @P_notify_type = 2
	BEGIN
		SET @w_notify_id = (SELECT TOP 1 F002.notify_id FROM F002 WHERE F002.target_id = @P_target_id AND F002.screen_div = @P_screen_div AND F002.notify_div = 3)
		IF @w_notify_id IS NULL
		BEGIN
			INSERT INTO F002 OUTPUT inserted.notify_id INTO #NOTIFY
			SELECT
				F004.cre_user
			,	@P_target_id
			,	@P_screen_div
			,	0 
			,	3
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
			FROM F004
			WHERE F004.comment_id = @P_target_id
			AND F004.cre_user <> @P_user_id
			AND F004.del_flg = 0
		END
		ELSE
		BEGIN
			UPDATE F002 SET
				F002.notify_count		=	temp.notify_count
			,	F002.notify_condition	=	0
			,	F002.upd_user			=	temp.newest_user
			,	F002.upd_prg			=	'common'
			,	F002.upd_ip				=	@P_ip
			,	F002.upd_date			=	@w_time
			OUTPUT inserted.notify_id INTO #NOTIFY
			FROM 
			(
				SELECT MAX(F008.cre_user) AS newest_user,MAX(F004.cre_user) AS cre_user, (COUNT(DISTINCT F008.cre_user)-1) AS notify_count FROM F008
				INNER JOIN F004
				On F004.comment_id = F008.target_id
				WHERE F008.target_id = @P_target_id
				AND F008.execute_div = 3
				AND F008.execute_target_div = 3
				AND F008.cre_user <> F004.cre_user
			 ) AS temp
			WHERE 
			F002.notify_id = @w_notify_id
		END
		GOTO EXIT_SPC
	END

	--thông báo của vote up/down
	IF @P_notify_type = 3
	BEGIN
		GOTO EXIT_SPC
	END

	--thông báo của vỗ tay
	IF @P_notify_type = 4
	BEGIN
		SET @w_notify_id = (SELECT TOP 1 F002.notify_id FROM F002 WHERE F002.target_id = @P_target_id AND F002.screen_div = @P_screen_div AND F002.notify_div = 4)
		IF @w_notify_id IS NULL
		BEGIN
			INSERT INTO F002 OUTPUT inserted.notify_id INTO #NOTIFY
			SELECT
				M012.cre_user
			,	@P_target_id
			,	@P_screen_div
			,	0 
			,	4
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
			FROM M012
			WHERE M012.example_id = @P_target_id
			AND M012.cre_user <> @P_user_id
			AND M012.del_flg = 0
		END
		ELSE
		BEGIN
			UPDATE F002 SET
				F002.notify_count		=	temp.notify_count
			,	F002.notify_condition	=	0
			,	F002.upd_user			=	temp.newest_user
			,	F002.upd_prg			=	'common'
			,	F002.upd_ip				=	@P_ip
			,	F002.upd_date			=	@w_time
			OUTPUT inserted.notify_id INTO #NOTIFY
			FROM 
			(
				SELECT MAX(F008.cre_user) AS newest_user,MAX(M012.cre_user) AS cre_user, (COUNT(DISTINCT F008.cre_user)-1) AS notify_count FROM F008
				INNER JOIN M012
				On M012.example_id = F008.target_id
				WHERE F008.target_id = @P_target_id
				AND F008.execute_div = 1
				AND F008.execute_target_div IN(1,2)
				AND F008.cre_user <> M012.cre_user
			 ) AS temp
			WHERE 
			F002.notify_id = @w_notify_id
		END
		GOTO EXIT_SPC
	END

	--thông báo của đánh giá tăng
	IF @P_notify_type = 5
	BEGIN
		GOTO EXIT_SPC
	END

	--thông báo của góp ý học tập
	IF @P_notify_type = 6
	BEGIN
		GOTO EXIT_SPC
	END

	--thông báo của thêm ví dụ
	IF @P_notify_type = 7
	BEGIN
		GOTO EXIT_SPC
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
	INNER JOIN #NOTIFY
	ON #NOTIFY.notify_id = F002.notify_id

	SELECT 
		S003.screen_id AS screen_code
	,	IIF(@P_target_dtl_id <> '',@P_target_dtl_id,@P_target_id) AS target_id
	FROM S003
	WHERE S003.remark = @P_screen_div
	AND S003.del_flg = 0
END

