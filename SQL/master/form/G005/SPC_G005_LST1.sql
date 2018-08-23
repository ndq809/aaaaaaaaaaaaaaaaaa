IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_G005_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_G005_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_G005_LST1]
	@P_catalogue_div		TINYINT				=	0 
,	@P_catalogue_nm			NVARCHAR(200)		=	''
,	@P_group_nm				NVARCHAR(200)		=	''
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
	CREATE TABLE #M003(
		catalogue_div      	NVARCHAR(200)
	,	catalogue_id      	NVARCHAR(50)
	,	catalogue_nm      	NVARCHAR(100)
	,	group_id      		NVARCHAR(50)
	,	group_nm      		NVARCHAR(100)
	,	post_count      	INT		
	)
	
	--
	INSERT INTO #M003
	SELECT
		 M999.content
	,	 _M003.catalogue_id
	,	 M002.catalogue_nm
	,	 _M003.group_id
	,	 _M003.group_nm
	,	 (select COUNT(*) from M007 _M007 where _M007.group_id	=	_M003.group_id) post_count
	FROM M003 _M003
	LEFT JOIN M002
	ON	_M003.catalogue_id = M002.catalogue_id
	LEFT JOIN M999
	ON	(M002.catalogue_div = M999.number_id)
	AND	(M999.name_div = 7)
	WHERE _M003.del_flg = 0
	AND		(	(@P_group_nm		= '')
		OR	((_M003.group_id=@P_group_nm) OR(_M003.group_nm	LIKE '%' + @P_group_nm + '%')))
	AND		(	(@P_catalogue_nm		= '')
		OR	((M002.catalogue_id=@P_catalogue_nm) OR(M002.catalogue_nm	LIKE '%' + @P_catalogue_nm + '%')))
	AND		(	(@P_catalogue_div	= 0)
		OR	(	M002.catalogue_div		= @P_catalogue_div))

	--
	SELECT 
		*
	FROM #M003
	ORDER BY
		#M003.group_id ASC
	OFFSET (@P_page-1) * @P_page_size ROWS
	FETCH NEXT @P_page_size ROWS ONLY

	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	
	-- GET TOTAL OF RECORDS
	SET @totalRecord = (
		SELECT COUNT(W1.group_id)	AS	total 
		FROM #M003 AS W1
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

