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
	WHERE M002.del_flg = 0 
	AND	M002.catalogue_div		= @P_catalogue_div
	AND M002.catalogue_id IN (SELECT M003.catalogue_id FROM M003)

	--
END

