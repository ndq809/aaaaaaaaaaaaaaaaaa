IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_DISCUSS_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_DISCUSS_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_DISCUSS_LST1]
	
	@P_target_id			NVARCHAR(15)	=	'' 
,	@P_account_id			NVARCHAR(15)	=	''

AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	CREATE TABLE #TEMP(
		post_id	 INT
	)

	SELECT TOP 10
		F009.target_id AS tag_id
	,	M013.tag_nm
	,	COUNT(F009.target_id) AS tag_time
	FROM F009
	INNER JOIN M013
	ON M013.tag_id = F009.target_id
	AND M013.tag_div = 3
	WHERE F009.briged_div = 2
	GROUP BY 
		F009.target_id
	,	M013.tag_nm
	ORDER BY
	COUNT(F009.target_id) DESC

	SELECT TOP 10
		M007.post_id
	,	M007.post_title
	,	COUNT(M007.post_id) + ISNULL(SUM(F004.cmt_like),0) AS popular
	FROM M007
	INNER JOIN F008
	ON M007.post_id = F008.target_id
	AND execute_div = 4
	AND execute_target_div = 5
	LEFT JOIN F004
	ON F004.target_id = M007.post_id
	WHERE
	M007.post_div = 3
	AND	M007.catalogue_div = 6

	GROUP BY M007.post_id
	,	M007.post_title
	ORDER BY COUNT(M007.post_id) + ISNULL(SUM(F004.cmt_like),0) DESC

	SET @P_target_id = (SELECT TOP 1 M007.post_id FROM M007 WHERE M007.post_id = @P_target_id AND M007.del_flg = 0)

	SELECT
			''					AS catalogue_tranfer
		,	''					AS group_transfer
		,	@P_target_id		AS target_id

	SELECT
		M007.post_id
	,	M007.post_title
	FROM M007
	INNER JOIN F008
	ON M007.post_id = F008.target_id
	AND execute_div = 4
	AND execute_target_div = 5
	WHERE M007.cre_user = @P_account_id
	AND M007.post_div = 3
	AND	M007.catalogue_div = 6
	AND M007.del_flg = 0

	SELECT
		M013.tag_id
	,	M013.tag_nm
	FROM M013
	WHERE M013.tag_div = 3
	AND M013.del_flg = 0

	

END

