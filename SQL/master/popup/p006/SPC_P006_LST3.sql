IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_P006_LST3]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_P006_LST3]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_P006_LST3]
	@P_user_list		NVARCHAR(MAX)		=	''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@w_tag_div				INT


	CREATE TABLE #P006(
		account_id		NVARCHAR(15)
	,	account_nm		NVARCHAR(50)
	,	rank			NVARCHAR(50)
	,	job				NVARCHAR(100)
	,	city			NVARCHAR(255)
	)
	
	--
	INSERT INTO #P006
	SELECT
		S001.account_id	
	,	S001.account_nm     
	,	_M999_1.content
	,	_M999_2.content
	,	_M999_3.content
	FROM S001
	LEFT JOIN M001
	ON S001.user_id = M001.user_id
	AND M001.del_flg = 0
	LEFT JOIN M999 _M999_1
	ON	_M999_1.name_div = 14
	AND _M999_1.number_id = S001.account_div
	AND _M999_1.del_flg = 0
	LEFT JOIN M999 _M999_2
	ON	_M999_2.name_div = 15
	AND _M999_2.number_id = M001.job
	AND _M999_2.del_flg = 0
	LEFT JOIN M999 _M999_3
	ON	_M999_3.name_div = 18
	AND _M999_3.number_id = M001.position
	AND _M999_3.del_flg = 0
	LEFT JOIN
	(
	SELECT              
            account_id AS account_id              
        FROM OPENJSON(@P_user_list) WITH(
        	account_id	            VARCHAR(10)	'$.account_id'
        )
	)TEMP ON
	TEMP.account_id = S001.account_id
	WHERE S001.del_flg = 0 
	AND TEMP.account_id IS NOT NULL

	SELECT * FROM #P006
	--
END

