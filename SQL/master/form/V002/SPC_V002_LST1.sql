IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_V002_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_V002_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_V002_LST1]
	@P_vocabulary_id			NVARCHAR(15)				=	''
,	@P_vocabulary_dtl_id		TINYINT						=	''

AS
BEGIN
	SET NOCOUNT ON;

	CREATE TABLE #WORD(
		id					INT
	,	relationship_div	INT

	)

	INSERT INTO #WORD
	SELECT
		F012.vocabulary_target
	,	F012.relationship_div
	FROM M006
	INNER JOIN F012
	ON M006.id = F012.vocabulary_src
	WHERE 
		M006.vocabulary_id			= @P_vocabulary_id
	AND	M006.vocabulary_dtl_id		= @P_vocabulary_dtl_id
	AND	M006.del_flg = 0

	EXEC SPC_V002_FND1
	SELECT
		M006.vocabulary_id
	,	M006.vocabulary_dtl_id
	,	M006.vocabulary_nm
	,	M006.vocabulary_div
	,	M006.image
	,	M006.audio
	,	M006.mean
	,	M006.spelling
	,	M006.specialized
	,	M006.field	    
	FROM M006
	WHERE 
		M006.vocabulary_id			= @P_vocabulary_id
	AND	M006.vocabulary_dtl_id		= @P_vocabulary_dtl_id
	AND	M006.del_flg = 0

	SELECT 
		M012.language1_content
	,	M012.language2_content
	FROM M012
	INNER JOIN M006
	ON M012.target_id				= M006.id
	AND M006.del_flg = 0
	WHERE 
		M006.vocabulary_id				= @P_vocabulary_id
	AND	M006.vocabulary_dtl_id			= @P_vocabulary_dtl_id
	AND	M012.del_flg = 0
	AND M012.target_div = 1

	SELECT
		M006.Vocabulary_id		AS	vocabulary_id		
	,	M006.Vocabulary_dtl_id  AS	vocabulary_dtl_id  
	,	M006.Vocabulary_nm		AS	vocabulary_nm		
	,	M999_1.content			AS vocabulary_div
	,	M999_2.content			AS specialized
	,	M999_3.content			AS field			
	,   M006.spelling			
	,	M006.mean
	,	#WORD.relationship_div 				
	FROM M006
	LEFT JOIN M999 M999_1
	ON	M006.vocabulary_div = M999_1.number_id
	AND	M999_1.name_div = 8
	LEFT JOIN M999 M999_2
	ON	M006.specialized = M999_2.number_id
	AND	M999_2.name_div = 23
	LEFT JOIN M999 M999_3
	ON	M006.field = M999_3.number_id
	AND	M999_3.name_div = 24
	INNER JOIN #WORD
	ON #WORD.id = M006.id
	--
END

