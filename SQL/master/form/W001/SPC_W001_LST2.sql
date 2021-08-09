IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_W001_LST2]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_W001_LST2]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_W001_LST2]
	@P_catalogue_div		TINYINT				=	0 
,	@P_catalogue_nm			NVARCHAR(200)		=	''
,	@P_group_nm				NVARCHAR(200)		=	''
,	@P_record_div			INT					=	-1
,	@P_post_title			NVARCHAR(200)		=	''
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
	CREATE TABLE #M007(
		id					INT
	,	catalogue_div      	NVARCHAR(200)
	,	catalogue_id      	NVARCHAR(50)
	,	catalogue_nm      	NVARCHAR(100)
	,	group_id      		NVARCHAR(50)
	,	group_nm      		NVARCHAR(100)
	,	post_id      		NVARCHAR(50)
	,	post_title      	NVARCHAR(250)
	,	record_div				INT	
	,	record_div_nm			NVARCHAR(150)
	)
	
	--
	INSERT INTO #M007
	SELECT
		M007.post_id
	,	M999.content
	,	M007.catalogue_id
	,	M002.catalogue_nm
	,	M007.group_id
	,	M003.group_nm
	,	M007.post_id
	,	M007.post_title
	,	M007.record_div
	,	CASE M007.record_div
		WHEN 0 THEN N'Chưa phê duyệt'			       
		WHEN 1 THEN N'Đã phê duyệt'			       
		WHEN 2 THEN N'Đã công khai'
		END			       
	FROM M007
	LEFT JOIN M002
	ON	M007.catalogue_id = M002.catalogue_id
	LEFT JOIN M003
	ON	M007.group_id = M003.group_id
	LEFT JOIN M999
	ON	(M007.catalogue_div = M999.number_id)
	AND	(M999.name_div = 7)
	WHERE M007.del_flg = 0
	AND		(	(@P_post_title		= '')
		OR	(M007.post_title	LIKE '%' + @P_post_title + '%'))
	AND		(	(@P_group_nm		= '')
		OR	((M007.group_id=@P_group_nm) OR(M003.group_nm	LIKE '%' + @P_group_nm + '%')))
	AND		(	(@P_catalogue_nm		= '')
		OR	((M002.catalogue_id=@P_catalogue_nm) OR(M002.catalogue_nm	LIKE '%' + @P_catalogue_nm + '%')))
	AND		(	(@P_catalogue_div	= 0)
		OR	(	M999.number_id		= @P_catalogue_div))
	AND		(	(@P_record_div	= -1)
		OR	(	M007.record_div		= @P_record_div))

	--
	SELECT 
		*
	FROM #M007
	ORDER BY
		#M007.id ASC
	OFFSET (@P_page-1) * @P_page_size ROWS
	FETCH NEXT @P_page_size ROWS ONLY

	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	
	-- GET TOTAL OF RECORDS
	SET @totalRecord = (
		SELECT COUNT(W1.id)	AS	total 
		FROM #M007 AS W1
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

