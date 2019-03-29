IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_LISTENING_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_LISTENING_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_LISTENING_LST1]
	
	@P_target_id			NVARCHAR(15)	=	'' 
,	@P_account_id			NVARCHAR(15)	=	''
,	@P_catalogue_id			NVARCHAR(15)	=	''
,	@P_group_id				NVARCHAR(15)	=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	CREATE TABLE #TEMP(
		post_id	 INT
	,	catalogue_id INT
	,	group_id	 INT
	)

	EXEC SPC_COMMON_CATALORUE_USER '3'

	INSERT INTO #TEMP
	SELECT 
		M007.post_id
	,	M007.catalogue_id
	,	M007.group_id
	FROM M007
	WHERE 
		M007.post_id = @P_target_id
	AND M007.record_div = 2
	AND M007.del_flg = 0

	SELECT
		F003.id 
	,	M002.catalogue_nm
	,	M003.group_nm
	,	IIF(#TEMP.post_id IS NULL,'0','1') AS focused
	FROM F003
	INNER JOIN M002
	ON F003.item_1 = M002.catalogue_id
	INNER JOIN M003
	ON F003.item_2 = M003.group_id
	LEFT JOIN #TEMP
	ON M002.catalogue_id = #TEMP.catalogue_id
	AND M003.group_id = #TEMP.group_id
	WHERE
		F003.connect_div = 1
	AND F003.screen_div = 3
	AND F003.del_flg = 0
	AND F003.user_id = @P_account_id

	IF NOT EXISTS(
		SELECT
			*
		FROM F003
		INNER JOIN #TEMP
		ON F003.item_1 = #TEMP.catalogue_id
		AND F003.item_2 = #TEMP.group_id
		WHERE
			F003.connect_div = 1
		AND F003.screen_div = 3
		AND F003.del_flg = 0
		AND F003.user_id = @P_account_id
	)
	BEGIN
		IF @P_catalogue_id <> '' AND @P_group_id <> '' AND EXISTS(SELECT * FROM #TEMP WHERE #TEMP.catalogue_id = @P_catalogue_id AND #TEMP.group_id = @P_group_id)
		BEGIN
			SELECT 
				M002.catalogue_nm AS catalogue_tranfer
			,	M003.group_nm AS group_transfer
			,	@P_target_id	   AS target_id
			FROM #TEMP
			INNER JOIN M002
			ON #TEMP.catalogue_id = M002.catalogue_id
			INNER JOIN M003
			ON #TEMP.group_id = M003.group_id
			WHERE #TEMP.catalogue_id = @P_catalogue_id 
			AND #TEMP.group_id = @P_group_id
			AND M002.catalogue_div = 3

		END
		ELSE
		BEGIN
			SELECT TOP 1 
				M002.catalogue_nm AS catalogue_tranfer
			,	M003.group_nm AS group_transfer
			,	@P_target_id	   AS target_id
			FROM #TEMP
			INNER JOIN M002
			ON #TEMP.catalogue_id = M002.catalogue_id
			INNER JOIN M003
			ON #TEMP.group_id = M003.group_id
			WHERE M002.catalogue_div = 3
		END
		
	END
	ELSE
	BEGIN
		SELECT
			''					AS catalogue_tranfer
		,	''					AS group_transfer
		,	@P_target_id		AS target_id
	END

	EXEC SPC_COMMON_GROUP_USER '3'

END

