<div class="panel-header">
    <h5 class="panel-title">Chi Tiết Phân Quyền</h5>
</div>
<div class="panel-content no-padding-left">
    <div class="col-xs-12 no-padding-right">
        <div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-multicheckbox">
                <thead>
                    <tr>
                        <th rowspan="2">Mã Màn Hình</th>
                        <th rowspan="2">Tên Màn Hình</th>
                        <th colspan="6">Quyền Hạn</th>
                        <th rowspan="2">Ghi Chú</th>
                    </tr>
                    <tr>
                        <th><label class="checkbox-inline"><input type="checkbox" class="super-all-checkbox" group="1">Truy Cập</label></th>
                        <th><label class="checkbox-inline"><input type="checkbox" class="super-all-checkbox" group="2">Hiển Thị Menu</label></th>
                        <th><label class="checkbox-inline"><input type="checkbox" class="super-all-checkbox" group="3">Thêm Dữ Liệu</label></th>
                        <th><label class="checkbox-inline"><input type="checkbox" class="super-all-checkbox" group="4">Sửa Dữ Liệu</label></th>
                        <th><label class="checkbox-inline"><input type="checkbox" class="super-all-checkbox" group="5">Xóa Dữ Liệu</label></th>
                        <th><label class="checkbox-inline"><input type="checkbox" class="super-all-checkbox" group="6">Xuất Dữ Liệu</label></th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($data)&&$data[1][0]['account_div']!='')
                    @for($i=1;$i<=Count($data[0]);$i++)
                    <tr style="background: #ebeae1" class="tr-header">
                        <td colspan="2" style="font-weight: bold;">{{$data[0][$i-1]['screen_group_nm']}}</td>
                        <td><input type="checkbox" name="" class="super-checkbox" group="1{{$i}}"></td>
                        <td><input type="checkbox" name="" class="super-checkbox" group="2{{$i}}"></td>
                        <td><input type="checkbox" name="" class="super-checkbox" group="3{{$i}}"></td>
                        <td><input type="checkbox" name="" class="super-checkbox" group="4{{$i}}"></td>
                        <td><input type="checkbox" name="" class="super-checkbox" group="5{{$i}}"></td>
                        <td><input type="checkbox" name="" class="super-checkbox" group="6{{$i}}"></td>
                        <td></td>
                    </tr>
                    @for($j=1;$j<=Count($data[1]);$j++)
                    @if($data[1][$j-1]['screen_group']!=$data[0][$i-1]['screen_group'])
                         @continue
                    @endif
                    <tr>
                        <td>{{$data[1][$j-1]['screen_id']}}</td>
                        <td class="text-left">{{$data[1][$j-1]['screen_nm']}}</td>
                        <td><input type="checkbox" name="" class="sub-checkbox" id="access_per" {{$data[1][$j-1]['access_per']==1?'Checked':''}} group="1{{$i.$j}}"></td>
                        <td><input type="checkbox" name="" class="sub-checkbox" id="menu_per" {{$data[1][$j-1]['menu_per']==1?'Checked':''}} group="2{{$i.$j}}"></td>
                        <td><input type="checkbox" name="" class="sub-checkbox" id="add_per" {{$data[1][$j-1]['add_per']==1?'Checked':''}} group="3{{$i.$j}}"></td>
                        <td><input type="checkbox" name="" class="sub-checkbox" id="edit_per" {{$data[1][$j-1]['edit_per']==1?'Checked':''}} group="4{{$i.$j}}"></td>
                        <td><input type="checkbox" name="" class="sub-checkbox" id="delete_per" {{$data[1][$j-1]['delete_per']==1?'Checked':''}} group="5{{$i.$j}}"></td>
                        <td><input type="checkbox" name="" class="sub-checkbox" id="report_per" {{$data[1][$j-1]['report_per']==1?'Checked':''}} group="6{{$i.$j}}"></td>
                        <td><input type="text" name="" class="form-control input-sm" id="remark" value="{{$data[1][$j-1]['remark']}}"></td>
                    </tr>
                    @endfor
                    @endfor
                    @else
                    <tr>
                        <td colspan="9">Xin chọn loại người dùng</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>