IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_V001_LST2]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_V001_LST2]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_V001_LST2]
	@P_vocabulary_div		INT					=	0
,	@P_Vocabulary_nm		NVARCHAR(50)		=	''
,	@P_mean					NVARCHAR(200)		=	''
,	@P_record_div			INT					=	-1
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
	CREATE TABLE #P003(
		vocabulary_id			NVARCHAR(15)
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
	,	record_div				INT	
	,	record_div_nm			NVARCHAR(150)	
	)
	
	--
	INSERT INTO #P003
	SELECT
		M006.Vocabulary_id		
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
	,	M006.record_div
	,	CASE M006.record_div
		WHEN 0 THEN N'Chưa phê duyệt'			       
		WHEN 1 THEN N'Đã phê duyệt'			       
		WHEN 2 THEN N'Đã công khai'
		END			       
	FROM M006
	LEFT JOIN M999
	ON	M006.vocabulary_div = M999.number_id
	AND	M999.name_div = 8
	WHERE M006.del_flg = 0 
	AND		(	(@P_Vocabulary_nm		= '')
		OR	(	M006.Vocabulary_nm	LIKE '%' + @P_Vocabulary_nm + '%'))
	AND		(	(@P_mean		= '')
		OR	(	M006.mean	LIKE '%' + @P_mean + '%'))
	AND		(	(@P_vocabulary_div	= 0)
		OR	(	M006.vocabulary_div		= @P_vocabulary_div))
	AND		(	(@P_record_div	= -1)
		OR	(	M006.record_div		= @P_record_div))
	AND	(M006.del_flg = 0)

	--
	SELECT 
		*
	FROM #P003
	ORDER BY
		#P003.vocabulary_id ASC
	,	#P003.vocabulary_dtl_id ASC
	OFFSET (@P_page-1) * @P_page_size ROWS
	FETCH NEXT @P_page_size ROWS ONLY

	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	
	-- GET TOTAL OF RECORDS
	SET @totalRecord = (
		SELECT COUNT(W1.vocabulary_id)	AS	total 
		FROM #P003 AS W1
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

