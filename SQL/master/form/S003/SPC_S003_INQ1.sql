USE [EPLUS]
GO
/****** Object:  StoredProcedure [dbo].[SPC_M004_INQ1]    Script Date: 2018/05/15 10:12:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE [dbo].[SPC_M004_INQ1]
	@P_employee_id		NVARCHAR(15)		= ''
AS
BEGIN
	SET NOCOUNT ON;
		SELECT
			 employee_id 
		,	 family_nm    
		,	 first_name   
		,	 email        
		,	 cellphone    
		,	 sex      	
		,	 birth_date   
		,	 department_id
		,	 remark   	    
		--
		,	M009.cre_user
		,	M009.upd_user		
		,	FORMAT(M009.cre_date,'dd/MM/yyyy HH:mm')	AS cre_date
		,	FORMAT(M009.upd_date,'dd/MM/yyyy HH:mm')	AS upd_date
		FROM M009 WHERE
			(M009.employee_id = @P_employee_id)
		AND	(M009.del_flg = 0)
END

