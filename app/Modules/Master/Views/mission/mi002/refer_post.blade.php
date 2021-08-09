<table class="table table-bordered table-input submit-table">
    <thead>
        <tr>
            <th width="40px">STT</th>
            <th width="100px">Mã Bài Viết</th>
            <th width="150px">Loại Danh Mục</th>
            <th width="250px">Tên Danh Mục</th>
            <th width="250px">Tên Nhóm</th>
            <th >Tiêu Đề Bài Viết</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($data_post)&&$data_post[0]['post_id']!='')
        @foreach($data_post as $index=>$row)
        <tr>
            <td>{{$index+1}}</td>
            <td class="hidden" refer-id='id'>{{$row['post_id']}}</td>
            <td refer-id='post_id'>{{$row['post_id']}}</td>
            <td refer_id='catalogue_div'><span>{{$row['catalogue_div']}}</span></td>
            <td refer_id='catalogue_nm' class="text-left"><span>{{$row['catalogue_nm']}}</span></td>
            <td refer_id='group_nm' class="text-left"><span>{{$row['group_nm']}}</span></td>
            <td refer_id='post_title' class="td-1-line text-left">{{$row['post_title']}}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
<input type="hidden" class="total_unit" name="" value="{{isset($data_post)?count($data_post):'0'}}">
