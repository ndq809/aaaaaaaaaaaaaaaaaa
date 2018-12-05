﻿IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_RELAX_LST2]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_RELAX_LST2]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_RELAX_LST2]
	
		@P_post_id				NVARCHAR(15)	=	''
	,	@P_loadtime				INT				=	1 
	,	@P_post_type			INT				=	7 
	,	@P_tag_list				XML				=	'' 
	,	@P_account_id			NVARCHAR(15)	=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0
	,	@tagcount			INT					=	0
	,	@record_count		INT					=	0

	CREATE TABLE #RELAX(
		row_id				INT
	,	post_id				INT
	,	briged_id			INT
	,	post_title			NVARCHAR(100)
	,	post_content		NVARCHAR(MAX)
	,	post_media			NVARCHAR(MAX)
	,	post_media_div		NVARCHAR(50)
	,	post_member			NVARCHAR(50)
	,	post_rate			MONEY
	,	my_rate				MONEY
	,	post_view			INT
	,	cre_date			DATETIME2
	,	edit_date			DATETIME2
	,	post_type			INT
	)

	CREATE TABLE #COMMENT(
		row_id			INT
	,	comment_id		INT
	,	reply_id		INT
	,	target_id		INT
	,	count_row_id	INT
	)

	CREATE TABLE #TAG(
		tag_id			INT
	)

	CREATE TABLE #BRIGED(
		briged_id			INT
	,	tagcount			INT
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
	IF @P_post_id <> ''
	BEGIN
		INSERT INTO #TAG
		SELECT F009.target_id
		FROM M007
		INNER JOIN F009
		ON M007.briged_id = F009.briged_id
		AND F009.briged_div = 2
		WHERE M007.post_id = @P_post_id
	END
	ELSE
	BEGIN
		INSERT INTO #TAG
		SELECT
		tag_id						=	T.C.value('@tag_id 	  ', 'nvarchar(15)')
		FROM @P_tag_list.nodes('row') T(C)
	END


	IF NOT EXISTS (SELECT * FROM #TAG)
	BEGIN
		INSERT INTO #RELAX
		SELECT
			ROW_NUMBER() OVER(ORDER BY M007.post_id ASC) AS row_id
		,	M007.post_id
		,	M007.briged_id
		,	M007.post_title
		,	M007.post_content
		,	M007.post_media
		,	CASE M007.media_div
			WHEN 3 THEN 'video/youtube'
			WHEN 4 THEN 'video/facebook'
			ELSE 'video'
			END
		,	M007.cre_user
		,	M007.post_rating
		,	IIF(_F008.excute_id IS NULL,'0',_F008.remark)
		,	M007.post_view
		,	F008.cre_date
		,	M007.upd_date
		,	CASE M007.catalogue_div
				WHEN 7 THEN 4
				WHEN 8 THEN 5
				WHEN 9 THEN 6
			END AS post_type
		FROM M007
		INNER JOIN F008
		ON M007.post_id = F008.target_id
		AND execute_div = 4
		AND execute_target_div = 5
		LEFT JOIN F008 _F008
		ON	_F008.execute_div = 5
		AND _F008.execute_target_div = 5
		AND _F008.target_id = M007.post_id
		AND _F008.user_id = @P_account_id
		WHERE M007.del_flg = 0
		AND M007.catalogue_div IN (7,8,9)
		ORDER BY M007.upd_date DESC
		OFFSET 0 ROWS
		FETCH NEXT (@P_loadtime * 20) ROWS ONLY

		SELECT
			@record_count = COUNT(*)
		FROM M007
		INNER JOIN F008
		ON M007.post_id = F008.target_id
		AND execute_div = 4
		AND execute_target_div = 5
		LEFT JOIN F008 _F008
		ON	_F008.execute_div = 5
		AND _F008.execute_target_div = 5
		AND _F008.target_id = M007.post_id
		AND _F008.user_id = @P_account_id
		WHERE M007.del_flg = 0
		AND M007.catalogue_div = @P_post_type

	END
	ELSE
	BEGIN
		SET @tagcount = (SELECT COUNT(*) FROM #TAG)

		INSERT INTO #BRIGED
		SELECT
			F009.briged_id
		,	COUNT(F009.briged_id) AS tagcount
		FROM F009
		LEFT JOIN #TAG
		ON F009.target_id = #TAG.tag_id
		WHERE F009.briged_div = 2
		AND #TAG.tag_id IS NOT NULL
		GROUP BY F009.briged_id

		INSERT INTO #RELAX
		SELECT
			ROW_NUMBER() OVER(ORDER BY M007.post_id ASC) AS row_id
		,	M007.post_id
		,	M007.briged_id
		,	M007.post_title
		,	M007.post_content
		,	M007.post_media
		,	CASE M007.media_div
			WHEN 3 THEN 'video/youtube'
			WHEN 4 THEN 'video/facebook'
			ELSE 'video'
			END
		,	M007.cre_user
		,	M007.post_rating
		,	IIF(_F008.excute_id IS NULL,'0',_F008.remark)
		,	M007.post_view
		,	F008.cre_date
		,	M007.upd_date
		--use 4,5,6 to know what tag div of post
		,	CASE M007.catalogue_div
				WHEN 7 THEN 4
				WHEN 8 THEN 5
				WHEN 9 THEN 6
			END AS post_type
		FROM M007
		INNER JOIN F008
		ON M007.post_id = F008.target_id
		AND execute_div = 4
		AND execute_target_div = 5
		LEFT JOIN F008 _F008
		ON	_F008.execute_div = 5
		AND _F008.execute_target_div = 5
		AND _F008.target_id = M007.post_id
		AND _F008.user_id = @P_account_id
		INNER JOIN #BRIGED
		ON M007.briged_id = #BRIGED.briged_id
		LEFT JOIN F003
		ON M007.post_id = F003.item_1
		AND F003.connect_div = 3
		AND F003.user_id = @P_account_id
		AND F003.item_2 IS NULL
		WHERE M007.del_flg = 0
		AND M007.catalogue_div IN (7,8,9)
		ORDER BY 
		CASE
		WHEN #BRIGED.tagcount = @tagcount THEN 1
		WHEN #BRIGED.tagcount > @tagcount THEN 2
		ELSE 3
		END
		OFFSET 0 ROWS
		FETCH NEXT (@P_loadtime * 20) ROWS ONLY

		SELECT
			@record_count = COUNT(*)
		FROM M007
		INNER JOIN F008
		ON M007.post_id = F008.target_id
		AND execute_div = 4
		AND execute_target_div = 5
		LEFT JOIN F008 _F008
		ON	_F008.execute_div = 5
		AND _F008.execute_target_div = 5
		AND _F008.target_id = M007.post_id
		AND _F008.user_id = @P_account_id
		INNER JOIN #BRIGED
		ON M007.briged_id = #BRIGED.briged_id
		WHERE M007.del_flg = 0
		AND M007.catalogue_div = @P_post_type
	END
	INSERT INTO #COMMENT
	SELECT *
	FROM
	(
	SELECT
		#RELAX.row_id
	,	F004.comment_id	
	,	F004.reply_id
	,	F004.target_id
	,	ROW_NUMBER() OVER(partition by F004.target_id ORDER BY F004.target_id ASC) AS count_row_id
	FROM F004
	INNER JOIN #RELAX
	ON F004.target_id				= #RELAX.post_id
	AND F004.reply_id IS NULL
	AND F004.screen_div = 7
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
	WHERE F004.screen_div = 7
	)TEMP1
	WHERE TEMP1.count_row_id < 4
	
	SELECT * FROM #COMMENT_DETAIL


	INSERT INTO #PAGER
	SELECT
		MAX(#RELAX.row_id)	 
	,	COUNT(*)
	,	CEILING(CAST(COUNT(*) AS FLOAT) / 5)
	,	1
	,	5
	FROM F004
	INNER JOIN #RELAX
	ON F004.target_id				= #RELAX.post_id
	AND F004.reply_id IS NULL
	GROUP BY 
		F004.target_id

	SELECT * FROM #PAGER

	SELECT * FROM #RELAX

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
	AND F003.screen_div = 7
	AND F003.del_flg = 0

	SELECT
		#RELAX.row_id
	,	#RELAX.post_id
	,	M006.id
	,	M006.vocabulary_nm
	,	M006.spelling
	,	M006.mean
	FROM F009
	JOIN M006
	ON F009.target_id = M006.id
	AND F009.briged_div = 1
	INNER JOIN #RELAX
	ON #RELAX.briged_id = F009.briged_id
	ORDER BY 
	#RELAX.post_id

		SELECT
		M004.question_id 
	,	M004.question_content
	,	M004.question_div
	,	M005.answer_id
	,	M005.answer_content
	,	M005.verify
	,	ROW_NUMBER() OVER(partition by M004.post_id ORDER BY M004.post_id ASC) AS question_num	
	,	#RELAX.row_id
	FROM M004
	JOIN M005
	ON M004.question_id = M005.question_id
	JOIN #RELAX
	ON M004.post_id = #RELAX.post_id
	WHERE 
		M004.question_id IN (SELECT TOP 5 M004.question_id FROM M004 WHERE M004.post_id IN(SELECT #RELAX.post_id FROM #RELAX) ORDER BY NEWID())

	SELECT
		#RELAX.row_id
	,	M013.tag_id
	,	M013.tag_nm
	FROM M013
	LEFT JOIN F009
	ON F009.target_id = M013.tag_id
	AND F009.briged_div = 2
	INNER JOIN #RELAX 
	ON F009.briged_id = #RELAX.briged_id
	WHERE M013.del_flg = 0
	AND M013.tag_div = #RELAX.post_type

	SELECT IIF(@record_count <= @P_loadtime * 20,1,0) AS is_end

END
