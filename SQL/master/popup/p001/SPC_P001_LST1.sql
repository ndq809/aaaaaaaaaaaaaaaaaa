IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_P001_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_P001_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_P001_LST1]
	@P_department_nm		NVARCHAR(50)		=	'' 
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
		department_id			NVARCHAR(15)
	,	section_nm				NVARCHAR(150)
	,	department_nm  			NVARCHAR(150)	
	,	department_ab_nm  		NVARCHAR(50)	
	,	remark					NVARCHAR(100)	
	)
	
	--
	INSERT INTO #P001
	SELECT 
		M008.department_id
	,	M999.content
	,	M008.department_nm 
	,	M008.department_ab_nm 
	,	M008.remark  
	FROM M008
	LEFT JOIN M999 ON
		M008.section_id=M999.number_id
	AND M999.name_div = 3 
	WHERE 
		(	(@P_department_nm	= '')
		OR	(M008.department_nm	LIKE '%' + @P_department_nm + '%'))
	AND	(M008.del_flg = 0)

	--
	SELECT 
		ISNULL(#P001.department_id,'')		AS	department_id
	,	ISNULL(#P001.section_nm,'')			AS	section_nm
	,	ISNULL(#P001.department_nm,'')		AS	department_nm
	,	ISNULL(#P001.department_ab_nm,'')	AS	department_ab_nm
	,	ISNULL(#P001.remark,'')				AS	remark
	FROM #P001
	ORDER BY
		#P001.department_id ASC
	OFFSET (@P_page-1) * @P_page_size ROWS
	FETCH NEXT @P_page_size ROWS ONLY

	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	
	-- GET TOTAL OF RECORDS
	SET @totalRecord = (
		SELECT COUNT(W1.department_id)	AS	total 
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

