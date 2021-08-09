IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_HOMEPAGE_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_HOMEPAGE_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_HOMEPAGE_LST1]
	@P_page_size			INT					=	4
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
	CREATE TABLE #M016(
		link		      	NVARCHAR(200)
	,	target_id	      	NVARCHAR(200)
	,	special_param	    NVARCHAR(200)
	,	description1      	NVARCHAR(100)	
	,	description2      	NVARCHAR(100)
	,	description3      	NVARCHAR(100)
	,	notes		      	NVARCHAR(500)
	,	cre_time		    DATETIME2
	)
	
	--
	INSERT INTO #M016
	SELECT 
		#TEMP.link
	,	#TEMP.target_id
	,	#TEMP.special_param
	,	#TEMP.description1
	,	#TEMP.description2
	,	#TEMP.description3
	,	#TEMP.notes
	,	#TEMP.cre_date
	FROM(
	SELECT
		ROW_NUMBER() over (PARTITION BY _M016.target_id,_M016.target_div ORDER BY _M016.target_row_no DESC) as row_id
	,	 M999.text_remark1 AS link
	,	 IIF(M007.catalogue_div=1,'&p=1','') AS special_param
	,	 _M016.target_id AS target_id
	,	 M999.text_remark3 AS description1
	,	 IIF(M007.catalogue_div=1,M003.group_nm,M007.post_title) AS description2
	,	 IIF(_M016.history_div=1,N'đã được thêm mới',N'đã được cập nhật') AS description3
	,	_M016.notes
	,	_M016.cre_date
	,	_M016.record_div
	FROM M016 _M016
	LEFT JOIN M007
	ON _M016.target_id = M007.post_id
	AND _M016.target_div = 0
	LEFT JOIN M003
	ON M007.group_id = M003.group_id
	LEFT JOIN M999
	ON	(M007.catalogue_div = M999.number_id)
	AND	(M999.name_div = 7)
	) AS #TEMP
	WHERE 
		#TEMP.row_id = 1
	AND #TEMP.record_div = 2
	--
	SELECT 
		*
	FROM #M016
	ORDER BY
		#M016.cre_time DESC
	OFFSET (@P_page-1) * @P_page_size ROWS
	FETCH NEXT @P_page_size ROWS ONLY

	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	
	-- GET TOTAL OF RECORDS
	SET @totalRecord = (
		SELECT COUNT(W1.cre_time)	AS	total 
		FROM #M016 AS W1
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

