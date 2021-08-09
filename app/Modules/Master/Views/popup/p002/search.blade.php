<div class="panel-header padding-10-l">
    <h5 class="panel-title">Danh Sách Nhân Viên</h5>
</div>
<div class="panel-content padding-10-l">
    <div class="table-fixed-width no-padding-left" min-width='700px'>
        <table class="table table-hover table-bordered table-refer">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mã Nhân Viên</th>
                    <th>Họ Và Tên</th>
                    <th>Email</th>
                    <th>Số Điện Thoại</th>
                    <th>Giới Tính</th>
                    <th>Ngày Sinh</th>
                    <th>Bộ Phận</th>
                    <th>Loại Nhân Viên</th>
                    <th>Ghi Chú</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data)&&$data[0][0]['employee_id'] != '')
                @foreach($data[0] as $index => $row)
                <tr>
                    <td>{{$index+1}}</td>
                    <td class="refer-item">{{$row['employee_id']}}</td>
                    <td class="refer-item">{{$row['name']}}</td>
                    <td >{{$row['email']}}</td>
                    <td >{{$row['cellphone']}}</td>
                    <td >{{$row['sex']}}</td>
                    <td >{{$row['birth_date']}}</td>
                    <td  class="td-1-line">{{$row['department_nm']}}</td>
                    <td  class="td-1-line">{{$row['employee_div_nm']}}</td>
                    <td >{{$row['remark']}}</td>
                </tr>
                @endforeach
                 @else
                 <tr>
                    @if(!isset($data))
                        <td colspan="11">Xin nhập điều kiện tìm kiếm</td>
                    @else
                        <td colspan="11">Không có bản ghi nào khớp với điều kiệm tìm kiếm</td>
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
