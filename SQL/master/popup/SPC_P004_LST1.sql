IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_P004_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_P004_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_P004_LST1]
	@P_post_id			NVARCHAR(15)				=	''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@w_tag_div				INT

	CREATE TABLE #P003(
		vocabulary_id			NVARCHAR(15)
	,	vocabulary_dtl_id    	NVARCHAR(15)
	,	vocabulary_nm           NVARCHAR(50)
	,	vocabulary_div			INT	
	,	vocabulary_div_nm		NVARCHAR(50)
	,   spelling				NVARCHAR(50)	
	,	mean					NVARCHAR(200)
	,	explain					NVARCHAR(200)
	,	image					NVARCHAR(200)
	,	audio					NVARCHAR(200)
	,	remark					NVARCHAR(150)	
	)

	SELECT
		 M007.catalogue_div
	,	 M007.post_id
	,	 M999.content
	,	 M007.catalogue_id
	,	 M002.catalogue_nm
	,	 M007.group_id
	,	 M003.group_nm
	,	 M007.post_id
	,	 M007.post_title
	,	 M007.post_content
	,	 M007.post_media
	,	CASE M007.media_div
				WHEN 3 THEN 'video/youtube'
				WHEN 4 THEN 'video/facebook'
				ELSE 'video'
				END AS media_div
	FROM M007
	LEFT JOIN M002
	ON	M007.catalogue_id = M002.catalogue_id
	LEFT JOIN M003
	ON	M007.group_id = M003.group_id
	LEFT JOIN M999
	ON	(M007.catalogue_div = M999.number_id)
	AND	(M999.name_div = 7)
	WHERE 
	M007.post_id		= @P_post_id
	AND	M007.del_flg = 0

	INSERT INTO #P003
	SELECT
		M006.Vocabulary_id		
	,	M006.Vocabulary_dtl_id  
	,	M006.Vocabulary_nm
	,	M999.number_id      
	,	M999.content				
	,   M006.spelling			
	,	M006.mean				
	,	M006.explain
	,	M006.image
	,	M006.audio			
	,	M006.remark				       
	FROM F009
	LEFT JOIN M006
	ON F009.target_id = M006.id
	AND F009.briged_div = 1
	AND M006.del_flg = 0 
	LEFT JOIN M999
	ON M999.name_div = 8
	AND M999.number_id = M006.vocabulary_div
	WHERE F009.briged_id 
	IN (SELECT
		 M007.briged_id	    
	FROM M007
	WHERE 
	M007.post_id		= @P_post_id
	AND	M007.del_flg = 0)

	SELECT * FROM #P003

	SELECT 
		M012.language1_content
	,	M012.language2_content
	FROM M012
	WHERE 
		M012.target_id		= @P_post_id
	AND M012.target_div		<> 1
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

	SET @w_tag_div = (SELECT M999.num_remark1 FROM M007 LEFT JOIN M999 ON M999.name_div = 7 AND M999.number_id = M007.catalogue_div WHERE M007.post_id = @P_post_id)
	SELECT
		M013.tag_id
	,	M013.tag_nm
	,	IIF(F009.briged_id IS NULL,0,1) AS selected
	FROM M013
	LEFT JOIN F009
	ON F009.target_id = M013.tag_id
	AND F009.briged_div = 2
	AND F009.briged_id = (SELECT TOP 1 F009.briged_id FROM F009 INNER JOIN M007 ON F009.briged_id = M007.briged_id AND M007.post_id = @P_post_id)
	WHERE M013.del_flg = 0
	AND M013.tag_div = @w_tag_div
	--
END

