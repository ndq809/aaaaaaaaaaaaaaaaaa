﻿IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_DATA]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_DATA]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_DATA]
		@P_account_id			NVARCHAR(15)	=	''
,		@P_account_div			INT				=	0
,		@P_system_div			INT				=	0
,		@P_screen_div			INT				=	'' 
 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	EXEC SPC_COM_PERMISSION @P_account_div,@P_system_div,'';

	SELECT
		M013.tag_id
	,	M013.tag_nm
	FROM M013
	WHERE M013.tag_div = 3
	AND M013.del_flg = 0

	SELECT
		F002.notify_id 
	,	F002.get_user_id
	,	F002.notify_condition
	,	M999.text_remark1 AS notify_content
	,	M999.text_remark2 AS notify_url
	,	S001.account_nm
	,	F002.cre_date
	,	F002.notify_count
	FROM F002
	LEFT JOIN M999
	ON M999.name_div = 21
	AND M999.number_id = F002.notify_div
	LEFT JOIN S001 
	ON S001.account_id = F002.cre_user
	WHERE F002.get_user_id = @P_account_id
	ORDER BY 
	CASE
	WHEN F002.notify_condition = 1 THEN 1
	END,F002.cre_date DESC

	SELECT TOP 10
		S001.account_id
	,	S001.account_nm
	,	(S001.exp + S001.ctp) AS ep
	FROM S001
	WHERE
		S001.system_div = 1
	AND S001.del_flg = 0
	ORDER BY
		S001.account_div DESC
	,	(S001.exp + S001.ctp) DESC

	SELECT TOP 20
		F002.notify_id 
	,	F002.get_user_id AS get_user_code
	,	F002.notify_condition
	,	M999.text_remark1 AS notify_content
	,	M999.text_remark2 AS notify_url
	,	S001.account_nm
	,	F002.cre_date
	,	F002.notify_count
	,	F002.target_id
	FROM F002
	LEFT JOIN M999
	ON M999.name_div = 21
	AND M999.number_id = F002.notify_div
	LEFT JOIN S001 
	ON S001.account_id = F002.cre_user
	WHERE F002.get_user_id IS NULL
	AND F002.notify_condition = 0
	ORDER BY 
	CASE
	WHEN F002.notify_condition = 1 THEN 1
	END,F002.cre_date DESC
END

