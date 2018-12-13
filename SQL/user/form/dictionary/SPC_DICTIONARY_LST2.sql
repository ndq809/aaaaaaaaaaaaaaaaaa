IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_DICTIONARY_LST2]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_DICTIONARY_LST2]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_DICTIONARY_LST2]
	
		@P_vocabulary_nm		NVARCHAR(200)	=	'' 
	,	@P_account_id			NVARCHAR(15)	=	''
	,	@P_ip					NVARCHAR(200)	=	'' 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0
	,	@vocabylary_id		INT					=	0
	,	@vocabylary_code	INT					=	0
	,	@history_number 	INT					=	0

	CREATE TABLE #VOCABULARY(
		row_id				INT
	,	id					INT
	,	vocabulary_nm		NVARCHAR(100)
	,	vocabulary_div		NVARCHAR(100)
	,	image				NVARCHAR(MAX)
	,	audio				NVARCHAR(MAX)
	,	mean				NVARCHAR(MAX)
	,	spelling			NVARCHAR(100)
	,	explain				NVARCHAR(MAX)
	,	remark				NVARCHAR(MAX)
	,	remembered			INT
	)

	CREATE TABLE #PAGER(
		row_id			INT
	,	totalRecord		INT
	,	pageMax			INT
	,	page			INT
	,	pagesize		INT
	)

	CREATE TABLE #SEARCH_HISTORY(
		id			INT
	,	target_id	INT
	)

	INSERT INTO #SEARCH_HISTORY
	SELECT
		F008.excute_id
	,	F008.target_id
	FROM F008 WHERE 
		F008.execute_div = 2
	AND F008.execute_target_div = 1
	AND F008.del_flg = 0
	AND F008.user_id = @P_account_id
	ORDER BY F008.cre_date

	IF　@P_vocabulary_nm <>'' AND NOT EXISTS (SELECT M006.vocabulary_id FROM M006 WHERE M006.vocabulary_nm = @P_vocabulary_nm AND M006.del_flg = 0) --code not exits 
	BEGIN
	 INSERT INTO @ERR_TBL
	 SELECT 
	   0
	 , 16
	 , 'key-word'
	 , ''
	END
	IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC
	
	SET @vocabylary_id =(SELECT TOP 1 M006.vocabulary_id FROM M006 WHERE M006.vocabulary_nm = @P_vocabulary_nm AND M006.del_flg = 0)
	SET @vocabylary_code =(SELECT TOP 1 M006.id FROM M006 WHERE M006.vocabulary_nm = @P_vocabulary_nm AND M006.del_flg = 0)

	SELECT @history_number = COUNT(*) FROM #SEARCH_HISTORY
	IF EXISTS(SELECT * FROM #SEARCH_HISTORY WHERE #SEARCH_HISTORY.target_id = @vocabylary_code)
	BEGIN
		DELETE F008 WHERE F008.excute_id IN (SELECT #SEARCH_HISTORY.id FROM #SEARCH_HISTORY WHERE #SEARCH_HISTORY.target_id = @vocabylary_code)
	END
	IF @history_number = 10
	BEGIN
	DELETE F008 WHERE F008.excute_id IN (SELECT TOP 1 #SEARCH_HISTORY.id FROM #SEARCH_HISTORY)
	END
	IF @P_account_id <> ''
	BEGIN 
		INSERT INTO F008
		SELECT
			@vocabylary_code
		,	@P_account_id
		,	2
		,	1
		,	NULL
		,	0
		,	@P_account_id
		,	'common'
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
	INSERT INTO #VOCABULARY
	SELECT
		ROW_NUMBER() OVER(ORDER BY M006.vocabulary_id , M006.vocabulary_dtl_id ASC) AS row_id
	,	M006.id
	,	M006.vocabulary_nm
	,	M999.content
	,	M006.image
	,	M006.audio
	,	M006.mean
	,	M006.spelling
	,	M006.explain
	,	M006.remark
	,	IIF(F003.item_1 IS NULL,0,1) AS remembered
	FROM M006
	LEFT JOIN F003
	ON M006.id = F003.item_1
	AND F003.connect_div = 2
	AND F003.user_id = @P_account_id
	AND F003.item_2 IS NULL
	INNER JOIN M999
	ON M006.vocabulary_div = M999.number_id
	AND M999.name_div = 8
	AND m999.del_flg = 0
	WHERE
	M006.vocabulary_id = @vocabylary_id
	AND M006.del_flg = 0

	SELECT * FROM 
	(	
	SELECT
		#VOCABULARY.row_id
	,	M012.example_id		AS id
	,	M012.language1_content
	,	M012.language2_content
	,	IIF(M012.cre_prg <> 'W002',M012.cre_user,N'Hệ thống') AS cre_user
	,	FORMAT(M012.cre_date,'dd/MM/yyyy HH:mm') AS cre_date
	,	M012.clap
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

	SELECT TOP 1 M006.id FROM M006 WHERE M006.vocabulary_nm = @P_vocabulary_nm AND M006.del_flg = 0

	SELECT TOP 10
		F008.target_id
	,	M006.vocabulary_nm
	FROM F008
	LEFT JOIN M006
	ON F008.target_id = M006.id
	WHERE 
		F008.execute_div = 2
	AND F008.execute_target_div = 1
	AND F008.del_flg = 0
	AND F008.user_id = @P_account_id
	ORDER BY
		F008.cre_date DESC

EXIT_SPC:

	SELECT  Id
		,	Code 
		,	Data 
		,	[Message]
	FROM @ERR_TBL
	ORDER BY Code

END

