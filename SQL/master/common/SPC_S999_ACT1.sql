/****** Object:  StoredProcedure [dbo].[SPC_S999_ACT1]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_S999_ACT1]
GO
/****** Object:  StoredProcedure [dbo].[SPC_S999_ACT1]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE PROCEDURE [dbo].[SPC_S999_ACT1]
     @P_user_id				NVARCHAR(15)		= ''
,    @P_screen_id			NVARCHAR(15)		= ''
,    @P_screen_nm			NVARCHAR(150)		= ''
,    @P_excute_date			DATETIME2			= NULL
,    @P_execute_div			NVARCHAR(20)		= ''
,	 @P_execute_key			NVARCHAR(100)		= ''
,    @P_execute_result		NVARCHAR(10)		= ''
,	 @P_remark				NVARCHAR(500)		= ''

AS
BEGIN

	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME2		= GETDATE()
	
	--
	BEGIN TRANSACTION
	BEGIN TRY
		--
		INSERT INTO S999
		SELECT
		     @P_user_id				
		,    @P_screen_id			
		,    @P_screen_nm
		,	 @P_excute_date		
		,    @P_execute_div
		,	 @P_execute_key				
		,    @P_execute_result				
		,	 @P_remark				
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
