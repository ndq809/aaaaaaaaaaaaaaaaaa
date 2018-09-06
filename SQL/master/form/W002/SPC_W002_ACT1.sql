﻿IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_W002_ACT1]') AND type IN (N'P', N'PC'))
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
,    @P_post_content    	NTEXT				= ''
,    @P_post_media     		NVARCHAR(200)		= ''
,    @P_post_media_nm     	NVARCHAR(200)		= ''
,    @P_post_media_div     	TINYINT				= 0
,    @P_xml_detail   		XML					= ''
,    @P_xml_detail1   		XML					= ''
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
	OUTPUT 0,scope_identity() INTO #VOCABULARY
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
	IF @P_post_id = ''
	BEGIN
		IF EXISTS (SELECT 1 FROM #VOCABULARY)
		BEGIN
			SELECT @w_briged_id= ISNULL(MAX(F009.briged_id),0)+1 FROM F009
			INSERT INTO F009
			SELECT 
				@w_briged_id
			,	#VOCABULARY.Vocabulary_code
			FROM #VOCABULARY
		END
		INSERT INTO M012(
			target_id
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
 
		INSERT INTO M007 (
			 catalogue_div     
		,	 catalogue_id
		,	 group_id
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
		,	 @P_catalogue_nm
		,	 @P_group_nm
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
		IF EXISTS (SELECT 1 FROM #VOCABULARY)
		BEGIN
			SELECT @w_briged_id = M007.briged_id FROM M007 WHERE M007.post_id = @P_post_id
			IF @w_briged_id IS NULL
			BEGIN
				SELECT @w_briged_id= ISNULL(MAX(F009.briged_id),0)+1 FROM F009
			END
			DELETE FROM F009 WHERE F009.briged_id = @w_briged_id
			INSERT INTO F009
			SELECT 
				@w_briged_id
			,	#VOCABULARY.Vocabulary_code
			FROM #VOCABULARY
		END
		DELETE FROM M012 WHERE M012.target_id = @P_post_id
		INSERT INTO M012(
			target_id
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
		,	 catalogue_id	  =	@P_catalogue_nm
		,	 group_id		  =	@P_group_nm
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
