/****** Object:  StoredProcedure [dbo].[SPC_M016_ACT1]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_M016_ACT1]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M016_ACT1]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE PROCEDURE [dbo].[SPC_M016_ACT1]
 @ @P_target_id				NVARCHAR(15)		= ''
,   @P_target_div			INT					= 0
,	@P_history_div			TINYINT					= 0
,	@P_notes				NVARCHAR(500)		= ''
,	@P_user_id				NVARCHAR(15)		= ''
,	@P_ip					NVARCHAR(50)		= ''
,	@P_program_id			NVARCHAR(50)		= ''
,	@P_time					DATETIME2			=@NULL

AS
BEGIN

	SET NOCOUNT ON;
	DECLARE
		@ERR_TBL					ERRTABLE
	,	@w_max						INT = 0
	--
	BEGIN TRANSACTION
	BEGIN TRY
		--
		IF @P_target_div = 0
		BEGIN
			IF EXISTS(SELECT 1 FROM M016 WHERE M016.target_id = @P_target_id AND M016.target_div = @P_target_div)
			BEGIN
				SELECT @w_max = MAX(M016.target_row_no) + 1 FROM M016 WHERE M016.target_id = @P_target_id AND M016.target_div = @P_target_div
			END
			INSERT INTO M016
			SELECT
				@P_target_id
			,	@w_max
			,	@P_target_div
			,	M007.record_div
			,	@P_history_div
			,	@P_notes
			,	@P_user_id
			,	@P_program_id
			,	@P_ip
			,	@P_time
			FROM M007
			WHERE
				M007.post_id = @P_target_id
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
	

COMPLETE_QUERY:
	IF EXISTS(SELECT 1 FROM @ERR_TBL)
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
END


GO
