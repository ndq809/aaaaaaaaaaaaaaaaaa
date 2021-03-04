IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_GET_MORE_COMMENT]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_GET_MORE_COMMENT]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_GET_MORE_COMMENT]

	@P_comment_id	    INT					= 0
,	@P_page		    	INT					= 0
,	@P_account_id		NVARCHAR(15)		= '' 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0
	BEGIN TRANSACTION
	BEGIN TRY

	CREATE TABLE #COMMENT_DETAIL(
		comment_id		INT
	,	reply_id		NVARCHAR(10)
	,	target_id		INT
	,	account_id		NVARCHAR(50)
	,	cre_user		NVARCHAR(50)
	,	avarta			NVARCHAR(1000)
	,	rank			NVARCHAR(50)
	,	cmt_content		NTEXT
	,	cmt_div			INT
	,	cmt_like		INT
	,	effected		INT
	,	cre_date		NVARCHAR(50)
	)
	INSERT INTO #COMMENT_DETAIL
	SELECT
		F004.comment_id		AS comment_id
	,	'' AS reply_id
	,	F004.target_id
	,	S001.account_id	
	,	S001.account_nm AS cre_user
	,	M001.avarta
	,	M999.content
	,	F004.cmt_content
	,	F004.cmt_div
	,	F004.cmt_like
	,	IIF(F008.target_id IS NULL,0,IIF(F008.remark IS NULL,1,F008.remark)) AS effected
	,	FORMAT(F004.cre_date,'dd/MM/yyyy HH:mm:ss') AS cre_date
	FROM F004
	LEFT JOIN S001
	ON F004.cre_user = S001.account_id
	LEFT JOIN M001
	ON S001.user_id = M001.user_id
	LEFT JOIN M999
	ON M999.name_div = 14
	AND S001.account_div = M999.number_id
	LEFT JOIN F008
	ON F004.comment_id = F008.target_id
	AND F008.user_id = @P_account_id
	AND F008.execute_div = 3
	AND F008.execute_target_div = 3
	WHERE F004.reply_id = @P_comment_id

	SET @totalRecord = (
		SELECT COUNT(W1.comment_id)	AS	total 
		FROM #COMMENT_DETAIL AS W1
	)

	--
	SET @pageMax = CEILING(CAST(@totalRecord AS FLOAT) / 10)

	SELECT 
		*
	,	IIF(@P_page = 1,0,@P_page - 1) AS page_prev
	,	IIF(@P_page = @pageMax,0,@P_page+1) AS page_next
	FROM #COMMENT_DETAIL
	ORDER BY
		#COMMENT_DETAIL.comment_id ASC
	OFFSET (@P_page-1) * 10 ROWS
	FETCH NEXT 10 ROWS ONLY

	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	
	-- GET TOTAL OF RECORDS
	


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
	--EXEC SPC_S999_ACT1 @P_user_id,@w_program_id,@w_prs_prg_nm,@w_time,@w_mode,@w_prs_key,@w_result,@w_message

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
	
END

