﻿IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_REMEMBER]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_REMEMBER]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_REMEMBER]
    @P_screen_div			TINYINT				= 0
,   @P_connect_div			TINYINT				= 0
,	@P_row_id				INT					= 0
,   @P_item_1     			NVARCHAR(200)		= ''
,	@P_user_id				NVARCHAR(15)		= ''
,	@P_ip					NVARCHAR(50)		= '' 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0
	BEGIN TRANSACTION
	BEGIN TRY
	IF @P_connect_div = 2 
	BEGIN
		IF NOT EXISTS (SELECT 1 FROM M006 WHERE M006.id = @P_item_1 AND M006.del_flg = 0) --code not exits 
		BEGIN
		 INSERT INTO @ERR_TBL
		 SELECT 
		   0
		 , 5
		 , 'table-right vocabulary'
		 , @P_row_id
		END

		IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC
	END
	IF @P_connect_div = 3 
	BEGIN
		IF NOT EXISTS (SELECT 1 FROM M007 WHERE M007.post_id = @P_item_1 AND M007.del_flg = 0) --code not exits 
		BEGIN
		 INSERT INTO @ERR_TBL
		 SELECT 
		   0
		 , 5
		 , 'table-right post'
		 , @P_row_id
		END

		IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC
	END
	DELETE FROM F003 WHERE F003.user_id = @P_user_id AND F003.item_1 = @P_item_1 AND F003.connect_div = 2
	INSERT INTO F003 
	SELECT
	    @P_user_id	
	,   @P_item_1
	,	NULL     	
	,   @P_connect_div  
	,	@P_screen_div
	,	0
	,	@P_user_id
	,	'vocabulary'
	,	@P_ip
	,	SYSDATETIME()
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
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
	
END

