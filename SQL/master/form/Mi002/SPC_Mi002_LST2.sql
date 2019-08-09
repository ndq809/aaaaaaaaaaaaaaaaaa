IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_Mi002_LST2]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_Mi002_LST2]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO
-- 

CREATE PROCEDURE [dbo].[SPC_Mi002_LST2]
	
		@P_catalogue_div		INT				=	0 
	,	@P_catalogue_id			NVARCHAR(15)	=	'' 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	CREATE TABLE #DATA(
		group_nm	NVARCHAR(255)
	,	post_count	INT
	,	data_type   INT
	)

	IF @P_catalogue_div <> 1
	BEGIN
		INSERT INTO #DATA
		SELECT
			MAX(M003.group_nm)
		,	COUNT(M007.post_id)
		,	0
		FROM M002
		INNER JOIN M003
		ON	M002.catalogue_div = M003.catalogue_div
		AND M002.catalogue_id = M003.catalogue_id
		AND M003.del_flg = 0
		INNER JOIN M007
		ON M003.catalogue_div = M007.catalogue_div
		AND M003.catalogue_id = M007.catalogue_id
		AND M003.group_id = M007.group_id
		AND M007.del_flg = 0
		WHERE M002.catalogue_div = @P_catalogue_div
		AND M002.catalogue_id = @P_catalogue_id
		GROUP BY 
			M003.group_id
	END
	ELSE
	BEGIN
		INSERT INTO #DATA
		SELECT
			MAX(M003.group_nm)
		,	COUNT(F009.briged_id)
		,	1
		FROM M002
		INNER JOIN M003
		ON	M002.catalogue_div = M003.catalogue_div
		AND M002.catalogue_id = M003.catalogue_id
		AND M003.del_flg = 0
		INNER JOIN M007
		ON M003.catalogue_div = M007.catalogue_div
		AND M003.catalogue_id = M007.catalogue_id
		AND M003.group_id = M007.group_id
		AND M007.del_flg = 0
		INNER JOIN F009
		ON M007.briged_id = F009.briged_id
		AND F009.briged_div = 1
		WHERE M002.catalogue_div = @P_catalogue_div
		AND M002.catalogue_id = @P_catalogue_id
		GROUP BY 
			M003.group_id
	END

	SELECT * FROM #DATA

	SELECT
		COUNT(#DATA.group_nm) AS group_count
	,	SUM(#DATA.post_count)	AS post_sum
	FROM #DATA
	GROUP BY #DATA.data_type
	
END

