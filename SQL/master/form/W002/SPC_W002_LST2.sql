IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_W002_LST2]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_W002_LST2]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_W002_LST2]
	@P_catalogue_div			INT				=	0

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@w_tag_div				INT
	
	EXEC SPC_COMMON_CATALORUE @P_catalogue_div

	SET @w_tag_div = (SELECT M999.num_remark1 FROM M999 WHERE M999.name_div = 7 AND M999.number_id = @P_catalogue_div)
	SELECT
		M013.tag_id
	,	M013.tag_nm
	FROM M013
	WHERE M013.del_flg = 0
	AND M013.tag_div = @w_tag_div
	--
END

