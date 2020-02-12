<div class="form-group table-fixed-width" min-width="768px">
    <label>Phân Tách Bài Nghe</label>
    <table class="table table-bordered table-input listen-table-body">
       <thead>
           <th width="50px"><a id="btn-new-body" class="btn-add"><span class="fa fa-plus"></span></a></th>
           <th>Nội dung đoạn nghe</th>
           <th width="100px">TG bắt đầu</th>
           <th width="100px">TG kết thúc</th>
           <th width="50px">Xóa</th>
       </thead>
        <tbody>
            <tr class="hidden">
                <td>1</td>
                <td><input type="text" name="" refer-id='listen_cut_content' class="form-control input-sm"></td>
                <td><input type="text" name="" refer-id='start_time' class="form-control input-sm"></td>
                <td><input type="text" name="" refer-id='end_time' class="form-control input-sm"></td>
                <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
            </tr>
        @if(isset($data[6]))
            @foreach($data[6] as $index=>$value)
                <tr>
                    <td>{{$index+1}}</td>
                    <td><input type="text" name="" refer-id='listen_cut_content' class="form-control input-sm" value="{{$value['listen_cut_content']}}"></td>
                    <td><input type="text" name="" refer-id='start_time' class="form-control input-sm" value="{{$value['listen_cut_start']}}"></td>
                    <td><input type="text" name="" refer-id='end_time' class="form-control input-sm" value="{{$value['listen_cut_end']}}"></td>
                    <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                </tr>
            @endforeach
        @endif   
        </tbody>
    </table>
</div>
