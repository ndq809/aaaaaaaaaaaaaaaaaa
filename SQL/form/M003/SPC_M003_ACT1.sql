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
	,	@w_time					DATETIME		=  SYSDATETIME()
	,   @w_prs_user_id			VARCHAR(6)		= @P_user_id
	,   @w_prs_prg				VARCHAR(10)		= 'M003'
	,   @w_prs_prg_nm			VARCHAR(50)		= 'Danh sách nhân viên'
	,   @w_prs_mode				VARCHAR(10)		= 'update'
	,   @w_prs_key				VARCHAR(1000)	= ''
	,	@w_prs_result			VARCHAR(20)		= ''
	,	@w_remarks				VARCHAR(200)	= ''
	--
	BEGIN TRANSACTION
	BEGIN TRY
		SET @w_prs_result = 'OK'
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
		,	upd_prg				=	@w_prs_prg
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
COMPLETE_QUERY:
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
