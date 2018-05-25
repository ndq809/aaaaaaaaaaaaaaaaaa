<?php
namespace App\Helpers;

class Button
{

    //register button
    protected static $button_val = array(
        'btn-list' => array('id' => 'btn-list', 'class' => '', 'icon' => 'fa fa-file-text', 'label' => 'Danh Sách', 'data_popup' => 'tooltip', 'color' => ''),
        'btn-add' => array('id' => 'btn-add', 'class' => '', 'icon' => 'fa fa-plus', 'label' => 'Thêm Mới', 'data_popup' => 'tooltip', 'color' => ''),
        'btn-update' => array('id' => 'btn-update', 'class' => '', 'icon' => 'fa fa-refresh', 'label' => 'Chỉnh Sửa', 'data_popup' => 'tooltip', 'color' => ''),
        'btn-delete' => array('id' => 'btn-delete', 'class' => '', 'icon' => 'fa fa-remove', 'label' => 'Xóa', 'data_popup' => 'tooltip', 'color' => ''),
        'btn-search' => array('id' => 'btn-search', 'class' => '', 'icon' => 'fa fa-search', 'label' => 'Tìm Kiếm', 'data_popup' => 'tooltip', 'color' => ''),
        'btn-save' => array('id' => 'btn-save', 'class' => '', 'icon' => 'fa fa-save', 'label' => 'Lưu Lại', 'data_popup' => 'tooltip', 'color' => ''),
        'btn-print' => array('id' => 'btn-search', 'class' => '', 'icon' => 'fa fa-print', 'label' => 'In Dữ Liệu', 'data_popup' => 'tooltip', 'color' => ''),
        'btn-cancel' => array('id' => 'btn-cancel', 'class' => '', 'icon' => 'fa fa-minus-circle', 'label' => 'Hủy', 'data_popup' => 'tooltip', 'color' => ''),
        'btn-new-row' => array('id' => 'btn-new-row', 'class' => '', 'icon' => 'fa fa-plus', 'label' => 'Thêm Hàng', 'data_popup' => 'tooltip', 'color' => ''),
        'btn-manager-page' => array('id' => 'btn-manager', 'class' => '', 'icon' => 'fa fa-share', 'label' => 'Quản Lý', 'data_popup' => 'tooltip', 'color' => ''),
        'btn-add-page' => array('id' => 'btn-add-page', 'class' => '', 'icon' => 'fa fa-share', 'label' => 'Thêm Mới', 'data_popup' => 'tooltip', 'color' => ''),
        'btn-change-pass' => array('id' => 'btn-change-pass', 'class' => '', 'icon' => 'fa fa-key', 'label' => 'Đổi MK', 'data_popup' => 'tooltip', 'color' => ''),
        'btn-refresh' => array('id' => 'btn-refresh', 'class' => '', 'icon' => 'fa fa-refresh', 'label' => 'Làm Mới', 'data_popup' => 'tooltip', 'color' => ''),
    );

    public static function menu_button(array $array)
    {

        foreach ($array as $key => $value) {
            if (array_key_exists($value, self::$button_val)) {
                $btn_lang_tootip = 'tooltip.' . self::$button_val[$value]['id'];
                echo '<li tabindex="0" class="' . 'cl-' . self::$button_val[$value]['id'] . ' ' . self::$button_val[$value]['class'] . '" id="' . self::$button_val[$value]['id'] . '">';
                echo '<a class="">';
                echo '<i class="' . self::$button_val[$value]['icon'] . ' ' . self::$button_val[$value]['color'] . ' ">' . '</i><span class="' . self::$button_val[$value]['color'] . ' ">';
                echo ' ' . self::$button_val[$value]['label'];
                echo '</span></a></li>';
            }
        }
    }

    public static function button_right(array $array)
    {

        foreach ($array as $key => $value) {
            if (array_key_exists($value, self::$button_val)) {
                $btn_lang_tootip = 'tooltip.' . self::$button_val[$value]['id'];

                echo '<li tabindex="0" class="' . 'cl-' . self::$button_val[$value]['id'] . '" id="' . self::$button_val[$value]['id'] . '" data-original-title="' . self::$button_val[$value]['label'] . '" data-popup="' . self::$button_val[$value]['data_popup'] . '">';

                if ($value == "btn-close") {
                    //add link back vulq 2016-10-04
                    $url_old = \URL::previous();
                    if (strpos($url_old, 'maintenance')) {
                        $url_old = \Request::url();
                    }
                    //end
                    echo '<a href="javascript:void(0)" link="' . $url_old . '" class="btn btn-link">';
                } else {
                    echo '<a class="btn btn-link">';
                }

                echo '<i class="' . self::$button_val[$value]['icon'] . ' ' . self::$button_val[$value]['color'] . ' ">' . '</i><span class="' . self::$button_val[$value]['color'] . ' ">';
                echo ' ' . self::$button_val[$value]['label'];
                echo '</span></a></li>';

            }
        }

    }
    public static function button_search($inline)
    {
        if ($inline) {
            echo '<div class="form-group">';
            echo '<div class="col-md-12 text-right">';
            echo '<button type="button" class="btn btn-primary" id="btn-search"><i class="icon-search4"> 検索 </i></button>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="col-md-1 pull-right text-right" >';
            echo '<button type="button" class="btn btn-primary" id="btn-search"><i class="icon-search4"> 検索 </i></button>';
            echo '</div>';
        }

    }

    public static function button_bottom(array $array)
    {
        foreach ($array as $key => $value) {
            if (array_key_exists($value, self::$button_val)) {
                echo '<button class="btn btn-primary" id="' . self::$button_val[$value]['id'] . '"><i class="' . self::$button_val[$value]['icon'] . '"></i>' . ' ' . self::$button_val[$value]['label'] . '</button>';
            }
        }
    }

}
