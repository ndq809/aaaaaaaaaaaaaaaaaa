IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COMMON_REFER]') AND type IN (N'P', N'PC'))
BEGIN
    DROP PROCEDURE [dbo].[SPC_COMMON_REFER]
END
GO

/****** Object:  StoredProcedure [dbo].[SPC_COMMON_REFER]    Script Date: 12/12/2017 11:55:15 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[SPC_COMMON_REFER]
-- =============================================
-- Author:		ANS AnhDt
-- Create date: 2017/12/12
-- Description:	Refer infor from key
-- EXEC SPC_COMMON_REFER N'', N''
-- =============================================
	-- Add the parameters for the stored procedure here
	@P_key			NVARCHAR(100)	=	''
,	@P_id			NVARCHAR(100)	=	''
,	@P_option1		NVARCHAR(100)	=	''
,	@P_option2		NVARCHAR(100)	=	''
,	@P_option3		NVARCHAR(100)	=	''
,	@P_option4		NVARCHAR(100)	=	''
,	@P_option5		NVARCHAR(100)	=	''
,	@P_option6		NVARCHAR(100)	=	''
AS
BEGIN
	
	SET NOCOUNT ON;
	DECLARE @w_sales_recorded_date SMALLDATETIME

	SET @P_key = UPPER(@P_key)

    IF @P_key = 'P001'
	BEGIN
		SELECT	
			M008.department_id				AS department_id
		,	M008.department_nm				AS department_nm
		FROM M008 WITH(NOLOCK)
		WHERE
			(M008.department_id = @P_id)
		AND	(M008.del_flg = 0)
		
	END 
	ELSE IF @P_key = 'P002'
	BEGIN
		SELECT	
			M009.employee_id	AS employee_id	
		,	CONCAT(M009.family_nm,' ',M009.first_name)		AS name	
		FROM M009 WITH(NOLOCK)
		WHERE
			(M009.employee_id = @P_id)
		AND	(M009.del_flg = 0)
	END
	ELSE IF @P_key = 'EMAIL'
	BEGIN
		SELECT	
			M009.first_name		AS name
		,	M009.email		AS email
		FROM S001 WITH(NOLOCK)
		LEFT JOIN M009
		ON	S001.user_id = M009.employee_id
		WHERE 
			(S001.account_id = @P_id)
		AND	(S001.del_flg = 0)
	END

	--ELSE IF @P_key = 'LM003'
	--BEGIN
	--	SELECT	
	--		M003.emp_cd		AS emp_cd
	--	,	M003.emp_nm		AS emp_nm
	--	FROM M003 WITH(NOLOCK)
	--	WHERE	
	--		(M003.company_cd = @P_option1 or @P_option1 = '')
	--	--AND	(M003.section_cd = @P_option4 or @P_option4 = '')
	--	AND (M003.emp_cd = @P_id)
	--	AND	(M003.del_flg = 0)
	--END
	--ELSE IF @P_key = 'LM101'
	--BEGIN
	--	SELECT	
	--		M101.number_cd		AS number_cd	
	--	,	M101.name			AS name		
	--	,	CASE WHEN ISNULL(M101.change_perm_div, 0) = 0
	--		THEN N'※変更不可'
	--		ELSE N'※変更可能' END AS change_perm_div_nm
	--	FROM M101 WITH(NOLOCK)
	--	WHERE	
	--		(M101.number_cd = @P_id)
	--	AND	(name_type = '999')
	--	AND (del_flg = 0)
	--END
	--ELSE IF @P_key = 'LM004'
	--BEGIN	
	--	SELECT 
	--		M004.client_cd				AS client_cd
	--	,	CONCAT(ISNULL(M004.client_nm,''),' ',ISNULL(M004.client_br_nm,''))	AS client_nm
	--	FROM M004 WITH(NOLOCK)
	--	WHERE 
	--		(M004.company_cd = @P_option2)
	--	AND M004.client_cd    = @P_id
	--	AND M004.client_br_cd = @P_option1
	--	AND M004.del_flg = 0
	--END
	--ELSE IF @P_key = 'LM005'
	--BEGIN	
	--	SELECT 
	--		M005.vendor_cd				AS vendor_cd
	--	,	CONCAT(ISNULL(M005.vendor_nm,''),ISNULL(M005.vendor_br_nm,''))	AS vendor_nm
	--	,	CONCAT(ISNULL(M005.vendor_nm,''),ISNULL(M005.vendor_br_nm,''))	AS vendor_full_nm
	--	FROM M005 WITH(NOLOCK)
	--	WHERE 
	--		(M005.company_cd = @P_option2)
	--	AND M005.vendor_cd    = @P_id
	--	AND M005.vendor_br_cd = @P_option1
	--	AND M005.del_flg = 0
	--END
	--ELSE IF @P_key = 'LM006'
	--BEGIN	
	--	SELECT 
	--		M006.supplier_cd				AS supplier_cd
	--	,	ISNULL(M006.supplier_nm,'')		AS supplier_nm
	--	FROM M006 WITH(NOLOCK)
	--	WHERE 
	--		M006.supplier_cd    = @P_id
	--	AND M006.del_flg = 0
	--END
	--ELSE IF @P_key = 'L001'
	--BEGIN
	--	--IF (@P_option2 <> '')
	--	--BEGIN
	--	--	SET @w_sales_recorded_date = CAST(@P_option2 + '/01' AS SMALLDATETIME)
	--	--END
	--	SELECT	
	--		F001.project_no		AS project_no
	--	,	F001.project_nm		AS project_nm
	--	FROM F001 WITH(NOLOCK)
	--	WHERE
	--		(F001.company_cd = @P_option1 or @P_option1 = '')
	--	--AND (F001.sales_recorded_date = @w_sales_recorded_date or @P_option2 = '')
	--	--AND (F001.client_cd = @P_option3 or @P_option3 = '')
	--	--AND (F001.client_br_cd = @P_option4 or @P_option4 = '')
	--	--AND (F001.client_nm = @P_option5 or @P_option5 = '')
	--	--AND (F001.emp_cd = @P_option6 or @P_option6 = '')
	--	AND (F001.project_no = @P_id)
	--	AND	(F001.del_flg = 0)
	--END
END
GO

