IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M004_ACT1]') AND type IN (N'P', N'PC'))
DROP PROCEDURE [dbo].[SPC_M004_ACT1]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_M004_ACT1]

     @P_family_nm    		VARCHAR(50)		= ''
,	 @P_first_name    		VARCHAR(20)		= ''
,    @P_email          		VARCHAR(50)		= ''
,    @P_cellphone     		VARCHAR(15)		= ''
,	 @P_sex      			tinyint			= 0
,    @P_birth_date     		DATE			= NULL
,	 @P_department_id		VARCHAR(15)		= ''
,    @P_employee_div   		tinyint			= 0
,    @P_remark   			VARCHAR(MAX)	= ''
,    @P_account_nm     		VARCHAR(30)		= ''
,	 @P_password      		VARCHAR(100)	= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME		= SYSDATETIME()
	,	@w_mode					VARCHAR(10)		= ''
	,	@w_program_id			VARCHAR(50)		= 'M004'	
	,	@w_prs_prg_nm			VARCHAR(50)		= '‰ïŽÐƒ}ƒXƒ^'
	,	@w_result				VARCHAR(10)		= 'OK'
	,	@w_message				VARCHAR(100)	= ''
	,	@w_prs_key				VARCHAR(1000)	= ''
	,	@w_max_company_cd		SMALLINT		=	0

	BEGIN TRANSACTION
	BEGIN TRY
		
		--
		SET @w_mode = 'Insert'

		--		
		IF NOT EXISTS(SELECT 1 FROM M009  
					  WHERE M001.company_cd = @P_company_cd
					  AND M001.del_flg = 0
					  )
		BEGIN
			
			SET @w_result  = 'NG'
			SET @w_message = (SELECT ISNULL(message,'') FROM S888 WHERE message_no = 11)

			--
			INSERT INTO	@ERR_TBL
			SELECT	
				0
			,	'11'
			,	'#company_cd'
			,	''
		END

		--
		IF EXISTS(
			SELECT 1
			FROM M001 
			WHERE 
				M001.company_cd = @P_company_cd
			AND M001.del_flg = 1
		)
		BEGIN
			SET @w_result  = 'NG'
			SET @w_message = (SELECT ISNULL(message,'') FROM S888 WHERE message_no = 34)
			--
			INSERT INTO @ERR_TBL
			SELECT	
				0
			,	34
			,	'#company_cd'
			,	''
		END

		--
		IF EXISTS(SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC
		--
		IF NOT EXISTS(
			SELECT 1
			FROM M001 
			WHERE 
				M001.company_cd = @P_company_cd
			AND M001.del_flg = 0
		)
		BEGIN
			
			--
			EXEC SPC_COM_S005_UPD01 @w_program_id,@P_user_id,@P_ip,@P_company_cd_u,6,1,@w_max_company_cd OUTPUT
			
			--
			SET @P_company_cd = @w_max_company_cd
			SET @w_prs_key    = 'company_cd=' + CAST(@P_company_cd AS VARCHAR(8))
			
			--
			IF(@w_max_company_cd = -1)
			BEGIN
				SET @w_result  = 'NG'
				SET @w_message = (SELECT ISNULL(message,'') FROM S888 WHERE message_no = 35)
				--
				INSERT INTO @ERR_TBL
				SELECT	
					0
				,	35
				,	'#company_cd'
				,	''
			END

			IF(@w_max_company_cd = -2)
			BEGIN
				SET @w_result  = 'NG'
				SET @w_message = (SELECT ISNULL(message,'') FROM S888 WHERE message_no = 11)
				--
				INSERT INTO @ERR_TBL
				SELECT	
					0
				,	11
				,	'#company_cd'
				,	''
			END

			IF(@w_max_company_cd = -9)
			BEGIN
				SET @w_result  = 'NG'
				SET @w_message = (SELECT ISNULL(message,'') FROM S888 WHERE message_no = 36)
				--
				INSERT INTO @ERR_TBL
				SELECT	
					0
				,	36
				,	'#company_cd'
				,	''
			END

			--
			IF EXISTS(SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC

			--
			INSERT INTO M001 (
				 company_cd			
			,    company_nm	
			,    company_en_nm	
			,    company_kn_nm			
			,    company_ab_nm		
			,    company_en_ab_nm
			,    prefectures_en		
			,	 city_en		
			,	 company_adr_2		
			,	 chome_address_en	
			,	 company_zip			
			,	 company_adr_1		
			,	 town_en			
			,	 company_tel				
			,	 company_en_tel				
			,	 company_fax				
			,	 company_en_fax				
			,	 company_url				
			,	 remarks	
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
				 @P_company_cd			
			,    @P_company_nm	
			,    @P_company_en_nm	
			,    @P_company_kn_nm			
			,    @P_company_ab_nm		
			,    @P_company_en_ab_nm
			,    @P_prefectures_en		
			,	 @P_city_en		
			,	 @P_company_adr_2		
			,	 @P_chome_address_en	
			,	 @P_company_zip			
			,	 @P_company_adr_1		
			,	 @P_town_en			
			,	 @P_company_tel				
			,	 @P_company_en_tel				
			,	 @P_company_fax				
			,	 @P_company_en_fax				
			,	 @P_company_url				
			,	 @P_remarks	
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
		END
		ELSE
		BEGIN
			--
			SET	@w_mode = 'Update'
			SET @w_prs_key = 'company_cd=' + CAST(@P_company_cd AS VARCHAR(8))
			--
			UPDATE M001
			SET	
				 M001.company_nm		= @P_company_nm
			,    M001.company_en_nm		= @P_company_en_nm	
			,    M001.company_kn_nm		= @P_company_kn_nm	
			,    M001.company_ab_nm		= @P_company_ab_nm
			,    M001.company_en_ab_nm	= @P_company_en_ab_nm
			,    M001.prefectures_en	= @P_prefectures_en
			,	 M001.city_en			= @P_city_en	
			,	 M001.company_adr_2		= @P_company_adr_2	
			,	 M001.chome_address_en	= @P_chome_address_en	
			,	 M001.company_zip		= @P_company_zip
			,	 M001.company_adr_1		= @P_company_adr_1	
			,	 M001.town_en			= @P_town_en
			,	 M001.company_tel		= @P_company_tel
			,	 M001.company_en_tel	= @P_company_en_tel		
			,	 M001.company_fax		= @P_company_fax	
			,	 M001.company_en_fax	= @P_company_en_fax
			,	 M001.company_url		= @P_company_url	
			,	 M001.remarks			= @P_remarks
			,	 M001.upd_user			= @P_user_id
			,	 M001.upd_prg			= @w_program_id
			,	 M001.upd_ip			= @P_ip
			,	 M001.upd_date			= @w_time
			,	 M001.del_user			= ''
			,	 M001.del_prg			= ''
			,	 M001.del_ip			= ''
			,	 M001.del_date			= NULL
			,	 M001.del_flg			= 0									  
			WHERE M001.Company_cd		= @P_company_cd
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
	

EXIT_SPC:
	
	--INSERT S999
	EXEC SPC_S999_ACT1 @P_company_cd_u,@P_user_id,@w_program_id,@w_prs_prg_nm,@w_mode,@w_prs_key,@w_result,@w_message

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
	EXEC SPC_M001_INQ1 @P_company_cd
END
GO
