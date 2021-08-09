IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_D001_ACT1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_D001_ACT1]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_D001_ACT1]
	 @P_json_header			NVARCHAR(MAX)	=   ''
,	 @P_json_detail			NVARCHAR(MAX)	=   ''
,	 @P_user_id				VARCHAR(10)		=	''
,	 @P_ip					VARCHAR(20)		=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'd001'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'xử lý tố cáo'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'update'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''
	,	@DynamicPivotQuery		NVARCHAR(MAX)
	,	@ColumnName				NVARCHAR(MAX)

	--
	BEGIN TRANSACTION
	BEGIN TRY

		CREATE TABLE #HEADER(
			target_own_id			INT
		,	result_flag				INT
		)

		CREATE TABLE #DETAIL(
			target_own_id			INT
		,	target_id				INT
		,	denounce_div			INT
		,	result_flag_detail		INT
		)

		CREATE TABLE #CHECK_MASTER(
			row_id			INT
		,	item_id			nvarchar(50)
		,	item_div		NVARCHAR(15)
		)

		INSERT INTO #HEADER
		SELECT              
           		target_own_id		AS	target_own_id		
			,	result_flag			AS	result_flag	
			FROM OPENJSON(@P_json_header) WITH(
        		target_own_id			NVARCHAR(100)	'$.target_own_id		 '
			,	result_flag				NVARCHAR(100)	'$.result_flag	'
        )

		INSERT INTO #DETAIL
		SELECT              
           		target_own_id			AS	target_own_id		
           	,	target_id				AS	target_id		
			,	denounce_div			AS	denounce_div	
			,	result_flag_detail		AS	result_flag_detail	
			FROM OPENJSON(@P_json_detail) WITH(
        		target_own_id			NVARCHAR(100)	'$.target_own_id		 '
			,	target_id				NVARCHAR(100)	'$.target_id	'
			,	denounce_div			NVARCHAR(100)	'$.denounce_div	'
			,	result_flag_detail		NVARCHAR(100)	'$.result_flag_detail	'
        )

		EXEC SPC_COM_M_NUMBER @P_user_id,'','D001','D001',1, @w_inserted_key OUTPUT
		IF(@w_inserted_key = -1) --key out of range 
		BEGIN
		 SET @w_result = 'NG'
		 SET @w_message = 5
		 INSERT INTO @ERR_TBL
		 SELECT 
		  2
		 , 5
		 , 'Error M888'
		 , ''
		END

		IF(@w_inserted_key = -2) --not not declared key at m_number 
		BEGIN
		 SET @w_result = 'NG'
		 SET @w_message = 6
		 INSERT INTO @ERR_TBL
		 SELECT 
		  2
		 , 6
		 , 'Error M888'
		 , ''
		END

		IF(@w_inserted_key = -99) --system error
		BEGIN
		 SET @w_result = 'NG'
		 SET @w_message = 7
		 INSERT INTO @ERR_TBL
		 SELECT 
		  2
		 , 34
		 , 'Error M888'
		 , ''
		END
		IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC

		--update trạng thái của account sau khi xử lý report
		UPDATE _S001
		SET 
			_S001.block_div =	CASE #HEADER.result_flag
								WHEN 0 THEN NULL
								WHEN 1 THEN NULL
								ELSE #HEADER.result_flag
								END
		,	_S001.block_start = CASE #HEADER.result_flag
								WHEN 0 THEN NULL
								WHEN 1 THEN NULL
								ELSE @w_time
								END
		,	_S001.block_end =	CASE #HEADER.result_flag
								WHEN 0 THEN NULL
								WHEN 1 THEN NULL
								WHEN 2 THEN DATEADD(DAY,1,@w_time)
								WHEN 3 THEN DATEADD(DAY,3,@w_time)
								WHEN 4 THEN DATEADD(DAY,7,@w_time)
								WHEN 5 THEN DATEADD(MONTH,1,@w_time)
								WHEN 6 THEN NULL
								END
		,	_S001.block_id		=	@w_inserted_key
		,	_S001.upd_prg		=	@w_program_id
		,	_S001.upd_ip		=	@P_ip
		,	_S001.upd_date		=	@w_time
		FROM S001 _S001
		LEFT JOIN #HEADER
		ON _S001.account_id = #HEADER.target_own_id

		--update trạng thái những tố cáo của người dùng
		UPDATE _F006
		SET
			_F006.status		 =	CASE #HEADER.result_flag
									WHEN 0 THEN 0
									WHEN 1 THEN 3
									ELSE 2
									END
		,	_F006.upd_prg		=	@w_program_id
		,	_F006.upd_ip		=	@P_ip
		,	_F006.upd_date		=	@w_time
		FROM F006 _F006
		LEFT JOIN #DETAIL
		ON _F006.target_id = #DETAIL.target_id
		AND _F006.execute_div = #DETAIL.denounce_div
		LEFT JOIN #HEADER
		ON #HEADER.target_own_id = #DETAIL.target_own_id
		WHERE 
				_F006.status = 1
		AND		_F006.upd_user = @P_user_id

		--lưu log xử lý tố cáo
		INSERT INTO F014
		SELECT
			@w_inserted_key
		,	#DETAIL.target_id
		,	#DETAIL.denounce_div
		,	#DETAIL.result_flag_detail
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
		FROM #DETAIL

		--update trạng thái của đối tượng bị report
		UPDATE _M001
		SET
			_M001.avarta		=	NULL
		,	_M001.upd_prg		=	@w_program_id
		,	_M001.upd_ip		=	@P_ip
		,	_M001.upd_date		=	@w_time
		FROM M001 _M001
		INNER JOIN S001
		ON S001.user_id = _M001.user_id
		INNER JOIN #DETAIL
		ON #DETAIL.target_id = S001.account_id
		AND #DETAIL.denounce_div = 3
		WHERE 
			#DETAIL.result_flag_detail NOT IN(0,1)

		UPDATE _M007
		SET
			_M007.del_user	=	@P_user_id
		,	_M007.del_prg	=	@w_program_id
		,	_M007.del_ip	=	@P_ip
		,	_M007.del_date	=	@w_time
		,	_M007.del_flg	=	1
		FROM M007 _M007
		INNER JOIN #DETAIL
		ON #DETAIL.target_id = _M007.post_id
		AND #DETAIL.denounce_div = 1
		WHERE 
			#DETAIL.result_flag_detail NOT IN(0,1)

		UPDATE _F004
		SET
			_F004.del_user	=	@P_user_id
		,	_F004.del_prg	=	@w_program_id
		,	_F004.del_ip	=	@P_ip
		,	_F004.del_date	=	@w_time
		,	_F004.del_flg	=	1
		FROM F004 _F004
		INNER JOIN #DETAIL
		ON #DETAIL.target_id = _F004.comment_id
		AND #DETAIL.denounce_div = 2
		WHERE 
			#DETAIL.result_flag_detail NOT IN(0,1)

	--EXEC SPC_S999_ACT1 @P_company_cd_u,@w_prs_user_id,@w_prs_prg,@w_prs_prg_nm,@w_prs_mode,@w_prs_key,@w_prs_result,@w_remarks

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
EXIT_SPC:
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
