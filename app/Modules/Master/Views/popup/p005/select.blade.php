<div class="table-fixed-width no-padding-left" min-width='700px'>
    <table class="table table-hover table-bordered table-refer table-preview table-custom">
        <thead>
            <tr>
                <th width="40px">Xóa</th>
                <th width="100px">Mã Bài Viết</th>
                <th width="150px">Loại Danh Mục</th>
                <th width="250px">Tên Danh Mục</th>
                <th width="250px">Tên Nhóm</th>
                <th >Tiêu Đề Bài Viết</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($data)&&$data[0]['post_id'] != '')
            @foreach($data as $index => $row)
            <tr>
                <td><button class="btn btn-danger btn-delete-row" type="button"><span class="fa fa-close"></span></button></td>
                <td refer-id='post_id'>{{$row['post_id']}}</td>
                <td refer-id='catalogue_div'><span>{{$row['catalogue_div']}}</span></td>
                <td refer-id='catalogue_nm' class="text-left"><span>{{$row['catalogue_nm']}}</span></td>
                <td refer-id='group_nm' class="text-left"><span>{{$row['group_nm']}}</span></td>
                <td refer-id='post_title' class="td-1-line text-left">{{$row['post_title']}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
