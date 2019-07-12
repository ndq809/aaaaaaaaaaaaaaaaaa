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
	EXEC SPC_COM_M999_INQ1 '8'
	SELECT
		M006.vocabulary_id
	,	M006.vocabulary_dtl_id
	,	M006.vocabulary_nm
	,	M006.vocabulary_div
	,	M006.image
	,	M006.audio
	,	M006.mean
	,	M006.spelling
	,	M006.explain
	,	M006.remark	    
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

	--
END

