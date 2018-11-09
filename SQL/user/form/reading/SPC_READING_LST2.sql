IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_READING_LST2]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_READING_LST2]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_READING_LST2]
	
		@P_catalogue_id			NVARCHAR(15)	=	''
	,	@P_group_id				NVARCHAR(15)	=	''
	,	@P_account_id			NVARCHAR(15)	=	'' 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	CREATE TABLE #READING(
		row_id				INT
	,	post_id				INT
	,	briged_id			INT
	,	post_title			NVARCHAR(100)
	,	post_content		NVARCHAR(MAX)
	,	remembered			INT
	)

	CREATE TABLE #COMMENT(
		row_id			INT
	,	comment_id		INT
	,	reply_id		INT
	,	target_id		INT
	,	count_row_id	INT
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

	INSERT INTO #READING
	SELECT
		ROW_NUMBER() OVER(ORDER BY M007.post_id ASC) AS row_id
	,	M007.post_id
	,	M007.briged_id
	,	M007.post_title
	,	M007.post_content
	,	IIF(F003.item_1 IS NULL,0,1) AS remembered
	FROM M007
	LEFT JOIN F003
	ON M007.post_id = F003.item_1
	AND F003.connect_div = 3
	AND F003.user_id = @P_account_id
	AND F003.item_2 IS NULL
	WHERE M007.del_flg = 0
	AND M007.catalogue_div = 5
	AND M007.catalogue_id = @P_catalogue_id
	AND M007.group_id = @P_group_id

	INSERT INTO #COMMENT
	SELECT *
	FROM
	(
	SELECT
		#READING.row_id
	,	F004.comment_id	
	,	F004.reply_id
	,	F004.target_id
	,	ROW_NUMBER() OVER(partition by F004.target_id ORDER BY F004.target_id ASC) AS count_row_id
	FROM F004
	INNER JOIN #READING
	ON F004.target_id				= #READING.post_id
	AND F004.reply_id IS NULL
	AND F004.screen_div = 5
	)TEMP
	WHERE
	TEMP.count_row_id < 6

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
	,	F004.cre_user	
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
	ON F004.cre_user = S001.account_nm
	LEFT JOIN M001
	ON S001.user_id = M001.user_id
	LEFT JOIN M999
	ON M999.name_div = 14
	AND S001.account_div = M999.number_id
	WHERE F004.screen_div = 5
	)TEMP1
	WHERE TEMP1.count_row_id < 4
	
	SELECT * FROM #COMMENT_DETAIL


	INSERT INTO #PAGER
	SELECT
		MAX(#READING.row_id)	 
	,	COUNT(*)
	,	CEILING(CAST(COUNT(*) AS FLOAT) / 5)
	,	1
	,	5
	FROM F004
	INNER JOIN #READING
	ON F004.target_id				= #READING.post_id
	AND F004.reply_id IS NULL
	GROUP BY 
		F004.target_id

	SELECT * FROM #PAGER

	SELECT * FROM #READING

	SELECT
		F003.id 
	,	M002.catalogue_nm
	,	M003.group_nm
	FROM F003
	INNER JOIN M002
	ON F003.item_1 = M002.catalogue_id
	INNER JOIN M003
	ON F003.item_2 = M003.group_id
	WHERE F003.user_id = @P_account_id
	AND	F003.connect_div = 3
	AND F003.screen_div = 3
	AND F003.del_flg = 0

	SELECT
		#READING.row_id
	,	#READING.post_id
	,	M006.id
	,	M006.vocabulary_nm
	,	M006.spelling
	,	M006.mean
	FROM F009
	JOIN M006
	ON F009.target_id = M006.id
	AND F009.briged_div = 1
	INNER JOIN #READING
	ON #READING.briged_id = F009.briged_id
	ORDER BY 
	#READING.post_id

		SELECT
		M004.question_id 
	,	M004.question_content
	,	M004.question_div
	,	M005.answer_id
	,	M005.answer_content
	,	M005.verify
	,	ROW_NUMBER() OVER(partition by M004.post_id ORDER BY M004.post_id ASC) AS question_num	
	,	#READING.row_id
	FROM M004
	JOIN M005
	ON M004.question_id = M005.question_id
	JOIN #READING
	ON M004.post_id = #READING.post_id
	WHERE 
		M004.question_id IN (SELECT TOP 5 M004.question_id FROM M004 WHERE M004.post_id IN(SELECT #READING.post_id FROM #READING) ORDER BY NEWID())

END

