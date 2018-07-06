<div class="panel-header padding-10-l">
    <h5 class="panel-title">Chi Tiết Đối Tượng</h5>
</div>
<div class="panel-content padding-10-l">
    <div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-focus submit-table">
            <thead>
                 <tr>
                    <th><a id="btn-new-row" class="btn-add"><span class="fa fa-plus"></span></a></th>
                    <th width="150px">Mã Hạng Mục</th>
                    <th>Tên Hạng Mục</th>
                    <th width="100px">Ghi chú 1 (số)</th>
                    <th width="100px">Ghi chú 2 (số)</th>
                    <th width="100px">Ghi chú 3 (số)</th>
                    <th>Ghi Chú 1 (chữ)</th>
                    <th>Ghi Chú 2 (chữ)</th>
                    <th>Ghi Chú 3 (chữ)</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hidden">
                    <td></td>
                    <td><input type="text" id="number_id" name="" class="form-control input-sm required number_id numberic" value="" decimal='2' negative='1'></td>
                    <td><input type="text" id="content" name="" class="form-control input-sm content" value=""></td>
                    <td><input type="text" id="num_remark1" name="" class="form-control input-sm num_remark1" value=""></td>
                    <td><input type="text" id="num_remark2" name="" class="form-control input-sm num_remark2" value=""></td>
                    <td><input type="text" id="num_remark3" name="" class="form-control input-sm num_remark3" value=""></td>
                    <td><input type="text" id="text_remark1" name="" class="form-control input-sm text_remark1" value=""></td>
                    <td><input type="text" id="text_remark2" name="" class="form-control input-sm text_remark2" value=""></td>
                    <td><input type="text" id="text_remark3" name="" class="form-control input-sm text_remark3" value=""></td>
                    <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                </tr>
                @if(isset($data)&&$data[0][0]['name_div'] != '')
                @foreach($data[0] as $index => $row)
                <tr>
                    <td>{{$index+1}}</td>
                    <td><input type="text" id="number_id" name="" class="form-control input-sm required number_id numberic" value="{{$row['number_id']}}"></td>
                    <td><input type="text" id="content" name="" class="form-control input-sm content" value="{{$row['content']}}"></td>
                    <td><input type="text" id="num_remark1" name="" class="form-control input-sm num_remark1" value="{{$row['num_remark1']}}"></td>
                    <td><input type="text" id="num_remark2" name="" class="form-control input-sm num_remark2" value="{{$row['num_remark2']}}"></td>
                    <td><input type="text" id="num_remark3" name="" class="form-control input-sm num_remark3" value="{{$row['num_remark3']}}"></td>
                    <td><input type="text" id="text_remark1" name="" class="form-control input-sm text_remark1" value="{{$row['text_remark1']}}"></td>
                    <td><input type="text" id="text_remark2" name="" class="form-control input-sm text_remark2" value="{{$row['text_remark2']}}"></td>
                    <td><input type="text" id="text_remark3" name="" class="form-control input-sm text_remark3" value="{{$row['text_remark3']}}"></td>
                    <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                </tr>
                @endforeach
                 @else
                 <tr>
                    <td>1</td>
                    <td><input type="text" id="number_id" name="" class="form-control input-sm required number_id numberic" value=""></td>
                    <td><input type="text" id="content" name="" class="form-control input-sm content" value=""></td>
                    <td><input type="text" id="num_remark1" name="" class="form-control input-sm num_remark1" value=""></td>
                    <td><input type="text" id="num_remark2" name="" class="form-control input-sm num_remark2" value=""></td>
                    <td><input type="text" id="num_remark3" name="" class="form-control input-sm num_remark3" value=""></td>
                    <td><input type="text" id="text_remark1" name="" class="form-control input-sm text_remark1" value=""></td>
                    <td><input type="text" id="text_remark2" name="" class="form-control input-sm text_remark2" value=""></td>
                    <td><input type="text" id="text_remark3" name="" class="form-control input-sm text_remark3" value=""></td>
                    <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
