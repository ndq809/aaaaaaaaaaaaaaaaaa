IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M003_ACT1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_M003_ACT1]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_M003_ACT1]
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
	,	@w_program_id			NVARCHAR(50)		= 'M003'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Quản lý nhân viên'
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
		,	emp_id			nvarchar(15)
		,	family_nm    	nvarchar(50)
		,	first_name   	nvarchar(20)
		,	email        	nvarchar(50)
		,	cellphone    	nvarchar(15)
		,	sex      		tinyint	 
		,	birth_date   	nvarchar(15)
		,	department_id	nvarchar(15)
		,	employee_div	tinyint	 
		,	remark			nvarchar(MAX)
		,	avarta   	 	nvarchar(MAX)
		)

		CREATE TABLE #CHECK_MASTER(
			row_id			INT
		,	item_id			nvarchar(50)
		,	item_div		NVARCHAR(15)
		)

		INSERT INTO #SCREEN_DATA
		SELECT
			row_id				=	T.C.value('@row_id		 ', 'INT')
		,	emp_id	    		=	T.C.value('@emp_id		 ', 'nvarchar(15)')
		,	family_nm    		=	T.C.value('@family_nm    ', 'nvarchar(50)')
		,	first_name   		=	T.C.value('@first_name   ', 'nvarchar(20)')
		,	email        		=	T.C.value('@email        ', 'nvarchar(50)')
		,	cellphone    		=	T.C.value('@cellphone    ', 'nvarchar(15)')
		,	sex      			=	T.C.value('@sex      	 ', 'tinyint	 ')
		,	birth_date   		=	IIF(T.C.value('@birth_date  ', 'nvarchar(15)') IS NULL , N'', CONVERT(date, T.C.value('@birth_date   ', 'nvarchar(15)'), 105))
		,	department_id		=	T.C.value('@department_id', 'nvarchar(15)')
		,	employee_div		=	T.C.value('@employee_div ', 'tinyint	 ')
		,	remark				=	T.C.value('@remark		 ', 'nvarchar(MAX)')
		,	avarta   	  		=	T.C.value('@avarta   	 ', 'nvarchar(MAX)')
		FROM @P_emp_id_xml.nodes('row') T(C)

		INSERT INTO #CHECK_MASTER
		SELECT #SCREEN_DATA.row_id, CAST(employee_div AS NVARCHAR(15)),'employee_div' FROM #SCREEN_DATA
		UNION
		SELECT #SCREEN_DATA.row_id,CAST(department_id AS NVARCHAR(15)),'department_id' FROM #SCREEN_DATA
		UNION
		SELECT #SCREEN_DATA.row_id,CAST(sex AS NVARCHAR(15)),'sex' FROM #SCREEN_DATA

		DELETE #CHECK_MASTER
		FROM #CHECK_MASTER
		LEFT JOIN M999 M999_1
		ON M999_1.name_div = 2
		AND #CHECK_MASTER.item_id = CAST(M999_1.number_id AS NVARCHAR(15))
		AND M999_1.del_flg = 0
		LEFT JOIN M999 M999_2
		ON M999_2.name_div = 1
		AND #CHECK_MASTER.item_id = CAST(M999_2.number_id AS NVARCHAR(15))
		AND M999_2.del_flg = 0
		LEFT JOIN M008
		ON #CHECK_MASTER.item_id = M008.department_id
		AND M008.del_flg = 1
		WHERE (M999_1.number_id IS NOT NULL AND #CHECK_MASTER.item_div = 'employee_div')
		OR	(M999_2.number_id IS NOT NULL AND #CHECK_MASTER.item_div = 'sex')
		OR (M008.department_id IS NULL AND #CHECK_MASTER.item_div = 'department_id')

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
		--
		UPDATE M009 SET
			family_nm    		=	update_data.family_nm    
		,	first_name   		=	update_data.first_name   
		,	email        		=	update_data.email        
		,	cellphone    		=	update_data.cellphone    
		,	sex      			=	update_data.sex      		
		,	birth_date   		=	update_data.birth_date   
		,	department_id		=	update_data.department_id
		,	employee_div		=	update_data.employee_div	
		,	remark				=	update_data.remark			
		,	avarta   	  		=	update_data.avarta
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
			emp_id	    		=	T.C.value('@emp_id		 ', 'nvarchar(15)')
		,	family_nm    		=	T.C.value('@family_nm    ', 'nvarchar(50)')
		,	first_name   		=	T.C.value('@first_name   ', 'nvarchar(20)')
		,	email        		=	T.C.value('@email        ', 'nvarchar(50)')
		,	cellphone    		=	T.C.value('@cellphone    ', 'nvarchar(15)')
		,	sex      			=	T.C.value('@sex      	 ', 'tinyint	 ')
		,	birth_date   		=	IIF(T.C.value('@birth_date   ', 'nvarchar(15)') IS NULL , N'', CONVERT(date, T.C.value('@birth_date   ', 'nvarchar(15)'), 105))
		,	department_id		=	T.C.value('@department_id', 'nvarchar(15)')
		,	employee_div		=	T.C.value('@employee_div ', 'tinyint	 ')
		,	remark				=	T.C.value('@remark		 ', 'nvarchar(MAX)')
		,	avarta   	  		=	T.C.value('@avarta   	 ', 'nvarchar(MAX)')
		FROM @P_emp_id_xml.nodes('row') T(C)) update_data
		WHERE
			M009.employee_id = update_data.emp_id

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
