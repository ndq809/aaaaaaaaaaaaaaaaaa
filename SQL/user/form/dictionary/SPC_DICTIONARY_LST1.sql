IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_DICTIONARY_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_DICTIONARY_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_DICTIONARY_LST1]
	
		@P_target_id			NVARCHAR(15)	=	'' 
	,	@P_user_id				NVARCHAR(50)	=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	SELECT 
		M006.vocabulary_nm
	,	M006.id	
	FROM M006 WHERE M006.id = @P_target_id AND M006.del_flg = 0 AND M006.record_div = 2

	SELECT TOP 10
		F008.target_id
	,	M006.vocabulary_nm
	,	F008.excute_id
	FROM F008
	LEFT JOIN M006
	ON F008.target_id = M006.id
	AND M006.record_div = 2
	WHERE 
		F008.execute_div = 2
	AND F008.execute_target_div = 1
	AND F008.del_flg = 0
	AND F008.user_id = @P_user_id
	ORDER BY
		F008.cre_date DESC
END

