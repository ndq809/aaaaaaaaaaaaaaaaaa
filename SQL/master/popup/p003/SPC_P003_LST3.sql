IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_P003_LST3]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_P003_LST3]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_P003_LST3]
	@P_vocabulary_list		NVARCHAR(MAX)					=	''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@w_tag_div				INT


	CREATE TABLE #P003(
		vocabulary_code			NVARCHAR(15)
	,	vocabulary_id			NVARCHAR(15)
	,	vocabulary_dtl_id    	NVARCHAR(15)
	,	vocabulary_nm           NVARCHAR(500)
	,	vocabulary_div			INT	
	,	vocabulary_div_nm		NVARCHAR(50)
	,	specialized_div			INT	
	,	specialized_div_nm		NVARCHAR(500)
	,	field_div				INT	
	,	field_div_nm			NVARCHAR(500)
	,   spelling				NVARCHAR(500)	
	,	mean					NVARCHAR(MAX)
	,	image					NVARCHAR(500)
	,	audio					NVARCHAR(500)
	)
	
	--
	INSERT INTO #P003
	SELECT
		M006.id
	,	M006.Vocabulary_id		
	,	M006.Vocabulary_dtl_id  
	,	M006.Vocabulary_nm
	,	M999_1.number_id      
	,	M999_1.content
	,	M999_2.number_id      
	,	M999_2.content
	,	M999_3.number_id      
	,	M999_3.content						
	,   M006.spelling			
	,	M006.mean				
	,	M006.image
	,	M006.audio			
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
	INNER JOIN
	(
	SELECT              
            vocabulary_code AS vocabulary_code              
        FROM OPENJSON(@P_vocabulary_list) WITH(
        	vocabulary_code	            VARCHAR(10)	'$.vocabulary_code'
        )
	)TEMP ON
	TEMP.vocabulary_code = M006.id

	SELECT * FROM #P003
	--
END

