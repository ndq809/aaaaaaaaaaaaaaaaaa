IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_MENU]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_MENU]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_MENU]
	
		@P_account_div			INT				=	100 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	SELECT DISTINCT 
		S003.screen_group
	,	M999.content AS screen_group_nm
	,	M999.text_remark1 AS group_icon
	FROM S003
	LEFT JOIN M999
	ON S003.screen_group = M999.number_id
	AND M999.name_div = 6
	INNER JOIN S002 
	ON S003.screen_id=S002.screen_id
	AND S002.del_flg=0
	WHERE 
		(@P_account_div=100
	OR  S002.account_div = @P_account_div)
	AND	S002.menu_per=1
	AND S003.del_flg=0
	ORDER BY S003.screen_group
	SELECT
		 S003.screen_id		AS screen_id
	,	 S003.screen_nm		AS screen_nm
	,	 S003.screen_url	AS screen_url
	,	 S003.screen_group	AS screen_group	
	FROM S003
	INNER JOIN S002 
	ON S003.screen_id=S002.screen_id
	AND S002.del_flg=0
	WHERE 
		(@P_account_div=100
	OR  S002.account_div = @P_account_div)
	AND	S002.menu_per=1
	AND S003.del_flg=0
	AND S003.screen_group != 0
END

