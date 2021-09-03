<div class="panel-header padding-10-l">
    <h5 class="panel-title">Danh Sách Bài Viết</h5>
</div>
<div class="panel-content padding-10-l">
    <div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-checkbox">
            <thead>
                <tr>
                    <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                    <th width="50px">ID</th>
                    <th width="100px">Mã Bài Viết</th>
                    <th width="200px">Loại Danh Mục</th>
                    <th width="250px">Tên Danh Mục</th>
                    <th width="250px">Tên Nhóm</th>
                    <th >Tiêu Đề Bài Viết</th>
                    <th width="70px">Trạng Thái</th>
                    <th width="120px">Preview</th>
                    <th width="40px">Sửa</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data)&&$data[0][0]['post_id'] != '')
                @foreach($data[0] as $index => $row)
                <tr>
                    <td><input type="checkbox" name="" class="sub-checkbox"></td>
                    <td>{{$index+1}}</td>
                    <td refer-id='post_id'>{{$row['post_id']}}</td>
                    <td refer-id='catalogue_div'><span>{{$row['catalogue_div']}}</span></td>
                    <td refer-id='catalogue_nm' class="text-left"><span>{{$row['catalogue_nm']}}</span></td>
                    <td refer-id='group_nm' class="text-left"><span>{{$row['group_nm']}}</span></td>
                    <td refer-id='post_title' class="td-1-line text-left">{{$row['post_title']}}</td>
                    <td class="record-div-icon">
                        @if($row['record_div']==0)
                        <i class="fa fa-ban text-danger" title="{{$row['record_div_nm']}}"></i>
                        @elseif($row['record_div']==1)
                        <i class="fa fa-check text-primary" title="{{$row['record_div_nm']}}"></i>
                        @else
                        <i class="fa fa-send text-success" title="{{$row['record_div_nm']}}"></i>
                        @endif
                    </td>
                    <td><a data-toggle="collapse" data-target='#preview{{$index}}' type="button" class="btn-preview-row blank"><span class="fa fa-eye" style="padding-bottom: 2px;"></span> Xem preview</a></td>
                    <td><a href="/master/writing/w002?{{$row['post_id']}}" ><span class="fa fa fa-pencil-square-o fa-lg"></span></a></td>
                </tr>
                <tr><td colspan="100" id='preview{{$index}}' class="collapse preview-box"></td></tr>
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
