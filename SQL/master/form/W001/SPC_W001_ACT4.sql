IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_W001_ACT4]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_W001_ACT4]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_W001_ACT4]
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
	,	@w_program_id			NVARCHAR(50)		= 'W001'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Danh sách bài viết'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'reset'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			BIGINT				= 0
	--
	
	BEGIN TRANSACTION
	BEGIN TRY
		CREATE TABLE #UPDATE_ROWS(
			post_id INT
		,	record_div TINYINT
		)
		--
		UPDATE M007 SET
			M007.record_div =	0
		,	M007.upd_user	=	@P_user_id
		,	M007.upd_prg	=	@w_program_id
		,	M007.upd_ip		=	@P_ip
		,	M007.upd_date	=	@w_time
		OUTPUT
			inserted.post_id
		,	inserted.record_div
		INTO #UPDATE_ROWS
		FROM M007 _M007
		INNER JOIN( 
		SELECT              
            id    AS post_id          
        FROM OPENJSON(@P_voc_id_json) WITH(
        	id	            VARCHAR(10)	'$.id'
        )) TEMP
		ON TEMP.post_id= _M007.post_id

		-- Iterate over all customers
		WHILE (1 = 1) 
		BEGIN  

		  -- Get next customerId
		  SELECT TOP 1 @w_inserted_key = #UPDATE_ROWS.post_id
		  FROM #UPDATE_ROWS
		  WHERE #UPDATE_ROWS.post_id > @w_inserted_key 
		  ORDER BY #UPDATE_ROWS.post_id
		  -- Exit loop if no more customers
		  IF @@ROWCOUNT = 0 BREAK;

		  -- call your sproc
		EXEC SPC_M016_ACT1 @w_inserted_key,0,1,N'Đã bỏ công khai',@P_user_id,@P_ip,@w_program_id,@w_time
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
