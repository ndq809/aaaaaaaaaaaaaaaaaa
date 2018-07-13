IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_G006_ACT2]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_G006_ACT2]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_G006_ACT2]
	 @P_gro_id_xml			XML				=   ''
,	 @P_user_id				VARCHAR(10)		=	''
,	 @P_ip					VARCHAR(20)		=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME		=  SYSDATETIME()
	,   @w_prs_user_id			NVARCHAR(6)		= @P_user_id
	,   @w_prs_prg				NVARCHAR(10)	= 'G006'
	,   @w_prs_prg_nm			NVARCHAR(50)	= 'Thêm Nhóm'
	,   @w_prs_mode				NVARCHAR(10)	= 'Delete PSC'
	,   @w_prs_key				NVARCHAR(1000)	= ''
	,	@w_prs_result			NVARCHAR(20)	= ''
	,	@w_remarks				NVARCHAR(200)	= ''
	--
	BEGIN TRANSACTION
	BEGIN TRY
		SET @w_prs_result = 'OK'
		--
		DELETE FROM M003
		WHERE M003.group_id IN (
		SELECT
			role_id		=	T.C.value('@id', 'nvarchar(15)')
		FROM @P_gro_id_xml.nodes('row') T(C))
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
