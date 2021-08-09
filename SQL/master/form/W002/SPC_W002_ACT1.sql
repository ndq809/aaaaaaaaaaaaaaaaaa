IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_W002_ACT1]') AND type IN (N'P', N'PC'))
DROP PROCEDURE [dbo].[SPC_W002_ACT1]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_W002_ACT1]
	 @P_post_id		        NVARCHAR(15)		= ''
,    @P_catalogue_div       TINYINT				= 0
,    @P_catalogue_nm     	NVARCHAR(200)		= ''
,    @P_group_nm     		NVARCHAR(200)		= ''
,    @P_post_title     		NVARCHAR(200)		= ''
,    @P_post_title_tran    	NVARCHAR(200)		= ''
,    @P_post_tag     		NVARCHAR(MAX)		= ''
,    @P_post_content    	NTEXT				= ''
,    @P_post_content_tran   NTEXT				= ''
,    @P_notes		   		NVARCHAR(MAX)		= ''
,    @P_post_media     		NVARCHAR(200)		= ''
,    @P_post_media_nm     	NVARCHAR(200)		= ''
,    @P_post_media_div     	TINYINT				= 0
,    @P_json_detail   		NVARCHAR(MAX)		= ''
,    @P_json_detail1   		NVARCHAR(MAX)		= ''
,    @P_json_detail2   		NVARCHAR(MAX)		= ''
,    @P_json_detail3   		NVARCHAR(MAX)		= ''
,	 @P_user_id				NVARCHAR(15)		= ''
,	 @P_ip					NVARCHAR(50)		= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL					ERRTABLE
	,	@w_time						DATETIME			= SYSDATETIME()
	,	@w_program_id				NVARCHAR(50)		= 'W002'
	,	@w_prs_prg_nm				NVARCHAR(50)		= N'Thêm bài viết'
	,	@w_result					NVARCHAR(10)		= 'OK'
	,	@w_mode						NVARCHAR(20)		= 'insert'
	,	@w_prs_key					NVARCHAR(1000)		= ''
	,	@w_message					TINYINT				= 0
	,	@w_inserted_key				VARCHAR(15)			= ''
	,	@w_briged_id				INT					= NULL
	,	@w_increase_id				INT					= 0
	,	@w_old_media				NVARCHAR(1000)		= ''

	BEGIN TRANSACTION
	BEGIN TRY

	IF EXISTS (SELECT 1 FROM M999 WHERE M999.name_div = 7 AND M999.number_id = @P_catalogue_div AND M999.del_flg = 1) --code not exits 
	BEGIN
	 SET @w_result = 'NG'
	 SET @w_message = 5
	 INSERT INTO @ERR_TBL
	 SELECT 
	  0
	 , @w_message
	 , 'catalogue_div'
	 , ''
	END

	IF EXISTS (SELECT 1 FROM M002 WHERE M002.catalogue_id = @P_catalogue_nm AND M002.del_flg = 1) --code not exits 
	BEGIN
	 SET @w_result = 'NG'
	 SET @w_message = 5
	 INSERT INTO @ERR_TBL
	 SELECT 
	  0
	 , @w_message
	 , 'catalogue_nm'
	 , ''
	END

	IF EXISTS (SELECT 1 FROM M003 WHERE M003.group_id = @P_group_nm AND M003.del_flg = 1) --code not exits 
	BEGIN
	 SET @w_result = 'NG'
	 SET @w_message = 5
	 INSERT INTO @ERR_TBL
	 SELECT 
	  0
	 , @w_message
	 , 'group_nm'
	 , ''
	END

	IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC

	IF NOT EXISTS(SELECT 1
			  FROM M002 
			  WHERE 
				  CONVERT(NVARCHAR(15),M002.catalogue_id)		=	@P_catalogue_nm
			  AND LOWER(M002.catalogue_div)	=	LOWER(@P_catalogue_div) 
			  AND M002.del_flg			=	0
	)
	BEGIN
		--
		INSERT INTO M002(
			 catalogue_div     
		,	 catalogue_nm     	   
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
		     @P_catalogue_div  
		,	 @P_catalogue_nm   		
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

		SET @P_catalogue_nm = SCOPE_IDENTITY()
		
	END

	IF NOT EXISTS(SELECT 1
			  FROM M003 
			  WHERE 
				  CONVERT(NVARCHAR(15),M003.group_id)		=	@P_group_nm
			  AND M003.catalogue_div	=	@P_catalogue_div
			  AND LOWER(M003.catalogue_id)	=	LOWER(@P_catalogue_nm) 
			  AND M003.del_flg			=	0
	)
	BEGIN
		--
		INSERT INTO M003 (
			 catalogue_div
		,	 catalogue_id     
		,	 group_nm     	   
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
			 @P_catalogue_div
		,    @P_catalogue_nm  
		,	 @P_group_nm   		
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

		SET @P_group_nm = SCOPE_IDENTITY()

	END

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
	,	explan NVARCHAR(MAX)
	)

	CREATE TABLE #TABLE_DETAIL3(
		row_id INT
	,	content NVARCHAR(MAX)
	,	start_time MONEY	
	,	end_time MONEY
	)

	CREATE TABLE #TABLE_QUESTION(
		row_id INT
	,	question_id INT
	)

	INSERT INTO #TABLE_DETAIL3
	SELECT              
			row_id			AS row_id		
		,	content			AS listen_cut_content		
		,	start_time		AS start_time		
		,	end_time		AS end_time          
		FROM OPENJSON(@P_json_detail3) WITH(
     		row_id				NVARCHAR(100)	'$.row_id		 '
		,	content			    NVARCHAR(MAX)	'$.listen_cut_content		'
		,	start_time			NVARCHAR(100)	'$.start_time		'
		,	end_time			NVARCHAR(100)	'$.end_time'
    )

	INSERT INTO #TABLE_DETAIL2
	SELECT              
			row_id			AS row_id		
		,	content			AS content		
		,	verify			AS verify		
		,	question_div	AS question_div          
		,	explan			AS explan          
		FROM OPENJSON(@P_json_detail2) WITH(
     		row_id				NVARCHAR(100)	'$.row_id		 '
		,	content			    NVARCHAR(MAX)	'$.content		'
		,	verify			    NVARCHAR(100)	'$.verify		'
		,	question_div	    NVARCHAR(100)	'$.question_div'
		,	explan				NVARCHAR(MAX)	'$.explan'
    )

	INSERT INTO #TABLE_DETAIL
	SELECT              
			vocabulary_id			AS vocabulary_id		
		,	vocabulary_dtl_id 		AS vocabulary_dtl_id 	
		,	edit_confirm 			AS edit_confirm 		
		,	vocabulary_div 			AS vocabulary_div 		         
		,	vocabulary_nm 			AS vocabulary_nm 		         
		,	spelling 				AS spelling 			         
		,	mean 					AS mean 				         
		,	explain 				AS explain 			         
		,	row_number() over(partition by vocabulary_id,vocabulary_dtl_id order by vocabulary_id,vocabulary_dtl_id)	AS row_index 			         
		FROM OPENJSON(@P_json_detail) WITH(
     		vocabulary_id				NVARCHAR(100)	'$.vocabulary_id		 '
		,	vocabulary_dtl_id 		    NVARCHAR(100)	'$.vocabulary_dtl_id 	'
		,	edit_confirm 			    NVARCHAR(100)	'$.edit_confirm 		'
		,	vocabulary_div 			    NVARCHAR(100)	'$.vocabulary_div 		'
		,	vocabulary_nm 			    NVARCHAR(100)	'$.vocabulary_nm 		'
		,	spelling 				    NVARCHAR(100)	'$.spelling 			'
		,	mean 					    NVARCHAR(100)	'$.mean 				'
		,	explain 				    NVARCHAR(100)	'$.explain 			'
    ) AS #TEMP
	WHERE 
		#TEMP.edit_confirm IS NOT NULL

	INSERT INTO #VOCABULARY
	SELECT              
			row_id			AS row_id		
		,	Vocabulary_id		AS Vocabulary_id
		FROM OPENJSON(@P_json_detail) WITH(
			row_id						NVARCHAR(100)	'$.vocabulary_id		'
		,	vocabulary_id				NVARCHAR(100)	'$.vocabulary_code		'
		,	edit_confirm 				NVARCHAR(100)	'$.edit_confirm 		'
    ) AS #TEMP1
	WHERE 
		#TEMP1.edit_confirm IS NULL

	IF EXISTS(
	SELECT *
	FROM #VOCABULARY a
	JOIN (	SELECT Vocabulary_code 
			FROM #VOCABULARY 
			GROUP BY Vocabulary_code 
			HAVING COUNT(*) > 1 ) b
	ON a.Vocabulary_code = b.Vocabulary_code
	)
	BEGIN
	 SET @w_result = 'NG'
	 SET @w_message = 6
	 INSERT INTO @ERR_TBL
	 SELECT 
	  1
	 , @w_message
	 , 'submit-table'
	 , row_id
	 FROM #VOCABULARY a
	JOIN (	SELECT Vocabulary_code 
			FROM #VOCABULARY 
			GROUP BY Vocabulary_code 
			HAVING COUNT(*) > 1 ) b
	ON a.Vocabulary_code = b.Vocabulary_code
	END  
	IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC

	INSERT INTO M013
	SELECT              
    	#TEMP2.tag_nm	
	,	(SELECT M999.num_remark1 FROM M999 WHERE M999.name_div = 7 AND M999.number_id = @P_catalogue_div)	
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
	AND M013.tag_div = (SELECT M999.num_remark1 FROM M999 WHERE M999.name_div = 7 AND M999.number_id = @P_catalogue_div)
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
			 record_div     
		,	 catalogue_div     
		,	 catalogue_id
		,	 group_id
		,	 post_div
		,	 briged_id 
		,	 post_title 
		,	 post_title_tran 
		,	 post_content 
		,	 post_content_tran 
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
			 0	
		,    @P_catalogue_div     
		,	 IIF(@P_catalogue_nm='',NULL,@P_catalogue_nm)
		,	 IIF(@P_group_nm='',NULL,@P_group_nm)
		,	 1
		,	 @w_briged_id 
		,	 @P_post_title 
		,	 @P_post_title_tran
		,	 @P_post_content 
		,	 @P_post_content_tran
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

	IF EXISTS (SELECT 1 FROM #VOCABULARY)
		BEGIN
			INSERT INTO F009
			SELECT 
				@w_briged_id
			,	#VOCABULARY.Vocabulary_code
			,	1
			,	@w_inserted_key
			,	0
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
			,	@w_inserted_key
			,	0
			,	 @P_user_id
			,	 @w_program_id
			,	 @P_ip
			,	 @w_time
			FROM #TAG
		END

		INSERT INTO M012(
			target_id
		,	target_div
		,	language1_content
		,	language2_content
		,	clap
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
		,	@P_catalogue_div
		,	language1_content
		,	language2_content
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
		FROM OPENJSON(@P_json_detail1) WITH(
        	language1_content       NVARCHAR(100)	'$.language1_content '
		,	language2_content	    NVARCHAR(100)	'$.language2_content'
        )

		IF @P_catalogue_div IN(3)
		BEGIN
			INSERT INTO M015(
				post_id
			,	listen_cut_content
			,	listen_cut_start
			,	listen_cut_end
			,	cre_user
			,	cre_prg
			,	cre_ip
			,	cre_date
				)
			SELECT
				@w_inserted_key
			,	content
			,	start_time
			,	end_time
			,	@P_user_id
			,	@w_program_id
			,	@P_ip
			,	SYSDATETIME()
			FROM #TABLE_DETAIL3
		END

		IF @P_catalogue_div IN(7,8,9)
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

		MERGE INTO M004 _m004 USING #TABLE_DETAIL2 _tbl_detail2 ON 1 = 0
		WHEN NOT MATCHED AND _tbl_detail2.verify IS NULL THEN
			INSERT (
				question_content
			,	question_div
			,	post_id
			,	explan
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
			,	_tbl_detail2.explan
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

		EXEC SPC_M016_ACT1 @w_inserted_key,0,0,@P_notes,@P_user_id,@P_ip,@w_program_id,@w_time

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
			,	@P_post_id
			,	0
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
			,	@P_post_id
			,	0
			,	 @P_user_id
			,	 @w_program_id
			,	 @P_ip
			,	 @w_time
			FROM #TAG
		END

		IF @P_catalogue_div IN(3)
		BEGIN
			DELETE FROM M015 WHERE M015.post_id = @P_post_id

			INSERT INTO M015(
				post_id
			,	listen_cut_content
			,	listen_cut_start
			,	listen_cut_end
			,	cre_user
			,	cre_prg
			,	cre_ip
			,	cre_date
				)
			SELECT
				@P_post_id
			,	content
			,	start_time
			,	end_time
			,	@P_user_id
			,	@w_program_id
			,	@P_ip
			,	SYSDATETIME()
			FROM #TABLE_DETAIL3
		END
		
		
		DELETE FROM M012 WHERE M012.target_id = @P_post_id AND M012.target_div = @P_catalogue_div AND @P_catalogue_div <> 1
		INSERT INTO M012(
			target_id
		,	target_div
		,	language1_content
		,	language2_content
		,	clap
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
		,	@P_catalogue_div
		,	language1_content
		,	language2_content
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
		FROM OPENJSON(@P_json_detail1) WITH(
        	language1_content       NVARCHAR(100)	'$.language1_content '
		,	language2_content	    NVARCHAR(100)	'$.language2_content'
        )

		UPDATE M007 SET 
			 catalogue_div    =	@P_catalogue_div   
		,	 catalogue_id	  =	IIF(@P_catalogue_nm='',NULL,@P_catalogue_nm)
		,	 group_id		  =	IIF(@P_group_nm='',NULL,@P_group_nm)
		,	 briged_id 		  =	@w_briged_id 
		,	 post_title 	  =	@P_post_title 
		,	 post_title_tran  =	@P_post_title_tran 
		,	 post_content 	  =	@P_post_content 
		,	 post_content_tran 	  =	@P_post_content_tran 
		,	 post_media		  =	IIF(@P_post_media='',post_media,@P_post_media)
		,	 post_media_nm	  =	IIF(@P_post_media_nm='', post_media_nm,@P_post_media_nm)
		,	 media_div 		  =	IIF(@P_post_media_div =0,media_div,@P_post_media_div)
		,	 upd_user		  = @P_user_id
		,	 upd_prg		  = @w_program_id
		,	 upd_ip			  = @P_ip
		,	 upd_date		  = @w_time
		WHERE M007.post_id = @P_post_id

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
			,	explan
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
			,	_tbl_detail2.explan
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

		EXEC SPC_M016_ACT1 @w_inserted_key,0,0,@P_notes,@P_user_id,@P_ip,@w_program_id,@w_time
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
	SELECT @w_inserted_key AS post_id
	
END
GO
