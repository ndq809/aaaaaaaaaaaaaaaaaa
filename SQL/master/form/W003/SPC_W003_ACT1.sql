IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_W003_ACT1]') AND type IN (N'P', N'PC'))
DROP PROCEDURE [dbo].[SPC_W003_ACT1]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_W003_ACT1]

     @P_catalogue_nm  		NVARCHAR(MAX)		= ''
,    @P_group_nm   			NVARCHAR(MAX)		= ''
,    @P_json_detail   		NVARCHAR(MAX)		= ''
,	 @P_user_id				NVARCHAR(15)		= ''
,	 @P_ip					NVARCHAR(50)		= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'W003'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Import bài viết từ vựng'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'insert'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''
	,	@w_inserted_dtl_key		VARCHAR(15)			= ''
	,	@w_word_id				INT					= NULL
	,	@w_temp					NVARCHAR(MAX)		= NULL
	,	@number					INT					= 0
	,	@max					INT					= 0
	,	@w_briged_id			INT					= 0

	BEGIN TRANSACTION
	BEGIN TRY
	CREATE TABLE #DATA(
		row_id			INT
	,	id				INT
	,	word_id			INT
	,	word_dtl_id		INT
	,	word			NVARCHAR(MAX)
	,	specialized		NVARCHAR(MAX)
	,	field			NVARCHAR(MAX)
	,	word_div		NVARCHAR(MAX)
	,	spell			NVARCHAR(MAX)
	,	mean			NTEXT
	,	audio			NVARCHAR(MAX)
	,	execute_div		INT
	)

		CREATE TABLE #VOCABULARY(
			vocabulary_code INT	
		)

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
			  AND LOWER(M002.catalogue_div)	=	1
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
		     1  
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
			  AND M003.catalogue_div	=	1
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
			 1
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

	INSERT INTO #DATA
	SELECT              
       		row_id		
		,	id
		,	0
		,	0
		,	word		    
		,	specialized	    
		,	field		    
		,	word_div	    
		,	spell		    
		,	mean		    
		,	audio		    
		,	execute_div		    
		FROM OPENJSON(@P_json_detail) WITH(
    		row_id				NVARCHAR(100)	'$.row_id		 '
		,	id					NVARCHAR(100)	'$.id		'
		,	word			    NVARCHAR(MAX)	'$.word		'
		,	specialized		    NVARCHAR(100)	'$.specialized	'
		,	field			    NVARCHAR(100)	'$.field		'
		,	word_div		    NVARCHAR(100)	'$.vocabulary_div	'
		,	spell			    NVARCHAR(100)	'$.spelling		'
		,	mean			    NVARCHAR(MAX)	'$.mean		'
		,	audio			    NVARCHAR(MAX)	'$.audio		'
		,	execute_div			INT				'$.status		'
    )

	INSERT INTO #VOCABULARY
	SELECT id FROM #DATA WHERE #DATA.execute_div = 1

	SET @max = (SELECT MAX(M999.number_id) FROM M999 WHERE M999.name_div = 23)

	INSERT INTO M999
	SELECT 
		23
	,	ROW_NUMBER() OVER(ORDER BY #DATA.specialized ASC) + @max
	,	#DATA.specialized
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	0
	,	@P_user_id
	,	@w_program_id
	,	@P_ip
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL		
	FROM #DATA
	LEFT JOIN M999
	ON M999.name_div = 23
	AND LOWER(M999.content) = LOWER(#DATA.specialized)
	WHERE #DATA.specialized <> ''
	AND M999.number_id IS NULL
	GROUP BY
	#DATA.specialized 

	UPDATE #DATA_TEMP
	SET
	    #DATA_TEMP.specialized = Table_B.number_id
	FROM #DATA AS #DATA_TEMP
	INNER JOIN M999 AS Table_B
	ON Table_B.name_div = 23
	AND LOWER(Table_B.content) = LOWER(#DATA_TEMP.specialized)

	SET @max = (SELECT MAX(M999.number_id) FROM M999 WHERE M999.name_div = 24)

	INSERT INTO M999
	SELECT 
		24
	,	ROW_NUMBER() OVER(ORDER BY #DATA.field ASC) + @max
	,	#DATA.field
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	0
	,	@P_user_id
	,	@w_program_id
	,	@P_ip
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL		
	FROM #DATA
	LEFT JOIN M999
	ON M999.name_div = 24
	AND LOWER(M999.content) = LOWER(#DATA.field)
	WHERE #DATA.field <> ''
	AND M999.number_id IS NULL
	GROUP BY #DATA.field

	UPDATE #DATA_TEMP
	SET
	    #DATA_TEMP.field = Table_B.number_id
	FROM #DATA AS #DATA_TEMP
	INNER JOIN M999 AS Table_B
	ON Table_B.name_div = 24
	AND LOWER(Table_B.content) = LOWER(#DATA_TEMP.field)

	SET @max = (SELECT MAX(M999.number_id) FROM M999 WHERE M999.name_div = 8)

	INSERT INTO M999
	SELECT 
		8
	,	ROW_NUMBER() OVER(ORDER BY #DATA.word_div ASC) + @max
	,	#DATA.word_div
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	0
	,	@P_user_id
	,	@w_program_id
	,	@P_ip
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL		
	FROM #DATA
	LEFT JOIN M999
	ON M999.name_div = 8
	AND LOWER(M999.content) = LOWER(#DATA.word_div)
	WHERE #DATA.word_div <> ''
	AND M999.number_id IS NULL
	GROUP BY #DATA.word_div

	UPDATE #DATA_TEMP
	SET
	    #DATA_TEMP.word_div = Table_B.number_id
	FROM #DATA AS #DATA_TEMP
	INNER JOIN M999 AS Table_B
	ON Table_B.name_div = 8
	AND LOWER(Table_B.content) = LOWER(#DATA_TEMP.word_div)

	DECLARE	cursorElement CURSOR LOCAL FOR
    SELECT  
		#DATA.row_id AS row_id
    FROM #DATA
	WHERE #DATA.execute_div = 0

	OPEN cursorElement
	FETCH NEXT FROM cursorElement INTO @w_word_id

	WHILE ( @@FETCH_STATUS = 0 )
	BEGIN
		EXEC SPC_COM_M_NUMBER @P_user_id,'','M006','M006',1, @number OUTPUT
		IF(@number = -1) --key out of range 
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

		IF(@number = -2) --not not declared key at m_number 
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

		IF(@number = -99) --system error
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

		UPDATE #DATA SET
			#DATA.word_id = @number
		WHERE #DATA.row_id = @w_word_id

		FETCH NEXT FROM cursorElement INTO @w_word_id
	END         
	CLOSE cursorElement
	DEALLOCATE cursorElement

	DECLARE	cursorElement CURSOR LOCAL FOR
    SELECT  
		#DATA.id AS word_id
    FROM #DATA
	WHERE #DATA.execute_div = 2

	OPEN cursorElement
	FETCH NEXT FROM cursorElement INTO @w_word_id

	WHILE ( @@FETCH_STATUS = 0 )
	BEGIN
		SET @w_temp = (SELECT M006.vocabulary_id FROM M006 WHERE M006.id = @w_word_id)
		SET @number = (SELECT MAX(M006.vocabulary_dtl_id) FROM M006 WHERE M006.vocabulary_id = @w_temp)
		UPDATE #DATA SET
			#DATA.word_id = @w_temp
		,	#DATA.word_dtl_id = @number + 1
		WHERE #DATA.id = @w_word_id

		FETCH NEXT FROM cursorElement INTO @w_word_id
	END         
	CLOSE cursorElement
	DEALLOCATE cursorElement



	INSERT INTO M006
	OUTPUT INSERTED.id INTO #VOCABULARY
	SELECT
		#DATA.word_id		
	,	#DATA.word_dtl_id
	,	#DATA.word		
	,	#DATA.specialized	
	,	#DATA.field		
	,	#DATA.word_div	
	,	NULL	
	,	#DATA.audio
	,	#DATA.mean		
	,	#DATA.spell
	,	0
	,	2
	,	0
	,	@P_user_id
	,	@w_program_id
	,	@P_ip
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL		
	FROM #DATA
	WHERE #DATA.execute_div <> 1

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

		INSERT INTO M007 (
			 record_div     
		,	 catalogue_div     
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
			 0	
		,    1     
		,	 IIF(@P_catalogue_nm='',NULL,@P_catalogue_nm)
		,	 IIF(@P_group_nm='',NULL,@P_group_nm)
		,	 1
		,	 @w_briged_id 
		,	 NULL 
		,	 NULL
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
