IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_PERMISSION]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_PERMISSION]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_PERMISSION]
	
		@P_account_div			INT				=	0 
	,	@P_system_div			INT				=	0 
	,	@P_screen_id			NVARCHAR(15)	=	'' 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0
	,	@DynamicPivotQuery	NVARCHAR(MAX)
	,	@ColumnName			NVARCHAR(MAX)
	IF @P_screen_id <> ''
	BEGIN
		IF EXISTS(SELECT 1 FROM S002 WHERE S002.account_div = @P_account_div AND S002.screen_id = @P_screen_id)
		BEGIN
		SELECT
			 S002.account_div		AS account_div
		,	 S002.screen_id			AS screen_id
		,	 ISNULL(access_per	,0) AS access_per
		,	 ISNULL(menu_per	,0)	AS menu_per	
		,	 ISNULL(add_per		,0)	AS add_per		
		,	 ISNULL(edit_per	,0)	AS edit_per	
		,	 ISNULL(delete_per	,0)	AS delete_per
		,	 ISNULL(report_per	,0)	AS report_per
		FROM S002
		WHERE 
			S002.account_div = @P_account_div
		AND S002.system_div = @P_system_div
		AND	(@P_screen_id = ''
		OR S002.screen_id = @P_screen_id)
		END
		ELSE
		BEGIN
			SELECT
			 @P_account_div	AS account_div
		,	 @P_screen_id	AS screen_id
		,	 0  AS access_per
		,	 0	AS menu_per	
		,	 0	AS add_per		
		,	 0	AS edit_per	
		,	 0	AS delete_per
		,	 0	AS report_per
		END
	END
	ELSE
	BEGIN
		CREATE TABLE #PERMISSION
	(	 
		 screen_id	   NVARCHAR(50)
	,	 access_per	   NVARCHAR(50)
	)
	IF @P_account_div !=''
	BEGIN
	INSERT INTO #PERMISSION
	SELECT 
		 screen_id
	,	 access_per
	FROM
	(
	SELECT
		ROW_NUMBER() OVER(PARTITION BY _S002.system_div,_S002.screen_id ORDER BY _S002.account_div ASC) AS row_id
	,	M999.text_remark1 AS screen_id
	,	IIF(S002.screen_id IS NULL,_M999.content,'1') AS access_per
	FROM M999
	LEFT JOIN S002
	ON M999.text_remark1 = S002.screen_id
	AND S002.system_div = @P_system_div
	AND S002.account_div = @P_account_div
	LEFT JOIN S002 _S002
	ON M999.text_remark1 = _S002.screen_id
	AND _S002.system_div = @P_system_div
	AND _S002.access_per = 1
	LEFT JOIN M999 _M999
	ON _M999.number_id = _S002.account_div
	AND _M999.name_div = 14
	WHERE 
		M999.name_div = 13
	AND M999.number_id != 0
	AND M999.del_flg = 0
	)AS #TEMP
	WHERE #TEMP.row_id = 1
	END
	ELSE
	BEGIN
	INSERT INTO #PERMISSION
	SELECT
		 M999.text_remark1
	,	 IIF(S002.screen_id IS NULL,0,1)
	FROM M999
	LEFT JOIN S002
	ON M999.text_remark1 = S002.screen_id
	AND S002.system_div = @P_system_div
	AND S002.account_div = @P_account_div
	WHERE 
		M999.name_div = 13
	AND M999.number_id != 0
	AND M999.del_flg = 0
	END
	SELECT @ColumnName= ISNULL(@ColumnName + ',','') + QUOTENAME(screen_id)
	FROM (SELECT DISTINCT screen_id FROM #PERMISSION) AS screen_ids
	SET @DynamicPivotQuery = 
	  N'SELECT '+ @ColumnName + '
		FROM #PERMISSION
		PIVOT( MAX(access_per) 
			  FOR screen_id IN (' + @ColumnName + ')) AS PVTTable'
	execute(@DynamicPivotQuery)
	END
END

