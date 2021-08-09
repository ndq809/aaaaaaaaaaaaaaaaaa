/****** Object:  StoredProcedure [dbo].[SPC_USER_FND2]    Script Date: 12/7/2017 1:41:50 PM ******/
IF EXISTS (SELECT * FROM sys.objects WHERE OBJECT_ID = OBJECT_ID(N'[dbo].[SPC_S001_FND2]') AND TYPE IN (N'P', N'PC'))
BEGIN
    DROP PROCEDURE [dbo].[SPC_S001_FND2]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_S001_FND2]
	@P_target_div			INT				=	0
AS
BEGIN
	DECLARE 
		@w_name_div		INT		= 0
	SET @w_name_div = (SELECT M999.num_remark1 FROM M999 WHERE M999.name_div = 4 AND M999.number_id = @P_target_div AND M999.del_flg = 0)
	SET NOCOUNT ON;
	--[0]: 
	SELECT 
		number_id AS value
	,	content AS text
	FROM M999
	WHERE
	M999.name_div = @w_name_div
	AND M999.del_flg =0
END
GO
