IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_V002_ACT1]') AND type IN (N'P', N'PC'))
DROP PROCEDURE [dbo].[SPC_V002_ACT1]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_V002_ACT1]
	 @P_vocabulary_id		INT					= 0
,    @P_vocabulary_dtl_id   INT					= 0
,    @P_vocabulary_nm     	NVARCHAR(200)		= ''
,    @P_spelling     		NVARCHAR(200)		= ''
,    @P_specialized     	INT					= 0
,    @P_field     			INT					= 0
,    @P_vocabulary_div     	INT					= 0
,    @P_image     			NVARCHAR(200)		= ''
,    @P_mean    			NVARCHAR(200)		= ''
,    @P_post_audio   		NVARCHAR(200)		= ''
,    @P_json_detail1   		NVARCHAR(MAX)		= ''
,    @P_json_detail2  		NVARCHAR(MAX)		= ''
,    @P_json_detail3   		NVARCHAR(MAX)		= ''
,	 @P_user_id				NVARCHAR(15)		= ''
,	 @P_ip					NVARCHAR(50)		= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'V002'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Thêm từ vựng'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'insert'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''
	,	@w_inserted_dtl_key		VARCHAR(15)			= ''
	,	@w_briged_id			INT					= NULL
	,	@w_increase_id			INT					= 0

	BEGIN TRANSACTION
	BEGIN TRY

	CREATE TABLE #WORD(
		vocabulary_src		INT
	,	relationship_div	INT
	,	vocabulary_target	INT
	,	record_div			INT
	
	)

	IF @P_vocabulary_id = 0
	BEGIN
		EXEC SPC_COM_M_NUMBER @P_user_id,'','M006','M006',1, @w_inserted_key OUTPUT
		IF(@w_inserted_key = -1) --key out of range 
		BEGIN
		 SET @w_result = 'NG'
		 SET @w_message = 5
		 INSERT INTO @ERR_TBL
		 SELECT 
		  2
		 , 5
		 , 'Error M888'
		 , ''
		END

		IF(@w_inserted_key = -2) --not not declared key at m_number 
		BEGIN
		 SET @w_result = 'NG'
		 SET @w_message = 6
		 INSERT INTO @ERR_TBL
		 SELECT 
		  2
		 , 6
		 , 'Error M888'
		 , ''
		END

		IF(@w_inserted_key = -99) --system error
		BEGIN
		 SET @w_result = 'NG'
		 SET @w_message = 7
		 INSERT INTO @ERR_TBL
		 SELECT 
		  2
		 , 34
		 , 'Error M888'
		 , ''
		END
		IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC

		SELECT @w_inserted_dtl_key= 0
		INSERT INTO M006 (
			vocabulary_id
		,	vocabulary_dtl_id
		,	vocabulary_nm
		,	specialized
		,	field
		,	vocabulary_div
		,	image
		,	audio
		,	mean
		,	spelling
		,	record_div
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
		,	@w_inserted_dtl_key
		,	@P_vocabulary_nm		
		,	@P_specialized	
		,	@P_field	
		,	@P_vocabulary_div		
		,	@P_image
		,	@P_post_audio
		,	@P_mean				
		,	@P_spelling			
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


		SET @w_increase_id = SCOPE_IDENTITY()

		INSERT INTO #WORD
		SELECT
			@w_increase_id
		,	1
		,	M006.id
		,	1
		FROM(
		SELECT              
    		word_id			AS 	word_id		
		,	word_dtl_id		AS 	word_dtl_id	
		FROM OPENJSON(@P_json_detail1) WITH(
    			word_id		     NVARCHAR(100)	'$.word_id		 '
			,	word_dtl_id	    NVARCHAR(100)	'$.word_dtl_id'
		))#TEMP
		INNER JOIN M006
		ON #TEMP.word_id = M006.vocabulary_id
		AND #TEMP.word_dtl_id = M006.vocabulary_dtl_id
		AND M006.del_flg = 0

		INSERT INTO #WORD
		SELECT
			@w_increase_id
		,	2
		,	M006.id
		,	1
		FROM(
		SELECT              
    		word_id			AS 	word_id		
		,	word_dtl_id		AS 	word_dtl_id	
		FROM OPENJSON(@P_json_detail2) WITH(
    			word_id		     NVARCHAR(100)	'$.word_id		 '
			,	word_dtl_id	    NVARCHAR(100)	'$.word_dtl_id'
		))#TEMP
		INNER JOIN M006
		ON #TEMP.word_id = M006.vocabulary_id
		AND #TEMP.word_dtl_id = M006.vocabulary_dtl_id
		AND M006.del_flg = 0

		INSERT INTO F012
		SELECT
			vocabulary_src
		,	relationship_div
		,	vocabulary_target
		,	record_div
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
		FROM #WORD

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
			,	1
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
			FROM OPENJSON(@P_json_detail3) WITH(
        		language1_content       NVARCHAR(100)	'$.language1_content '
			,	language2_content	    NVARCHAR(100)	'$.language2_content'
        )
		
	END
	ELSE
	BEGIN
		SELECT @w_inserted_key = M006.id FROM M006 WHERE M006.vocabulary_id = @P_vocabulary_id AND M006.vocabulary_dtl_id = @P_vocabulary_dtl_id

		INSERT INTO #WORD
		SELECT
			@w_inserted_key
		,	1
		,	M006.id
		,	1
		FROM(
		SELECT              
    		word_id			AS 	word_id		
		,	word_dtl_id		AS 	word_dtl_id	
		FROM OPENJSON(@P_json_detail1) WITH(
    			word_id		     NVARCHAR(100)	'$.word_id		 '
			,	word_dtl_id	    NVARCHAR(100)	'$.word_dtl_id'
		))#TEMP
		INNER JOIN M006
		ON #TEMP.word_id = M006.vocabulary_id
		AND #TEMP.word_dtl_id = M006.vocabulary_dtl_id
		AND M006.del_flg = 0

		INSERT INTO #WORD
		SELECT
			@w_inserted_key
		,	2
		,	M006.id
		,	1
		FROM(
		SELECT              
    		word_id			AS 	word_id		
		,	word_dtl_id		AS 	word_dtl_id	
		FROM OPENJSON(@P_json_detail2) WITH(
    			word_id		     NVARCHAR(100)	'$.word_id		 '
			,	word_dtl_id	    NVARCHAR(100)	'$.word_dtl_id'
		))#TEMP
		INNER JOIN M006
		ON #TEMP.word_id = M006.vocabulary_id
		AND #TEMP.word_dtl_id = M006.vocabulary_dtl_id
		AND M006.del_flg = 0

		DELETE FROM F012 WHERE F012.vocabulary_src = @w_inserted_key

		INSERT INTO F012
		SELECT
			vocabulary_src
		,	relationship_div
		,	vocabulary_target
		,	record_div
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
		FROM #WORD

		DELETE FROM M012 WHERE M012.target_id = @P_vocabulary_id
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
			,	1
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
			FROM OPENJSON(@P_json_detail3) WITH(
        		language1_content       NVARCHAR(100)	'$.language1_content '
			,	language2_content	    NVARCHAR(100)	'$.language2_content'
        )
		UPDATE M006 SET 
			 vocabulary_id		=	@P_vocabulary_id 
		,	 vocabulary_dtl_id	=	@P_vocabulary_dtl_id
		,	 vocabulary_nm		=	@P_vocabulary_nm
		,	 specialized	 	=	@P_specialized	
		,	 field	 			=	@P_field	
		,	 vocabulary_div 	=	@P_vocabulary_div
		,	 image 				=	@P_image
		,	 audio 				=	IIF(@P_post_audio='',audio,@P_post_audio)
		,	 mean				=	@P_mean			
		,	 spelling			=	@P_spelling		
		,	 upd_user			=	@P_user_id
		,	 upd_prg			=	@w_program_id
		,	 upd_ip				=	@P_ip
		,	 upd_date			=	@w_time
		WHERE M006.vocabulary_id = @P_vocabulary_id
		AND	M006.vocabulary_dtl_id = @P_vocabulary_dtl_id

		SET @w_inserted_key = @P_vocabulary_id
		SET @w_inserted_dtl_key = @P_vocabulary_dtl_id

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
		@w_inserted_key		AS vocabulary_id
	,	@w_inserted_dtl_key AS vocabulary_dtl_id
	
END
GO
