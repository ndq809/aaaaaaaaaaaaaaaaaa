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
	@P_account_id		        NVARCHAR(30)		= ''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	CREATE TABLE #DATA(
		number_id			INT
	,	catalogue_div_nm	NVARCHAR(500)
	,	success_count		INT
	,	ignore_count		INT
	,	failed_count		INT
	,	point				FLOAT
	)

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
	,	S001.exp - ISNULL(M999.num_remark1,0) AS exp
	,	S001.ctp - ISNULL(M999.num_remark2,0) AS ctp
	,	M999.content AS rank
	,	_M999.num_remark1 AS rank_exp
	,	_M999.num_remark2 AS rank_ctp
	FROM S001
	INNER JOIN M001
	ON S001.user_id = M001.user_id
	LEFT JOIN M999
	ON M999.name_div = 14
	AND M999.number_id = S001.account_div
	LEFT JOIN M999 _M999
	ON _M999.name_div = 14
	AND _M999.number_id = S001.account_div +1
	WHERE
		S001.account_id = @P_account_id

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
		S001.account_id = @P_account_id

	
	INSERT INTO #DATA
	SELECT 
		#TEMP.number_id
	,	#TEMP.catalogue_div_nm
	,	#TEMP.success_count
	,	#TEMP.ignore_count
	,	#TEMP.failed_count
	,	IIF(#TEMP.all_count<>0, 10-((#TEMP.ignore_count*(10.0/#TEMP.all_count)/2)+(#TEMP.failed_count*(10.0/#TEMP.all_count))),0) AS point --error div with int
	FROM (
	SELECT
		MAX(M999.number_id) AS number_id
	,	MAX(M999.text_remark2) AS catalogue_div_nm
	,	SUM(F013.success_count) AS success_count
	,	SUM(F013.ignore_count) AS ignore_count
	,	SUM(F013.failed_count) AS failed_count
	,	SUM(F013.success_count) + SUM(F013.ignore_count) + SUM(F013.failed_count) AS all_count
	FROM F013
	INNER JOIN F001
	ON F001.mission_id = F013.mission_id
	LEFT JOIN M999
	ON M999.name_div = 7
	AND M999.number_id = F001.catalogue_div
	WHERE F013.account_id = @P_account_id
	GROUP BY
		F001.catalogue_div
	) AS #TEMP


	--7
	SELECT 
		M999.number_id
	,	M999.text_remark2	AS catalogue_div_nm
	,	IIF(#DATA.success_count IS NULL,0,#DATA.success_count)	AS success_count
	,	IIF(#DATA.ignore_count IS NULL,0,#DATA.success_count)	AS ignore_count
	,	IIF(#DATA.failed_count IS NULL,0,#DATA.success_count)	AS failed_count
	,	IIF(#DATA.point IS NULL,0,#DATA.success_count)			AS point
	FROM M999
	LEFT JOIN #DATA
	ON M999.number_id = #DATA.number_id
	WHERE
		M999.name_div = 7
	AND M999.num_remark2 = 1
END

