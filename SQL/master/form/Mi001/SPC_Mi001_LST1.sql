﻿IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_Mi001_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_Mi001_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_Mi001_LST1]

AS
BEGIN
	SET NOCOUNT ON;
	
	--
	EXEC SPC_COM_M999_INQ1 '25'
	EXEC SPC_COM_M999_INQ1 '26'
	EXEC SPC_COM_M999_INQ1 '7'
	EXEC SPC_COM_M999_INQ1 '20'
	EXEC SPC_COM_M999_INQ1 '14'

END

