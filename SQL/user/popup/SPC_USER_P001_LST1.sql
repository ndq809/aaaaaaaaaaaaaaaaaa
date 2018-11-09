IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_USER_P001_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_USER_P001_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_USER_P001_LST1]
	@P_vocabulary_div		INT					=	0
,	@P_Vocabulary_nm		NVARCHAR(50)		=	''
,	@P_mean					NVARCHAR(200)		=	''
,	@P_row_id				INT					=	''
,	@P_selected_list		XML					=	''
,	@P_page_size			INT					=	50
,	@P_page					INT					=	1


AS
BEGIN
	SET NOCOUNT ON;
	
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	--
	CREATE TABLE #P001(
		row_id					INT
	,	id						INT	
	,	vocabulary_id			NVARCHAR(15)
	,	vocabulary_dtl_id    	NVARCHAR(15)
	,	vocabulary_nm           NVARCHAR(50)
	,	vocabulary_div			INT	
	,	vocabulary_div_nm		NVARCHAR(50)
	,   spelling				NVARCHAR(50)	
	,	mean					NVARCHAR(200)
	,	explain					NVARCHAR(200)
	,	image					NVARCHAR(200)
	,	audio					NVARCHAR(200)
	,	remark					NVARCHAR(150)	
	)
	
	--
	INSERT INTO #P001
	SELECT
		@P_row_id
	,	M006.id
	,	M006.Vocabulary_id		
	,	M006.Vocabulary_dtl_id  
	,	M006.Vocabulary_nm
	,	M999.number_id      
	,	M999.content				
	,   M006.spelling			
	,	M006.mean				
	,	M006.explain
	,	M006.image
	,	M006.audio			
	,	M006.remark				       
	FROM M006
	LEFT JOIN M999
	ON	M006.vocabulary_div = M999.number_id
	AND	M999.name_div = 8
	LEFT JOIN
	(SELECT
		row_id			=	T.C.value('@row_id 		  ', 'int')	
	,	Vocabulary_code	=	T.C.value('@id 		  ', 'int')
	FROM @P_selected_list.nodes('row') T(C)
	)TEMP ON
	TEMP.Vocabulary_code = M006.id
	WHERE M006.del_flg = 0 
	AND		(	(@P_Vocabulary_nm		= '')
		OR	(	M006.Vocabulary_nm	LIKE '%' + @P_Vocabulary_nm + '%'))
	AND		(	(@P_mean		= '')
		OR	(	M006.mean	LIKE '%' + @P_mean + '%'))
	AND		(	(@P_vocabulary_div	= 0)
		OR	(	M006.vocabulary_div		= @P_vocabulary_div))
	AND	(M006.del_flg = 0)
	AND TEMP.Vocabulary_code IS NULL

	--
	SELECT 
		*
	FROM #P001
	ORDER BY
		#P001.vocabulary_id ASC
	,	#P001.vocabulary_dtl_id ASC
	OFFSET (@P_page-1) * @P_page_size ROWS
	FETCH NEXT @P_page_size ROWS ONLY

	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	
	-- GET TOTAL OF RECORDS
	SET @totalRecord = (
		SELECT COUNT(W1.vocabulary_id)	AS	total 
		FROM #P001 AS W1
	)

	--
	SET @pageMax = CEILING(CAST(@totalRecord AS FLOAT) / @P_page_size)
	
	--
	IF @pageMax = 0
	BEGIN
		SET @pageMax = 1
	END
	IF @P_page > @pageMax
	BEGIN
		SET @P_page = @pageMax
	END	

	--[1] SELECT INFO PAGE
	SELECT	
		@totalRecord			AS totalRecord
	,	@pageMax				AS pageMax
	,	@P_page					AS [page]
	,	@P_page_size			AS pagesize

END

