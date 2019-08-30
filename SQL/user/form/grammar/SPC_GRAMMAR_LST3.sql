IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_GRAMMAR_LST3]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_GRAMMAR_LST3]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_GRAMMAR_LST3]
	@P_mission_id			NVARCHAR(15)	=	''
,	@P_account_id			NVARCHAR(15)	=	'' 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0
	,	@mission_data_div	INT					=	0
	,	@current_unit		INT					=	0
	,	@unit_this_times	INT					=	0

	CREATE TABLE #GRAMMAR(
		row_id				INT
	,	post_id				INT
	,	post_title			NVARCHAR(100)
	,	post_content		NVARCHAR(MAX)
	,	remembered			INT
	,	del_flg				INT
	)

	CREATE TABLE #PAGER(
		row_id			INT
	,	totalRecord		INT
	,	pageMax			INT
	,	page			INT
	,	pagesize		INT
	)

	SET @mission_data_div = (SELECT F001.mission_data_div FROM F001 WHERE F001.mission_id = @P_mission_id)
	SET @current_unit = (SELECT ISNULL(F013.current_unit,0) FROM F013 WHERE F013.mission_id = @P_mission_id AND F013.account_id = @P_account_id)
	SET @unit_this_times = (SELECT F013.unit_this_times FROM F013 WHERE F013.mission_id = @P_mission_id AND F013.account_id = @P_account_id)

	IF @mission_data_div = 3
	BEGIN
		INSERT INTO #GRAMMAR
		SELECT
			ROW_NUMBER() OVER(ORDER BY M007.post_id ASC) AS row_id
		,	M007.post_id
		,	M007.post_title
		,	M007.post_content
		,	IIF(F003.item_1 IS NULL,0,1) AS remembered
		,	M007.del_flg
		FROM F001
		INNER JOIN F009
		ON F009.briged_id = F001.briged_id
		AND F009.briged_div = 3
		INNER JOIN F013
		ON F001.mission_id = F013.mission_id
		AND F013.account_id = @P_account_id
		INNER JOIN M007
		ON F009.target_id = M007.post_id
		LEFT JOIN F003
		ON M007.post_id = F003.item_1
		AND F003.connect_div = 3
		AND F003.user_id = @P_account_id
		AND F003.item_2 IS NULL
		WHERE F001.mission_id = @P_mission_id
		AND 0 =
			CASE 
				WHEN F003.item_1 IS NULL THEN M007.del_flg
				ELSE 0
			END
		AND M007.catalogue_div = 2
		AND M007.record_div = 2
		ORDER BY
		M007.post_id ASC
		OFFSET @current_unit ROWS
		FETCH NEXT @unit_this_times ROWS ONLY
	END

	IF @mission_data_div = 2
	BEGIN
		INSERT INTO #GRAMMAR
		SELECT
			ROW_NUMBER() OVER(ORDER BY M007.post_id ASC) AS row_id
		,	M007.post_id
		,	M007.post_title
		,	M007.post_content
		,	IIF(F003.item_1 IS NULL,0,1) AS remembered
		,	M007.del_flg
		FROM F001
		INNER JOIN F013
		ON F001.mission_id = F013.mission_id
		AND F013.account_id = @P_account_id
		INNER JOIN M007
		ON F001.catalogue_div = M007.catalogue_div
		AND F001.catalogue_id = M007.catalogue_id
		AND F001.group_id = M007.group_id
		AND M007.del_flg = 0
		LEFT JOIN F003
		ON M007.post_id = F003.item_1
		AND F003.connect_div = 3
		AND F003.user_id = @P_account_id
		AND F003.item_2 IS NULL
		WHERE F001.mission_id = @P_mission_id
		AND 0 =
			CASE 
				WHEN F003.item_1 IS NULL THEN M007.del_flg
				ELSE 0
			END
		AND M007.catalogue_div = 2
		AND M007.record_div = 2
		ORDER BY
		M007.post_id ASC
		OFFSET @current_unit ROWS
		FETCH NEXT @unit_this_times ROWS ONLY
	END

	IF @mission_data_div = 1
	BEGIN
		INSERT INTO #GRAMMAR
		SELECT
			ROW_NUMBER() OVER(ORDER BY M007.post_id ASC) AS row_id
		,	M007.post_id
		,	M007.post_title
		,	M007.post_content
		,	IIF(F003.item_1 IS NULL,0,1) AS remembered
		,	M007.del_flg
		FROM F001
		INNER JOIN F013
		ON F001.mission_id = F013.mission_id
		AND F013.account_id = @P_account_id
		INNER JOIN M007
		ON F001.catalogue_div = M007.catalogue_div
		AND F001.catalogue_id = M007.catalogue_id
		AND M007.del_flg = 0
		LEFT JOIN F003
		ON M007.post_id = F003.item_1
		AND F003.connect_div = 3
		AND F003.user_id = @P_account_id
		AND F003.item_2 IS NULL
		WHERE F001.mission_id = @P_mission_id
		AND 0 =
			CASE 
				WHEN F003.item_1 IS NULL THEN M007.del_flg
				ELSE 0
			END
		AND M007.catalogue_div = 2
		AND M007.record_div = 2
		ORDER BY
		M007.post_id ASC
		OFFSET @current_unit ROWS
		FETCH NEXT @unit_this_times ROWS ONLY
	END

	SELECT * FROM 
	(	
	SELECT
		#GRAMMAR.row_id
	,	M012.example_id		AS id
	,	M012.language1_content
	,	M012.language2_content
	,	M012.clap
	,	IIF(M012.cre_prg <> 'W002',S001.account_nm,N'Hệ thống') AS cre_user
	,	FORMAT(M012.cre_date,'dd/MM/yyyy HH:mm') AS cre_date
	,	ROW_NUMBER() OVER(partition by #GRAMMAR.row_id ORDER BY #GRAMMAR.row_id ASC) AS count_row_id
	,	IIF(F008.target_id IS NULL,0,1) AS effected
	FROM M012
	INNER JOIN #GRAMMAR
	ON M012.target_id				= #GRAMMAR.post_id
	LEFT JOIN F008
	ON M012.example_id = F008.target_id
	AND F008.user_id = @P_account_id
	AND F008.execute_div = 1
	AND F008.execute_target_div = 2
	LEFT JOIN S001 
	ON S001.account_id = M012.cre_user
	)temp
	WHERE temp.count_row_id <6
	ORDER BY temp.clap


	INSERT INTO #PAGER
	SELECT
		MAX(#GRAMMAR.row_id)	 
	,	COUNT(*)
	,	CEILING(CAST(COUNT(*) AS FLOAT) / 5)
	,	1
	,	5
	FROM M012
	INNER JOIN #GRAMMAR
	ON M012.target_id				= #GRAMMAR.post_id
	GROUP BY 
		M012.target_id

	SELECT * FROM #PAGER

	SELECT * FROM #GRAMMAR

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
	AND F003.screen_div = 2
	AND F003.del_flg = 0


END

