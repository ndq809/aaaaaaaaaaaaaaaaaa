﻿IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_G006_ACT1]') AND type IN (N'P', N'PC'))
DROP PROCEDURE [dbo].[SPC_G006_ACT1]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_G006_ACT1]
     @P_catalogue_id		NVARCHAR(15)		= ''
,    @P_group_nm     		NVARCHAR(200)		= ''
,	 @P_user_id				NVARCHAR(15)		= ''
,	 @P_ip					NVARCHAR(50)		= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'G006'
	,	@w_prs_prg_nm			NVARCHAR(50)		= 'Thêm nhóm'
	,	@w_result				TINYINT				= 0
	,	@w_message				TINYINT				= 0
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_inserted_key			VARCHAR(15)			= ''
	,	@w_insert_date			DATE				= NULL
	,	@w_mode					TINYINT				= 0

	BEGIN TRANSACTION
	BEGIN TRY
	IF EXISTS(SELECT 1
			  FROM M003 
			  WHERE 
				  M003.group_nm		=	@P_group_nm
			  AND LOWER(M003.catalogue_id)	=	LOWER(@P_catalogue_id) 
			  AND M003.del_flg			=	0
	)
	BEGIN
		--
		SET @w_mode    = 1
		SET @w_result  = 1
		SET @w_message = 5
	
		--
		INSERT INTO	@ERR_TBL
		SELECT	
			0
		,	6
		,	'group_nm'
		,	''
	END
	
	--
	IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC
	INSERT INTO M003 (
		 catalogue_id     
	,	 group_nm     	   
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
	     @P_catalogue_id  
	,	 @P_group_nm   		
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
	SET @w_inserted_key = CONCAT('GRO-',scope_identity())
EXIT_SPC:
	--INSERT S999
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
	SELECT @w_inserted_key AS gro_id
	
END
GO