IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M004_ACT1]') AND type IN (N'P', N'PC'))
DROP PROCEDURE [dbo].[SPC_M004_ACT1]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_M004_ACT1]
     @P_avarta	    		NVARCHAR(150)		= ''
,    @P_family_nm    		NVARCHAR(50)		= ''
,	 @P_first_name    		NVARCHAR(20)		= ''
,    @P_email          		NVARCHAR(50)		= ''
,    @P_cellphone     		NVARCHAR(15)		= ''
,	 @P_sex      			TINYINT				= 0
,    @P_birth_date     		NVARCHAR(15)		= ''
,	 @P_department_id		NVARCHAR(15)		= ''
,	 @P_employee_div		TINYINT				= ''
,    @P_remark   			NVARCHAR(MAX)		= ''
,	 @P_user_id				NVARCHAR(15)		= ''
,	 @P_ip					NVARCHAR(50)		= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'M004'
	,	@w_prs_prg_nm			NVARCHAR(50)		= 'Thêm nhân viên'
	,	@w_result				TINYINT				= 0
	,	@w_message				NVARCHAR(100)		= ''
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_inserted_key			VARCHAR(15)			= ''
	,	@w_insert_date			DATE				= NULL
	BEGIN TRANSACTION
	BEGIN TRY
	IF @P_birth_date!=''
	BEGIN
		SET @w_insert_date = CONVERT(date, @P_birth_date, 105)
	END
	INSERT INTO M009 (
		 family_nm    
	,	 first_name   
	,	 email        
	,	 cellphone    
	,	 sex      	
	,	 birth_date   
	,	 department_id
	,	 employee_div
	,	 remark
	,	 avarta   	    	
	,	 cre_user
	,	 cre_prg
	,	 cre_ip
	,	 cre_date
	,	 upd_user
	,	 upd_prg
	,	 upd_ip
	,	 upd_date
	,	 del_user
	,	 del_prg
	,	 del_ip
	,	 del_date
	,	 del_flg	
	)
	SELECT
	     @P_family_nm    	
	,	 @P_first_name    	
	,    @P_email          	
	,    @P_cellphone     	
	,	 @P_sex      		
	,    @w_insert_date     	
	,	 @P_department_id
	,	 @P_employee_div	
	,    @P_remark
	,	 @P_avarta   		
	,	 @P_user_id
	,	 @w_program_id
	,	 @P_ip
	,	 @w_time
	,	 ''
	,	 ''
	,	 ''
	,	 NULL
	,	 ''
	,	 ''
	,	 ''
	,	 NULL
	,	  0
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
EXIT_SPC:
	--INSERT S999
	SET @w_inserted_key = CONCAT('EMP-',scope_identity())
	EXEC SPC_S999_ACT1 @P_user_id,@w_program_id,@w_prs_prg_nm,0,@w_prs_key,@w_result,@w_message

	--
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
	--[1]
	SELECT @w_inserted_key AS emp_id
	
END
GO
