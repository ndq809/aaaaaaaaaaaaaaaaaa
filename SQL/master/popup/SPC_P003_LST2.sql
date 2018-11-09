IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_P003_LST2]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_P003_LST2]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_P003_LST2]
	@P_vocabulary_list		XML					=	''

AS
BEGIN
	SET NOCOUNT ON;
	
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	--
	CREATE TABLE #P003(
		vocabulary_code			INT	
	,	vocabulary_id			NVARCHAR(15)
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
	
	--
	INSERT INTO #P003
	SELECT
		M006.id
	,	M006.Vocabulary_id		
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
	FROM M006
	INNER JOIN
	(SELECT
		Vocabulary_code	=	T.C.value('@vocabulary_code 		  ', 'int')
	FROM @P_vocabulary_list.nodes('row') T(C)
	)TEMP ON
	TEMP.Vocabulary_code = M006.id
	LEFT JOIN M999
	ON	M006.vocabulary_div = M999.number_id
	AND	M999.name_div = 8

	--
	SELECT 
		*
	FROM #P003

END

