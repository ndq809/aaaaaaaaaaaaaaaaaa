IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_TOGGLE_EFFECT]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_TOGGLE_EFFECT]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_TOGGLE_EFFECT]

    @P_row_id				TINYINT				= 0
,   @P_target_id   			NVARCHAR(20)		= ''
,   @P_execute_div    		INT					= 0
,   @P_execute_target_div   INT					= 0
,	@P_mode					INT					= 0
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
	IF @P_mode = 0
	BEGIN
		INSERT INTO F008(
			target_id
		,	user_id
		,	execute_div
		,	execute_target_div
		,	del_flg
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

			)
		SELECT
			@P_target_id
		,	@P_user_id
		,	@P_execute_div
		,	@P_execute_target_div
		,	0
		,	@P_user_id
		,	'common'
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

		IF @P_execute_target_div = 1
		BEGIN
			UPDATE M012 SET
				M012.clap		= M012.clap + 1
			,	M012.upd_user	=	@P_user_id
			,	M012.upd_prg	=	'common'
			,	M012.upd_ip		=	@P_ip
			,	M012.upd_date	=	SYSDATETIME()
			WHERE M012.example_id = @P_target_id
		END
	END
	ELSE
	BEGIN
		DELETE F008 WHERE F008.target_id = @P_target_id
		IF @P_execute_target_div = 1
		BEGIN
			UPDATE M012 SET
				M012.clap		= M012.clap - 1
			,	M012.upd_user	=	@P_user_id
			,	M012.upd_prg	=	'common'
			,	M012.upd_ip		=	@P_ip
			,	M012.upd_date	=	SYSDATETIME()
			WHERE M012.example_id = @P_target_id
		END
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
	IF @P_execute_target_div = 1
	BEGIN
		SELECT clap AS effected_count
		FROM M012
		WHERE M012.example_id = @P_target_id
	END 
	
END

