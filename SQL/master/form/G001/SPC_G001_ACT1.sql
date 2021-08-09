IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_G001_ACT1]') AND type IN (N'P', N'PC'))
DROP PROCEDURE [dbo].[SPC_G001_ACT1]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_G001_ACT1]
     @P_avarta	    		NVARCHAR(150)		= ''
,    @P_family_nm    		NVARCHAR(50)		= ''
,	 @P_first_name    		NVARCHAR(20)		= ''
,    @P_email          		NVARCHAR(50)		= ''
,    @P_cellphone     		NVARCHAR(15)		= ''
,	 @P_sex      			TINYINT				= 0
,    @P_birth_date     		NVARCHAR(15)		= ''
,	 @P_address				NVARCHAR(15)		= ''
,	 @P_user_id				NVARCHAR(15)		= ''
,	 @P_ip					NVARCHAR(50)		= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'G001'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Trang cá nhân'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'update'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''
	,	@w_insert_date			DATE				= NULL
	BEGIN TRANSACTION
	BEGIN TRY

	IF @P_birth_date!=''
	BEGIN
		SET @w_insert_date = CONVERT(date, @P_birth_date, 105)
	END
	UPDATE M009 SET
		 family_nm		=	 @P_family_nm    
	,	 first_name   	=	 @P_first_name    
	,	 email        	=	 @P_email         
	,	 cellphone    	=	 @P_cellphone     
	,	 sex      		=	 @P_sex      		
	,	 birth_date   	=	 @w_insert_date   
	,	 address		=	 @P_address
	,	 avarta   	    =	 @P_avarta   			
	,	 upd_user		=	 @P_user_id
	,	 upd_prg		=	 @w_program_id
	,	 upd_ip			=	 @P_ip
	,	 upd_date		=	 @w_time
	WHERE
		M009.employee_id = @P_user_id
	AND M009.del_flg = 0
	
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
	EXEC SPC_S999_ACT1 @P_user_id,@w_program_id,@w_prs_prg_nm,@w_time,@w_mode,@w_prs_key,@w_result,@w_message

	SET @w_inserted_key = scope_identity()

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
	
END
GO
