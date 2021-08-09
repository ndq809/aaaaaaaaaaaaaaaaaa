IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_P006_INQ1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_P006_INQ1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_P006_INQ1]
AS
BEGIN
	SET NOCOUNT ON;
	
	EXEC SPC_COM_M999_INQ1 '4','0','14'
	EXEC SPC_COM_M999_INQ1 '14'
	EXEC SPC_COM_M999_INQ1 '15'
	EXEC SPC_COM_M999_INQ1 '18'

	--
END

