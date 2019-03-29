IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_G001_LST1]') AND type IN (N'P', N'PC'))
/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
DROP PROCEDURE [dbo].[SPC_G001_LST1]
GO

/****** Object:  StoredProcedure [dbo].[SPC_M001L_FND1]    Script Date: 2017/11/23 16:46:46 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[SPC_G001_LST1]
	@P_user_id		NVARCHAR(50)				=	0 
AS
BEGIN
	SET NOCOUNT ON;
	
	--
	DECLARE 
		@ERR_TBL			ERRTABLE
	,	@totalRecord		DECIMAL(18,0)		=	0
	,	@month				NVARCHAR(10)		=	(SELECT CONCAT('10/',FORMAT(GETDATE(),'MM/yyyy')))
	,	@prevmonth			NVARCHAR(10)		=	(SELECT CONCAT('11/',FORMAT(dateadd(month,-1,GETDATE()),'MM/yyyy')))

	--
	EXEC SPC_COM_M999_INQ1 '1'

	SELECT
		M009.first_name
	,	M009.family_nm
	,	FORMAT(M009.birth_date,'dd/MM/yyyy') AS birth_date
	,	M009.cellphone
	,	M009.address
	,	M009.avarta
	,	M009.email
	,	M009.sex
	FROM S001
	INNER JOIN M009
	ON S001.user_id = M009.employee_id
	WHERE 
		S001.system_div <> 1
	AND S001.del_flg = 0
	AND S001.account_id = @P_user_id

	EXEC SPC_G001_LST2 @prevmonth,@month,@P_user_id
END

