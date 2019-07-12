IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_RELAX_ACT3]') AND type IN (N'P', N'PC'))
DROP PROCEDURE [dbo].[SPC_RELAX_ACT3]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_RELAX_ACT3]
     @P_post_id     		NVARCHAR(50)		= ''
,    @P_post_div     		INT					= 0
,    @P_post_title     		NVARCHAR(200)		= ''
,    @P_post_tag     		NVARCHAR(MAX)		= ''
,    @P_post_content    	NTEXT				= ''
,    @P_post_media     		NVARCHAR(200)		= ''
,    @P_post_media_nm     	NVARCHAR(200)		= ''
,    @P_post_media_div     	TINYINT				= 0
,	 @P_user_id				NVARCHAR(15)		= ''
,	 @P_ip					NVARCHAR(50)		= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'relax'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Thêm bài viết'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'insert'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''
	,	@w_briged_id			INT					= NULL
	,	@w_increase_id			INT					= 0
	,	@w_old_media			NVARCHAR(1000)		= ''

	BEGIN TRANSACTION
	BEGIN TRY
	IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC

	CREATE TABLE #VOCABULARY(
		row_id	INT
	,	Vocabulary_code INT	
	)

	CREATE TABLE #TAG(
		tag_id INT	
	)

	INSERT INTO M013
	SELECT
		#TEMP.tag_nm	
	,	CASE @P_post_div
		WHEN 7 THEN 4	
		WHEN 8 THEN 5	
		WHEN 9 THEN 6
		END	
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
	AND M013.tag_div =	CASE @P_post_div
							WHEN 7 THEN 4	
							WHEN 8 THEN 5	
							WHEN 9 THEN 6
						END	
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
	
	IF @P_post_id =''
	BEGIN
	
		SELECT @w_briged_id= ISNULL(MAX(F009.briged_id),0)+1 FROM F009
		IF EXISTS (SELECT 1 FROM #VOCABULARY)
		BEGIN
			INSERT INTO F009
			SELECT 
				@w_briged_id
			,	#VOCABULARY.Vocabulary_code
			,	1
			,	 @P_user_id
			,	 @w_program_id
			,	 @P_ip
			,	 @w_time
			FROM #VOCABULARY
		END

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
		INSERT INTO M007 (
			 catalogue_div     
		,	 catalogue_id
		,	 group_id
		,	 record_div
		,	 post_div
		,	 briged_id 
		,	 post_title 
		,	 post_content 
		,	 post_media
		,	 post_media_nm
		,	 media_div 
		,	 post_view 
		,	 post_rating 
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
		     @P_post_div    
		,	 NULL
		,	 NULL
		,	 2
		,	 2
		,	 @w_briged_id 
		,	 @P_post_title 
		,	 @P_post_content 
		,	 @P_post_media
		,	 @P_post_media_nm 
		,	 @P_post_media_div 
		,	 0 
		,	 0   		
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
			@w_inserted_key
		,	@P_user_id
		,	4
		,	5
		,	0
		,	@P_user_id
		,	@w_program_id
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
	END
	ELSE
	BEGIN
		SET @w_mode='update'
		IF NOT EXISTS (SELECT 1 FROM M007 WHERE M007.post_id = @P_post_id AND M007.del_flg = 0) --code not exits 
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
		SELECT @w_briged_id = M007.briged_id FROM M007 WHERE M007.post_id = @P_post_id
		IF @w_briged_id IS NULL
		BEGIN
			SELECT @w_briged_id= ISNULL(MAX(F009.briged_id),0)+1 FROM F009
		END

		DELETE FROM F009 WHERE F009.briged_id = @w_briged_id AND F009.briged_div = 1
		IF EXISTS (SELECT 1 FROM #VOCABULARY)
		BEGIN
			INSERT INTO F009
			SELECT 
				@w_briged_id
			,	#VOCABULARY.Vocabulary_code
			,	1
			,	 @P_user_id
			,	 @w_program_id
			,	 @P_ip
			,	 @w_time
			FROM #VOCABULARY
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
		UPDATE M007 SET 
			 catalogue_div    =	@P_post_div   
		,	 catalogue_id	  =	NULL
		,	 group_id		  =	NULL
		,	 briged_id 		  =	@w_briged_id 
		,	 post_title 	  =	@P_post_title 
		,	 post_content 	  =	@P_post_content 
		,	 post_media		  =	IIF(@P_post_media='',post_media,@P_post_media)
		,	 post_media_nm	  =	IIF(@P_post_media_nm='', post_media_nm,@P_post_media_nm)
		,	 media_div 		  =	IIF(@P_post_media_div =0,media_div,@P_post_media_div)
		,	 upd_user		  = @P_user_id
		,	 upd_prg		  = @w_program_id
		,	 upd_ip			  = @P_ip
		,	 upd_date		  = @w_time
		WHERE M007.post_id = @P_post_id
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
	SELECT  Id
		,	Code 
		,	Data 
		,	[Message]
	FROM @ERR_TBL
	ORDER BY Code
	--[1]
	SELECT 
		@w_inserted_key AS post_id
	,	@P_post_title AS post_title
	,	CASE M007.catalogue_div
		WHEN 7 THEN	N'Hình ảnh'
		WHEN 8 THEN	N'Video'
		WHEN 9 THEN	N'truyện'
		END AS catalogue_div
	FROM M007
	WHERE M007.post_id = @w_inserted_key
	
END
GO
