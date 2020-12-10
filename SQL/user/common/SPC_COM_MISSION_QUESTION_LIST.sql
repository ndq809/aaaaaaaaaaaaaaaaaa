IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_MISSION_QUESTION_LIST]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_MISSION_QUESTION_LIST]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_MISSION_QUESTION_LIST]
 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	SELECT
		M004.question_id 
	,	M004.question_content
	,	M004.question_div
	,	M005.answer_id
	,	M005.answer_content
	,	M004.explan
	,	M005.verify
	,	ROW_NUMBER() OVER(partition by M004.post_id ORDER BY M004.post_id ASC) AS question_num	
	,	-1 AS row_id
	FROM M004
	JOIN M005
	ON M004.question_id = M005.question_id
	WHERE 
		M004.question_id IN (SELECT TOP 1 M004.question_id FROM M004 INNER JOIN M007 ON M004.post_id = M007.post_id AND M007.catalogue_div = 11 AND M007.record_div <> 0 ORDER BY NEWID())
END
