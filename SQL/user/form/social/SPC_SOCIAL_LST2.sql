IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_SOCIAL_LST2]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_SOCIAL_LST2]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_SOCIAL_LST2]
	
		@P_post_id				NVARCHAR(15)	=	''
	,	@P_loadtime				INT				=	1 
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

	CREATE TABLE #SOCIAL(
		row_id				INT
	,	row_count			INT
	,	post_id				INT
	,	briged_id			INT
	,	post_title			NVARCHAR(100)
	,	post_content		NVARCHAR(MAX)
	,	post_member			NVARCHAR(50)
	,	post_rate			MONEY
	,	my_rate				MONEY
	,	post_view			INT
	,	cre_date			DATETIME2
	,	edit_date			DATETIME2
	,	remembered			INT
	,	del_flg				INT
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
		AND M007.record_div = 2
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
		INSERT INTO #SOCIAL
		SELECT * FROM(
			SELECT
				ROW_NUMBER() OVER(ORDER BY M007.post_id ASC) AS row_id
			,	ROW_NUMBER() OVER(PARTITION BY M007.catalogue_div 
					ORDER BY 
					CASE
					WHEN M007.post_id = @P_post_id THEN 1
					END,M007.upd_date DESC) AS row_count
			,	M007.post_id
			,	M007.briged_id
			,	M007.post_title
			,	M007.post_content
			,	S001.account_nm AS cre_user
			,	M007.post_rating
			,	IIF(_F008.excute_id IS NULL,'0',_F008.remark) AS my_rate
			,	M007.post_view
			,	F008.cre_date
			,	M007.upd_date
			,	IIF(F003.item_1 IS NULL,0,1) AS remembered
			,	M007.del_flg
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
			LEFT JOIN F003
			ON M007.post_id = F003.item_1
			AND F003.connect_div = 3
			AND F003.user_id = @P_account_id
			AND F003.item_2 IS NULL
			LEFT JOIN S001 
			ON S001.account_id = M007.cre_user
			WHERE 0 =
			CASE 
				WHEN F003.item_1 IS NULL THEN M007.del_flg
				ELSE 0
			END
			AND M007.catalogue_div = 4
			AND M007.post_div = 2
			AND M007.record_div = 2
			AND F003.item_1 IS NULL
		)TEMP WHERE (TEMP.row_count <= 20 * @P_loadtime)

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
		LEFT JOIN F003
		ON M007.post_id = F003.item_1
		AND F003.connect_div = 3
		AND F003.user_id = @P_account_id
		AND F003.item_2 IS NULL
		WHERE 0 =
			CASE 
				WHEN F003.item_1 IS NULL THEN M007.del_flg
				ELSE 0
			END
		AND M007.catalogue_div = 4
		AND M007.post_div = 2
		AND M007.record_div = 2
		AND F003.item_1 IS NULL

		INSERT INTO #SOCIAL
		SELECT * FROM(
			SELECT
				ROW_NUMBER() OVER(ORDER BY M007.post_id ASC) AS row_id
			,	ROW_NUMBER() OVER(PARTITION BY M007.catalogue_div 
					ORDER BY 
					CASE
					WHEN M007.post_id = @P_post_id THEN 1
					END,M007.upd_date DESC) AS row_count
			,	M007.post_id
			,	M007.briged_id
			,	M007.post_title
			,	M007.post_content
			,	S001.account_nm AS cre_user
			,	M007.post_rating
			,	IIF(_F008.excute_id IS NULL,'0',_F008.remark) AS my_rate
			,	M007.post_view
			,	F008.cre_date
			,	M007.upd_date
			,	IIF(F003.item_1 IS NULL,0,1) AS remembered
			,	M007.del_flg
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
			LEFT JOIN F003
			ON M007.post_id = F003.item_1
			AND F003.connect_div = 3
			AND F003.user_id = @P_account_id
			AND F003.item_2 IS NULL
			LEFT JOIN S001 
			ON S001.account_id = M007.cre_user
			WHERE 0 =
			CASE 
				WHEN F003.item_1 IS NULL THEN M007.del_flg
				ELSE 0
			END
			AND M007.catalogue_div = 4
			AND M007.post_div = 2
			AND M007.record_div = 2
			AND F003.item_1 IS NOT NULL
		)TEMP WHERE (TEMP.row_count <= 20 * @P_loadtime)

		UPDATE temp
		SET temp.row_id = temp.new_row_id
		FROM (
		  SELECT #SOCIAL.row_id, ROW_NUMBER() OVER(ORDER BY #SOCIAL.row_id ASC) AS new_row_id
		  FROM #SOCIAL
		  ) temp
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

		INSERT INTO #SOCIAL
		SELECT * FROM (
		SELECT
			ROW_NUMBER() OVER(ORDER BY M007.post_id ASC) AS row_id
		,	ROW_NUMBER() OVER(PARTITION BY M007.catalogue_div 
				ORDER BY 
				CASE
				WHEN M007.post_id = @P_post_id THEN 1
				WHEN #BRIGED.tagcount = @tagcount THEN 2
				WHEN #BRIGED.tagcount > @tagcount THEN 3
				ELSE 4
				END) AS row_count
		,	M007.post_id
		,	M007.briged_id
		,	M007.post_title
		,	M007.post_content
		,	S001.account_nm AS cre_user
		,	M007.post_rating
		,	IIF(_F008.excute_id IS NULL,'0',_F008.remark) AS my_rate
		,	M007.post_view
		,	F008.cre_date
		,	M007.upd_date
		,	IIF(F003.item_1 IS NULL,0,1) AS remembered
		,	M007.del_flg
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
		LEFT JOIN S001 
		ON S001.account_id = M007.cre_user
		WHERE 0 =
			CASE 
				WHEN F003.item_1 IS NULL THEN M007.del_flg
				ELSE 0
			END
		AND M007.catalogue_div = 4
		AND M007.post_div = 2
		AND M007.record_div = 2
		)TEMP WHERE (TEMP.row_count <= 20 * @P_loadtime)

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
		LEFT JOIN F003
		ON M007.post_id = F003.item_1
		AND F003.connect_div = 3
		AND F003.user_id = @P_account_id
		AND F003.item_2 IS NULL
		WHERE 0 =
			CASE 
				WHEN F003.item_1 IS NULL THEN M007.del_flg
				ELSE 0
			END
		AND M007.catalogue_div = 4
		AND M007.post_div = 2
		AND M007.record_div = 2

	END

	INSERT INTO #COMMENT
	SELECT *
	FROM
	(
	SELECT
		#SOCIAL.row_id
	,	F004.comment_id	
	,	F004.reply_id
	,	F004.target_id
	,	ROW_NUMBER() OVER(partition by F004.target_id ORDER BY F004.target_id ASC) AS count_row_id
	FROM F004
	INNER JOIN #SOCIAL
	ON F004.target_id				= #SOCIAL.post_id
	AND F004.reply_id IS NULL
	AND F004.screen_div = 6
	AND F004.cmt_div = 1
	)TEMP
	WHERE
	TEMP.count_row_id < 6

	INSERT INTO #COMMENT
	SELECT *
	FROM
	(
	SELECT
		#SOCIAL.row_id
	,	F004.comment_id	
	,	F004.reply_id
	,	F004.target_id
	,	ROW_NUMBER() OVER(partition by F004.target_id ORDER BY F004.target_id ASC) AS count_row_id
	FROM F004
	INNER JOIN #SOCIAL
	ON F004.target_id				= #SOCIAL.post_id
	AND F004.reply_id IS NULL
	AND F004.screen_div = 6
	AND F004.cmt_div = 2
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
	,	S001.account_nm AS　cre_user	
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
	WHERE F004.screen_div = 6
	)TEMP1
	WHERE TEMP1.count_row_id < 4
	
	SELECT * FROM #COMMENT_DETAIL


	INSERT INTO #PAGER
	SELECT
		MAX(#SOCIAL.row_id)	 
	,	COUNT(*)
	,	CEILING(CAST(COUNT(*) AS FLOAT) / 5)
	,	1
	,	5
	FROM F004
	INNER JOIN #SOCIAL
	ON F004.target_id				= #SOCIAL.post_id
	AND F004.reply_id IS NULL
	AND F004.cmt_div = 1
	AND F004.screen_div = 6
	GROUP BY 
		F004.target_id

	INSERT INTO #PAGER
	SELECT
		MAX(#SOCIAL.row_id)	 
	,	COUNT(*)
	,	CEILING(CAST(COUNT(*) AS FLOAT) / 5)
	,	1
	,	5
	FROM F004
	INNER JOIN #SOCIAL
	ON F004.target_id				= #SOCIAL.post_id
	AND F004.reply_id IS NULL
	AND F004.cmt_div = 2
	AND F004.screen_div = 6
	GROUP BY 
		F004.target_id

	SELECT * FROM #PAGER

	SELECT * FROM #SOCIAL

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
	AND F003.screen_div = 6
	AND F003.del_flg = 0

	SELECT
		#SOCIAL.row_id
	,	#SOCIAL.post_id
	,	M006.id
	,	M006.vocabulary_nm
	,	M006.spelling
	,	M006.mean
	FROM F009
	JOIN M006
	ON F009.target_id = M006.id
	AND F009.briged_div = 1
	AND M006.record_div = 2
	INNER JOIN #SOCIAL
	ON #SOCIAL.briged_id = F009.briged_id
	ORDER BY 
	#SOCIAL.post_id

		SELECT
		M004.question_id 
	,	M004.question_content
	,	M004.question_div
	,	M005.answer_id
	,	M005.answer_content
	,	M005.verify
	,	ROW_NUMBER() OVER(partition by M004.post_id ORDER BY M004.post_id ASC) AS question_num	
	,	#SOCIAL.row_id
	FROM M004
	LEFT JOIN M005
	ON M004.question_id = M005.question_id
	INNER JOIN #SOCIAL
	ON M004.post_id = #SOCIAL.post_id
	WHERE 
		M004.question_id IN (SELECT TOP 5 M004.question_id FROM M004 WHERE M004.post_id IN(SELECT #SOCIAL.post_id FROM #SOCIAL) ORDER BY NEWID())

	SELECT
		#SOCIAL.row_id
	,	M013.tag_id
	,	M013.tag_nm
	FROM M013
	LEFT JOIN F009
	ON F009.target_id = M013.tag_id
	AND F009.briged_div = 2
	INNER JOIN #SOCIAL 
	ON F009.briged_id = #SOCIAL.briged_id
	WHERE M013.del_flg = 0
	AND M013.tag_div = 2

	SELECT IIF(@record_count <= @P_loadtime * 20,1,0) AS is_end

END

