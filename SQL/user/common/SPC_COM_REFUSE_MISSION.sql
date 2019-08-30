IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_REFUSE_MISSION]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_REFUSE_MISSION]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_REFUSE_MISSION]

    @P_mission_id			NVARCHAR(15)		= ''
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
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Từ chối nhiệm vụ'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'update'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''

	BEGIN TRANSACTION
	BEGIN TRY
		UPDATE F013 SET
			F013.condition			= 3
		,	F013.ignore_count		= ISNULL(F013.ignore_count,0)+1
		,	F013.upd_user			= @P_user_id
		,	F013.upd_prg			= @w_program_id
		,	F013.upd_ip				= @P_ip
		,	F013.upd_date			= @w_time
		WHERE F013.account_id = @P_user_id
		AND F013.mission_id = @P_mission_id

		UPDATE _S001 SET
			_S001.exp = IIF(_S001.exp - (F001.failed_exp/2) < 0,0,_S001.exp - (F001.failed_exp/2))
		,	_S001.ctp = IIF(_S001.ctp - (F001.failed_ctp/2) < 0,0,_S001.ctp - (F001.failed_ctp/2))
		,	_S001.account_div = IIF(IIF(_S001.exp - F001.failed_exp < 0,0,_S001.exp - F001.failed_exp) - ISNULL(_M999.num_remark1,0) < 0,_S001.account_div-1,_S001.account_div)
		FROM S001 _S001
		INNER JOIN F013
		ON _S001.account_id = F013.account_id
		INNER JOIN F001
		ON F013.mission_id = F001.mission_id
		LEFT JOIN M999
		ON M999.name_div = 14 
		AND M999.number_id = _S001.account_div + 1
		LEFT JOIN M999 _M999
		ON _M999.name_div = 14 
		AND _M999.number_id = _S001.account_div
		WHERE _S001.del_flg = 0
		AND F013.mission_id = @P_mission_id
		AND F013.account_id = @P_user_id

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

