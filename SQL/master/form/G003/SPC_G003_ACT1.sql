IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_G003_ACT1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_G003_ACT1]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_G003_ACT1]
	 @P_emp_id_xml			XML				=   ''
,	 @P_user_id				VARCHAR(10)		=	''
,	 @P_ip					VARCHAR(20)		=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'G003'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Quản lý danh mục'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'update'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''
	--
	BEGIN TRANSACTION
	BEGIN TRY
		--
		CREATE TABLE #CHECK_MASTER(
			row_id			INT
		,	item_id			NVARCHAR(50)
		,	item_div		NVARCHAR(15)
		)

		CREATE TABLE #SCREEN_DATA(
			row_id			INT
		,	catalogue_div	NVARCHAR(15)
		,	catalogue_nm	NVARCHAR(50)
		,	catalogue_id   	NVARCHAR(50)
		)

		INSERT INTO #SCREEN_DATA
		SELECT
			row_id				=	T.C.value('@row_id		 ', 'INT')
		,	catalogue_div		=	T.C.value('@catalogue_div		 ', 'nvarchar(15)')
		,	catalogue_nm   		=	T.C.value('@catalogue_nm    ', 'nvarchar(50)')
		,	catalogue_id  		=	T.C.value('@catalogue_id   ', 'nvarchar(20)')
		FROM @P_emp_id_xml.nodes('row') T(C)
		
		INSERT INTO #CHECK_MASTER
		SELECT
			#SCREEN_DATA.row_id
		,	#SCREEN_DATA.catalogue_div
		,	'catalogue_div'
		FROM #SCREEN_DATA
		LEFT JOIN M999
		ON M999.name_div = 7
		AND #SCREEN_DATA.catalogue_div = M999.number_id
		AND M999.del_flg = 0
		WHERE M999.number_id IS NULL

		IF EXISTS (SELECT * FROM #CHECK_MASTER)
		BEGIN
			SET @w_result = 'NG'
			SET @w_message = 5
			INSERT INTO @ERR_TBL
			SELECT 
			 1
			, @w_message
			, 'catalogue_div'
			, #CHECK_MASTER.row_id
			FROM #CHECK_MASTER
		END
		IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC

		INSERT INTO #CHECK_MASTER
		SELECT
			#SCREEN_DATA.row_id
		,	IIF(#SCREEN_DATA.catalogue_nm IS NULL ,M002.catalogue_nm,#SCREEN_DATA.catalogue_nm)
		,	M002.catalogue_div
		FROM #SCREEN_DATA
		RIGHT JOIN M002
		ON　#SCREEN_DATA.catalogue_id = M002.catalogue_id
		AND #SCREEN_DATA.catalogue_div = M002.catalogue_div
		AND M002.del_flg = 0

		DELETE #CHECK_MASTER FROM #CHECK_MASTER 
		WHERE #CHECK_MASTER.item_id IN (SELECT #CHECK_MASTER.item_id FROM #CHECK_MASTER GROUP BY #CHECK_MASTER.item_id,#CHECK_MASTER.item_div HAVING COUNT(*) = 1)
		OR #CHECK_MASTER.row_id IS NULL
		
		IF EXISTS (SELECT * FROM #CHECK_MASTER)
		BEGIN
			SET @w_result = 'NG'
			SET @w_message = 6
			INSERT INTO @ERR_TBL
			SELECT 
			 1
			, @w_message
			, 'catalogue_nm'
			, #CHECK_MASTER.row_id
			FROM #CHECK_MASTER
		END
		IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC
		 
		UPDATE M002 SET
			catalogue_div   	=	update_data.catalogue_div   
		,	catalogue_nm  		=	update_data.catalogue_nm  
		,	upd_user			=	@P_user_id
		,	upd_prg				=	@w_program_id
		,	upd_ip				=	@P_ip
		,	upd_date			=	@w_time
		,	del_user			=	''
		,	del_prg				=	''
		,	del_ip				=	''
		,	del_date			=	NULL
		,	del_flg				=	0	   	  
		FROM (
		SELECT
			catalogue_div		=	T.C.value('@catalogue_div		 ', 'nvarchar(15)')
		,	catalogue_nm   		=	T.C.value('@catalogue_nm    ', 'nvarchar(50)')
		,	catalogue_id  		=	T.C.value('@catalogue_id   ', 'nvarchar(20)')
		FROM @P_emp_id_xml.nodes('row') T(C)) update_data
		WHERE
			M002.catalogue_id = update_data.catalogue_id

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
EXIT_SPC:
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
