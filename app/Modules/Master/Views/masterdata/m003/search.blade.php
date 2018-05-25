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
                    <th>Mã Nhân Viên</th>
                    <th>Họ Và tên Lót</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Số Điện Thoại</th>
                    <th>Giới Tính</th>
                    <th>Ngày Sinh</th>
                    <th>Bộ Phận</th>
                    <th>Loại Nhân Viên</th>
                    <th>Ghi Chú</th>
                    <th width="80px">Chỉnh Sửa?</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data)&&$data[0][0]['employee_id'] != '')
                @foreach($data[0] as $index => $row)
                <tr>
                    <td><input type="checkbox" name="" class="sub-checkbox"></td>
                    <td>{{$index+1}}</td>
                    <td refer-id='emp_id'>{{$row['employee_id']}}</td>
                    <td refer-id='family_nm'>{{$row['family_nm']}}</td>
                    <td refer-id='first_name'>{{$row['first_name']}}</td>
                    <td refer-id='email'>{{$row['email']}}</td>
                    <td refer-id='cellphone'>{{$row['cellphone']}}</td>
                    <td refer-id='sex'>{{$row['sex']}}</td>
                    <td refer-id='birth_date'>{{$row['birth_date']}}</td>
                    <td refer-id='department_id' class="td-1-line">{{$row['department_nm']}}</td>
                    <td refer-id='employee_div' class="td-1-line">{{$row['employee_div_nm']}}</td>
                    <td refer-id='remark'>{{$row['remark']}}</td>
                    <td class="edit-flag">Không</td>
                    <td refer-id='avarta' class="hidden">{{$row['avarta']}}</td>
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
