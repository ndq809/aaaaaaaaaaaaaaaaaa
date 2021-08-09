IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_Mi002_ACT1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT1]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_Mi002_ACT1]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT1]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
--EXEC SPC_Mi002_ACT1 '','1','3','1','','','1','1','8','','','','','','','','chiếm lấy e đi','<p>nothing to say</p>','[]','[{"id":"1"}]','1','::1';
CREATE PROCEDURE [dbo].[SPC_Mi002_ACT1]
	 @P_mission_id				NVARCHAR(15)	=   ''
,	 @P_mission_div				INT				=   0
,	 @P_mission_data_div		INT				=   0
,	 @P_catalogue_div			INT				=   0
,	 @P_catalogue_nm			INT				=   0
,	 @P_group_nm				INT				=   0
,	 @P_mission_user_div		INT				=   0
,	 @P_rank_from				INT				=   0
,	 @P_rank_to					INT				=   0
,	 @P_exp						INT				=   0
,	 @P_failed_exp				INT				=   0
,	 @P_ctp						INT				=   0
,	 @P_failed_ctp				INT				=   0
,	 @P_period					INT				=   0
,	 @P_unit_per_times			INT				=   0
,	 @P_try_times				INT				=   0
,	 @P_mission_nm				NVARCHAR(255)	=   ''
,	 @P_mission_content			NVARCHAR(MAX)	=   ''
,	 @P_total_unit				INT				=   0
,	 @P_json_detail1			NVARCHAR(MAX)	=   ''
,	 @P_json_detail2			NVARCHAR(MAX)	=   ''
,	 @P_user_id					VARCHAR(10)		=	''
,	 @P_ip						VARCHAR(20)		=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			=  SYSDATETIME()
	,   @w_prs_user_id			VARCHAR(6)			= @P_user_id
	,	@w_program_id			NVARCHAR(50)		= 'Mi002'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Thêm nhiệm vụ'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'insert'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_briged_id			INT					= NULL
	--
	BEGIN TRANSACTION
	BEGIN TRY
		CREATE TABLE #DETAIL(
			id			NVARCHAR(15)
		,	data_div	TINYINT
		)

		INSERT INTO #DETAIL
		SELECT              
            id			AS id              
        ,   IIF(@P_catalogue_div=1,1,3)	AS data_div              
        FROM OPENJSON(@P_json_detail2) WITH(
        	id	        VARCHAR(10)	'$.id'
        )
		
		IF @P_mission_id = ''
		BEGIN
			IF EXISTS (SELECT 1 FROM #DETAIL)
			BEGIN
				SELECT @w_briged_id= ISNULL(MAX(F009.briged_id),0)+1 FROM F009
			END
			INSERT INTO F001(
				mission_div
			,	mission_data_div
			,	title
			,	[content]
			,	catalogue_div
			,	catalogue_id
			,	group_id
			,	exp
			,	failed_exp
			,	ctp
			,	failed_ctp
			,	period
			,	mission_user_div
			,	rank_from
			,	rank_to
			,	unit_per_times
			,	total_unit
			,	try_times
			,	briged_id
			,	record_div
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
				@P_mission_div
			,	@P_mission_data_div
			,	@P_mission_nm
			,	@P_mission_content
			,	@P_catalogue_div
			,	@P_catalogue_nm
			,	@P_group_nm
			,	@P_exp
			,	@P_failed_exp
			,	@P_ctp
			,	@P_failed_ctp
			,	@P_period
			,	@P_mission_user_div
			,	@P_rank_from
			,	@P_rank_to
			,	@P_unit_per_times
			,	@P_total_unit
			,	@P_try_times
			,	@w_briged_id
			,	0
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

		SET @P_mission_id = SCOPE_IDENTITY()

		IF EXISTS (SELECT 1 FROM #DETAIL)
			SELECT @w_briged_id= ISNULL(MAX(F009.briged_id),0)+1 FROM F009
			BEGIN
				INSERT INTO F009
				SELECT 
					@w_briged_id
				,	#DETAIL.id
				,	#DETAIL.data_div
				,	 @P_mission_id
				,	 1
				,	 @P_user_id
				,	 @w_program_id
				,	 @P_ip
				,	 @w_time
				FROM #DETAIL
			END

			IF @P_mission_user_div = 2
			BEGIN
				IF @w_briged_id IS NULL
				BEGIN
					SELECT @w_briged_id= ISNULL(MAX(F009.briged_id),0)+1 FROM F009
				END
				INSERT INTO F009
				SELECT 
					@w_briged_id
				,	#TEMP.account_id
				,	4
				,	 @P_mission_id
				,	 1
				,	 @P_user_id
				,	 @w_program_id
				,	 @P_ip
				,	 @w_time
				FROM 
				(SELECT              
					account_id			AS account_id              
				FROM OPENJSON(@P_json_detail1) WITH(
        			account_id	        VARCHAR(10)	'$.id'
				))#TEMP
			END

		END
		ELSE
		BEGIN
			SET @w_briged_id = (SELECT TOP 1 F001.briged_id FROM F001 WHERE F001.mission_id = @P_mission_id)
			IF @w_briged_id IS NULL AND (EXISTS (SELECT 1 FROM #DETAIL))
			BEGIN
				SELECT @w_briged_id= ISNULL(MAX(F009.briged_id),0)+1 FROM F009
			END
			DELETE FROM F009 WHERE F009.briged_id = @w_briged_id AND F009.briged_own_id = @P_mission_id
			BEGIN
				INSERT INTO F009
				SELECT 
					@w_briged_id
				,	#DETAIL.id
				,	#DETAIL.data_div
				,	 @P_mission_id
				,	 1
				,	 @P_user_id
				,	 @w_program_id
				,	 @P_ip
				,	 @w_time
				FROM #DETAIL
			END

			IF @P_mission_user_div = 2
			BEGIN
				INSERT INTO F009
				SELECT 
					@w_briged_id
				,	#TEMP.account_id
				,	4
				,	 @P_mission_id
				,	 1
				,	 @P_user_id
				,	 @w_program_id
				,	 @P_ip
				,	 @w_time
				FROM 
				(SELECT              
					account_id			AS account_id              
				FROM OPENJSON(@P_json_detail1) WITH(
        			account_id	        VARCHAR(10)	'$.id'
				))#TEMP
			END

			UPDATE F001 SET
				F001.mission_div		=	@P_mission_div
			,	F001.mission_data_div	=	@P_mission_data_div
			,	F001.title				=	@P_mission_nm
			,	F001.[content]			=	@P_mission_content
			,	F001.catalogue_div		=	@P_catalogue_div
			,	F001.catalogue_id		=	@P_catalogue_nm
			,	F001.group_id			=	@P_group_nm
			,	F001.exp				=	@P_exp
			,	F001.failed_exp			=	@P_failed_exp
			,	F001.ctp				=	@P_ctp
			,	F001.failed_ctp			=	@P_failed_ctp
			,	F001.period				=	@P_period
			,	F001.mission_user_div	=	@P_mission_user_div
			,	F001.rank_from			=	@P_rank_from
			,	F001.rank_to			=	@P_rank_to
			,	F001.unit_per_times		=	@P_unit_per_times
			,	F001.total_unit			=	@P_total_unit
			,	F001.try_times			=	@P_try_times
			,	F001.briged_id			=	@w_briged_id
			,	F001.record_div			=	IIF(F001.record_div	IS NOT NULL,F001.record_div,0)
			,	F001.upd_user			=	@P_user_id
			,	F001.upd_prg			=	@w_program_id
			,	F001.upd_ip				=	@P_ip
			,	F001.upd_date			=	@w_time
			WHERE F001.mission_id		=	@P_mission_id
		END

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

	SELECT @P_mission_id AS mission_id

END

GO
