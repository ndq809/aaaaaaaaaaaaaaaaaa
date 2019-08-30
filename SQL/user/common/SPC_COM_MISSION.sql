IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_MISSION]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_COM_MISSION]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_COM_MISSION]
		@P_mission_id			INT		=	0
,		@P_user_id				INT		=	0
 
AS
BEGIN
	SET NOCOUNT ON;
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@pageMax			INT					=	0

	SELECT
		F013.mission_id
	,	F013.account_id
	,	F001.title
	,	F001.content
	,	F001.exp
	,	F001.failed_exp
	,	F001.ctp
	,	F001.failed_ctp
	,	F001.unit_per_times
	,	ISNULL(F001.try_times,0) AS try_times
	,	F013.unit_this_times
	,	F013.try_times_count
	,	F013.condition
	,	F001.mission_div
	FROM F001
	INNER JOIN F013
	ON F013.mission_id = F001.mission_id
	WHERE F013.mission_id = @P_mission_id
	AND F013.account_id = @P_user_id
END

