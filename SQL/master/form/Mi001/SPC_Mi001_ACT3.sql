IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_Mi001_ACT3]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_Mi001_ACT3]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_Mi001_ACT3]
	 @P_mission_id_json		NVARCHAR(MAX)	=   ''
,	 @P_user_id				VARCHAR(10)		=	''
,	 @P_ip					VARCHAR(20)		=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'Mi001'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Công khai nhiệm vụ'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'public'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	--
	BEGIN TRANSACTION
	BEGIN TRY
		--
		CREATE TABLE #MISSION(
			mission_id			NVARCHAR(15)
		,	account_id			NVARCHAR(15)
		,	unit_this_times		INT
		)

		INSERT INTO #MISSION
		SELECT
			F001.mission_id
		,	F009.target_id
		,	F001.unit_per_times
		FROM F009
		INNER JOIN F001
		ON F009.briged_id = F001.briged_id
		AND F009.briged_div = 4
		INNER JOIN(
		SELECT              
           		mission_id		AS	mission_id	
			FROM OPENJSON(@P_mission_id_json) WITH(
        		mission_id	       NVARCHAR(100)	'$.id	  '
        )) TEMP
		ON TEMP.mission_id= F001.mission_id
		WHERE F001.mission_user_div = 2

		INSERT INTO #MISSION
		SELECT
			F001.mission_id
		,	S001.account_id
		,	F001.unit_per_times
		FROM S001
		INNER JOIN F001
		ON S001.account_div >= F001.rank_from
		AND S001.account_div <= F001.rank_to
		AND S001.system_div = 1
		INNER JOIN(
		SELECT              
           		mission_id		AS	mission_id	
			FROM OPENJSON(@P_mission_id_json) WITH(
        		mission_id	       NVARCHAR(100)	'$.id	  '
        )) TEMP
		ON TEMP.mission_id= F001.mission_id
		WHERE F001.mission_user_div <> 2
		AND S001.del_flg = 0


		INSERT INTO F013(
			mission_id
		,	account_id
		,	condition
		,	unit_this_times
		,	try_times_count
		,	success_count
		,	failed_count
		,	ignore_count
		,	start_time
		,	finished_time
		,	del_flg
		,	cre_user
		,	cre_prg
		,	cre_ip
		,	cre_date
		,	upd_user
		,	upd_prg
		,	upd_ip
		,	upd_date
		,	del_user
		,	del_prg
		,	del_ip
		,	del_date
		)
		SELECT
			#MISSION.mission_id
		,	#MISSION.account_id
		,	0
		,	#MISSION.unit_this_times
		,	0
		,	0
		,	0
		,	0
		,	NULL
		,	NULL
		,	0
		,	@P_user_id
		,	@w_program_id
		,	@P_ip
		,	@w_time
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		FROM #MISSION
		
		UPDATE F001 SET
			F001.record_div =	2
		,	F001.upd_user	=	@P_user_id
		,	F001.upd_prg	=	@w_program_id
		,	F001.upd_ip		=	@P_ip
		,	F001.upd_date	=	@w_time
		FROM F001 _F001
		INNER JOIN(
		SELECT              
           		mission_id		AS	mission_id	
			FROM OPENJSON(@P_mission_id_json) WITH(
        		mission_id	       NVARCHAR(100)	'$.id	  '
        )) TEMP
		ON TEMP.mission_id= _F001.mission_id

	END TRY
	BEGIN CATCH
		DELETE FROM @ERR_TBL
		INSERT INTO @ERR_TBL
			SELECT	
				0
			,	ERROR_NUMBER()
			,	'Exception'
			,	'Error'                                                          + CHAR(13) + CHAR(10) +
				'Procedure : ' + ISNULL(ERROR_PROCEDURE(), '???')                + CHAR(13) + CHAR(10) +
				'Line : '      + ISNULL(CAST(ERROR_LINE() AS NVARCHAR(10)), '0') + CHAR(13) + CHAR(10) +
				'Message : '   + ISNULL(ERROR_MESSAGE(), 'An unexpected error occurred.')
	END CATCH
	--
COMPLETE_QUERY:
	EXEC SPC_S999_ACT1 @P_user_id,@w_program_id,@w_prs_prg_nm,@w_time,@w_mode,@w_prs_key,@w_result,@w_message
	IF EXISTS(SELECT 1 FROM @ERR_TBL AS ERR_TBL WHERE ERR_TBL.Data = 'Exception')
	BEGIN
		IF @@TRANCOUNT >0
		BEGIN
			ROLLBACK TRANSACTION
		END
	END
	ELSE
	BEGIN
		COMMIT TRANSACTION
	END

	--[0]
	SELECT  Id
		,	Code 
		,	Data 
		,	[Message]
	FROM @ERR_TBL
	ORDER BY Code

END

GO
