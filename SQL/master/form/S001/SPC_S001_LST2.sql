IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_S001_LST2]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_S001_LST2]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_S001_LST2]
	
	@P_account_div			INT				=	0
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0
	
	CREATE TABLE #S003
	(	 account_div		int
	,	 screen_id	   NVARCHAR(50)
	,	 screen_nm	   NVARCHAR(150)
	)

	INSERT INTO #S003
	SELECT
		 @P_account_div
	,	 M999.text_remark1
	,	 M999.content
	FROM M999
	WHERE 
		M999.name_div = 13
	AND M999.number_id != 0
	AND M999.del_flg = 0

	SELECT DISTINCT
		 M999.content AS screen_group_nm
	FROM M999
	WHERE M999.name_div = 999
	AND M999.number_id = 13
	AND M999.del_flg = 0

	SELECT
		 #S003.account_div
	,	 #S003.screen_id
	,	 #S003.screen_nm
	,	 S002.remark
	,	 ISNULL(access_per	,0) AS access_per
	,	 ISNULL(menu_per	,0)	AS menu_per	
	,	 ISNULL(add_per		,0)	AS add_per		
	,	 ISNULL(edit_per	,0)	AS edit_per	
	,	 ISNULL(delete_per	,0)	AS delete_per
	,	 ISNULL(report_per	,0)	AS report_per
	FROM #S003
	LEFT JOIN S002
	ON #S003.account_div=S002.account_div
	AND #S003.screen_id=S002.screen_id
	WHERE 
		#S003.account_div=@P_account_div
	DROP TABLE #S003
END

