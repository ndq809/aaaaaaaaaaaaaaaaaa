IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_COM_M999_INQ1]') AND type IN (N'P', N'PC'))
BEGIN
    DROP PROCEDURE [dbo].[SPC_COM_M999_INQ1]
END
GO

CREATE PROCEDURE [dbo].[SPC_COM_M999_INQ1]
/*ÉpÉâÉÅÅ[É^*/
	@P_name_div 	TINYINT		 = 0
,	@P_number_cd	TINYINT		 = 0
,	@P_option1		TINYINT		 = 0
,	@P_option2		TINYINT		 = 0
,	@P_option3		TINYINT		 = 0

AS
BEGIN
	SET NOCOUNT ON
		
	--[0]
	SELECT 
		M999.number_id
	,	M999.content
	,	M999.name_div
	FROM M999 WITH(NOLOCK)
	WHERE 
		(M999.name_div = @P_name_div)
    AND (@P_number_cd = 0 OR (M999.number_id = @P_number_cd))
    AND (@P_option1 = 0 OR (M999.num_remark1 = @P_option1))
    AND (@P_option2 = 0 OR (M999.num_remark2 = @P_option2))
    AND (@P_option3 = 0 OR (M999.num_remark3 = @P_option3))
	AND	(M999.del_flg = 0)
	ORDER BY 
		M999.number_id
END
GO
