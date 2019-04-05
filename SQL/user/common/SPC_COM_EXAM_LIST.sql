IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_EXAM_LIST]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_EXAM_LIST]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_EXAM_LIST]
		@P_row_id				INT	=	0
	,	@P_target_id			INT	=	0
	,	@P_order_div			INT	=	0
	,	@P_page					INT	=	0
	,	@P_target_div			INT	=	0
	,	@P_account_id			NVARCHAR(15)	=	'' 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	SELECT
		@P_row_id AS row_id
	,	M012.example_id AS id
	,	M012.language1_content
	,	M012.language2_content
	,	M012.clap
	,	IIF(M012.cre_prg <> 'W002',S001.account_nm,N'Hệ thống') AS cre_user
	,	FORMAT(M012.cre_date,'dd/MM/yyyy HH:mm') AS cre_date
	,	@P_order_div AS order_div
	,	IIF(F008.target_id IS NULL,0,1) AS effected
	FROM M012
	LEFT JOIN F008
	ON M012.example_id = F008.target_id
	AND F008.user_id = @P_account_id
	AND F008.execute_div = 1
	AND F008.execute_target_div = @P_target_div
	LEFT JOIN S001 
	ON S001.account_id = M012.cre_user
	WHERE
		M012.target_id			= @P_target_id
	AND M012.target_div			= @P_target_div
	ORDER BY
	CASE @P_order_div
		WHEN 1 THEN M012.cre_date
	END DESC,
	CASE @P_order_div
		WHEN 2 THEN M012.clap		
	END DESC,
		M012.target_id ASC
	OFFSET (@P_page-1) * 5 ROWS
	FETCH NEXT 5 ROWS ONLY

	SELECT
		@P_row_id AS row_id	 
	,	COUNT(*) AS totalRecord
	,	CEILING(CAST(COUNT(*) AS FLOAT) / 5) AS pageMax
	,	@P_page AS page
	,	5 AS pagesize
	FROM M012
	WHERE
		M012.target_id				= @P_target_id
	GROUP BY 
		M012.target_id
END

