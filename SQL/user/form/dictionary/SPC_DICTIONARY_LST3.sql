﻿IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_DICTIONARY_LST3]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_DICTIONARY_LST3]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_DICTIONARY_LST3]
	
	@P_target_nm			NVARCHAR(200)	=	'' 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	SELECT TOP 100 
		M006.vocabulary_nm 
	FROM M006 
	WHERE 
		M006.vocabulary_nm LIKE @P_target_nm +'%' 
	AND M006.vocabulary_dtl_id = 0
	AND M006.record_div = 2 
	AND M006.del_flg = 0
	ORDER BY
		CASE WHEN M006.vocabulary_nm = @P_target_nm THEN 1
		ELSE
		2
		END
END

