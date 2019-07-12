IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_TRANSLATION_ACT1]') AND type IN (N'P', N'PC'))
DROP PROCEDURE [dbo].[SPC_TRANSLATION_ACT1]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_TRANSLATION_ACT1]
	 @P_post_id		        NVARCHAR(15)		= ''
,	 @P_post_title		    NVARCHAR(250)		= ''
,	 @P_post_tag		    NVARCHAR(MAX)		= ''
,    @P_en_text     		NTEXT				= ''
,    @P_vi_text     		NTEXT				= ''
,    @P_en_array   			NVARCHAR(MAX)		= ''
,    @P_vi_array   			NVARCHAR(MAX)		= ''
,    @P_auto_array   		NVARCHAR(MAX)		= ''
,    @P_save_mode   		INT					= 0
,	 @P_user_id				NVARCHAR(15)		= ''
,	 @P_ip					NVARCHAR(50)		= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'translation'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'phiên dịch'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'insert'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''
	,	@w_briged_id			VARCHAR(15)			= ''

	BEGIN TRANSACTION
	BEGIN TRY

	CREATE TABLE #TAG(
		tag_id INT	
	)

	INSERT INTO M013
	SELECT
		#TEMP.tag_nm	
	,	6	
	,	0
	,	0
	,	@P_user_id
	,	@w_program_id
	,	@P_ip
	,	@w_time
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	FROM OPENJSON(@P_post_tag) WITH(
        is_new	            NVARCHAR(100)	'$.is_new	     '
    ,   tag_nm	            NVARCHAR(100)	'$.tag_nm	     '
    ) AS #TEMP
	LEFT JOIN M013
	ON #TEMP.tag_nm = M013.tag_nm
	AND M013.tag_div = 6
	WHERE #TEMP.is_new = 1
	AND M013.tag_id IS NULL

	INSERT INTO #TAG
	SELECT
		M013.tag_id
	FROM OPENJSON(@P_post_tag) WITH(
        tag_id	            NVARCHAR(100)	'$.tag_id	     '
    ,   tag_nm	            NVARCHAR(100)	'$.tag_nm	     '
    ) AS #TEMP
	INNER JOIN M013
	ON (#TEMP.tag_nm = M013.tag_nm OR #TEMP.tag_id = M013.tag_id)


	IF @P_post_id = ''
	BEGIN
		SELECT @w_briged_id= ISNULL(MAX(F009.briged_id),0)+1 FROM F009
		
		IF EXISTS (SELECT 1 FROM #TAG)
		BEGIN
			INSERT INTO F009
			SELECT 
				@w_briged_id
			,	#TAG.tag_id
			,	2
			,	 @P_user_id
			,	 @w_program_id
			,	 @P_ip
			,	 @w_time			
			FROM #TAG
		END

		INSERT INTO F010(
			 post_title
		,	 en_text
		,	 vi_text
		,	 post_div
		,	 briged_id
		,	 cre_user
		,	 cre_prg
		,	 cre_ip
		,	 cre_date
		,	 upd_user
		,	 upd_prg
		,	 upd_ip
		,	 upd_date
		,	 del_user
		,	 del_prg
		,	 del_ip
		,	 del_date
		,	 del_flg	
		)
		SELECT
			 @P_post_title
		,	 @P_en_text
		,	 @P_vi_text
		,	 @P_save_mode
		,	 @w_briged_id
		,	 @P_user_id
		,	 @w_program_id
		,	 @P_ip
		,	 @w_time
		,	 NULL
		,	 NULL
		,	 NULL
		,	 NULL
		,	 NULL
		,	 NULL
		,	 NULL
		,	 NULL
		,	  0

		SET @w_inserted_key = scope_identity()

		INSERT INTO F011
		SELECT
			@w_inserted_key
		,	EN_ARRAY.en_text
		,	VI_ARRAY.vi_text
		,	AUTO_ARRAY.auto_text
		,	0
		,	@P_user_id
		,	@w_program_id
		,	@P_ip
		,	@w_time
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		FROM
		(SELECT
				id			AS	id		
			,	en_text		AS	en_text
			FROM OPENJSON(@P_en_array) WITH(
				id	            NVARCHAR(100)	'$.id	     '
			,	en_text	        NVARCHAR(100)	'$.value	     '
			)
		)EN_ARRAY
		LEFT JOIN 
		(SELECT
				id			AS	id		
			,	vi_text		AS	vi_text
			FROM OPENJSON(@P_vi_array) WITH(
				id	            NVARCHAR(100)	'$.id	     '
			,	vi_text	        NVARCHAR(100)	'$.value	     '
			)
		)VI_ARRAY
		ON EN_ARRAY.id = VI_ARRAY.id
		LEFT JOIN 
		(SELECT
				id				AS	id		
			,	auto_text		AS	auto_text
			FROM OPENJSON(@P_auto_array) WITH(
				id	            NVARCHAR(100)	'$.id	     '
			,	auto_text	        NVARCHAR(100)	'$.value	     '
			)
		)AUTO_ARRAY
		ON EN_ARRAY.id = AUTO_ARRAY.id	
	END
	ELSE
	BEGIN
		SET @w_mode='update'
		SET @w_inserted_key = @P_post_id
		IF NOT EXISTS (SELECT 1 FROM F010 WHERE F010.post_id = @P_post_id AND F010.del_flg = 0) --code not exits 
		BEGIN
		 SET @w_result = 'NG'
		 SET @w_message = 5
		 INSERT INTO @ERR_TBL
		 SELECT 
		  0
		 , @w_message
		 , 'post_id'
		 , ''
		END
		IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC

		SELECT @w_briged_id = F010.briged_id FROM F010 WHERE F010.post_id = @P_post_id
		IF @w_briged_id IS NULL
		BEGIN
			SELECT @w_briged_id= ISNULL(MAX(F009.briged_id),0)+1 FROM F009
		END

		DELETE FROM F009 WHERE F009.briged_id = @w_briged_id AND F009.briged_div = 2
		IF EXISTS (SELECT 1 FROM #TAG)
		BEGIN
			INSERT INTO F009
			SELECT 
				@w_briged_id
			,	#TAG.tag_id
			,	2
			,	 @P_user_id
			,	 @w_program_id
			,	 @P_ip
			,	 @w_time
			FROM #TAG
		END
		
		UPDATE F010 SET 
			 en_text		=	@P_en_text   
		,	 vi_text		=	@P_vi_text   
		,	 post_div		=	@P_save_mode   
		,	 upd_user		=	@P_user_id
		,	 upd_prg		=	@w_program_id
		,	 upd_ip			=	@P_ip
		,	 upd_date		=	@w_time
		WHERE F010.post_id	=	@P_post_id
		AND F010.del_flg	=	0

		SET @w_inserted_key = @P_post_id

		DELETE FROM F011 WHERE post_id = @P_post_id

		INSERT INTO F011
		SELECT
			@w_inserted_key
		,	EN_ARRAY.en_text
		,	VI_ARRAY.vi_text
		,	AUTO_ARRAY.auto_text
		,	0
		,	@P_user_id
		,	@w_program_id
		,	@P_ip
		,	@w_time
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		,	NULL
		FROM
		(SELECT
				id			AS	id		
			,	en_text		AS	en_text
			FROM OPENJSON(@P_en_array) WITH(
				id	            NVARCHAR(100)	'$.id	     '
			,	en_text	        NVARCHAR(100)	'$.value	     '
			)
		)EN_ARRAY
		LEFT JOIN 
		(SELECT
				id			AS	id		
			,	vi_text		AS	vi_text
			FROM OPENJSON(@P_vi_array) WITH(
				id	            NVARCHAR(100)	'$.id	     '
			,	vi_text	        NVARCHAR(100)	'$.value	     '
			)
		)VI_ARRAY
		ON EN_ARRAY.id = VI_ARRAY.id
		LEFT JOIN 
		(SELECT
				id				AS	id		
			,	auto_text		AS	auto_text
			FROM OPENJSON(@P_auto_array) WITH(
				id	            NVARCHAR(100)	'$.id	     '
			,	auto_text	        NVARCHAR(100)	'$.value	     '
			)
		)AUTO_ARRAY
		ON EN_ARRAY.id = AUTO_ARRAY.id	
		
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
	EXEC SPC_S999_ACT1 @P_user_id,@w_program_id,@w_prs_prg_nm,@w_time,@w_mode,@w_prs_key,@w_result,@w_message

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
	EXEC SPC_TRANSLATION_LST1 @w_inserted_key,@P_user_id 
	--[1]

	SELECT  Id
		,	Code 
		,	Data 
		,	[Message]
	FROM @ERR_TBL
	ORDER BY Code
END
GO
