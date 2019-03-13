﻿IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_S002_ACT1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_S002_ACT1]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_S002_ACT1]
	 @P_emp_id_xml			XML				=   ''
,	 @P_user_id				VARCHAR(10)		=	''
,	 @P_ip					VARCHAR(20)		=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'S002'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Quản lý tài khoản'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'update'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''
	--
	BEGIN TRANSACTION
	BEGIN TRY

		CREATE TABLE #SCREEN_DATA(
			row_id			INT
		,	account_id		nvarchar(15)
		,	account_nm  	nvarchar(50)
		,	employee_id 	nvarchar(20)
		,	system_div  	nvarchar(50)
		,	account_div 	nvarchar(15)
		,	remark			nvarchar(MAX)
		)

		CREATE TABLE #CHECK_MASTER(
			row_id			INT
		,	item_id			nvarchar(50)
		,	item_div		NVARCHAR(15)
		)

		INSERT INTO #SCREEN_DATA
		SELECT
			row_id				=	T.C.value('@row_id		 ', 'INT')
		,	account_id			=	T.C.value('@account_id		 ', 'nvarchar(15)')
		,	account_nm   		=	T.C.value('@account_nm    ',	'nvarchar(50)')
		,	employee_id  		=	T.C.value('@employee_id   ',	'nvarchar(20)')
		,	system_div   		=	T.C.value('@system_div        ','nvarchar(50)')
		,	account_div  		=	T.C.value('@account_div    ',	'nvarchar(15)')
		,	remark				=	T.C.value('@remark		 ',		'nvarchar(MAX)')
		FROM @P_emp_id_xml.nodes('row') T(C)

		INSERT INTO #CHECK_MASTER
		SELECT #SCREEN_DATA.row_id, CAST(employee_id AS NVARCHAR(15)),'employee_id' FROM #SCREEN_DATA
		UNION
		SELECT #SCREEN_DATA.row_id,CAST(system_div AS NVARCHAR(15)),'system_div' FROM #SCREEN_DATA
		UNION
		SELECT #SCREEN_DATA.row_id,CAST(account_div AS NVARCHAR(15)),'account_div' FROM #SCREEN_DATA

		DELETE #CHECK_MASTER
		FROM #CHECK_MASTER
		LEFT JOIN M999 M999_1
		ON M999_1.name_div = 4
		AND #CHECK_MASTER.item_id = CAST(M999_1.number_id AS NVARCHAR(15))
		AND M999_1.del_flg = 0
		LEFT JOIN M009
		ON #CHECK_MASTER.item_id = M009.employee_id
		AND M009.del_flg = 0
		LEFT JOIN M999 M999_2
		ON M999_2.name_div = 5
		AND #CHECK_MASTER.item_id = CAST(M999_2.number_id AS NVARCHAR(15))
		AND M999_2.del_flg = 0
		WHERE (M999_1.number_id IS NOT NULL AND #CHECK_MASTER.item_div = 'system_div')
		OR (#CHECK_MASTER.item_id='' OR M009.employee_id IS NOT NULL AND #CHECK_MASTER.item_div = 'employee_id')
		OR (M999_2.number_id IS NOT NULL AND #CHECK_MASTER.item_div = 'account_div')

		IF EXISTS (SELECT * FROM #CHECK_MASTER)
		BEGIN
			SET @w_result = 'NG'
			SET @w_message = 5
			INSERT INTO @ERR_TBL
			SELECT 
			 1
			, @w_message
			, #CHECK_MASTER.item_div
			, #CHECK_MASTER.row_id
			FROM #CHECK_MASTER
		END
		IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC

		INSERT INTO #CHECK_MASTER
		SELECT
			#SCREEN_DATA.row_id
		,	IIF(#SCREEN_DATA.account_nm IS NULL ,S001.account_nm,#SCREEN_DATA.account_nm)
		,	'account_nm'
		FROM #SCREEN_DATA
		RIGHT JOIN S001
		ON　
		#SCREEN_DATA.account_id = CAST(S001.account_id AS NVARCHAR(15))
		AND S001.del_flg = 0

		DELETE #CHECK_MASTER FROM #CHECK_MASTER 
		WHERE #CHECK_MASTER.item_id IN (SELECT #CHECK_MASTER.item_id FROM #CHECK_MASTER GROUP BY #CHECK_MASTER.item_id HAVING COUNT(*) = 1)
		OR #CHECK_MASTER.row_id IS NULL
		
		IF EXISTS (SELECT * FROM #CHECK_MASTER)
		BEGIN
			SET @w_result = 'NG'
			SET @w_message = 6
			INSERT INTO @ERR_TBL
			SELECT 
			 1
			, @w_message
			, 'account_nm'
			, #CHECK_MASTER.row_id
			FROM #CHECK_MASTER
		END
		IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC
		--
		UPDATE S001 SET
			account_nm   		=	update_data.account_nm   
		,	user_id  			=	IIF(update_data.employee_id='',user_id,update_data.employee_id)
		,	system_div   		=	update_data.system_div   
		,	account_div  		=	update_data.account_div  
		,	remark				=	update_data.remark			
		,	upd_user			=	@P_user_id
		,	upd_prg				=	@w_program_id
		,	upd_ip				=	@P_ip
		,	upd_date			=	@w_time
		,	del_user			=	''
		,	del_prg				=	''
		,	del_ip				=	''
		,	del_date			=	NULL
		,	del_flg				=	0	   	  
		FROM (
		SELECT
			account_id			=	T.C.value('@account_id		 ', 'nvarchar(15)')
		,	account_nm   		=	T.C.value('@account_nm    ',	'nvarchar(50)')
		,	employee_id  		=	T.C.value('@employee_id   ',	'nvarchar(20)')
		,	system_div   		=	T.C.value('@system_div        ','nvarchar(50)')
		,	account_div  		=	T.C.value('@account_div    ',	'nvarchar(15)')
		,	remark				=	T.C.value('@remark		 ',		'nvarchar(MAX)')
		FROM @P_emp_id_xml.nodes('row') T(C)) update_data
		WHERE
			S001.account_id = update_data.account_id
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
