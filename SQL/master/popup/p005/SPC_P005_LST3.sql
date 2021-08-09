IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_P005_LST3]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_P005_LST3]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_P005_LST3]
	@P_post_list		NVARCHAR(MAX)		=	''
,	@P_catalogue_div	NVARCHAR(15)		=	''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@w_tag_div				INT


	CREATE TABLE #P005(
		catalogue_div		NVARCHAR(50)
	,	catalogue_nm		NVARCHAR(50)
	,	group_nm			NVARCHAR(50)
	,	post_id				NVARCHAR(15)
	,	post_title			NVARCHAR(255)
	)
	
	--
	INSERT INTO #P005
	SELECT
		M999.content	
	,	M002.catalogue_nm     
	,	M003.group_nm
	,	M007.post_id
	,	M007.post_title		
	FROM M007
	LEFT JOIN M002
	ON M007.catalogue_div = M002.catalogue_div
	AND M007.catalogue_id = M002.catalogue_id
	AND M002.del_flg = 0
	LEFT JOIN M003
	ON M007.catalogue_div = M003.catalogue_div
	AND M007.catalogue_id = M003.catalogue_id
	AND M007.group_id = M003.group_id
	AND M003.del_flg = 0
	LEFT JOIN M999
	ON M999.name_div = 7
	AND M999.number_id = @P_catalogue_div
	LEFT JOIN
	(
	SELECT              
            post_id AS post_id              
        FROM OPENJSON(@P_post_list) WITH(
        	post_id	            VARCHAR(10)	'$.post_id'
        )
	)TEMP ON
	TEMP.post_id = M007.post_id
	WHERE M007.del_flg = 0 
	AND (M007.record_div = 1 OR M007.record_div = 2)
	AND M007.catalogue_div = @P_catalogue_div
	AND TEMP.post_id IS NOT NULL

	SELECT * FROM #P005
	--
END

