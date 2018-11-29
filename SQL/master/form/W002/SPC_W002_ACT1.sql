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
,    @P_post_tag     		XML					= ''
,    @P_post_content    	NTEXT				= ''
,    @P_post_media     		NVARCHAR(200)		= ''
,    @P_post_media_nm     	NVARCHAR(200)		= ''
,    @P_post_media_div     	TINYINT				= 0
,    @P_xml_detail   		XML					= ''
,    @P_xml_detail1   		XML					= ''
,    @P_xml_detail2   		XML					= ''
,	 @P_user_id				NVARCHAR(15)		= ''
,	 @P_ip					NVARCHAR(50)		= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'W002'
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

	INSERT INTO #TABLE_DETAIL2
	SELECT
		row_id	=	T.C.value('@row_id 		  ', 'int')
	,	content	=	T.C.value('@content 	  ', 'nvarchar(max)')
	,	verify	=	T.C.value('@verify	  ', 'tinyint')
	,	question_div	=	T.C.value('@question_div	  ', 'tinyint')
	FROM @P_xml_detail2.nodes('row') T(C)

	INSERT INTO #TABLE_DETAIL
	SELECT
		vocabulary_id		=	T.C.value('@vocabulary_id 		  ', 'int')
	,	vocabulary_dtl_id 	=	T.C.value('@vocabulary_dtl_id 	  ', 'tinyint')
	,	edit_confirm 		=	T.C.value('@edit-confirm 	  ', 'tinyint')
	,	vocabulary_div 		=	T.C.value('@vocabulary_div 	  ', 'tinyint')
	,	vocabulary_nm 		=	T.C.value('@vocabulary_nm 	  ', 'nvarchar(200)')
	,	spelling 			=	T.C.value('@spelling 	  ', 'nvarchar(200)')
	,	mean 				=	T.C.value('@mean 	  ', 'nvarchar(MAX)')
	,	explain 			=	T.C.value('@explain 	  ', 'nvarchar(MAX)')
	,	row_index 			=	row_number() over(partition by T.C.value('@vocabulary_id', 'int'),T.C.value('@vocabulary_dtl_id', 'tinyint') order by T.C.value('@vocabulary_id', 'int'),T.C.value('@vocabulary_dtl_id', 'tinyint'))
	FROM @P_xml_detail.nodes('row') T(C)
	WHERE T.C.value('@edit-confirm 	  ', 'nvarchar(15)') IS NOT NULL 

	INSERT INTO #VOCABULARY
	SELECT
		row_id						=	T.C.value('@row_id 	  ', 'nvarchar(15)')
	,	Vocabulary_id				=	T.C.value('@vocabulary_code 	  ', 'INT')
	FROM @P_xml_detail.nodes('row') T(C)
	WHERE T.C.value('@edit-confirm 	  ', 'nvarchar(15)') IS NULL

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

	INSERT INTO M006
	OUTPUT 0,INSERTED.id INTO #VOCABULARY
	SELECT
		CASE vocabulary_id
		WHEN 0 THEN (SELECT ISNULL(MAX(M006.vocabulary_id),0) + row_index FROM M006 WHERE M006.vocabulary_id = #TABLE_DETAIL.vocabulary_id)
		ELSE vocabulary_id
		END
	,	CASE vocabulary_dtl_id
		WHEN 0 THEN 1
		ELSE (SELECT ISNULL(MAX(M006.vocabulary_dtl_id),0)+ row_index FROM M006 WHERE M006.vocabulary_id = #TABLE_DETAIL.vocabulary_id)
		END
	,	vocabulary_nm		
	,	vocabulary_div		
	,	NULL
	,	NULL
	,	mean				
	,	spelling			
	,	explain			
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
	FROM #TABLE_DETAIL
	WHERE #TABLE_DETAIL.edit_confirm IS NOT NULL

	INSERT INTO M013
	SELECT
		T.C.value('@tag_nm', 'nvarchar(1000)')		
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
	FROM @P_post_tag.nodes('row') T(C)
	LEFT JOIN M013
	ON T.C.value('@tag_nm', 'nvarchar(1000)') = M013.tag_nm
	AND M013.tag_div = (SELECT M999.num_remark1 FROM M999 WHERE M999.name_div = 7 AND M999.number_id = @P_catalogue_div)
	WHERE T.C.value('@is_new', 'int') = 1
	AND M013.tag_id IS NULL

	INSERT INTO #TAG
	SELECT
		M013.tag_id
	FROM @P_post_tag.nodes('row') T(C)
	INNER JOIN M013
	ON (T.C.value('@tag_nm', 'nvarchar(1000)') = M013.tag_nm OR T.C.value('@tag_id', 'nvarchar(1000)') = M013.tag_id)

	IF @P_post_id = ''
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
		     @P_catalogue_div     
		,	 IIF(@P_catalogue_nm='',NULL,@P_catalogue_nm)
		,	 IIF(@P_group_nm='',NULL,@P_group_nm)
		,	 1
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
		,	language1_content		=	T.C.value('@language1_content 		', 'nvarchar(MAX)')
		,	language2_content		=	T.C.value('@language2_content 		', 'nvarchar(MAX)')
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
		FROM @P_xml_detail1.nodes('row') T(C)

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
		DELETE FROM M012 WHERE M012.target_id = @P_post_id
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
			@P_post_id
		,	@P_catalogue_div
		,	language1_content		=	T.C.value('@language1_content 		', 'nvarchar(MAX)')
		,	language2_content		=	T.C.value('@language2_content 		', 'nvarchar(MAX)')
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
		FROM @P_xml_detail1.nodes('row') T(C)
		UPDATE M007 SET 
			 catalogue_div    =	@P_catalogue_div   
		,	 catalogue_id	  =	IIF(@P_catalogue_nm='',NULL,@P_catalogue_nm)
		,	 group_id		  =	IIF(@P_group_nm='',NULL,@P_group_nm)
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
