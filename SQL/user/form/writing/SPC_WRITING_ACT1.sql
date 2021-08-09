IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_WRITING_ACT1]') AND type IN (N'P', N'PC'))
DROP PROCEDURE [dbo].[SPC_WRITING_ACT1]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_WRITING_ACT1]
	 @P_row_id		        INT					= 0
,	 @P_post_id		        NVARCHAR(15)		= ''
,    @P_post_tag     		NVARCHAR(MAX)		= ''
,    @P_post_title     		NVARCHAR(200)		= ''
,    @P_post_content    	NTEXT				= ''
,    @P_json_detail   		NVARCHAR(MAX)		= ''
,	 @P_user_id				NVARCHAR(15)		= ''
,	 @P_ip					NVARCHAR(50)		= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'Writing'
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

	CREATE TABLE #WRITING(
		row_id				INT
	,	post_id				INT
	,	briged_id			INT
	,	post_title			NVARCHAR(100)
	,	post_content		NVARCHAR(MAX)
	,	my_post				INT
	,	edit_time			DATETIME2
	)

	CREATE TABLE #VOCABULARY(
		row_id	INT
	,	Vocabulary_code INT	
	)

	CREATE TABLE #TAG(
		tag_id INT	
	)

	CREATE TABLE #TABLE_DETAIL(
		vocabulary_id INT
	,	vocabulary_dtl_id TINYINT
	,	edit_confirm INT
	,	vocabulary_div INT
	,	vocabulary_nm NVARCHAR(200)
	,	spelling NVARCHAR(200)
	,	mean NVARCHAR(MAX)
	,	explain NVARCHAR(MAX)
	,	row_index INT		
	)

	CREATE TABLE #TABLE_DETAIL1(
		vocabulary_id INT
	,	vocabulary_dtl_id TINYINT
	,	edit_confirm INT
	,	vocabulary_div INT
	,	vocabulary_nm NVARCHAR(200)
	,	spelling NVARCHAR(200)
	,	mean NVARCHAR(MAX)
	,	explain NVARCHAR(MAX)
	,	row_index INT		
	)

	CREATE TABLE #TABLE_DETAIL2(
		row_id INT
	,	content NVARCHAR(MAX)
	,	verify TINYINT
	,	question_div TINYINT
	)

	CREATE TABLE #TABLE_QUESTION(
		row_id INT
	,	question_id INT
	)

	INSERT INTO #TABLE_DETAIL
	SELECT              
       		vocabulary_id		AS vocabulary_id		
		,	vocabulary_dtl_id 	AS vocabulary_dtl_id 	
		,	edit_confirm 		AS edit_confirm 		
		,	vocabulary_div 		AS vocabulary_div 		          
		,	vocabulary_nm 		AS vocabulary_nm 		          
		,	spelling 			AS spelling 			          
		,	mean 				AS mean 				          
		,	explain 			AS explain 			          
		,	row_number() over(partition by vocabulary_id,vocabulary_dtl_id order by vocabulary_id,vocabulary_dtl_id)	AS row_index 			          
		FROM OPENJSON(@P_json_detail) WITH(
    		vocabulary_id				NVARCHAR(100)	'$.vocabulary_id		 '
		,	vocabulary_dtl_id 		    NVARCHAR(100)	'$.vocabulary_dtl_id 	'
		,	edit_confirm 			    NVARCHAR(100)	'$.edit_confirm 		'
		,	vocabulary_div 			    NVARCHAR(100)	'$.vocabzulary_div 		'
		,	vocabulary_nm 			    NVARCHAR(100)	'$.vocabulary_nm 		'
		,	spelling 				    NVARCHAR(100)	'$.spelling 			'
		,	mean 					    NVARCHAR(100)	'$.mean 				'
		,	explain 				    NVARCHAR(100)	'$.explain 			'
    ) AS #TEMP
	WHERE #TEMP.edit_confirm IS NOT NULL 

	INSERT INTO #VOCABULARY
	SELECT              
       		row_id			AS row_id		
		,	Vocabulary_id	AS Vocabulary_id
		FROM OPENJSON(@P_json_detail) WITH(
    		row_id		       NVARCHAR(100)	'$.row_id		 '
		,	Vocabulary_id	    NVARCHAR(100)	'$.id'
    )

	INSERT INTO M013
	SELECT              
    	#TEMP2.tag_nm	
	,	2
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
    	tag_nm	            NVARCHAR(1000)	'$.tag_nm	     '
	,	is_new			    NVARCHAR(100)	'$.is_new'
    ) AS #TEMP2
	LEFT JOIN M013
	ON #TEMP2.tag_nm = M013.tag_nm
	AND M013.tag_div = 2
	WHERE #TEMP2.is_new = 1
	AND M013.tag_id IS NULL

	INSERT INTO #TAG
	SELECT              
    	M013.tag_id
	FROM OPENJSON(@P_post_tag) WITH(
    	tag_nm	            NVARCHAR(1000)	'$.tag_nm	     '
    ,	tag_id	            NVARCHAR(1000)	'$.tag_id	     '
    ) AS #TEMP3
	INNER JOIN M013
	ON #TEMP3.tag_nm = M013.tag_nm 
	OR #TEMP3.tag_id = M013.tag_id

	IF @P_post_id = ''
	BEGIN
		IF EXISTS (SELECT 1 FROM #VOCABULARY) OR EXISTS (SELECT 1 FROM #TAG)
		BEGIN
			SELECT @w_briged_id= ISNULL(MAX(F009.briged_id),0)+1 FROM F009
		END

		INSERT INTO M007 (
			 catalogue_div     
		,	 catalogue_id
		,	 group_id
		,	 post_div
		,	 record_div
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
		     4     
		,	 NULL
		,	 NULL
		,	 2
		,	 2
		,	 @w_briged_id 
		,	 @P_post_title 
		,	 @P_post_content 
		,	 NULL
		,	 NULL
		,	 NULL 
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

	IF EXISTS (SELECT 1 FROM #VOCABULARY)
	BEGIN
		INSERT INTO F009
		SELECT 
			@w_briged_id
		,	#VOCABULARY.Vocabulary_code
		,	1
		,	 @w_inserted_key
		,	 0
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
		,	 @w_inserted_key
		,	 0
		,	 @P_user_id
		,	 @w_program_id
		,	 @P_ip
		,	 @w_time			
		FROM #TAG
	END

	INSERT INTO F003
	SELECT
		@P_user_id
	,	@w_inserted_key
	,	NULL
	,	4
	,	4
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
		
	END
	ELSE
	BEGIN
		SET @w_mode='update'
		SET @w_inserted_key = @P_post_id
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
		SET @w_briged_id = (SELECT TOP 1 M007.briged_id FROM M007 WHERE M007.post_id = @P_post_id)
		IF @w_briged_id IS NULL AND (EXISTS (SELECT 1 FROM #VOCABULARY) OR EXISTS (SELECT 1 FROM #TAG))
		BEGIN
			SELECT @w_briged_id= ISNULL(MAX(F009.briged_id),0)+1 FROM F009
		END
		DELETE FROM F009 WHERE F009.briged_id = @w_briged_id AND F009.briged_div = 1 AND F009.briged_own_id = @P_post_id
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

		DELETE FROM F009 WHERE F009.briged_id = @w_briged_id AND F009.briged_div = 2 AND F009.briged_own_id = @P_post_id
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
			 catalogue_div    =	4   
		,	 briged_id 		  =	@w_briged_id 
		,	 post_title 	  =	@P_post_title 
		,	 post_content 	  =	@P_post_content 
		,	 upd_user		  = @P_user_id
		,	 upd_prg		  = @w_program_id
		,	 upd_ip			  = @P_ip
		,	 upd_date		  = @w_time
		WHERE M007.post_id	  = @P_post_id
		AND M007.del_flg	  = 0
		AND M007.post_div     = 2

		SET @w_inserted_key = @P_post_id
		DELETE M004
		OUTPUT DELETED.question_id INTO #TABLE_QUESTION(question_id)
		WHERE M004.post_id = @w_inserted_key

		DELETE M005 WHERE M005.question_id IN (SELECT #TABLE_QUESTION.question_id FROM #TABLE_QUESTION)

		DELETE #TABLE_QUESTION

		MERGE INTO M004 _m004 USING #TABLE_DETAIL2 _tbl_detail2 ON 1 = 0
		WHEN NOT MATCHED AND _tbl_detail2.verify IS NULL THEN
			INSERT (
				question_content
			,	question_div
			,	post_id
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
			VALUES (
				_tbl_detail2.content
			,	_tbl_detail2.question_div
			,	@w_inserted_key
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
			)
			OUTPUT _tbl_detail2.row_id,INSERTED.question_id
			INTO #TABLE_QUESTION;

			INSERT INTO M005
			SELECT
				#TABLE_QUESTION.question_id
			,	#TABLE_DETAIL2.content
			,	#TABLE_DETAIL2.verify
			,	NULL
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
			FROM #TABLE_DETAIL2
			JOIN #TABLE_QUESTION
			ON #TABLE_DETAIL2.row_id = #TABLE_QUESTION.row_id
			WHERE #TABLE_DETAIL2.verify IS NOT NULL
	END

	IF @P_row_id = 0
	BEGIN
		SELECT
			@P_row_id = COUNT(M007.post_id)
		FROM M007
		WHERE
			M007.catalogue_div = 4
	END
	INSERT INTO #WRITING
	SELECT 
		@P_row_id
	,	M007.post_id
	,	M007.briged_id
	,	M007.post_title
	,	M007.post_content
	,	1
	,	M007.cre_date
	FROM M007
	WHERE M007.post_id = @w_inserted_key
	


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
	SELECT * FROM #WRITING

	SELECT
		#WRITING.row_id
	,	#WRITING.post_id
	,	#WRITING.my_post
	,	M006.id
	,	M006.vocabulary_nm
	,	M006.spelling
	,	M006.mean
	FROM F009
	JOIN M006
	ON F009.target_id = M006.id
	AND F009.briged_div = 1
	INNER JOIN #WRITING
	ON #WRITING.briged_id = F009.briged_id
	ORDER BY 
	#WRITING.post_id

	SELECT
		#WRITING.row_id
	,	M013.tag_id
	,	M013.tag_nm
	FROM M013
	LEFT JOIN F009
	ON F009.target_id = M013.tag_id
	AND F009.briged_div = 2
	INNER JOIN #WRITING 
	ON F009.briged_id = #WRITING.briged_id
	WHERE M013.del_flg = 0
	AND M013.tag_div = 2

	SELECT @P_row_id AS row_id
END
GO
