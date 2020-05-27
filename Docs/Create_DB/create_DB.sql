
SELECT 
	COLUMN_NAME
,	DATA_TYPE
,	IIF(DATA_TYPE IN ('smallint','int','tinyint','smallmoney','money','bigint'),N'Số',IIF(DATA_TYPE IN ('nvarchar','ntext'),N'Chữ',N'Ngày tháng'))
,	IIF(CHARACTER_MAXIMUM_LENGTH IS NULL OR DATA_TYPE='ntext','',IIF(CHARACTER_MAXIMUM_LENGTH=-1,'Max',CONVERT(nvarchar(100),CHARACTER_MAXIMUM_LENGTH)))
,	''
,	''
,	IIF(IS_NULLABLE='NO','x','')
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = N'F008'
