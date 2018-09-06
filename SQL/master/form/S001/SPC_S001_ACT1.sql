IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_S001_ACT1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_S001_ACT1]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_S001_ACT1]
	 @P_system_div			TINYINT			=   0
,	 @P_account_div			TINYINT			=   0
,	 @P_per_xml				XML				=   ''
,	 @P_user_id				VARCHAR(10)		=	''
,	 @P_ip					VARCHAR(20)		=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'S001'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Quản lý phân quyền'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'update'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''
	--
	BEGIN TRANSACTION
	BEGIN TRY
		
		SET @w_result = 'OK'
		--
		IF @P_system_div =5
		BEGIN
			IF NOT EXISTS (SELECT 1 FROM M999 WHERE M999.name_div = 5 AND M999.number_id = @P_account_div AND M999.del_flg = 0) --code not exits 
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
		END
		ELSE
		BEGIN
			IF NOT EXISTS (SELECT 1 FROM M999 WHERE M999.name_div = 14 AND M999.number_id = @P_account_div AND M999.del_flg = 0) --code not exits 
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
		END
		DELETE FROM S002 WHERE S002.system_div = @P_system_div AND S002.account_div = @P_account_div

		INSERT INTO S002(
			system_div
		,	account_div
		,	screen_id
		,	access_per 		
		,	menu_per			
		,	add_per		 		
		,	edit_per	 		
		,	delete_per		
		,	report_per
		,	remark
		,	cre_user
		,	cre_prg
		,	cre_ip
		,	cre_date
		,	upd_user
		,	upd_prg
		,	upd_ip
		,	upd_date
		,	del_user
		,	del_prg
		,	del_ip
		,	del_date
		,	del_flg
		)	
			SELECT
			system_div			=	@P_system_div
		,	account_div			=	@P_account_div
		,	screen_id 	 		=	T.C.value('@screen_id 	  ', 'nvarchar(100)')
		,	access_per 	 		=	T.C.value('@access_per 	  ', 'tinyint')
		,	menu_per	 		=	T.C.value('@menu_per	  ', 'tinyint')
		,	add_per		 		=	T.C.value('@add_per		  ', 'tinyint')
		,	edit_per	 		=	T.C.value('@edit_per	  ', 'tinyint')
		,	delete_per			=	T.C.value('@delete_per	  ', 'tinyint')
		,	report_per 			=	T.C.value('@report_per    ', 'tinyint')
		,	remark				=	T.C.value('@remark ', 'nvarchar(MAX)')
		,	@P_user_id
		,	@w_program_id
		,	@P_ip
		,	@w_time
		,	''
		,	''
		,	''
		,	NULL
		,	''
		,	''
		,	''
		,	NULL
		,	 0
		FROM @P_per_xml.nodes('row') T(C)
		
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
