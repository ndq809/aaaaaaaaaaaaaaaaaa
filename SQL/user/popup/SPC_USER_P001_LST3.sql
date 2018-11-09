IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_USER_P001_LST3]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_USER_P001_LST3]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_USER_P001_LST3]
	@P_vocabulary_list		XML					=	''
,	@P_row_id				INT					=	0

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@w_tag_div				INT

	SELECT
		TEMP.row_id
	,	M006.id
	,	M006.vocabulary_id
	,	M999.content AS vocabulary_div
	,	M006.vocabulary_nm
	,	M006.spelling
	,	M006.mean
	,	M006.explain
	,	1 AS my_post
	FROM M006
	INNER JOIN
	(SELECT
		row_id			=	T.C.value('@row_id 		  ', 'int')	
	,	Vocabulary_code	=	T.C.value('@id', 'int')
	FROM @P_vocabulary_list.nodes('row') T(C)
	)TEMP ON
	TEMP.Vocabulary_code = M006.id
	LEFT JOIN M999
	ON M999.name_div = 8
	AND M999.number_id = M006.vocabulary_div
	--

	SELECT @P_row_id AS row_id
END

