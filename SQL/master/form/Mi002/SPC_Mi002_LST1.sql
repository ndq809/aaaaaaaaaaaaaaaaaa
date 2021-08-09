IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_Mi002_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_Mi002_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_Mi002_LST1]
	@P_mission_id			NVARCHAR(15)				=	''

AS
BEGIN
	SET NOCOUNT ON;

	DECLARE 
		@w_mission_data_div				TINYINT				= 0
	,	@w_briged_id				INT					= NULL
	,	@w_catalogue_div				INT					= NULL

	SET @w_mission_data_div = (SELECT TOP 1 F001.mission_data_div FROM F001 WHERE F001.mission_id = @P_mission_id)

	EXEC SPC_Mi002_FND1

	SELECT
		F001.mission_id
	,	F001.mission_div
	,	F001.mission_data_div
	,	F001.title
	,	F001.[content]
	,	F001.catalogue_div
	,	F001.catalogue_id
	,	F001.group_id
	,	F001.exp
	,	F001.failed_exp
	,	F001.ctp
	,	F001.failed_ctp
	,	F001.period
	,	F001.mission_user_div
	,	F001.rank_from
	,	F001.rank_to
	,	F001.unit_per_times
	,	F001.try_times
	FROM F001
	WHERE F001.mission_id = @P_mission_id
	AND F001.del_flg = 0
	
	SELECT @w_briged_id= (SELECT F001.briged_id FROM F001 WHERE F001.mission_id = @P_mission_id AND F001.del_flg = 0)
	SELECT @w_catalogue_div= (SELECT F001.catalogue_div FROM F001 WHERE F001.mission_id = @P_mission_id AND F001.del_flg = 0)

	IF @w_catalogue_div = 1
	BEGIN
		SELECT
			M006.id					AS	vocabulary_code		
		,	M006.Vocabulary_id		AS	vocabulary_id		
		,	M006.Vocabulary_dtl_id  AS	vocabulary_dtl_id   
		,	M006.Vocabulary_nm		AS	vocabulary_nm       
		,	M999_1.number_id      	AS	vocabulary_div		
		,	M999_1.content			AS	vocabulary_div_nm	
		,	M999_2.number_id      	AS	specialized_div		
		,	M999_2.content			AS	specialized_div_nm	
		,	M999_3.number_id      	AS	field_div			
		,	M999_3.content			AS	field_div_nm					
		,   M006.spelling			AS	spelling			
		,	M006.mean				AS	mean				
		,	M006.image				AS	image				
		,	M006.audio				AS	audio				
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
		INNER JOIN F009
		ON M006.id = F009.target_id
		AND F009.briged_div = 1
		AND F009.briged_id = @w_briged_id
	END
	ELSE
	BEGIN
		SELECT
			M999.content		AS	catalogue_div	
		,	M002.catalogue_nm   AS	catalogue_nm	  
		,	M003.group_nm		AS	group_nm		
		,	M007.post_id		AS	post_id			
		,	M007.post_title		AS	post_title		
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
		AND M999.number_id = @w_catalogue_div
		INNER JOIN F009
		ON M007.post_id = F009.target_id
		AND F009.briged_div = 3
		AND F009.briged_own_div = 1
		AND F009.briged_own_id = @P_mission_id
		AND F009.briged_id = @w_briged_id
		WHERE M007.del_flg = 0 
		AND (M007.record_div = 1 OR M007.record_div = 2)
		AND M007.catalogue_div = @w_catalogue_div
	END

	SELECT
		S001.account_id		AS	account_id	
	,	S001.account_nm     AS	account_nm	
	,	_M999_1.content		AS	rank		
	,	_M999_2.content		AS	job			
	,	_M999_3.content		AS	city		
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
	INNER JOIN F009
	ON S001.account_id = F009.target_id
	AND F009.briged_div = 4
	AND F009.briged_id = @w_briged_id

	
	--
END

