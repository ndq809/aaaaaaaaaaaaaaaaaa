IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_G001_LST2]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_G001_LST2]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_G001_LST2]
	@P_date_from		NVARCHAR(10)		=	'' 
,	@P_date_to			NVARCHAR(10)		=	''
,	@P_user_id			NVARCHAR(200)		=	''
,	@P_user_div			INT					=	''

AS
BEGIN
	SET NOCOUNT ON;
	
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0
	,	@date_from			DATE				=	NULL
	,	@date_to			DATE				=	NULL

	--

	SET @date_from = CONVERT(date, @P_date_from, 105)
	SET @date_to = CONVERT(date, @P_date_to, 105)
	CREATE TABLE #DATA(
		record_type      	TINYINT
	,	confirmed       	TINYINT
	)

	CREATE TABLE #DATA_RESULT(
		record_type			TINYINT
	,	record_type_nm		NVARCHAR(200)
	,	confirmed			NVARCHAR(200)
	,	qty       			INT
	,	price       		MONEY
	,	bill       			MONEY
	)
	
	--
	INSERT INTO #DATA
	SELECT 
		1 AS record_type
	,	M006.record_div
	FROM M006
	WHERE M006.cre_user = @P_user_id
	AND M006.cre_date BETWEEN @date_from AND @date_to
	AND M006.del_flg = 0
	UNION ALL
	SELECT
		M007.catalogue_div
	,	M007.record_div
	FROM M007
	WHERE M007.cre_user = @P_user_id
	AND M007.cre_date BETWEEN @date_from AND @date_to
	AND M007.del_flg = 0
	AND M007.catalogue_div != 1

	INSERT INTO #DATA_RESULT
	SELECT
		#DATA.record_type
	,	CASE #DATA.record_type
			WHEN 1 THEN N'Từ Vựng'
			WHEN 2 THEN N'Ngữ Pháp'
			WHEN 3 THEN N'Nghe'
			WHEN 4 THEN N'Học Viết'
			WHEN 5 THEN N'Đọc Hiểu'
			WHEN 6 THEN N'Câu Hỏi Thảo Luận'
			WHEN 7 THEN N'Giải Trí Hình Ảnh'
			WHEN 8 THEN N'Giải Trí Video'
			WHEN 9 THEN N'Giải Trí Truyện'
			WHEN 10 THEN N'Quảng Cáo'
		END AS record_type_nm
	,	CASE #DATA.confirmed
			WHEN 0 THEN N'Chưa Phê Duyệt'
			ELSE N'Đã Phê Duyệt'
		END AS confirmed
	,	COUNT(*) AS qty
	,	IIF(#DATA.confirmed > 0,M014.upr,0) AS price
	,	COUNT(*) * IIF(#DATA.confirmed > 0,M014.upr,0) AS bill
	FROM #DATA
	LEFT JOIN M014
	ON	M014.target_div = 1
	AND	M014.price_div = #DATA.record_type
	AND M014.target_dtl_div = @P_user_div
	GROUP BY 
		#DATA.record_type
	,	#DATA.confirmed
	,	M014.upr
	--

	SELECT 
		record_type		
	,	record_type_nm	
	,	confirmed		
	,	qty       		
	,	FORMAT(price,'###,###,###.##') AS price       	
	,	FORMAT(bill,'###,###,###.##') AS bill       	
	FROM #DATA_RESULT
	ORDER BY
		#DATA_RESULT.record_type,#DATA_RESULT.confirmed ASC

END

