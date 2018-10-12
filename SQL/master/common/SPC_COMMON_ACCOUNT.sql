IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COMMON_ACCOUNT]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COMMON_ACCOUNT]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COMMON_ACCOUNT]
		@P_user_id			INT					=	0
	,	@P_system_div		INT					=	0

AS
BEGIN
	SET NOCOUNT ON;
	
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	--
	IF @P_system_div = 1
	BEGIN
		SELECT M001.avarta
		FROM M001
		WHERE M001.user_id = @P_user_id
	END
	ELSE
	BEGIN
		SELECT M009.avarta
		FROM M009
		WHERE M009.employee_id = @P_user_id
	END

	--
END

