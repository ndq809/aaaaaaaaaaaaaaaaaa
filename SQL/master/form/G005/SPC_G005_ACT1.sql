IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_G005_ACT1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_G005_ACT1]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_G005_ACT1]
	 @P_gro_id_json			NVARCHAR(MAX)	=   ''
,	 @P_user_id				VARCHAR(10)		=	''
,	 @P_ip					VARCHAR(20)		=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'G005'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Quản lý nhóm'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'update'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''
	--
	BEGIN TRANSACTION
	BEGIN TRY
		CREATE TABLE #SCREEN_DATA(
			row_id			INT
		,	catalogue_div	nvarchar(15)
		,	catalogue_id	nvarchar(15)
		,	group_nm   		nvarchar(50)
		,	group_id  		nvarchar(20)
		)

		CREATE TABLE #CHECK_MASTER(
			row_id			INT
		,	item_id			nvarchar(50)
		,	item_div		NVARCHAR(15)
		)

		INSERT INTO #SCREEN_DATA
		SELECT              
           	row_id			
		,	catalogue_div	
		,	catalogue_id	
		,	group_nm   		            
		,	group_id  		            
        FROM OPENJSON(@P_gro_id_json) WITH(
        	row_id					NVARCHAR(100)	'$.row_id			 '
        ,	catalogue_div		    NVARCHAR(100)	'$.catalogue_div	'
        ,	catalogue_id		    NVARCHAR(100)	'$.catalogue_nm	'
        ,	group_nm   			    NVARCHAR(100)	'$.group_nm   		'
        ,	group_id  			    NVARCHAR(100)	'$.group_id  		'
        )

		INSERT INTO #CHECK_MASTER
		SELECT #SCREEN_DATA.row_id, CAST(catalogue_div AS NVARCHAR(15)),'catalogue_div' FROM #SCREEN_DATA
		UNION
		SELECT #SCREEN_DATA.row_id,CAST(catalogue_id AS NVARCHAR(15)),'catalogue_nm' FROM #SCREEN_DATA

		DELETE #CHECK_MASTER
		FROM #CHECK_MASTER
		LEFT JOIN M999
		ON M999.name_div = 7
		AND #CHECK_MASTER.item_id = CAST(M999.number_id AS NVARCHAR(15))
		AND M999.del_flg = 0
		LEFT JOIN M002
		ON #CHECK_MASTER.item_id = M002.catalogue_id
		AND M002.del_flg = 0
		WHERE (M999.number_id IS NOT NULL AND #CHECK_MASTER.item_div = 'catalogue_div')
		OR (M002.catalogue_id IS NOT NULL AND #CHECK_MASTER.item_div = 'catalogue_nm')

		IF EXISTS (SELECT * FROM #CHECK_MASTER)
		BEGIN
			SET @w_result = 'NG'
			SET @w_message = 5
			INSERT INTO @ERR_TBL
			SELECT 
			 1
			, @w_message
			, #CHECK_MASTER.item_div
			, #CHECK_MASTER.row_id
			FROM #CHECK_MASTER
		END
		IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC
		
		INSERT INTO #CHECK_MASTER
		SELECT
			#SCREEN_DATA.row_id
		,	IIF(#SCREEN_DATA.group_nm IS NULL ,M003.group_nm,#SCREEN_DATA.group_nm)
		,	CONCAT(M003.catalogue_div,M003.catalogue_id)
		FROM #SCREEN_DATA
		RIGHT JOIN M003
		ON　#SCREEN_DATA.catalogue_id = M003.catalogue_id
		AND #SCREEN_DATA.catalogue_div = CAST(M003.catalogue_div AS NVARCHAR(15))
		AND #SCREEN_DATA.group_id = M003.group_id
		AND M003.del_flg = 0
		--select * from #CHECK_MASTER
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
			, 'group_nm'
			, #CHECK_MASTER.row_id
			FROM #CHECK_MASTER
		END
		IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC
		UPDATE M003 SET
			catalogue_div		=	update_data.catalogue_div
		,	catalogue_id   		=	update_data.catalogue_id   
		,	group_nm  			=	update_data.group_nm  
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
           	row_id			AS	row_id			
		,	catalogue_div	AS	catalogue_div	
		,	catalogue_nm	AS	catalogue_id	
		,	group_nm   		AS	group_nm   		            
		,	group_id  		AS	group_id  		            
        FROM OPENJSON(@P_gro_id_json) WITH(
        	row_id					NVARCHAR(100)	'$.row_id			 '
        ,	catalogue_div		    NVARCHAR(100)	'$.catalogue_div	'
        ,	catalogue_nm		    NVARCHAR(100)	'$.catalogue_nm	'
        ,	group_nm   			    NVARCHAR(100)	'$.group_nm   		'
        ,	group_id  			    NVARCHAR(100)	'$.group_id  		'
        )
		) update_data
		WHERE
			M003.group_id = update_data.group_id

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
