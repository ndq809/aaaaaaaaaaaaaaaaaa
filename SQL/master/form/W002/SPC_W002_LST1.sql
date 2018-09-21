IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_W002_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_W002_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_W002_LST1]
	@P_post_id			NVARCHAR(15)				=	''

AS
BEGIN
	SET NOCOUNT ON;
	SELECT
		 *	    
	FROM M007
	WHERE 
	M007.post_id		= @P_post_id
	AND	M007.del_flg = 0

	EXEC SPC_COM_M999_INQ1 '8'

	SELECT
		M006.id AS vocabulary_code
	,	M006.vocabulary_id
	,	M006.vocabulary_div
	,	M006.vocabulary_nm
	,	M006.spelling
	,	M006.mean
	,	M006.explain
	FROM F009
	JOIN M006
	ON F009.vocabulary_code = M006.id
	AND M006.del_flg = 0 
	WHERE F009.briged_id 
	IN (SELECT
		 M007.briged_id	    
	FROM M007
	WHERE 
	M007.post_id		= @P_post_id
	AND	M007.del_flg = 0)

	SELECT 
		M012.language1_content
	,	M012.language2_content
	FROM M012
	WHERE 
	M012.target_id		= @P_post_id
	AND	M012.del_flg = 0

	SELECT
		M004.question_id 
	,	M004.question_content
	,	M005.answer_content
	,	M005.verify
	FROM M004
	JOIN M005
	ON M004.question_id = M005.question_id
	WHERE M004.post_id = @P_post_id
	--
END

