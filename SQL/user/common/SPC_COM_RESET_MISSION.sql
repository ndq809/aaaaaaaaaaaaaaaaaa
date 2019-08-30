IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_RESET_MISSION]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_RESET_MISSION]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_RESET_MISSION]
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'Common'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'reset nhiệm vụ'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'update'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''

	BEGIN TRANSACTION
	BEGIN TRY
		
		CREATE TABLE #CATALOGUE_CHECK(
			catalogue_div	INT
		,	account_id		NVARCHAR(15)
		)

		UPDATE _S001 SET
			_S001.exp = IIF(_S001.exp - (F001.failed_exp/2) < 0,0,_S001.exp - (F001.failed_exp/2))
		,	_S001.ctp = IIF(_S001.ctp - (F001.failed_ctp/2) < 0,0,_S001.ctp - (F001.failed_ctp/2))
		FROM S001 _S001
		INNER JOIN F013
		ON _S001.account_id = F013.account_id
		INNER JOIN F001
		ON F013.mission_id = F001.mission_id
		WHERE _S001.del_flg = 0
		AND F013.condition = 0
		AND F013.status = 1

		UPDATE _S001 SET
			_S001.exp = IIF(_S001.exp - F001.failed_exp < 0,0,_S001.exp - F001.failed_exp)
		,	_S001.ctp = IIF(_S001.ctp - F001.failed_ctp < 0,0,_S001.ctp - F001.failed_ctp)
		FROM S001 _S001
		INNER JOIN F013
		ON _S001.account_id = F013.account_id
		INNER JOIN F001
		ON F013.mission_id = F001.mission_id
		WHERE _S001.del_flg = 0
		AND F013.condition = 1
		AND F013.status = 1

		UPDATE _F013 SET
			_F013.condition			= 0
		,	_F013.try_times_count	= 0
		,	_F013.status            = IIF(ISNULL(_F013.current_unit,0) < ISNULL(F001.total_unit,0),1,2)
		,	_F013.unit_this_times	= F001.unit_per_times
		FROM F013 _F013
		INNER JOIN F001
		ON _F013.mission_id = F001.mission_id
		WHERE F001.mission_div = 1
		AND _F013.status = 1

		UPDATE _S001 SET
			_S001.account_div = IIF(_S001.exp - ISNULL(_M999.num_remark1,0) < 0,_S001.account_div-1,_S001.account_div)
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
		AND F013.status = 1 
		AND (F013.condition = 0 OR F013.condition = 1)

		INSERT INTO #CATALOGUE_CHECK
		SELECT
			F001.catalogue_div
		,	F013.account_id
		FROM F001
		INNER JOIN F013
		ON F001.mission_id = F013.mission_id
		AND F013.status = 1
		GROUP BY 
			F001.catalogue_div
		,	F013.account_id

		UPDATE _F013 SET
			_F013.status            = 1
		FROM (
			SELECT
				ROW_NUMBER() OVER(PARTITION BY F001.catalogue_div,F013.account_id ORDER BY NEWID() ASC) AS row_id 
			,	F013.status
			FROM F013
			INNER JOIN F001
			ON F013.mission_id = F001.mission_id
			LEFT JOIN #CATALOGUE_CHECK
			ON F001.catalogue_div = #CATALOGUE_CHECK.catalogue_div
			AND F013.account_id = #CATALOGUE_CHECK.account_id
			WHERE ISNULL(F013.status,0) = 0
			AND #CATALOGUE_CHECK.catalogue_div IS NULL
		)_F013
		WHERE _F013.row_id = 1

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
END

