IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COMMON_GET_SUGGEST]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COMMON_GET_SUGGEST]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COMMON_GET_SUGGEST]
AS
BEGIN 
	SET NOCOUNT ON;
	--
	SELECT 
		M007.post_id
	,	M007.post_title
	,	M013.tag_id
	,	LOWER(M013.tag_nm) AS tag_nm
	FROM F009
	INNER JOIN M013
	ON M013.tag_id = F009.target_id
	AND M013.tag_div = 1
	INNER JOIN M007 
	ON M007.briged_id = F009.briged_id 
	WHERE 
		F009.briged_div = 2
	AND F009.briged_own_id = M007.post_id
	AND F009.briged_own_div = 0
	AND M007.record_div = 2

	SELECT
		tag_id
	,	LOWER(M013.tag_nm) AS tag_nm
	FROM M013
	WHERE M013.tag_div = 2

	
END

