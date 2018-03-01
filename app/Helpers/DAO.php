<?php
/**
 *-------------------------------------------------------------------------*
 * Souei
 * Helpers call procedue sql server
 *
 * 処理概要/process overview  :
 * 作成日/create date         :   2016/10/20
 * 作成者/creater             :   vuongvt – vuongvt@ans-asia.com
 *
 * @package                  :   MASTER
 * @copyright                :   Copyright (c) ANS-ASIA
 * @version                  :   1.0.0
 *-------------------------------------------------------------------------*
 * DESCRIPTION
 *
 *
 *
 *
 */
namespace App\Helpers;
use PDO,DB;
class Dao{
    const FROM_ENCODING = 'SJIS';
    const TO_ENCODING = 'UTF-8';
    const EXCEPTION = 'EXCEPTION';

    public function __construct() {

    }

    /**
     * runs a stored procedure and returns results if any
     *--------------------------------------------
     * @author      :   vuongvt    - 2016/10/20 - create
     * @author      :
     * @param string    $sProcedure
     * @param array     $aParams
     */
    public static function call_stored_procedure($sProcedure, $aParams = array(), $option = FALSE,$debug = FALSE)
    {
        try{

            $this_ = new Dao;
            // create database connection
            $db = DB::connection()->getPdo();
            // if any params are present, add them
            $sParamsIn = '';
            if(isset($aParams) && is_array($aParams) && count($aParams)>0) {
                // loop through params and set
                foreach($aParams as $sParam) {
                    $sParamsIn .= '?,';
                }

                // trim the last comma from the params in string
                $sParamsIn = substr($sParamsIn, 0, strlen($sParamsIn)-1);
            }
            // create initial stored procedure call
            $stmt = $db->prepare("{CALL $sProcedure($sParamsIn)}");

            // if any params are present, add them
            if(isset($aParams) && is_array($aParams) && count($aParams)>0) {
                $iParamCount = 1;
                // loop through params and bind value to the prepare statement
                foreach ($aParams as &$value) {
                    //$value = $this_->sqlServerEscapeString($value);//vulq comment 20160804
                    $stmt->bindParam($iParamCount, $value);

                    $iParamCount++;
                }
            }

            //write log
            if ($aParams == null || count($aParams) > 0) {
                $debug_sql = $this_->interpolateQuery($sProcedure, $aParams);
            } else {
                $debug_sql = $this_->interpolateQuery($sProcedure);
            }

            $log_path =  dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'log';
            if (!file_exists($log_path)) {
                if (!mkdir($log_path, 0777, true)) {
                    die("Failed to create folder $log_path");
                }
            }
            $file_name = date("Ymd");
            $time = date("Y-m-d H:i:s");
            $file_path = 'log' . DIRECTORY_SEPARATOR . $file_name . '.log';
            file_put_contents($file_path, $time . ' ' . $debug_sql . PHP_EOL, FILE_APPEND);

            //    Debug
            if($debug){
                echo $this_->debugQuery($sProcedure, $aParams);
            }

            // execute the stored procedure
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);



            $result = array();
            $i = 0;
            do {
                while($respon = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    foreach ($respon as $key_from_encoding => $res_from_encoding) {
                        $key_to_encoding = mb_convert_encoding($key_from_encoding, self::TO_ENCODING, self::FROM_ENCODING);
                        $res_from_encoding = html_entity_decode($res_from_encoding);
                        unset ($respon[$key_from_encoding]);
                        $respon[$key_to_encoding] = $res_from_encoding;
                    }
                    $result[$i][] = $respon;
                }

                if(!isset($result[$i])) {
                    $result[$i] = $this_->getColumns($stmt, 'default');
                }
                $i++;
            } while ($stmt->nextRowset());

        }catch (\Exception $e) {
            $result[0][0] = array(
                'Id'      => '',
                'Code'    => $e->getCode(),
                'Data'    => self::EXCEPTION,
                'Message' => 'PHP: '.$e->getMessage()
            );
            // Write log error
            $log_path =  dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'log';
            if (!file_exists($log_path)) {
                if (!mkdir($log_path, 0777, true)) {
                    die("Failed to create folder $log_path");
                }
            }
            $file_name = date("Ymd");
            $time = date("Y-m-d H:i:s");
            $file_path = 'log' . DIRECTORY_SEPARATOR . $file_name . '.log';
            file_put_contents($file_path, $time . ' ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
        }
        return $result;
    }

    /**
     * interpolateQuery
     *
     * @author      :   vuongvt    - 2016/10/20 - create
     * @author      :
     * @param       :   $query,$params
     * @return      :
     * @access      :   protected
     * @see         :   get _db
     */
    protected function interpolateQuery($query, $params) {

        $keys = array();
        $values = $params;
        $arr = array_fill(0, sizeof($params), '?');
        $params_str = implode("','", $params);
        $query = "EXEC " . $query;
        if ($params != null || count($params) > 0) {
            $query .= " '" . $params_str . "';";
        }
        return $query;
    }

    /**
     * debugQuery
     *
     * @author      :   vuongvt    - 2016/10/20 - create
     * @author      :
     * @param       :   $query,$params
     * @return      :
     * @access      :   protected
     * @see         :   get _db
     */
    protected function debugQuery($query, $params) {
        $keys = array();
        $values = $params;
        $arr = array_fill(0, sizeof($params), '?');
        $quote_css = '<span style="color:#FF0000;">' . "'" . '</span>';
        $comma_css = '<span style="color:#808080;">,</span>';
        $semicolon_css = '<span style="color:#808080;">;</span>';
        $str_css  = '</span>' . $quote_css;
        $str_css .= $comma_css;
        $str_css .= $quote_css . '<span style="color:#FF0000;">';
        $params_str = implode($str_css, $params);
        $query = '<span style="color:#0000FF;">EXEC</span>' . "<span> $query </span>";
        $query .= $quote_css.'<span style="color:#FF0000;">' . $params_str . '</span>'.$quote_css . $semicolon_css;
        return     '<div><span>SQL Debug:<span><br>
                <pre style="display: block;color: #000;font-size: 16px;background-color: #eff0f1;"><code>'.$query.'</code></pre></div><br>';
    }

    /**
     * getColumns
     *
     * @author      :   vuongvt    - 2016/10/20 - create
     * @author      :
     * @param       :   $statement,$option
     * @return      :
     * @access      :   protected
     * @see         :
     */
    protected function getColumns($statement, $option) {
        $columns = array();
        if($option == 'default'){
            for ($i = 0; $i < $statement->columnCount(); $i++) {
                $col = $statement->getColumnMeta($i);
                $columns[0][$col['name']] = $this->setDefaultByType($col['sqlsrv:decl_type']);
            }
        }
        return $columns;
    }

    /**
     * setDefaultByType
     *
     * @author      :   vuongvt    - 2016/10/20 - create
     * @author      :
     * @param       :   $mssql_type
     * @return      :
     * @access      :   private
     * @see         :
     */
    private function setDefaultByType($mssql_type) {
        $default = null;
        switch(strtoupper($mssql_type)) {
            case 'BIT':
                $default = '';
                break;
            case 'TINYINT':
            case 'SMALLINT':
            case 'MEDIUMINT':
            case 'INT':
            case 'INTEGER':
            case 'BIGINT':
                $default = '';
                break;
            case 'FLOAT':
            case 'DOUBLE':
            case 'DECIMAL':
                $default = '';
                break;
            case 'CHAR':
            case 'ENUM':
            case 'SET':
            case 'VARCHAR':
            case 'NVARCHAR':
                $default = '';
                break;
            case 'TINYTEXT':
            case 'TEXT':
            case 'MEDIUMTEXT':
            case 'LONGTEXT':
                $default = '';
                break;
            case 'BINARY':
            case 'VARBINARY':
            case 'BLOB':
            case 'TINYBLOB':
            case 'MEDIUMBLOB':
            case 'LONGBLOB':
                $default = '';
                break;
            case 'DATE':
            case 'TIME':
            case 'DATETIME':
            case 'TIMESTAMP':
            case 'YEAR':
                $default = '';
                break;
            default:
                $default = '';
                break;
        }
        return $default;
    }

    /**
     * validate string
     *
     * @author      :   vuongvt    - 2016/10/20 - create
     * @author      :
     * @param       :   string $input
     * @return      :   string
     * @access      :   public
     * @see         :
     */
    public function sqlServerEscapeString($input){
        $input = str_replace('[', '[[]', $input);
        $input = str_replace('%', '[%]', $input);
        $input = str_replace('_', '[_]', $input);
        $input = str_replace('\\', '[\\]', $input);
        $input = str_replace('\'', '\'\'', $input);
        if ($input === NULL){
            $input = NULL;
        }
        return $input;
    }

}
