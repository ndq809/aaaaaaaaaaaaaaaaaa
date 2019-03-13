IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_PROFILE_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_PROFILE_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_PROFILE_LST1]
	@P_account_nm		        NVARCHAR(30)		= ''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0
	--0
	SELECT 
		M999.number_id  AS lib_cd
	,	M999.content	AS lib_nm 
	FROM M999
	WHERE
		M999.name_div = 1
	AND M999.del_flg = 0
	--1
	SELECT 
		M999.number_id  AS lib_cd
	,	M999.content	AS lib_nm 
	FROM M999
	WHERE
		M999.name_div = 15
	AND M999.del_flg = 0
	--2
	SELECT 
		M999.number_id  AS lib_cd
	,	M999.content	AS lib_nm 
	FROM M999
	WHERE
		M999.name_div = 16
	AND M999.del_flg = 0
	--3
	SELECT 
		M999.number_id  AS lib_cd
	,	M999.content	AS lib_nm 
	FROM M999
	WHERE
		M999.name_div = 18
	AND M999.del_flg = 0
	--4
	SELECT 
		M999.number_id  AS lib_cd
	,	M999.content	AS lib_nm 
	FROM M999
	WHERE
		M999.name_div = 17
	AND M999.del_flg = 0
	--5
	SELECT
		M001.family_nm
	,	M001.first_name
	,	M001.email
	,	FORMAT(M001.birth_date,'dd/MM/yyyy') AS birth_date
	,	M001.cellphone
	,	M001.sex
	,	M001.avarta
	,	M001.job
	,	M001.english_lv
	,	M001.position
	,	M001.field
	,	M001.slogan
	,	S001.account_nm
	FROM S001
	INNER JOIN M001
	ON S001.user_id = M001.user_id
	WHERE
		S001.account_nm = @P_account_nm

	--6
	SELECT
		F009.target_id AS lib_cd
	FROM S001
	INNER JOIN M001
	ON S001.user_id = M001.user_id
	INNER JOIN F009
	ON M001.field = F009.briged_id
	AND F009.briged_div = 3
	INNER JOIN M999
	ON M999.name_div = 17
	AND M999.number_id = F009.target_id
	WHERE
		S001.account_nm = @P_account_nm

END

