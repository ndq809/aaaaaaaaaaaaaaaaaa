<div class="table-fixed-width no-padding-left" min-width='1160px'>
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Hạng Mục Thao Tác</th>
                <th>Số Lượng</th>
                <th>Tình Trạng</th>
                <th>Đơn Giá</th>
                <th>Thu Nhập Nhận Được</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($data)&&$data[0]['record_type'] != '')
                @foreach($data as $index => $row)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$row['record_type_nm']}}</td>
                    <td>{{$row['qty']}}</td>
                    <td>{{$row['confirmed']}}</td>
                    <td>{{$row['price']}}</td>
                    <td class="bill">{{$row['bill']}}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-right">Tổng Thu Nhập: </td>
                    <td id="salary" class="money-format"></td>
                </tr>
                @else
                 <tr>
                    <td colspan="6" class="text-center">Không có dữ liệu nào</td>
                </tr>   
            @endif
            
        </tbody>
    </table>
</div>
