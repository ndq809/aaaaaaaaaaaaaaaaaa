IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_VOCABULARY_LST2]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_VOCABULARY_LST2]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_VOCABULARY_LST2]
	
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

	CREATE TABLE #WORD(
		src_id				INT
	,	target_id			INT
	,	relationship_div	INT

	)

	CREATE TABLE #VOCABULARY(
		row_id					INT
	,	id						INT
	,	vocabulary_nm			NVARCHAR(500)
	,	vocabulary_div			INT	
	,	vocabulary_div_nm		NVARCHAR(50)
	,	specialized_div			INT	
	,	specialized_div_nm		NVARCHAR(500)
	,	field_div				INT	
	,	field_div_nm			NVARCHAR(500)
	,   spelling				NVARCHAR(500)
	,	mean					NVARCHAR(MAX)
	,	image					NVARCHAR(500)
	,	audio					NVARCHAR(500)
	,	remembered				INT
	,	del_flg					INT
	)

	CREATE TABLE #PAGER(
		row_id			INT
	,	totalRecord		INT
	,	pageMax			INT
	,	page			INT
	,	pagesize		INT
	)

	INSERT INTO #VOCABULARY
	SELECT
		ROW_NUMBER() OVER(ORDER BY M006.vocabulary_id , M006.vocabulary_dtl_id ASC) AS row_id
	,	M006.id
	,	M006.Vocabulary_nm
	,	M999_1.number_id     
	,	M999_1.content
	,	M999_2.number_id     
	,	M999_2.content
	,	M999_3.number_id     
	,	M999_3.content		
	,   M006.spelling		
	,	M006.mean			
	,	M006.image
	,	M006.audio			
	,	IIF(F003.item_1 IS NULL,0,1) AS remembered
	,	M006.del_flg
	FROM M006
	INNER JOIN F009
	ON F009.target_id = M006.id
	AND F009.briged_div = 1
	LEFT JOIN F003
	ON M006.id = F003.item_1
	AND F003.connect_div = 2
	AND F003.user_id = @P_account_id
	AND F003.item_2 IS NULL
	LEFT JOIN M999 M999_1
	ON	M006.vocabulary_div = M999_1.number_id
	AND	M999_1.name_div = 8
	LEFT JOIN M999 M999_2
	ON	M006.specialized = M999_2.number_id
	AND	M999_2.name_div = 23
	LEFT JOIN M999 M999_3
	ON	M006.field = M999_3.number_id
	AND	M999_3.name_div = 24
	WHERE F009.briged_id IN 
	(
		SELECT briged_id FROM M007
		WHERE M007.catalogue_id = @P_catalogue_id
		AND M007.group_id = @P_group_id
		AND M007.catalogue_div = 1
		AND M007.record_div = 2
	)
	AND 0 =
		CASE 
			WHEN F003.item_1 IS NULL THEN M006.del_flg
			ELSE 0
		END
	AND M006.record_div = 2

	INSERT INTO #WORD
	SELECT
		F012.vocabulary_src
	,	F012.vocabulary_target
	,	F012.relationship_div
	FROM F012
	INNER JOIN #VOCABULARY
	ON F012.vocabulary_src = #VOCABULARY.id

	SELECT * FROM 
	(	
	SELECT
		#VOCABULARY.row_id
	,	M012.example_id		AS id
	,	M012.language1_content
	,	M012.language2_content
	,	M012.clap
	,	IIF(M012.cre_prg <> 'W002',S001.account_nm,N'Hệ thống') AS cre_user
	,	FORMAT(M012.cre_date,'dd/MM/yyyy HH:mm') AS cre_date
	,	ROW_NUMBER() OVER(partition by #VOCABULARY.row_id ORDER BY #VOCABULARY.row_id ASC) AS count_row_id
	,	IIF(F008.target_id IS NULL,0,1) AS effected
	FROM M012
	INNER JOIN #VOCABULARY
	ON M012.target_id				= #VOCABULARY.id
	LEFT JOIN F008
	ON M012.example_id = F008.target_id
	AND F008.user_id = @P_account_id
	AND F008.execute_div = 1
	AND F008.execute_target_div = 1
	LEFT JOIN S001 
	ON S001.account_id = M012.cre_user
	WHERE
		M012.target_div = 1
	)temp
	WHERE temp.count_row_id <6
	ORDER BY temp.clap


	INSERT INTO #PAGER
	SELECT
		MAX(#VOCABULARY.row_id)	 
	,	COUNT(*)
	,	CEILING(CAST(COUNT(*) AS FLOAT) / 5)
	,	1
	,	5
	FROM M012
	INNER JOIN #VOCABULARY
	ON M012.target_id				= #VOCABULARY.id
	WHERE
		M012.target_div = 1
	GROUP BY 
		M012.target_id

	SELECT * FROM #PAGER

	SELECT * FROM #VOCABULARY

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
	AND	F003.connect_div = 1
	AND F003.screen_div = 1
	AND F003.del_flg = 0

	SELECT
		#WORD.src_id				AS	src_id		
	,	#WORD.target_id				AS	target_id		
	,	M006.Vocabulary_nm	AS	vocabulary_nm		
	,   M006.spelling			
	,	M006.mean
	,	#WORD.relationship_div 				
	FROM M006
	INNER JOIN #WORD
	ON #WORD.target_id = M006.id


END

