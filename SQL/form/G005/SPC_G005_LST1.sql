﻿IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_G005_LST1]') AND type IN (N'P', N'PC'))
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
		id					INT
	,	catalogue_div      	NVARCHAR(200)
	,	catalogue_id      	NVARCHAR(50)
	,	catalogue_nm      	NVARCHAR(100)
	,	group_id      		NVARCHAR(50)
	,	group_nm      		NVARCHAR(100)	
	)
	
	--
	INSERT INTO #M003
	SELECT
		 M003.generate_id
	,	 M999.content
	,	 M003.catalogue_id
	,	 M002.catalogue_nm
	,	 M003.group_id
	,	 M003.group_nm
	FROM M003
	LEFT JOIN M002
	ON	M003.catalogue_id = M002.catalogue_id
	LEFT JOIN M999
	ON	(M002.catalogue_div = M999.number_id)
	AND	(M999.name_div = 7)
	WHERE M003.del_flg = 0
	AND		(	(@P_group_nm		= '')
		OR	(	M003.group_nm	LIKE '%' + @P_group_nm + '%')) 
	AND		(	(@P_catalogue_nm		= '')
		OR	(	M002.catalogue_nm	LIKE '%' + @P_catalogue_nm + '%'))
	AND		(	(@P_catalogue_div	= 0)
		OR	(	M002.catalogue_div		= @P_catalogue_div))

	--
	SELECT 
		*
	FROM #M003
	ORDER BY
		#M003.id ASC
	OFFSET (@P_page-1) * @P_page_size ROWS
	FETCH NEXT @P_page_size ROWS ONLY

	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	
	-- GET TOTAL OF RECORDS
	SET @totalRecord = (
		SELECT COUNT(W1.id)	AS	total 
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
