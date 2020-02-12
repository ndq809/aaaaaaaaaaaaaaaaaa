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
	DECLARE 
		@w_tag_div				INT
	SELECT
		 *	    
		FROM M007
		WHERE 
		M007.post_id		= @P_post_id
		AND	M007.del_flg = 0
	EXEC SPC_COM_M999_INQ1 '8'

	SELECT
		M006.id 					AS	vocabulary_code		
	,	M006.Vocabulary_id			AS	vocabulary_id		
	,	M006.Vocabulary_dtl_id  	AS	vocabulary_dtl_id   
	,	M006.Vocabulary_nm			AS	vocabulary_nm       
	,	M999_1.number_id			AS	vocabulary_div		
	,	M999_1.content				AS	vocabulary_div_nm	
	,	M999_2.number_id      		AS	specialized_div		
	,	M999_2.content				AS	specialized_div_nm	
	,	M999_3.number_id      		AS	field_div			
	,	M999_3.content				AS	field_div_nm		
	,   M006.spelling				AS	spelling			
	,	M006.mean					AS	mean				
	,	M006.image					AS	image				
	,	M006.audio					AS	audio				
	FROM M006
	LEFT JOIN F009
	ON F009.target_id = M006.id
	AND F009.briged_div = 1
	AND M006.del_flg = 0 
	LEFT JOIN M999 M999_1
	ON	M006.vocabulary_div = M999_1.number_id
	AND	M999_1.name_div = 8
	LEFT JOIN M999 M999_2
	ON	M006.specialized = M999_2.number_id
	AND	M999_2.name_div = 23
	LEFT JOIN M999 M999_3
	ON	M006.field = M999_3.number_id
	AND	M999_3.name_div = 24
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
	,	M004.explan
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

	SELECT
		M015.listen_cut_id
	,	M015.listen_cut_content
	,	M015.listen_cut_start
	,	M015.listen_cut_end
	FROM M015
	WHERE M015.post_id = @P_post_id
	--
END

