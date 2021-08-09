IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M008_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_M008_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_M008_LST1]
	@P_name_div			SMALLINT				=	1
AS
BEGIN
	SET NOCOUNT ON;

	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0
	,	@DynamicPivotQuery	NVARCHAR(MAX)
	,	@ColumnName			NVARCHAR(MAX)

	CREATE TABLE #UPR
	(	 
		 target_dtl_div	   INT
	,	 target_dtl_nm	   NVARCHAR(200)
	,	 price_div		   INT
	,	 upr			   MONEY
	)

	INSERT INTO #UPR
	SELECT
		M999.number_id AS target_dtl_div
	,	M999.content AS target_dtl_nm
	,	ISNULL(M014.price_div,-1)
	,	M014.upr
	FROM M999
	LEFT JOIN M014 ON
		M014.target_div = M999.num_remark1
	AND	M014.target_dtl_div = M999.number_id
	WHERE
		M999.name_div = 5
	AND M999.del_flg = 0
	AND M999.num_remark1 =	@P_name_div

	SELECT @ColumnName = ISNULL(@ColumnName + ',','') + QUOTENAME(price_div)
	FROM (SELECT DISTINCT price_div FROM #UPR) AS screen_ids

	IF @ColumnName IS NOT NULL
	BEGIN
		SET @DynamicPivotQuery = 
		  N'SELECT DISTINCT target_dtl_div,target_dtl_nm, '+ @ColumnName + '
			FROM #UPR
			PIVOT( MAX(upr) 
				  FOR price_div IN (' + @ColumnName + ')) AS PVTTable'

		EXECUTE(@DynamicPivotQuery)
	END
	ELSE
	BEGIN
		SELECT * FROM #UPR
	END

	SELECT M999.num_remark1 AS price_count
	FROM M999
	WHERE
		M999.name_div = 19
	AND M999.number_id = @P_name_div
END

