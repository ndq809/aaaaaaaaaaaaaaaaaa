IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COMMON_GROUP]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COMMON_GROUP]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COMMON_GROUP]
		@P_catalogue_id			NVARCHAR(15)				=	''

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
		M003.group_id			AS value
	,	M003.group_nm			AS text	 
	,	M002.catalogue_id		AS catalogue_id
	,	M002.catalogue_div		AS catalogue_div
	FROM M003
	INNER JOIN M002
	ON M003.catalogue_id = M002.catalogue_id
	AND M002.del_flg = 0
	WHERE	M003.del_flg = 0 
	AND		(	(@P_catalogue_id	= '')
		OR	(	M003.catalogue_id		= @P_catalogue_id))

	--
END

