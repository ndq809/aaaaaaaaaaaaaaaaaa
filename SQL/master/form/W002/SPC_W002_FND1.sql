﻿/****** Object:  StoredProcedure [dbo].[SPC_USER_FND2]    Script Date: 12/7/2017 1:41:50 PM ******/
IF EXISTS (SELECT * FROM sys.objects WHERE OBJECT_ID = OBJECT_ID(N'[dbo].[SPC_W002_FND1]') AND TYPE IN (N'P', N'PC'))
BEGIN
    DROP PROCEDURE [dbo].[SPC_W002_FND1]
END
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_W002_FND1]
AS
BEGIN
	SET NOCOUNT ON;
	--[0]: 
	EXEC SPC_COM_M999_INQ1 '7'
	EXEC SPC_COM_M999_INQ1 '8'
END
GO
