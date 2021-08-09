<div class="table-fixed-width no-padding-left" min-width='700px'>
    <table class="table table-hover table-bordered table-preview table-custom">
        <thead>
            <tr>
                <th width="40px">Chọn</th>
                <th width="100px">Mã Bài Viết</th>
                <th width="150px">Loại Danh Mục</th>
                <th width="250px">Tên Danh Mục</th>
                <th width="250px">Tên Nhóm</th>
                <th >Tiêu Đề Bài Viết</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($data)&&$data[0][0]['post_id'] != '')
            @foreach($data[0] as $index => $row)
            <tr>
                <td><button class="btn btn-primary full-width btn-add" type="button"><span class="fa fa-arrow-down"></span></button></td>
                    <td refer-id='post_id'>{{$row['post_id']}}</td>
                    <td refer-id='catalogue_div'><span>{{$row['catalogue_div']}}</span></td>
                    <td refer-id='catalogue_nm' class="text-left"><span>{{$row['catalogue_nm']}}</span></td>
                    <td refer-id='group_nm' class="text-left"><span>{{$row['group_nm']}}</span></td>
                    <td refer-id='post_title' class="td-1-line text-left">{{$row['post_title']}}</td>
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
