IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_PROFILE_ACT1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_PROFILE_ACT1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_PROFILE_ACT1]
		@P_first_name			NVARCHAR(20)	=	'' 
	,	@P_family_nm			NVARCHAR(50)	=	''
	,	@P_account_nm			NVARCHAR(30)	=	''
	,	@P_email				NVARCHAR(50)	=	''
	,	@P_avatar				NVARCHAR(MAX)	=	''
	,	@P_birth_date			NVARCHAR(20)	=	''
	,	@P_sex					INT				=	''
	,	@P_job					INT				=	''
	,	@P_eng_level			INT				=	''
	,	@P_cellphone			NVARCHAR(20)	=	''
	,	@P_position				INT				=	''
	,	@P_field				XML				=	''
	,	@P_slogan				NVARCHAR(MAX)	=	''
	,	@P_facebook_id			NVARCHAR(200)	=	''
	,	@P_facebook_token		NVARCHAR(500)	=	''
	,	@P_account_id			NVARCHAR(15)	=	''
	,	@P_ip					NVARCHAR(15)	=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'profile'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'cập nhật thông tin'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'insert'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''
	,	@w_current_nm			VARCHAR(15)			= ''
	,	@w_current_email		VARCHAR(50)			= ''
	,	@w_briged_id			INT					= NULL
	,	@w_increase_id			INT					= 0
	,	@w_old_media			NVARCHAR(1000)		= ''

	BEGIN TRANSACTION
	BEGIN TRY
	SELECT 
		@w_current_nm = S001.account_nm
	,	@w_current_email = M001.email 
	FROM S001 
	INNER JOIN M001
	ON S001.user_id = M001.user_id
	WHERE
		S001.account_id = @P_account_id

	IF EXISTS (SELECT 1 FROM S001 WHERE S001.account_nm = @P_account_nm AND @P_account_nm <> @w_current_nm AND S001.del_flg = 0) --username exits 
	BEGIN
	 SET @w_result = 'NG'
	 SET @w_message = 19
	 INSERT INTO @ERR_TBL
	 SELECT 
	  0
	 , @w_message
	 , 'account_nm_create'
	 , ''
	END

	IF EXISTS (SELECT 1 FROM M001 WHERE M001.email = @P_email AND @P_email <> @w_current_email AND M001.del_flg = 0) --username exits 
	BEGIN
	 SET @w_result = 'NG'
	 SET @w_message = 21
	 INSERT INTO @ERR_TBL
	 SELECT 
	  0
	 , @w_message
	 , 'email'
	 , ''
	END

	IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC
	SELECT @w_briged_id= ISNULL(MAX(F009.briged_id),0)+1 FROM F009
	INSERT INTO F009
	SELECT 
		@w_briged_id
	,	T.C.value('@tag_id', 'int')
	,	3
	,	 @P_account_nm
	,	 @w_program_id
	,	 @P_ip
	,	 @w_time
	FROM @P_field.nodes('row') T(C) 

	UPDATE M001 SET
		family_nm	=	@P_family_nm
	,	first_name	=	@P_first_name
	,	email		=	@P_email
	,	birth_date	=	convert(datetime,@P_birth_date,103)
	,	cellphone	=	@P_cellphone
	,	sex			=	@P_sex
	,	avarta		=	@P_avatar
	,	job			=	@P_job
	,	english_lv	=	@P_eng_level
	,	position	=	@P_position
	,	field		=	@w_briged_id
	,	slogan		=	@P_slogan
	,	del_flg		=	0
	,	cre_user	=	cre_user
	,	cre_prg		=	cre_prg	
	,	cre_ip		=	cre_ip	
	,	cre_date	=	cre_date
	,	upd_user	=	@P_account_nm
	,	upd_prg		=	@w_program_id
	,	upd_ip		=	@P_ip
	,	upd_date	=	@w_time
	,	del_user	=	NULL
	,	del_prg		=	NULL
	,	del_ip		=	NULL
	,	del_date	=	NULL

	SET @w_inserted_key = scope_identity()
	
	UPDATE S001 SET
		social_id		=	@P_facebook_id
	,	account_nm		=	@P_account_nm
	,	social_token	=	@P_facebook_token
	,	upd_user		=	@P_account_nm
	,	upd_prg			=	@w_program_id
	,	upd_ip			=	@P_ip
	,	upd_date		=	@w_time
	WHERE
		S001.account_id = @P_account_id

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
	--EXEC SPC_S999_ACT1 @P_user_id,@w_program_id,@w_prs_prg_nm,@w_time,@w_mode,@w_prs_key,@w_result,@w_message

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
	SELECT @P_account_nm AS account_nm
	
END

