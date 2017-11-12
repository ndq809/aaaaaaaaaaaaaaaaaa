<?php

/**
 *-------------------------------------------------------------------------*
 * Helpers
 * @created         :   2016/11/24
 * @author          :   tannq@ans-asia.com
 * @package         :   common
 * @copyright       :   Copyright (c) ANS-ASIA
 * @version         :   1.0.0
 *-------------------------------------------------------------------------*
 *
 */

/*
 * Add timestamp version
 */
/**
 *
 */
namespace App\Helpers;
class WebFunctions
{

        static function file_cached($path, $bustQuery = false)
        {
            // Get the full path to the file.
            $realPath = ($path);

            if ( ! file_exists($realPath)) {
                throw new \LogicException("File not found at [{$realPath}]");
            }
            // Get the last updated timestamp of the file.
            $timestamp = filemtime($realPath);

            if (!$bustQuery) {
                // Get the extension of the file.
                $extension = pathinfo($realPath, PATHINFO_EXTENSION);

                // Strip the extension off of the path.
                $stripped = substr($path, 0, -(strlen($extension) + 1));

                // Put the timestamp between the filename and the extension.
                $path = implode('.', array($stripped, $timestamp, $extension));
            } else {
                // Append the timestamp to the path as a query string.
                $path .= '?v=' . $timestamp;
            }

            return asset($path);
        }

/*
 * Call url file
 */
        static function public_url($url, $attributes = null)
        {
            $realPath = public_path($url);
            if (file_exists($url)) {
                $attr = '';
                if (!empty($attributes) && is_array($attributes)) {
                    foreach ($attributes as $key => $val) {
                        $attr .= $key . '="' . $val . '" ';
                    }
                }
                $attr = rtrim($attr);
                if (ends_with($url, '.css')) {
                    return '<link rel="stylesheet" href="' . WebFunctions::file_cached($url, true) . '" type="text/css" ' . $attr . '>';
                } elseif (ends_with($url, '.js')) {
                    return '<script src="' . WebFunctions::file_cached($url, true) . '" type="text/javascript" charset="utf-8" ' . $attr . '></script>';
                } else {
                    return asset($url);
                }
            }
            $console = 'File:[' . $url . '] not found';
            return "<script>console.log('" . $console . "')</script>";
        }

// numberformat
        function formatNumber($number = '', $decimal = 0)
        {
            if ($number == '') {
                return $number;
            }

            $number = 1 * $number;
            if (($number - round($number)) != 0) {
                $number = number_format($number, $decimal, '.', ',');
            } else {
                $number = number_format($number, 0, '.', ',');
            }
            return $number;
        }

// make keyword
        function makeKeyword($keyword = null, $input = 'keyword')
        {
            $keyword        = trim(\Request::get($input));
            $keyword        = explode(' ', $keyword);
            $keyword        = implode('%', $keyword);
            return $keyword = '%' . $keyword . '%';
        }

// get combobox
        function getCombobox($table_key = '', $typ = 0)
        {
            $params = array(
                1
                , $table_key
                , $typ,
            );
            $data = \Dao::executeSql('SPC_COMBOBOX_INQ1', $params);
            return $data[0];
        }

// get session login
        function session_data()
        {
            return app('session_data');
        }
}
