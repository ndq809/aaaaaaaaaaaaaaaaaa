IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M007_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_M007_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_M007_LST1]
	@P_name_div			SMALLINT				=	100 
AS
BEGIN
	SET NOCOUNT ON;
	SELECT
		M999.name_div
	,	M999.number_id
	,	M999.content
	,	M999.num_remark1
	,	M999.num_remark2
	,	M999.num_remark3
	,	M999.text_remark1
	,	M999.text_remark2
	,	M999.text_remark3
	FROM M999
	WHERE ((@P_name_div	=	100)
	OR (M999.name_div	=	@P_name_div))
	AND M999.del_flg	=	0
END

