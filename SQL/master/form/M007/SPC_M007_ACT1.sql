IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M007_ACT1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_M007_ACT1]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_M007_ACT1]
	 @P_name_div			INT				=   0
,	 @P_type_json			NVARCHAR(MAX)	=   ''
,	 @P_user_id				VARCHAR(10)		=	''
,	 @P_ip					VARCHAR(20)		=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME			= SYSDATETIME()
	,	@w_program_id			NVARCHAR(50)		= 'M007'
	,	@w_prs_prg_nm			NVARCHAR(50)		= N'Quản lý phân loại'
	,	@w_result				NVARCHAR(10)		= 'OK'
	,	@w_mode					NVARCHAR(20)		= 'update'
	,	@w_prs_key				NVARCHAR(1000)		= ''
	,	@w_message				TINYINT				= 0
	,	@w_inserted_key			VARCHAR(15)			= ''
	--
	BEGIN TRANSACTION
	BEGIN TRY
		
		--
		DELETE FROM M999 WHERE M999.name_div = @P_name_div

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
           	@P_name_div
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
