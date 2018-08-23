<div class="panel-header padding-10-l">
    <h5 class="panel-title">Danh Sách Nhân Viên</h5>
</div>
<div class="panel-content padding-10-l">
    <div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-focus">
           <thead>
                <tr>
                    <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                    <th>ID</th>
                    <th>Mã Tài Khoản</th>
                    <th>Tên Tài Khoản</th>
                    <th>Nhân Viên</th>
                    <th>Loại Hệ Thống</th>
                    <th>Loại Tài Khoản</th>
                    <th>Ghi Chú</th>
                    <th width="80px">Chỉnh Sửa?</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data)&&$data[0][0]['account_nm'] != '')
                @foreach($data[0] as $index => $row)
                <tr>
                    <td><input type="checkbox" name="" class="sub-checkbox"></td>
                    <td>{{$index+1}}</td>
                    <td refer-id='account_id'>{{$row['account_id']}}</td>
                    <td refer-id='account_nm'><span>{{$row['account_nm']}}</span></td>
                    <td refer-id='employee_id'><span>{{$row['employee_nm']}}</span></td>
                    <td refer-id='system_div'><span>{{$row['system_div']}}</span></td>
                    <td refer-id='account_div'><span>{{$row['account_div']}}</span></td>
                    <td refer-id='remark'>{{$row['remark']}}</td>
                    <td class="edit-flag">Không</td>
                </tr>
                @endforeach
                 @else
                 <tr>
                    @if(!isset($data))
                        <td colspan="13">Xin nhập điều kiện tìm kiếm</td>
                    @else
                        <td colspan="13">Không có bản ghi nào khớp với điều kiệm tìm kiếm</td>
                    @endif
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    @if(!isset($paging))
        @php
            $paging=array('page' => 6,'pagesize' => 15,'totalRecord' => 0,'pageMax'=>10 )
        @endphp
    @endif
    @if($paging['totalRecord'] != 0)
        <div class=" text-center no-padding-left">
            {!!Paging::show($paging,0)!!}
        </div>
    @endif
</div>
