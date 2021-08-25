/****** Object:  StoredProcedure [dbo].[SPC_USER_FND2]    Script Date: 12/7/2017 1:41:50 PM ******/
IF EXISTS (SELECT * FROM sys.objects WHERE OBJECT_ID = OBJECT_ID(N'[dbo].[SPC_S001_FND1]') AND TYPE IN (N'P', N'PC'))
BEGIN
    DROP PROCEDURE [dbo].[SPC_S001_FND1]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_S001_FND1]
AS
BEGIN
	SET NOCOUNT ON;
	--[0]: 
	EXEC SPC_COM_M999_INQ1 '4'
	SELECT 
		M999.number_id AS value
	,	M999.content AS text
	,	_M999.number_id AS user_div
	FROM M999
	INNER JOIN M999 _M999
	ON
		_M999.name_div = 4
	AND M999.name_div = _M999.num_remark1
	WHERE
		M999.del_flg =0
END
GO
