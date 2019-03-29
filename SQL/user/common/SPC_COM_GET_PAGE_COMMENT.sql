IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_GET_PAGE_COMMENT]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_GET_PAGE_COMMENT]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_GET_PAGE_COMMENT]
		@P_row_id				INT	=	0
	,	@P_screen_div			INT	=	0
	,	@P_target_id			INT	=	0
	,	@P_page					INT	=	0
	,	@P_account_id			NVARCHAR(15)	=	'' 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	CREATE TABLE #COMMENT(
		row_id			INT
	,	comment_id		INT
	,	reply_id		INT
	,	target_id		INT
	)

	CREATE TABLE #COMMENT_DETAIL(
		row_id			INT
	,	comment_id		INT
	,	link_id			INT
	,	reply_id		INT
	,	target_id		INT
	,	cre_user		NVARCHAR(50)
	,	avarta			NVARCHAR(1000)
	,	rank			NVARCHAR(50)
	,	cmt_content		NTEXT
	,	cmt_div			INT
	,	cmt_like		INT
	,	count_row_id	INT
	,	effected		INT
	,	cre_date		NVARCHAR(50)
	,	load_more		INT
	)

	CREATE TABLE #PAGER(
		row_id			INT
	,	totalRecord		INT
	,	pageMax			INT
	,	page			INT
	,	pagesize		INT
	)

	INSERT INTO #COMMENT
	SELECT
		@P_row_id
	,	F004.comment_id	
	,	F004.reply_id
	,	F004.target_id
	FROM F004
	WHERE 
	F004.target_id				= @P_target_id
	AND F004.reply_id IS NULL
	AND F004.screen_div = @P_screen_div
	ORDER BY
	F004.comment_id
	OFFSET (@P_page-1) * 5 ROWS
	FETCH NEXT 5 ROWS ONLY
	

	INSERT INTO #COMMENT_DETAIL
	SELECT 
		* 
	FROM
	(
	SELECT
		TEMP2.row_id
	,	F004.comment_id
	,	IIF(F004.reply_id IS NULL,TEMP2.comment_id,F004.reply_id) AS link_id	
	,	F004.reply_id	
	,	F004.target_id	
	,	S001.account_nm AS cre_user	
	,	M001.avarta
	,	M999.content AS rank	
	,	F004.cmt_content	
	,	F004.cmt_div		
	,	F004.cmt_like
	,	ROW_NUMBER() OVER(partition by IIF(F004.reply_id IS NULL,TEMP2.comment_id,F004.reply_id) ORDER BY IIF(F004.reply_id IS NULL,TEMP2.comment_id,F004.reply_id) ASC) AS count_row_id	
	,	IIF(F008.target_id IS NULL,0,1) AS effected
	,	FORMAT(F004.cre_date,'dd/MM/yyyy HH:mm:ss') AS cre_date
	,	TEMP2.comment_count AS load_more	
	FROM F004
	INNER JOIN 
	(SELECT
		#COMMENT.row_id
	,	#COMMENT.comment_id
	,	COUNT(*) AS comment_count
	FROM #COMMENT
	INNER JOIN F004
	ON #COMMENT.comment_id = F004.reply_id
	OR #COMMENT.comment_id = F004.comment_id
	GROUP BY
		#COMMENT.row_id 
	,	#COMMENT.comment_id
	,	#COMMENT.reply_id
	)TEMP2
	ON
	TEMP2.comment_id = F004.reply_id
	OR TEMP2.comment_id = F004.comment_id
	LEFT JOIN F008
	ON F004.comment_id = F008.target_id
	AND F008.user_id = @P_account_id
	AND F008.execute_div = 3
	AND F008.execute_target_div = 3
	LEFT JOIN S001
	ON F004.cre_user = S001.account_id
	LEFT JOIN M001
	ON S001.user_id = M001.user_id
	LEFT JOIN M999
	ON M999.name_div = 14
	AND S001.account_div = M999.number_id
	WHERE
	F004.screen_div = @P_screen_div
	)TEMP1
	WHERE TEMP1.count_row_id < 4
	
	SELECT * FROM #COMMENT_DETAIL

	SELECT
		@P_row_id AS row_id	 
	,	COUNT(*) AS totalRecord
	,	CEILING(CAST(COUNT(*) AS FLOAT) / 5) AS pageMax
	,	@P_page AS page
	,	5 AS pagesize
	FROM F004
	WHERE
		F004.target_id				= @P_target_id
	AND F004.reply_id IS NULL
	GROUP BY 
		F004.target_id
END

