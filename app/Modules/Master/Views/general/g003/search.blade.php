<div class="panel-header padding-10-l">
    <h5 class="panel-title">Danh Sách Danh Mục</h5>
</div>
<div class="panel-content padding-10-l">
    <div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-focus">
            <thead>
                <tr>
                    <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                    <th width="50px">ID</th>
                    <th width="100px">Mã Danh Mục</th>
                    <th width="150px">Loại Danh Mục</th>
                    <th>Tên Danh Mục</th>
                    <th width="100px">Số Nhóm</th>
                    <th width="80px">Chỉnh Sửa?</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data)&&$data[0][0]['catalogue_id'] != '')
                @foreach($data[0] as $index => $row)
                <tr>
                    <td><input type="checkbox" name="" class="sub-checkbox"></td>
                    <td>{{$index+1}}</td>
                    <td refer-id='catalogue_id'>{{$row['catalogue_id']}}</td>
                    <td refer-id='catalogue_div'>{{$row['catalogue_div']}}</td>
                    <td refer-id='catalogue_nm' class="text-left">{{$row['catalogue_nm']}}</td>
                    <td>{{$row['group_count']}}</td>
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
