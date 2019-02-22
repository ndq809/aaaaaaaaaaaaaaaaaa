IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_REGISTER_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_REGISTER_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_REGISTER_LST1]
 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	SELECT 
		M999.number_id  AS lib_id
	,	M999.content	AS lib_nm 
	FROM M999
	WHERE
		M999.name_div = 1
	AND M999.del_flg = 0

	SELECT 
		M999.number_id  AS lib_id
	,	M999.content	AS lib_nm 
	FROM M999
	WHERE
		M999.name_div = 15
	AND M999.del_flg = 0

	SELECT 
		M999.number_id  AS lib_id
	,	M999.content	AS lib_nm 
	FROM M999
	WHERE
		M999.name_div = 16
	AND M999.del_flg = 0
END

