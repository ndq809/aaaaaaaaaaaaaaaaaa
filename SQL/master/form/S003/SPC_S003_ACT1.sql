﻿IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_S003_ACT1]') AND type IN (N'P', N'PC'))
DROP PROCEDURE [dbo].[SPC_S003_ACT1]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_S003_ACT1]
     @P_user_id_in    		NVARCHAR(15)		= ''
,	 @P_system_div    		TINYINT				= 0
,    @P_account_div          TINYINT				= 0
,    @P_account_nm     		NVARCHAR(30)		= ''
,	 @P_password      		NVARCHAR(100)		= ''
,    @P_signature   		NVARCHAR(MAX)		= ''
,    @P_remark   			NVARCHAR(MAX)		= ''
,	 @P_user_id				NVARCHAR(15)		= ''
,	 @P_ip					NVARCHAR(50)		= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'S003'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Thêm tài khoản'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'insert'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''

	BEGIN TRANSACTION
	BEGIN TRY
	
	IF NOT EXISTS (SELECT 1 FROM M009 WHERE M009.employee_id = @P_user_id_in AND M009.del_flg = 0) AND @P_user_id_in <>'' --code not exits 
	BEGIN
	 SET @w_result = 'NG'
	 SET @w_message = 5
	 INSERT INTO @ERR_TBL
	 SELECT 
	  0
	 , @w_message
	 , 'employee_id'
	 , ''
	END

	IF EXISTS (SELECT 1 FROM M999 WHERE M999.name_div = 4 AND M999.number_id = @P_system_div AND M999.del_flg = 1) --code not exits 
	BEGIN
	 SET @w_result = 'NG'
	 SET @w_message = 5
	 INSERT INTO @ERR_TBL
	 SELECT 
	  0
	 , @w_message
	 , 'system_div'
	 , ''
	END

	IF EXISTS (SELECT 1 FROM M999 WHERE M999.name_div = 5 AND M999.number_id = @P_account_div AND M999.del_flg = 1) --code not exits 
	BEGIN
	 SET @w_result = 'NG'
	 SET @w_message = 5
	 INSERT INTO @ERR_TBL
	 SELECT 
	  0
	 , @w_message
	 , 'account_div'
	 , ''
	END
	--
	IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC

	IF EXISTS(SELECT 1 FROM S001 WHERE S001.account_nm	= @P_account_nm AND S001.del_flg = 0)
	BEGIN
		--
		SET @w_result = 'NG'
		SET @w_message = 6
		--
		INSERT INTO	@ERR_TBL
		SELECT	
			0
		,	@w_message
		,	'account_nm'
		,	''
	END
	
	--
	IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC
	INSERT INTO S001 (
		 user_id     
	,	 system_div     
	,	 account_div     
	,	 account_nm      
	,	 password    
	,    signature   		
	,	 remark   	   
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
	     @P_user_id_in  
	,	 @P_system_div  
	,    @P_account_div  
	,    @P_account_nm   
	,	 @P_password    
	,    @P_signature   		
	,    @P_remark   		
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
	SET @w_inserted_key = scope_identity()
EXIT_SPC:
	--INSERT S999
	EXEC SPC_S999_ACT1 @P_user_id,@w_program_id,@w_prs_prg_nm,@w_time,@w_mode,@w_prs_key,@w_result,@w_message

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
	SELECT @w_inserted_key AS acc_id
	
END
GO
