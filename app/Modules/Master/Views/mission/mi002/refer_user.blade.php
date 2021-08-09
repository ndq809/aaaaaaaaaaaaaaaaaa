<table class="table table-bordered table-input submit-table">
    <thead>
        <tr>
            <th width="40px">STT</th>
            <th width="100px">Mã Người Dùng</th>
            <th width="150px">Tên Tài Khoản</th>
            <th width="250px">Rank</th>
            <th width="250px">Nghề Nghiệp</th>
            <th >Tỉnh/Thành Phố</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($data_user)&&$data_user[0]['account_id']!='')
        @foreach($data_user as $index=>$row)
        <tr>
            <td>{{$index+1}}</td>
            <td refer-id='account_id'>{{$row['account_id']}}</td>
            <td ><span>{{$row['account_nm']}}</span></td>
            <td class="text-left"><span>{{$row['rank']}}</span></td>
            <td class="text-left"><span>{{$row['job']}}</span></td>
            <td class="td-1-line text-left">{{$row['city']}}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
