<div class="table-fixed-width no-padding-left" min-width='700px'>
    <table class="table table-hover table-bordered table-refer table-preview table-custom">
        <thead>
            <tr>
                <th width="40px">Xóa</th>
                <th width="100px">Mã Người Dùng</th>
                <th width="150px">Tên Tài Khoản</th>
                <th width="250px">Rank</th>
                <th width="250px">Nghề Nghiệp</th>
                <th >Tỉnh/Thành Phố</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($data)&&$data[0]['account_id'] != '')
            @foreach($data as $index => $row)
            <tr>
                <td><button class="btn btn-danger btn-delete-row" type="button"><span class="fa fa-close"></span></button></td>
                <td refer-id='account_id'>{{$row['account_id']}}</td>
                <td refer-id='account_nm'><span>{{$row['account_nm']}}</span></td>
                <td refer-id='rank' class="text-left"><span>{{$row['rank']}}</span></td>
                <td refer-id='job' class="text-left"><span>{{$row['job']}}</span></td>
                <td refer-id='city' class="td-1-line text-left">{{$row['city']}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
