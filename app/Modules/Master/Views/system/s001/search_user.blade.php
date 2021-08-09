<div class="panel-header">
    <h5 class="panel-title">Chi Tiết Phân Quyền</h5>
</div>
<div class="panel-content no-padding-left">
    <div class="col-xs-12 no-padding-right">
        <div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-multicheckbox table-custom">
                <thead>
                    <tr>
                        <th width="120px">Mã Chức Năng</th>
                        <th width="200px">Tên Chức Năng</th>
                        <th width="120px">Quyền Truy Cập</th>
                        <th >Ghi Chú</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($data)&&$data[0][0]['screen_group_nm']!='')
                    <tr style="background: #ebeae1" class="tr-header">
                        <td colspan="2" style="font-weight: bold;">{{$data[0][0]['screen_group_nm']}}</td>
                        <td><input type="checkbox" name="" class="super-checkbox" group="10"></td>
                        
                        <td></td>
                    </tr>
                    @for($j=1;$j<=Count($data[1]);$j++)
                    <tr>
                        <td>{{$data[1][$j-1]['screen_id']}}</td>
                        <td class="text-left">{{$data[1][$j-1]['screen_nm']}}</td>
                        <td><input type="checkbox" name="" class="sub-checkbox" id="access_per" {{$data[1][$j-1]['access_per']==1?'Checked':''}} group="10{{$j}}"></td>
                        
                        <td><input type="text" name="" class="form-control input-sm" id="remark" value="{{$data[1][$j-1]['remark']}}"></td>
                    </tr>
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