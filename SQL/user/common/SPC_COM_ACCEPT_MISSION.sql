IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_ACCEPT_MISSION]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_ACCEPT_MISSION]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_ACCEPT_MISSION]

    @P_mission_id			NVARCHAR(15)		= ''
,   @P_unit_this_times		INT					= 0
,	@P_user_id				NVARCHAR(15)		= ''
,	@P_ip					NVARCHAR(50)		= '' 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'Common'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Chấp nhận nhiệm vụ'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'update'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''

	BEGIN TRANSACTION
	BEGIN TRY
		UPDATE F013 SET
			F013.condition			= 1
		,	F013.unit_this_times	= @P_unit_this_times
		,	F013.upd_user			= @P_user_id
		,	F013.upd_prg			= @w_program_id
		,	F013.upd_ip				= @P_ip
		,	F013.upd_date			= @w_time
		WHERE F013.account_id = @P_user_id
		AND F013.mission_id = @P_mission_id
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

	EXEC SPC_COM_MISSION @P_mission_id,@P_user_id
END

