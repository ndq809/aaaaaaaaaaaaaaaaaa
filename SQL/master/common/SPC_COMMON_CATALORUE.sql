IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COMMON_CATALORUE]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COMMON_CATALORUE]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COMMON_CATALORUE]
	@P_catalogue_div			INT				=	-1

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
	,	 M002.catalogue_div   AS catalogue_div	    
	FROM M002
	WHERE M002.del_flg = 0 
	AND		(	(@P_catalogue_div	= -1)
		OR	(	M002.catalogue_div		= @P_catalogue_div))

	--
END

