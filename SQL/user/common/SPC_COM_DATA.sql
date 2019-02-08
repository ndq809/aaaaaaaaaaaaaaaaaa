IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_DATA]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_DATA]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_DATA]
		@P_account_id			NVARCHAR(15)	=	''
,		@P_account_div			INT				=	0
,		@P_system_div			INT				=	0
,		@P_screen_div			INT				=	'' 
 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	EXEC SPC_COM_PERMISSION @P_account_div,@P_system_div,'';

	SELECT
		M013.tag_id
	,	M013.tag_nm
	FROM M013
	WHERE M013.tag_div = 3
	AND M013.del_flg = 0
END

