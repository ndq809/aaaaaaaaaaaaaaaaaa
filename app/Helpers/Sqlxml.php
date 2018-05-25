<?php
/**
 *-------------------------------------------------------------------------*
 * Souei
 * Helpers button
 *
 * 処理概要/process overview  :
 * 作成日/create date         :   2016/10/28
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
class SqlXml
{

    public function xml($data)
    {
        // $result = array();
        // foreach ($data as $object) {
        //     $xml = '';
        //     foreach ($object as $key => $value) {
        //         $xml .= '<row ';
        //         foreach ($object[$key] as $rowKey => $rowValue) {
        //             $xml .= $rowKey . '="' . $this->_convert($rowValue) . '" ';
        //         }
        //         $xml .= '/>';
        //     }
        //     array_push($result, $xml);
        // }

        // return $result;
        // $result = array();
        $xml = '';
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $xml .= '<row ';
                foreach ($data[$key] as $rowKey => $rowValue) {
                    $xml .= $rowKey . '="' . $this->_convert($rowValue) . '" ';
                }
                $xml .= '/>';
            }
        }

        return $xml;
    }

    public function xml_i001($data, $custom_attr = '')
    {
        $xml = '';
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $xml .= '<row ';
                $xml .= $custom_attr . ' ';
                foreach ($data[$key] as $rowKey => $rowValue) {
                    $xml .= $rowKey . '="' . $this->_convert($rowValue) . '" ';
                }
                $xml .= '/>';
            }
        }

        return $xml;
    }

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new SqlXml();
        }

        return self::$instance;
    }

    private function _convert($str)
    {
        $search = array('<', '>', '"', '\'', '&');
        $replace = array('&lt;', '&gt;', '&quot;', '&apos;', '&amp;');
        return str_replace($search, $replace, $str);
    }

}