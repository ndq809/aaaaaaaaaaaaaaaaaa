IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COMMON_GROUP_USER]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COMMON_GROUP_USER]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COMMON_GROUP_USER]
		@P_catalogue_div			INT				=	0

AS
BEGIN
	SET NOCOUNT ON;
	
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	--
	SELECT DISTINCT
		 M003.catalogue_id	
	,	 M003.group_id	 AS value
	,	 M003.group_nm   AS text	    
	FROM M003
	INNER JOIN M007
	ON M007.catalogue_div = M003.catalogue_div
	AND M007.catalogue_id = M003.catalogue_id
	AND M007.group_id = M003.group_id
	AND M007.del_flg = 0
	AND M007.post_div = 1
	AND M007.record_div = 2
	WHERE	M003.del_flg = 0 
	AND		M003.catalogue_div = @P_catalogue_div
	

	--
END

