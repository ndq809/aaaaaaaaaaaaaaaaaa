IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_ADD_QUESTION]') AND type IN (N'P', N'PC'))
DROP PROCEDURE [dbo].[SPC_COM_ADD_QUESTION]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_ADD_QUESTION]
     @P_post_id     		NVARCHAR(200)		= ''
,    @P_post_title     		NVARCHAR(200)		= ''
,    @P_post_content    	NTEXT				= ''
,    @P_post_tag     		NVARCHAR(MAX)		= ''
,	 @P_user_id				NVARCHAR(15)		= ''
,	 @P_ip					NVARCHAR(50)		= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'COMMON'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Thêm câu hỏi'
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
    		#TEMP2.tag_nm	
		,	3	
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
		AND M013.tag_div = 3
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
				 6    
			,	 NULL
			,	 NULL
			,	 3
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
		SET @w_briged_id = (SELECT TOP 1 M007.briged_id FROM M007 WHERE M007.post_id = @P_post_id)
		IF @w_briged_id IS NULL AND (EXISTS (SELECT 1 FROM #VOCABULARY) OR EXISTS (SELECT 1 FROM #TAG))
		BEGIN
			SELECT @w_briged_id= ISNULL(MAX(F009.briged_id),0)+1 FROM F009
		END
		DELETE FROM F009 WHERE F009.briged_id = @w_briged_id AND F009.briged_div = 2 AND F009.briged_own_id = @P_post_id

			UPDATE M007 SET 
			 post_title 	  =	@P_post_title 
		,	 post_content 	  =	@P_post_content 
		,	 briged_id	 	  =	@w_briged_id
		,	 upd_user		  = @P_user_id
		,	 upd_prg		  = @w_program_id
		,	 upd_ip			  = @P_ip
		,	 upd_date		  = @w_time
		WHERE M007.post_id	  = @P_post_id
		AND M007.del_flg	  = 0
		AND M007.post_div     = 3

		SET @w_inserted_key = @P_post_id

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
	,	3 AS catalogue_div
	FROM M007
	WHERE M007.post_id = @w_inserted_key
	
END
GO
