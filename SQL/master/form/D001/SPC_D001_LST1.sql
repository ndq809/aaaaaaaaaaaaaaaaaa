IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_D001_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_D001_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
--EXEC SPC_D001_LST1 '','','','','10','1'
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_D001_LST1]
	@P_date_from			NVARCHAR(15)		=	''
,	@P_date_to				NVARCHAR(15)		=	'' 
,	@P_user_name			NVARCHAR(50)		=	'' 
,	@P_page_size			INT					=	50
,	@P_page					INT					=	1
,	@P_user_id				VARCHAR(10)			=	''
,	@P_ip					VARCHAR(20)			=	''

AS
BEGIN
	SET NOCOUNT ON;
	
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@w_time				DATETIME2			= SYSDATETIME()
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0
	,	@w_date_from		DATETIME2			=	NULL
	,	@w_date_to			DATETIME2			=	NULL
	,	@w_account_id		INT					=	0
	
	SET @w_date_from = IIF(@P_date_from='',NULL,CONVERT(DATETIME2,@P_date_from,103))
	SET @w_date_to = IIF(@w_date_to='',NULL,CONVERT(DATETIME2,@w_date_to,103))
	--
	CREATE TABLE #D001_ALL(
		report_id	      	INT
	,	target_id	      	NVARCHAR(15)
	,	target_nm	      	NVARCHAR(MAX)
	,	target_nm_detail	NVARCHAR(MAX)
	,	denounce_div      	INT	
	,	target_own_id    	INT
	,	checklist		    NVARCHAR(MAX)
	,	comment		    	NVARCHAR(MAX)
	)

	CREATE TABLE #D001_HEADER(
		id					INT				IDENTITY(1,1) NOT NULL
	,	target_own_id    	INT
	,	target_own_nm    	NVARCHAR(150)
	,	denounce_div      	INT	
	,	denounce_div_nm     NVARCHAR(100)	
	,	denounce_count    	INT
	)

	CREATE TABLE #D001_DETAIL(
		id					INT				IDENTITY(1,1) NOT NULL
	,	target_id	      	NVARCHAR(15)
	,	target_nm	      	NVARCHAR(MAX)
	,	target_nm_detail	NVARCHAR(MAX)
	,	denounce_div      	INT	
	,	denounce_div_nm     NVARCHAR(100)	
	,	denounce_count    	INT
	,	note_count	    	INT
	,	target_own_id    	INT
	,	target_own_nm    	NVARCHAR(150)
	)

	CREATE TABLE #D001_CHECKLIST(
		target_id	      	NVARCHAR(15)
	,	denounce_div      	INT	
	,	checklist		    INT
	)

	CREATE TABLE #D001_COMMENT(
		target_id	      	NVARCHAR(15)
	,	denounce_div      	INT	
	,	comment		    	NVARCHAR(MAX)
	)

	--

	UPDATE F006
	SET
		F006.status = 0
	WHERE 
		F006.status = 1
	AND F006.upd_user = @P_user_id

	INSERT INTO #D001_ALL
	SELECT
		 F006.report_id
	,	 CASE F006.execute_div
		 WHEN 1 THEN M007.post_id
		 WHEN 2 THEN F004.comment_id
		 WHEN 3 THEN S001.account_id
		 END
	,	 CASE F006.execute_div
		 WHEN 1 THEN M007.post_title
		 WHEN 2 THEN SUBSTRING(F004.cmt_content,0,100)
		 WHEN 3 THEN S001.account_nm
		 END
	,	 CASE F006.execute_div
		 WHEN 1 THEN M007.post_content
		 WHEN 2 THEN F004.cmt_content
		 WHEN 3 THEN M001.avarta
		 END
	,	 F006.execute_div
	,	 CASE F006.execute_div
		 WHEN 1 THEN M007.cre_user
		 WHEN 2 THEN F004.cre_user
		 WHEN 3 THEN S001.cre_user
		 END
	,	 F006.checklist
	,	 F006.remark_text
	FROM F006
	LEFT JOIN S001 
	ON	S001.account_id = F006.target_id
	LEFT JOIN M001 
	ON	S001.user_id = M001.user_id
	LEFT JOIN F004
	ON	F006.target_id = F004.comment_id
	LEFT JOIN M007
	ON	F006.target_id = M007.post_id
	WHERE
			(	(@w_date_from		IS NULL)
		OR	(	F006.cre_date>=@w_date_from))
	AND		(	(@w_date_to		IS NULL)
		OR	(	F006.cre_date<=@w_date_to))
	AND		(	(ISNULL(F006.status,0) = 0)
		OR	(	ISNULL(F006.status,0) = 1 AND F006.upd_user=@P_user_id)
		OR	(	ISNULL(F006.status,0) = 1 AND F006.upd_user<>@P_user_id AND F006.upd_date<DATEADD(day,-1,@w_time))) 

	DELETE _D001_ALL FROM #D001_ALL _D001_ALL
	LEFT JOIN S001 
	ON	S001.account_id = _D001_ALL.target_own_id
	WHERE 
		@P_user_name <> ''
	AND	S001.account_nm NOT LIKE CONCAT('%',@P_user_name,'%')

	UPDATE _F006
	SET
		_F006.status = 1
	,	_F006.upd_user = @P_user_id
	,	_F006.upd_ip = @P_ip
	,	_F006.upd_prg = 'd001'
	,	_F006.upd_date = @w_time
	FROM F006 _F006
	INNER JOIN #D001_ALL
	ON _F006.report_id = #D001_ALL.report_id

	INSERT INTO #D001_HEADER
	SELECT 
		#D001_ALL.target_own_id
	,	MAX(S001.account_nm)
	,	#D001_ALL.denounce_div
	,	MAX(M999.content)
	,	COUNT(1)
	FROM #D001_ALL
	LEFT JOIN M999
	ON #D001_ALL.denounce_div = M999.number_id
	AND M999.name_div = 11
	LEFT JOIN S001
	ON #D001_ALL.target_own_id = S001.account_id
	GROUP BY
		#D001_ALL.target_own_id
	,	#D001_ALL.denounce_div

	INSERT INTO #D001_CHECKLIST
	SELECT 
		#D001_ALL.target_id		
	,	#D001_ALL.denounce_div	
	,	value				AS	type
	FROM #D001_ALL
	CROSS APPLY STRING_SPLIT(#D001_ALL.checklist, ',')
	ORDER BY 
		#D001_ALL.target_id		
	,	#D001_ALL.denounce_div

	INSERT INTO #D001_COMMENT
	SELECT 
		#D001_ALL.target_id		
	,	#D001_ALL.denounce_div	
	,	#D001_ALL.comment
	FROM #D001_ALL
	WHERE #D001_ALL.comment<>''
	ORDER BY 
		#D001_ALL.target_id		
	,	#D001_ALL.denounce_div

	INSERT INTO #D001_DETAIL
	SELECT
		#D001_ALL.target_id
	,	MAX(#D001_ALL.target_nm)
	,	MAX(#D001_ALL.target_nm_detail)
	,	#D001_ALL.denounce_div
	,	MAX(M999.content)
	,	COUNT(1)
	,	COUNT(CASE #D001_ALL.comment WHEN '' THEN NULL ELSE 1 END)
	,	MAX(S001.account_id)
	,	MAX(S001.account_nm)
	FROM #D001_ALL
	LEFT JOIN M999
	ON #D001_ALL.denounce_div = M999.number_id
	AND M999.name_div = 11
	LEFT JOIN S001
	ON #D001_ALL.target_own_id = S001.account_id
	GROUP BY
		#D001_ALL.target_id
	,	#D001_ALL.denounce_div

	--
	SELECT 
		_#D001_HEADER.id
	,	ROW_NUMBER() OVER(PARTITION BY #D001_HEADER.target_own_id ORDER BY #D001_HEADER.target_own_id ASC) AS row_id
	,	#D001_HEADER.target_own_id  
	,	#D001_HEADER.target_own_nm  
	,	#D001_HEADER.denounce_div   
	,	#D001_HEADER.denounce_div_nm
	,	#D001_HEADER.denounce_count
	,	_#D001_HEADER.target_count
	INTO #D001_HEADER_SIZE
	FROM #D001_HEADER
	LEFT JOIN 
	(SELECT ROW_NUMBER() OVER(ORDER BY #D001_HEADER.target_own_id ASC) AS id,target_own_id,COUNT(1) AS target_count FROM #D001_HEADER GROUP BY target_own_id)
	AS _#D001_HEADER
	ON #D001_HEADER.target_own_id = _#D001_HEADER.target_own_id
	WHERE _#D001_HEADER.id <= @P_page_size
	ORDER BY _#D001_HEADER.id

	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	
	-- GET TOTAL OF RECORDS
	SET @totalRecord = (
	SELECT
		COUNT(1)
	FROM(
		SELECT W1.target_own_id
		FROM #D001_HEADER AS W1
		GROUP BY W1.target_own_id
		)AS W2
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


	SELECT
		_#D001_HEADER_SIZE.id
	,	ROW_NUMBER() OVER(PARTITION BY #D001_HEADER_SIZE.target_own_id ORDER BY #D001_HEADER_SIZE.target_own_id ASC) AS row_id
	,	#D001_HEADER_SIZE.target_own_id  
	,	#D001_HEADER_SIZE.target_own_nm  
	,	#D001_HEADER_SIZE.denounce_div   
	,	#D001_HEADER_SIZE.denounce_div_nm
	,	#D001_HEADER_SIZE.denounce_count
	,	_#D001_HEADER_SIZE.target_count
	FROM #D001_HEADER_SIZE
	LEFT JOIN 
	(SELECT ROW_NUMBER() OVER(ORDER BY #D001_HEADER_SIZE.target_own_id ASC) AS id,target_own_id,COUNT(1) AS target_count FROM #D001_HEADER_SIZE GROUP BY target_own_id)
	AS _#D001_HEADER_SIZE
	ON #D001_HEADER_SIZE.target_own_id = _#D001_HEADER_SIZE.target_own_id
	ORDER BY _#D001_HEADER_SIZE.id

	SELECT * FROM #D001_DETAIL

	--[1] SELECT INFO PAGE
	SELECT	
		@totalRecord			AS totalRecord
	,	@pageMax				AS pageMax
	,	@P_page					AS [page]
	,	@P_page_size			AS pagesize

	SELECT
		MAX(#D001_DETAIL.id) AS id	
	,	#D001_CHECKLIST.target_id	
	,	#D001_CHECKLIST.denounce_div
	,	#D001_CHECKLIST.checklist
	,	COUNT(1) AS type_count
	,	MAX(M999.content) AS type_nm
	FROM #D001_CHECKLIST
	LEFT JOIN M999
	ON name_div=10
	AND number_id <>0
	AND #D001_CHECKLIST.checklist = M999.number_id
	LEFT JOIN #D001_DETAIL
	ON #D001_CHECKLIST.target_id = #D001_DETAIL.target_id
	AND #D001_CHECKLIST.denounce_div = #D001_DETAIL.denounce_div
	GROUP BY
		#D001_CHECKLIST.target_id	
	,	#D001_CHECKLIST.denounce_div
	,	#D001_CHECKLIST.checklist
	ORDER BY
		MAX(#D001_DETAIL.id)

	SELECT
		#D001_DETAIL.id AS id
	,	#D001_COMMENT.target_id	
	,	#D001_COMMENT.denounce_div
	,	#D001_COMMENT.comment
	FROM #D001_COMMENT
	LEFT JOIN #D001_DETAIL
	ON #D001_COMMENT.target_id = #D001_DETAIL.target_id
	AND #D001_COMMENT.denounce_div = #D001_DETAIL.denounce_div

	EXEC SPC_COM_M999_INQ1 '22'

END

