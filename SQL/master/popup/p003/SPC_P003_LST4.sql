IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_P003_LST4]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_P003_LST4]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_P003_LST4]
	@P_mean					NVARCHAR(200)		=	''

AS
BEGIN
	SET NOCOUNT ON;
	
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	--
	SELECT TOP 100
		M006.id						AS	vocabulary_code		
	,	M006.Vocabulary_id			AS	vocabulary_id		
	,	M006.Vocabulary_dtl_id  	AS	vocabulary_dtl_id   
	,	M006.Vocabulary_nm			AS	vocabulary_nm       
	,	M999_1.number_id      		AS	vocabulary_div		
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
	LEFT JOIN M999 M999_1
	ON	M006.vocabulary_div = M999_1.number_id
	AND	M999_1.name_div = 8
	LEFT JOIN M999 M999_2
	ON	M006.specialized = M999_2.number_id
	AND	M999_2.name_div = 23
	LEFT JOIN M999 M999_3
	ON	M006.field = M999_3.number_id
	AND	M999_3.name_div = 24
	WHERE 
		M006.vocabulary_nm LIKE +@P_mean +'%' 
	AND M006.record_div = 2
	AND M006.del_flg = 0
	ORDER BY
		M006.vocabulary_nm
		
	--
END

