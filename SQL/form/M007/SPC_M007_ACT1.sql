﻿IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M007_ACT1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
DROP PROCEDURE [dbo].[SPC_M007_ACT1]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M001_ACT2]    Script Date: 2017/11/23 15:16:49 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_M007_ACT1]
	 @P_name_div			TINYINT			=   0
,	 @P_type_xml				XML			=   ''
,	 @P_user_id				VARCHAR(10)		=	''
,	 @P_ip					VARCHAR(20)		=	''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL				ERRTABLE
	,	@w_time					DATETIME		=  SYSDATETIME()
	,   @w_prs_user_id			VARCHAR(6)		= @P_user_id
	,   @w_prs_prg				VARCHAR(10)		= 'M007'
	,   @w_prs_prg_nm			VARCHAR(50)		= 'Danh sách phân loại'
	,   @w_prs_mode				VARCHAR(10)		= 'update'
	,   @w_prs_key				VARCHAR(1000)	= ''
	,	@w_prs_result			VARCHAR(20)		= ''
	,	@w_remarks				VARCHAR(200)	= ''
	--
	BEGIN TRANSACTION
	BEGIN TRY
		
		SET @w_prs_result = 'OK'
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
			name_div			=	@P_name_div
		,	number_id 			=	T.C.value('@number_id 	  ', 'tinyint')
		,	content 			=	T.C.value('@content 	  ', 'nvarchar(MAX)')
		,	num_remark1 		=	IIF(T.C.value('@num_remark1	  ', 'nvarchar(10)')='',NULL,T.C.value('@num_remark1	  ', 'nvarchar(10)'))
		,	num_remark2 		=	IIF(T.C.value('@num_remark2	  ', 'nvarchar(10)')='',NULL,T.C.value('@num_remark2	  ', 'nvarchar(10)'))
		,	num_remark3 		=	IIF(T.C.value('@num_remark3	  ', 'nvarchar(10)')='',NULL,T.C.value('@num_remark3	  ', 'nvarchar(10)'))
		,	text_remark1		=	T.C.value('@text_remark1  ', 'nvarchar(MAX)')
		,	text_remark2		=	T.C.value('@text_remark2  ', 'nvarchar(MAX)')
		,	text_remark3		=	T.C.value('@text_remark3  ', 'nvarchar(MAX)')
		,	@P_user_id
		,	@w_prs_prg
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
		FROM @P_type_xml.nodes('row') T(C)
		
	--EXEC SPC_S999_ACT1 @P_company_cd_u,@w_prs_user_id,@w_prs_prg,@w_prs_prg_nm,@w_prs_mode,@w_prs_key,@w_prs_result,@w_remarks

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
