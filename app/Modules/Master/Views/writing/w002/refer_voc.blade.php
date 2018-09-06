<div class="form-group table-fixed-width" min-width="1024px">
    <label>Danh Sách Từ Vựng</label>
    <table class="table table-bordered table-input submit-table">
        <thead>
            <tr>
                <th width="70px" class="transform-content" transform-div='-1'>Nhập tay</th>
                <th width="50px"><a id="btn-new-row" class="btn-add"><span class="fa fa-plus"></span></a></th>
                <th width="70px"></th>
                <th width="50px"></th>
                <th>Loại Từ</th>
                <th width="200px">Tên</th>
                <th width="200px">Phiên Âm</th>
                <th>Nghĩa</th>
                <th>Giải Thích (Tiếng Anh)</th>
                <th width="50px">Xóa</th>
            </tr>
        </thead>
        <tbody>
            <tr class="hidden">
                <td class="transform-content" transform-div='-1'><input type="checkbox" class="edit-confirm" name="" refer-id="edit-confirm"></td>
                <td></td>
                <td><a type="button" href="/master/popup/p003" class="btn btn-sm btn-primary full-width btn-popup">Tìm kiếm</a></td>
                <td><button type="button" class="btn btn-sm btn-primary full-width btn-copy"><span class="fa fa-copy"></span></button></td>
                <td class="hidden"><input type="text" name="" refer-id="vocabulary_code" class="vocabulary_code" value=""></td>
                <td>
                    <select class="form-control input-sm vocabulary_div" disabled="" refer-id="vocabulary_div">
                        @foreach($data[1] as $item)
                            <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" refer-id="vocabulary_nm" name="" class="form-control input-sm vocabulary_nm" value="" disabled=""></td>
                <td><input type="text" refer-id="spelling" name="" class="form-control input-sm spelling" value="" disabled=""></td>
                <td><input type="text" refer-id="mean" name="" class="form-control input-sm mean" value="" disabled=""></td>
                <td><input type="text" refer-id="explain" name="" class="form-control input-sm explain" value="" disabled=""></td>
                <td><button type="button" class="btn btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
            </tr>
            @if(isset($data[2]))
            @foreach($data[2] as $index=>$value)
            <tr>
                <td class="transform-content" transform-div='-1'><input type="checkbox" class="edit-confirm" refer-id="edit-confirm" name=""></td>
                <td>{{$index+1}}</td>
                <td><a type="button" href="/master/popup/p003" class="btn btn-sm btn-primary full-width btn-popup">Tìm kiếm</a></td>
                <td><button type="button" title="Thêm 1 phiên bản khác của từ đang được chọn khi từ đó không có trong danh sách tìm kiếm và muốn chuyển đổi từ loại,cách dùng...(vd: Game->Gamer)" class="btn btn-primary full-width btn-copy"><span class="fa fa-copy"></span></button></td>
                <td class="hidden"><input type="text" name="" refer-id="vocabulary_code" class="vocabulary_code" value="{{isset($value)?$value['vocabulary_code']:''}}"></td>
                <td>
                    <select class="form-control input-sm vocabulary_div" disabled="" refer-id="vocabulary_div">
                        @foreach($data[1] as $item)
                            @if($item['number_id']==$value['vocabulary_div'])
                                <option value="{{$item['number_id']==0?'':$item['number_id']}}" selected="">{{$item['content']}}</option>
                            @else
                                <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                            @endif
                        @endforeach
                    </select>
                </td>
                <td><input type="text" refer-id="vocabulary_nm" name="" class="form-control input-sm vocabulary_nm" value="{{isset($value)?$value['vocabulary_nm']:''}}" disabled=""></td>
                <td><input type="text" refer-id="spelling" name="" class="form-control input-sm spelling" value="{{isset($value)?$value['spelling']:''}}" disabled=""></td>
                <td><input type="text" refer-id="mean" name="" class="form-control input-sm mean" value="{{isset($value)?$value['mean']:''}}" disabled=""></td>
                <td><input type="text" refer-id="explain" name="" class="form-control input-sm explain" value="{{isset($value)?$value['explain']:''}}" disabled=""></td>
                <td><button type="button" class="btn btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
