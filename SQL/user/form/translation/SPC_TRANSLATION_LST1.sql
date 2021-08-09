IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_TRANSLATION_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_TRANSLATION_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_TRANSLATION_LST1]
	
	@P_target_id			NVARCHAR(15)	=	'' 
,	@P_account_id			NVARCHAR(15)	=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	CREATE TABLE #TRANSLATION(
		row_id				INT
	,	post_id				NVARCHAR(15)
	,	post_title			NVARCHAR(250)
	,	post_title_tran		NVARCHAR(250)
	,	en_text				NTEXT
	,	vi_text				NTEXT
	,	post_div			INT
	,	briged_id			NVARCHAR(15)
	,	cre_user			NVARCHAR(50)
	,	cre_date			DATETIME2
	,	upd_user			NVARCHAR(50)
	,	upd_date			DATETIME2
	,	selected			INT
	)

	INSERT INTO #TRANSLATION
	SELECT
		ROW_NUMBER() OVER(ORDER BY M007.post_id ASC) AS row_id
	,	post_id		
	,	post_title	
	,	post_title_tran	
	,	post_content AS en_text		
	,	post_content_tran AS vi_text		
	,	post_div	
	,	briged_id	
	,	cre_user	
	,	cre_date	
	,	upd_user	
	,	upd_date	
	,	IIF(M007.post_id = @P_target_id,1,0) AS selected
	FROM M007
	WHERE 
		M007.cre_user = @P_account_id 
	AND del_flg = 0
	ORDER BY 
	CASE
	WHEN M007.post_id = @P_target_id THEN 1
	END
	,	M007.upd_date DESC 

	SELECT * FROM #TRANSLATION

	SELECT
		#TRANSLATION.row_id
	,	M013.tag_id
	,	M013.tag_nm
	FROM M013
	LEFT JOIN F009
	ON F009.target_id = M013.tag_id
	AND F009.briged_div = 2
	INNER JOIN #TRANSLATION 
	ON F009.briged_id = #TRANSLATION.briged_id
	AND  F009.briged_own_div = 0
	WHERE M013.tag_div = 6
	AND M013.del_flg = 0

END

