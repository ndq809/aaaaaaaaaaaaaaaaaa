<div class="panel-header padding-10-l">
    <h5 class="panel-title">Danh Sách Nhóm</h5>
</div>
<div class="panel-content padding-10-l">
    <div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-focus">
            <thead>
                <tr>
                    <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                    <th width="50px">ID</th>
                    <th width="100px">Mã Nhóm</th>
                    <th width="150px">Loại Danh Mục</th>
                    <th width="250px">Tên Danh Mục</th>
                    <th>Tên Nhóm</th>
                    <th width="80px">Số Bài Viết</th>
                    <th width="120px">Thao Tác</th>
                    <th width="80px">Chỉnh Sửa?</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data)&&$data[0][0]['group_id'] != '')
                @foreach($data[0] as $index => $row)
                <tr>
                    <td><input type="checkbox" name="" class="sub-checkbox"></td>
                    <td>{{$index+1}}</td>
                    <td refer-id='group_id'>{{$row['group_id']}}</td>
                    <td refer-id='catalogue_div'><span>{{$row['catalogue_div']}}</span></td>
                    <td refer-id='catalogue_nm' class="text-left"><span>{{$row['catalogue_nm']}}</span></td>
                    <td refer-id='group_nm' class="text-left"><span>{{$row['group_nm']}}</span></td>
                    <td >{{$row['post_count']}}</td>
                    <td><a href="/master/writing/w002" target="_blank"><span class="fa fa-plus" style="padding-bottom: 2px;"></span> Thêm bài viết</a></td>
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
