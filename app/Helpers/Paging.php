<?php
/**
 *-------------------------------------------------------------------------*
 * Souei
 * Helpers pagging
 *
 * 処理概要/process overview  :
 * 作成日/create date         :   2016/11/15
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

class Paging
{

    /**
     * show pagging for list
     * -----------------------------------------------
     * @author      :   vuongvt     - 2016/11/16 - create
     * @param       :   null
     * @return      :   null
     * @access      :   public
     * @see         :   remark
     */
    public static function show($page = array(), $showLabel = 1)
    {
        $strpage = '';
        if (sizeof($page) != 0) {
            $start = min(($page['page'] - 1) * $page['pagesize'] + 1, $page['totalRecord']);
            $end = min(($page['page'] - 1) * $page['pagesize'] + 50, $page['totalRecord']);
            $label = $showLabel == 1 ? self::_displayCount($start, $end, $page['totalRecord']) : '';
            $strpage = '<label class="panel-title inline-block">' . $label . '</label>';
            $strpage .= self::_showPage($page['page'], $page['pageMax'], $page['totalRecord']);
        } else {
            $strpage = '<label class="panel-title inline-block"></label>';
            $strpage .= '<ul class="pagination pagination-xs pagination-location">';
            $strpage .= '   <li class="pagging-disable"><a href=""><i class="fa fa-caret-left"></i></a></li>';
            $strpage .= '   <li class="pagging-disable"><a href=""><i class="fa fa-angle-left"></i></a></li>';
            $strpage .= '   <li class="active"><a href="">1</a></li>';
            $strpage .= '   <li class="pagging-disable"><a href=""><i class="fa fa-angle-right"></i></a></li>';
            $strpage .= '   <li class="pagging-disable"><a href=""><i class="fa fa-caret-right"></i></a></li>';
            $strpage .= '</ul>';
        }
        echo $strpage;

    }

    public static function showText($page = array(), $showLabel = 1)
    {
        $strpage = '';
        if (sizeof($page) != 0) {
            $start = min(($page['page'] - 1) * $page['pagesize'] + 1, $page['totalRecord']);
            $end = min(($page['page'] - 1) * $page['pagesize'] + 50, $page['totalRecord']);
            $label = $showLabel == 1 ? self::_displayCount($start, $end, $page['totalRecord']) : '';
        } else {
            $strpage = '<label class="panel-title inline-block"></label>';
            $strpage .= '<ul class="pagination pagination-xs pagination-location">';
            $strpage .= '   <li class="pagging-disable"><a href=""><i class="fa fa-caret-left"></i></a></li>';
            $strpage .= '   <li class="active"><a href="">1</a></li>';
            $strpage .= '   <li class="pagging-disable"><a href=""><i class="fa fa-caret-right"></i></a></li>';
            $strpage .= '</ul>';
        }
        echo $strpage;
    }

    /**
     * show pagging for list
     * -----------------------------------------------
     * @author      :   vuongvt     - 2016/11/16 - create
     * @author      :   DuyTP       - 2017/02/16 - fix [prev-next] btn to [first-last]
     * @param       :   null
     * @return      :   null
     * @access      :   public
     * @see         :   remark
     */
    private static function _showPage($page, $pageMax, $totalRecord)
    {
        if ($totalRecord == 0) {
            return '';
        }
        //add new
        $disabledfirst = ($page <= 1) ? 'pagging-disable' : '';
        $pagePrevious = 0;
        if ($page > 1) {
            $pagePrevious = $page - 1;
        }
        $page1 = ($page <= 2) ? '' : $page - 2;
        $page2 = ($page <= 1) ? '' : $page - 1;
        $page4 = ($pageMax <= $page) ? '' : $page + 1;
        $page5 = ($pageMax <= $page + 1) ? '' : $page + 2;
        $disabledlast = ($page >= $pageMax) ? 'pagging-disable' : '';

        $paging = '<ul class="pager hidden-xs">';
        $paging .= '    <li class="' . $disabledfirst . '"><a class="' . $disabledfirst . '" page="1">Đầu</a></li>'; // DuyTP 2017/02/16
        $paging .= '    <li class="' . $disabledfirst . '"><a class="' . $disabledfirst . '" page="' . $page2 . '">Trước</a></li>'; // QuyND 2017/12/07
        if ($page1 != '' && $page1 > 2 && $pageMax > 5) {
            $paging .= '    <li><a page="1">1</a></li>';
            $paging .= '    <li class="pagging-disable"><a>..</a></li>';
        }
        if ($page < 5) {
            if ($pageMax < 5) {
                $temp = $pageMax;
            } else {
                $temp = 5;
            }
            for ($i = 1; $i <= $temp; $i++) {
                if ($page != $i) {
                    $paging .= '<li><a page="' . $i . '">' . $i . '</a></li>';
                } else {
                    $paging .= '<li class="active"><a page="' . $i . '">' . $i . '</a></li>';
                }
            }
        } else {
            if ($page + 3 < $pageMax) {
                if ($page1 != '') {
                    $paging .= '    <li><a page="' . $page1 . '">' . $page1 . '</a></li>';
                }
                if ($page2 != '') {
                    $paging .= '    <li><a page="' . $page2 . '">' . $page2 . '</a></li>';
                }

                $paging .= '    <li class="active"><a page="' . $page . '">' . $page . '</a></li>';
                if ($page4 != '') {
                    $paging .= '    <li><a page="' . $page4 . '">' . $page4 . '</a></li>';
                }
                if ($page5 != '') {
                    $paging .= '    <li><a page="' . $page5 . '">' . $page5 . '</a></li>';
                }
            } else {
                for ($i = $pageMax - 4; $i <= $pageMax; $i++) {
                    if ($page != $i) {
                        $paging .= '<li><a page="' . $i . '">' . $i . '</a></li>';
                    } else {
                        $paging .= '<li class="active"><a page="' . $i . '">' . $i . '</a></li>';
                    }
                }
            }
        }

        if (($page5 != '' && $pageMax > $page5 && $pageMax > 5 && (!($pageMax == ($page + 3))) || ($pageMax == 6 && $page < 5)) || ($page == 4 && $pageMax == 7)) {
            $paging .= '    <li class="pagging-disable"><a>..</a></li>';
            $paging .= '    <li><a page="' . $pageMax . '">' . $pageMax . '</a></li>';
        }
        $paging .= '    <li class="' . $disabledlast . '"><a class="' . $disabledlast . '" page="' . $page4 . '">Tiếp</a></li>'; // QuyND 2017/12/07
        $paging .= '    <li class="' . $disabledlast . '"><a page="' . $pageMax . '" class="' . $disabledlast . '">Cuối</a></li>'; // DuyTP 2017/02/16
        $paging .= '</ul>';


        $paging .= '<ul class="pager visible-xs">';
        $paging .= '    <li class="' . $disabledfirst . '"><a class="' . $disabledfirst . '" page="1">Đầu</a></li>'; // DuyTP 2017/02/16
        $paging .= '    <li class="' . $disabledfirst . '"><a class="' . $disabledfirst . '" page="' . $page2 . '">Trước</a></li>'; // QuyND 2017/12/07
        $paging .= '    <li>';
        $paging .= '    <select class="form-control input-sm">';
        for($i=1;$i<=$pageMax;$i++){
            if($i!=$page){
                $paging .= '    <option>Trang '.$i.'</option>';
            }else{
                $paging .= '    <option selected="selected">Trang '.$i.'</option>';
            }
        }
        $paging .= '    </select>';
        $paging .= '    </li>';
        $paging .= '    <li class="' . $disabledlast . '"><a class="' . $disabledlast . '" page="' . $page4 . '">Tiếp</a></li>'; // QuyND 2017/12/07
        $paging .= '    <li class="' . $disabledlast . '"><a page="' . $pageMax . '" class="' . $disabledlast . '">Cuối</a></li>'; // DuyTP 2017/02/16
        $paging .= '</ul>';
        return $paging;
    }

    /**
     * show pagging for list
     * -----------------------------------------------
     * @author      :   vuongvt     - 2016/11/16 - create
     * @param       :   null
     * @return      :   null
     * @access      :   public
     * @see         :   remark
     */
    // private static function _showSize($size = 50) {
    //     $size10 = ($size == 10) ?  'selected' : '';
    //     $size50 = ($size == 50) ?  'selected' : '';
    //     $size100 = ($size ==100) ?  'selected' : '';

    //     $select  = '<select name="select" class="form-control show-item-paging" id="page-size" style="width: 78px;">';
    //     $select .= '    <option value="10" ' . $size10 . ' >10 件</option>';
    //     $select .= '    <option value="50" ' . $size50 . ' >50 件</option>';
    //     $select .= '    <option value="100" ' . $size100 . '>100 件</option>';
    //     $select .= '</select>';

    //     return $select;
    // }

    /**
     * show pagging for list
     * -----------------------------------------------
     * @author      :   vuongvt     - 2016/11/16 - create
     * @param       :   null
     * @return      :   null
     * @access      :   public
     * @see         :   remark
     */
    private static function _displayCount($start, $end, $totalRecord)
    {
        $displaycount = '';
        if ($start != 0 && $totalRecord > 0) {
            $displaycount = number_format($totalRecord) . "件の結果から " . number_format($start) . "-" . number_format($end) . "件を表示する";
        } else {
            $displaycount = number_format($totalRecord) . "件 ";
        }

        return $displaycount;
    }
}
