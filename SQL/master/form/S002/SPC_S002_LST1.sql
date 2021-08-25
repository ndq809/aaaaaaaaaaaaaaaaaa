IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_S002_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_S002_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
--EXEC SPC_S002_LST1 '','','','','10','1'
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_S002_LST1]
	@P_account_nm			NVARCHAR(50)		=	''
,	@P_employee_id			NVARCHAR(15)		=	''
,	@P_system_div			TINYINT				=	0
,	@P_account_div			TINYINT				=	0 
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
	CREATE TABLE #S002(
		account_id      	NVARCHAR(15)
	,	account_nm      	NVARCHAR(50)
	,	employee_nm      	NVARCHAR(100)	
	,	system_div   		NVARCHAR(150)
	,	account_div   		NVARCHAR(150)	
	,	password    		NVARCHAR(200)
	,   signature   		NVARCHAR(MAX)		
	,   remark   			NVARCHAR(MAX)		
	)
	
	--
	INSERT INTO #S002
	SELECT
		 S001.account_id
	,	 S001.account_nm
	,	 IIF(M009.employee_id IS NULL , N'', CONCAT(M009.employee_id,'_',CONCAT(M009.family_nm,' ',M009.first_name)))
	,	 M999_1.content
	,	 M999_2.content
	,	 S001.password
	,	 S001.signature   	    
	,	 S001.remark   	    
	FROM S001
	LEFT JOIN M009 
	ON	S001.user_id = M009.employee_id
	LEFT JOIN M999 AS M999_1
	ON	(S001.system_div = M999_1.number_id)
	AND	(M999_1.name_div = 4)
	LEFT JOIN M999 AS M999_2
	ON	(S001.account_div = M999_2.number_id)
	AND	(M999_2.name_div IN (SELECT M999.num_remark1 FROM M999 WHERE M999.name_div = 4 AND M999.number_id = S001.system_div AND M999.del_flg = 0))
	WHERE S001.del_flg = 0 
	AND		(	(@P_account_nm		= '')
		OR	(	S001.account_nm	LIKE '%' + @P_account_nm + '%'))
	AND		(	(@P_employee_id		= '')
		OR	(	M009.employee_id	LIKE '%' + @P_employee_id + '%'))
	AND		(	(@P_system_div	= 0)
		OR	(	S001.system_div	= @P_system_div))
	AND		(	(@P_account_div	= 0)
		OR	(	S001.account_div		= @P_account_div))
	AND	(S001.del_flg = 0)

	--
	SELECT 
		*
	FROM #S002
	ORDER BY
		#S002.account_id ASC
	OFFSET (@P_page-1) * @P_page_size ROWS
	FETCH NEXT @P_page_size ROWS ONLY

	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	
	-- GET TOTAL OF RECORDS
	SET @totalRecord = (
		SELECT COUNT(W1.account_id)	AS	total 
		FROM #S002 AS W1
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

