IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_DENOUNCE]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_DENOUNCE]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_DENOUNCE]
		 @P_type				NVARCHAR(15)		= ''
	,	 @P_target		 		NVARCHAR(15)		= ''
	,    @P_report_div     		TINYINT				= 0	
	,	 @P_user_id				NVARCHAR(15)		= ''
	,	 @P_ip					NVARCHAR(50)		= ''
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0
	IF NOT EXISTS(SELECT * FROM F006 WHERE F006.target_id=@P_target AND F006.execute_div=@P_report_div AND F006.user_id=@P_user_id)
	BEGIN
		SELECT 
			m999.number_id		AS	denounce_code
		,	M999.num_remark1	AS	denounce_remark
		,	M999.content		AS	denounce_name
		,	value				AS	type
		FROM M999
		CROSS APPLY STRING_SPLIT(M999.text_remark1, ',')
		WHERE 
			name_div=10
		AND number_id !=0
		AND value = @P_type
		ORDER BY value,num_remark1
	END
	ELSE
	BEGIN
		SELECT 1 AS reported
	END

	--EXEC SPC_COM_MISSION_QUESTION_LIST
END

