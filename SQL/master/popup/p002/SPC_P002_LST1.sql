IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_P002_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_P002_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_P002_LST1]
	@P_family_nm			NVARCHAR(50)		=	''
,	@P_first_name			NVARCHAR(50)		=	''
,	@P_department_id		NVARCHAR(15)		=	''
,	@P_employee_div			TINYINT				=	'' 
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
	CREATE TABLE #P002(
		employee_id			NVARCHAR(15)
	,	name    			NVARCHAR(50)
	,	email          		NVARCHAR(50)	
	,	cellphone			NVARCHAR(20)
	,   sex					NVARCHAR(10)	
	,	birth_date			NVARCHAR(15)
	,	department_nm		NVARCHAR(150)
	,	employee_div_nm		NVARCHAR(150)	
	,	remark  			NVARCHAR(100)	
	,	avarta   	    	NVARCHAR(500)	
	)
	
	--
	INSERT INTO #P002
	SELECT
		 M009.employee_id
	,	 CONCAT(M009.family_nm,' ',M009.first_name) AS name    
	,	 M009.email        
	,	 M009.cellphone    
	,	 IIF(sex = 0 , N'', IIF(sex = 1 , N'Nam', N'Nữ')) AS sex      	
	,	 FORMAT(birth_date, 'dd/MM/yyyy')  AS birth_date 
	,	 IIF(M008.department_nm IS NULL , N'', CONCAT(M008.department_id,'_',M008.department_nm)) AS department_nm
	,	 M999.content AS employee_div_nm
	,	 M009.remark
	,	 M009.avarta   	    
	FROM M009
	LEFT JOIN M008
	ON	M009.department_id = M008.department_id
	LEFT JOIN M999
	ON	M009.employee_div = M999.number_id
	AND	M999.name_div = 2
	WHERE M009.del_flg = 0 
	AND		(	(@P_family_nm		= '')
		OR	(	M009.family_nm	LIKE '%' + @P_family_nm + '%'))
	AND		(	(@P_first_name		= '')
		OR	(	M009.first_name	LIKE '%' + @P_first_name + '%'))
	AND		(	(@P_department_id	= '')
		OR	(	M009.department_id	= @P_department_id))
	AND		(	(@P_employee_div	= 0)
		OR	(	M009.employee_div		= @P_employee_div))
	AND	(M009.del_flg = 0)

	--
	SELECT 
		*
	FROM #P002
	ORDER BY
		#P002.employee_id ASC
	OFFSET (@P_page-1) * @P_page_size ROWS
	FETCH NEXT @P_page_size ROWS ONLY

	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	
	-- GET TOTAL OF RECORDS
	SET @totalRecord = (
		SELECT COUNT(W1.employee_id)	AS	total 
		FROM #P002 AS W1
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

