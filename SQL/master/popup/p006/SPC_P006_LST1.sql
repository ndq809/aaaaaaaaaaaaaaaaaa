IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_P006_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_P006_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_P006_LST1]
	@P_system_div		INT					=	0
,	@P_rank_from		INT					=	0
,	@P_rank_to			INT					=	0
,	@P_job				INT					=	0
,	@P_city				INT					=	0
,	@P_account_nm		NVARCHAR(50)		=	''
,	@P_user_list		NVARCHAR(MAX)		=	''
,	@P_page_size		INT					=	50
,	@P_page				INT					=	1

AS
BEGIN
	SET NOCOUNT ON;
	
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	--
	CREATE TABLE #P006(
		account_id		NVARCHAR(15)
	,	account_nm		NVARCHAR(50)
	,	rank			NVARCHAR(50)
	,	job				NVARCHAR(100)
	,	city			NVARCHAR(255)
	)
	
	--
	INSERT INTO #P006
	SELECT
		S001.account_id	
	,	S001.account_nm     
	,	_M999_1.content
	,	_M999_2.content
	,	_M999_3.content
	FROM S001
	LEFT JOIN M001
	ON S001.user_id = M001.user_id
	AND M001.del_flg = 0
	LEFT JOIN M999 _M999_1
	ON	_M999_1.name_div = 14
	AND _M999_1.number_id = S001.account_div
	AND _M999_1.del_flg = 0
	LEFT JOIN M999 _M999_2
	ON	_M999_2.name_div = 15
	AND _M999_2.number_id = M001.job
	AND _M999_2.del_flg = 0
	LEFT JOIN M999 _M999_3
	ON	_M999_3.name_div = 18
	AND _M999_3.number_id = M001.position
	AND _M999_3.del_flg = 0
	LEFT JOIN
	(
	SELECT              
            account_id AS account_id              
        FROM OPENJSON(@P_user_list) WITH(
        	account_id	            VARCHAR(10)	'$.account_id'
        )
	)TEMP ON
	TEMP.account_id = S001.account_id
	WHERE S001.del_flg = 0 
	AND		((	@P_system_div		= 0)
		OR	(	S001.system_div = @P_system_div))
	AND		((	@P_job		= 0)
		OR	(	M001.job = @P_job))
	AND		((	@P_city		= 0)
		OR	(	M001.position = @P_city))
	AND		((	@P_rank_from	= 0 AND @P_rank_to = 0)
		OR	(	@P_rank_from	<> 0 AND @P_rank_to	<> 0 AND S001.rank_id	>= @P_rank_from AND S001.rank_id <= @P_rank_to)
		OR	(	@P_rank_from	= 0 AND S001.rank_id < @P_rank_to)
		OR	(	@P_rank_to	= 0 AND S001.rank_id >= @P_rank_from))
	AND TEMP.account_id IS NULL

	--
	SELECT 
		*
	FROM #P006
	ORDER BY
		#P006.account_id ASC
	OFFSET (@P_page-1) * @P_page_size ROWS
	FETCH NEXT @P_page_size ROWS ONLY

	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	
	-- GET TOTAL OF RECORDS
	SET @totalRecord = (
		SELECT COUNT(W1.account_id)	AS	total 
		FROM #P006 AS W1
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

