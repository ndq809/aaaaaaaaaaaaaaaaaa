<div class="panel-header padding-10-l">
    <h5 class="panel-title">Chi Tiết Đối Tượng</h5>
</div>
<div class="panel-content padding-10-l">
    <div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-focus submit-table">
            <thead>
                 <tr>
                    <th width="40px">STT</th>
                    <th>Tên Đối Tượng</th>
                    @if(isset($data[1][0]['price_count']) && $data[1][0]['price_count'] != '')
                    @for($i = 1; $i <= (int)$data[1][0]['price_count'] ; $i++)
                    <th width="100px">Đơn giá {{$i}}</th>
                    @endfor
                    @endif
                </tr>
            </thead>
            <tbody>
                @if(isset($data)&&$data[0][0]['target_dtl_div'] != '')
                @foreach($data[0] as $index => $row)
                <tr>
                    <td>{{$index+1}}</td>
                    <td class="hidden"><input type="hidden" refer-id="target_dtl_div" value="{{$row['target_dtl_div']}}"></td>
                    <td width="150px">{{$row['target_dtl_nm']}}</td>
                    @if(isset($data[1][0]['price_count']) && $data[1][0]['price_count'] != '')
                    @for($i = 1; $i <= (int)$data[1][0]['price_count'] ; $i++)
                    <td><input type="text" refer-id="price_{{$i}}" name="" class="form-control input-sm content money" value="{{isset($row[$i])?$row[$i]:''}}"></td>
                    @endfor
                    @endif
                </tr>
                @endforeach
                 @else
                 <tr>
                    <td colspan="100">Xin lựa chọn đối tượng đơn giá</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
