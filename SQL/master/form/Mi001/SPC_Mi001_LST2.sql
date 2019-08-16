IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_Mi001_LST2]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_Mi001_LST2]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_Mi001_LST2]
	@P_mission_div			INT					=	0
,	@P_mission_data_div		INT					=	0
,	@P_catalogue_div		INT					=	0
,	@P_record_div			INT					=	0
,	@P_rank_from			INT					=	0
,	@P_rank_to				INT					=	0
,	@P_title				NVARCHAR(250)		=	''
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
	CREATE TABLE #Mi001(
		mission_id			NVARCHAR(15)
	,	mission_div         NVARCHAR(255)
	,	mission_data_div	NVARCHAR(255)	
	,	catalogue_div		NVARCHAR(255)
	,	catalogue_nm		NVARCHAR(255)	
	,	group_nm			NVARCHAR(255)
	,	mission_nm			NVARCHAR(255)	
	,	exp					INT
	,   cop					INT	
	,	period				INT
	,	rank				NVARCHAR(20)
	,	unit_per_times		INT
	,	record_div			INT
	,	record_div_nm		NVARCHAR(50)
	)
	
	--
	INSERT INTO #Mi001
	SELECT
		F001.mission_id		
	,	M999_1.content  
	,	M999_2.content
	,	M999_3.content      
	,	M002.catalogue_nm
	,	M003.group_nm     
	,	F001.title
	,	F001.exp      
	,	F001.cop				
	,   F001.period			
	,	CONCAT(M999_4.content,N' ➡ ',M999_5.content)				
	,	F001.unit_per_times
	,	F001.record_div
	,	CASE F001.record_div
		WHEN 0 THEN N'Chưa phê duyệt'			       
		WHEN 1 THEN N'Đã phê duyệt'			       
		WHEN 2 THEN N'Đã công khai'
		END			       
	FROM F001
	LEFT JOIN M999 M999_1
	ON	F001.mission_div = M999_1.number_id
	AND	M999_1.name_div = 25
	LEFT JOIN M999 M999_2
	ON	F001.mission_data_div = M999_2.number_id
	AND	M999_2.name_div = 26
	LEFT JOIN M999 M999_3
	ON	F001.catalogue_div = M999_3.number_id
	AND	M999_3.name_div = 7
	LEFT JOIN M999 M999_4
	ON	F001.rank_from = M999_4.number_id
	AND	M999_4.name_div = 14
	LEFT JOIN M999 M999_5
	ON	F001.rank_to = M999_5.number_id
	AND	M999_5.name_div = 14
	LEFT JOIN M002
	ON F001.catalogue_div = M002.catalogue_div
	AND F001.catalogue_id = M002.catalogue_id
	LEFT JOIN M003
	ON F001.catalogue_div = M003.catalogue_div
	AND F001.catalogue_id = M003.catalogue_id
	AND F001.group_id = M003.group_id
	WHERE F001.del_flg = 0 
	AND		(	(@P_mission_div	= 0)
		OR	(	F001.mission_div		= @P_mission_div))
	AND		(	(@P_mission_data_div	= 0)
		OR	(	F001.mission_data_div		= @P_mission_data_div))
	AND		(	(@P_catalogue_div	= 0)
		OR	(	F001.catalogue_div		= @P_catalogue_div))
	AND		(	(@P_record_div	= -1)
		OR	(	F001.record_div		= @P_record_div))
	AND		(	(@P_rank_from	= 0 AND @P_rank_to = 0)
			OR	(	@P_rank_from	<> 0 AND @P_rank_to	<> 0 AND F001.rank_from	>= @P_rank_from AND F001.rank_to <= @P_rank_to)
			OR	(	@P_rank_from	= 0 AND F001.rank_to < @P_rank_to)
			OR	(	@P_rank_to	= 0 AND F001.rank_from >= @P_rank_from)
			)
	AND		(	(@P_title		= '')
		OR	(	F001.title	LIKE '%' + @P_title + '%'))

	--
	SELECT 
		*
	FROM #Mi001
	ORDER BY
		#Mi001.mission_id ASC
	OFFSET (@P_page-1) * @P_page_size ROWS
	FETCH NEXT @P_page_size ROWS ONLY

	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	
	-- GET TOTAL OF RECORDS
	SET @totalRecord = (
		SELECT COUNT(W1.mission_id)	AS	total 
		FROM #Mi001 AS W1
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

