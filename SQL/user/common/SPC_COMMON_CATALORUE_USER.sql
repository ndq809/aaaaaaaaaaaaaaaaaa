IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COMMON_CATALORUE_USER]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COMMON_CATALORUE_USER]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COMMON_CATALORUE_USER]
	@P_catalogue_div			TINYINT				=	0

AS
BEGIN
	SET NOCOUNT ON;
	
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	--
	SELECT
		 M002.catalogue_id	 AS value
	,	 M002.catalogue_nm   AS text	    
	FROM M002
	INNER JOIN M003
	ON M002.catalogue_id = M003.catalogue_id
	AND M002.catalogue_div = M003.catalogue_div
	AND M003.del_flg = 0
	INNER JOIN M007
	ON M003.group_id = M007.group_id
	AND M002.catalogue_id = M007.catalogue_id
	AND M002.catalogue_div = M007.catalogue_div
	AND M007.del_flg = 0
	AND m007.post_div = 1
	WHERE M002.del_flg = 0 
	AND	M002.catalogue_div		= @P_catalogue_div

	--
END

