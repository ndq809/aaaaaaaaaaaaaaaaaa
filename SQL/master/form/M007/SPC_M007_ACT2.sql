IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M007_ACT2]') AND type IN (N'P', N'PC'))
DROP PROCEDURE [dbo].[SPC_M007_ACT2]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_M007_ACT2]
     @P_lib_nm	     		NVARCHAR(200)		= ''
,	 @P_type_json			NVARCHAR(MAX)		= ''
,	 @P_user_id				NVARCHAR(15)		= ''
,	 @P_ip					NVARCHAR(50)		= ''

AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'M007'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Danh sách phân loại'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'insert'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''
	,	@w_number_id			INT					= 0

	BEGIN TRANSACTION
	BEGIN TRY
	IF EXISTS(SELECT 1
			  FROM M999 
			  WHERE 
				  M999.content		=	@P_lib_nm
			  AND M999.del_flg		=	0
	)
	BEGIN
		--
		SET @w_mode    = 1
		SET @w_result  = 1
		SET @w_message = 5
	
		--
		INSERT INTO	@ERR_TBL
		SELECT	
			0
		,	6
		,	'group_nm'
		,	''
	END
	--
	IF EXISTS (SELECT 1 FROM @ERR_TBL) GOTO EXIT_SPC
	SELECT @w_number_id= MAX(M999.number_id)+1 FROM M999 WHERE M999.name_div = 999 AND M999.number_id != 999
	INSERT INTO M999(
		M999.name_div
	,	M999.number_id
	,	M999.content
	,	M999.num_remark1
	,	M999.num_remark2
	,	M999.num_remark3
	,	M999.text_remark1
	,	M999.text_remark2
	,	M999.text_remark3     	   
	,	M999.cre_user
	,	M999.cre_prg
	,	M999.cre_ip
	,	M999.cre_date
	,	M999.upd_user
	,	M999.upd_prg
	,	M999.upd_ip
	,	M999.upd_date
	,	M999.del_user
	,	M999.del_prg
	,	M999.del_ip
	,	M999.del_date
	,	M999.del_flg	
	)
	SELECT
		999	
	,	@w_number_id 	
	,	@P_lib_nm 	
	,	NULL 
	,	NULL
	,	NULL
	,	NULL
	,	NULL
	,	NULL
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
	,	 0

	DELETE FROM M999 WHERE M999.name_div = @w_number_id

	INSERT INTO M999(
		M999.name_div
	,	M999.number_id
	,	M999.content
	,	M999.num_remark1
	,	M999.num_remark2
	,	M999.num_remark3
	,	M999.text_remark1
	,	M999.text_remark2
	,	M999.text_remark3
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
	,	del_flg
	)
	SELECT              
           	@w_number_id
		,	number_id
		,	content
		,	IIF(num_remark1='',NULL,num_remark1)          
		,	IIF(num_remark2='',NULL,num_remark2)          
		,	IIF(num_remark3='',NULL,num_remark3)            
		,	text_remark1          
		,	text_remark2          
		,	text_remark3          
		,	@P_user_id        
		,	@w_program_id       
		,	@P_ip      
		,	@w_time        
		,	''        
		,	''       
		,	''      
		,	NULL        
		,	''        
		,	''       
		,	''      
		,	NULL        
		,	 0       
        FROM OPENJSON(@P_type_json) WITH(
        	number_id	    NVARCHAR(100)	'$.number_id'
        ,	content 	    NVARCHAR(100)	'$.content'
        ,	num_remark1 	NVARCHAR(100)	'$.num_remark1'
        ,	num_remark2 	NVARCHAR(100)	'$.num_remark2'
        ,	num_remark3 	NVARCHAR(100)	'$.num_remark3'
        ,	text_remark1 	NVARCHAR(100)	'$.text_remark1'
        ,	text_remark2 	NVARCHAR(100)	'$.text_remark2'
        ,	text_remark3 	NVARCHAR(100)	'$.text_remark3'
        )	
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
	EXEC SPC_M007_FND1
END
GO
