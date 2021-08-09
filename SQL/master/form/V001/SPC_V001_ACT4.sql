IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_V001_ACT4]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_V001_ACT4]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_V001_ACT4]
	 @P_voc_id_json			NVARCHAR(MAX)	=   ''
,	 @P_user_id				VARCHAR(10)		=	''
,	 @P_ip					VARCHAR(20)		=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'V001'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Danh sách từ vựng'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'reset'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	--
	
	BEGIN TRANSACTION
	BEGIN TRY

		CREATE TABLE #VOCABULARY(
			row_id				INT
		,	Vocabulary_id		INT
		,	Vocabulary_dtl_id	INT	
		)

		INSERT INTO #VOCABULARY
		SELECT              
           		row_id				AS	row_id	
           	,	vocabulary_id		AS	vocabulary_id	
			,	vocabulary_dtl_id	AS	vocabulary_dtl_id
			FROM OPENJSON(@P_voc_id_json) WITH(
        		row_id					NVARCHAR(100)	'$.row_id	  '
        	,	vocabulary_id			NVARCHAR(100)	'$.id	  '
			,	vocabulary_dtl_id	    NVARCHAR(100)	'$.dtl_id'
        )

		INSERT INTO @ERR_TBL
		 SELECT 
		  1
		 , 27
		 , 'table-preview'
		 , #VOCABULARY.row_id
		 FROM #VOCABULARY
		 INNER JOIN M006 ON
			 M006.vocabulary_id = #VOCABULARY.Vocabulary_id
		 AND M006.vocabulary_dtl_id = #VOCABULARY.Vocabulary_dtl_id
		 AND M006.record_div = 2
		 AND M006.del_flg = 0
		 LEFT JOIN F009 ON
			F009.briged_div = 1
		AND F009.target_id = M006.id
		LEFT JOIN M007 ON
		M007.briged_id = F009.briged_id
		AND M007.record_div = 2
		WHERE F009.target_id IS NOT NULL
		AND	M007.post_id IS NOT NULL

		IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO COMPLETE_QUERY
		--
		UPDATE M006 SET
			M006.record_div =	0
		,	M006.upd_user	=	@P_user_id
		,	M006.upd_prg	=	@w_program_id
		,	M006.upd_ip		=	@P_ip
		,	M006.upd_date	=	@w_time
		FROM M006 _M006
		INNER JOIN( 
		SELECT              
           		vocabulary_id		AS	vocabulary_id	
			,	vocabulary_dtl_id	AS	vocabulary_dtl_id
			FROM OPENJSON(@P_voc_id_json) WITH(
        		vocabulary_id	       NVARCHAR(100)	'$.id	  '
			,	vocabulary_dtl_id	    NVARCHAR(100)	'$.dtl_id'
        )) TEMP
		ON TEMP.vocabulary_id= _M006.vocabulary_id
		AND TEMP.vocabulary_dtl_id = _M006.vocabulary_dtl_id

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
COMPLETE_QUERY:
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
