<div class="col-sm-3 no-padding-right transform-content" transform-div='1,2,3,4,5,11'>
    <div class="form-group">
        <label>Tên Danh Mục</label>
        <select class="submit-item allow-selectize new-allow required" id="catalogue_nm">
            <option value=""></option>
            @foreach($data[0] as $item)
                <option value="{{$item['value']==0?'':$item['value']}}">{{$item['text']}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-3 no-padding-right transform-content" transform-div='1,2,3,4,5,11'>
    <div class="form-group">
        <label>Tên Nhóm</label>
        <select id="group_nm" class="submit-item allow-selectize new-allow required">
                <option value=""></option>
        </select>
    </div>
</div>
<div class="col-sm-12 no-padding-right">
   <div class="form-group table-fixed-width" min-width="1024px">
    <label>Danh Sách Các Từ Đọc Được</label>
    <table class="table table-bordered table-input table-hover submit-table" id="import-data">
       <thead>
           <th width="50px"><a id="btn-new-row" class="btn-add"><span class="fa fa-plus"></span></a></th>
           <th width="180px">Trạng thái</th>
           <th width="400px">Tên Từ Vựng</th>
           <th width="200px">Chuyên Ngành</th>
           <th width="200px">Lĩnh Vực</th>
           <th width="200px">Loại Từ</th>
           <th width="200px">Phiên Âm</th>
           <th>Nghĩa</th>
           <!-- <th width="100px">Âm Thanh</th> -->
           <th width="50px">Xóa</th>
       </thead>
        <tbody>
            <tr class="hidden" id="rowclone">
                <td class="row-index"></td>
                <td class="hidden"><input type="hidden" name="" refer-id='id' class="form-control input-sm"></td>
                <td>
                    <select class="form-control input-sm" refer-id='status'>
                        <option value="0">Thêm mới</option>
                        <option value="1">Lấy từ DB</option>
                        <option value="2">Thêm phiên bản mới</option>
                    </select>
                </td>
                <td><input type="text" name="" refer-id='word' class="form-control input-sm auto-fill"></td>
                <td>
                    <div class="autocomplete-wrap">
                        <input type="text" name="" refer-id='specialized' class="form-control input-sm autocomplete" value="" source="{{implode(',',array_column($data[1],'content'))}}">
                    </div>
                </td>
                <td>
                    <div class="autocomplete-wrap">
                        <input type="text" name="" refer-id='field' class="form-control input-sm autocomplete" value="" source="{{implode(',',array_column($data[2],'content'))}}">
                    </div>
                </td>
                
                <td>
                    <div class="autocomplete-wrap">
                        <input type="text" name="" refer-id='vocabulary_div' class="form-control input-sm autocomplete" value="" source="{{implode(',',array_column($data[3],'content'))}}">
                    </div>
                </td>
                <td><input type="text" name="" refer-id='spelling' class="form-control input-sm" value=""></td>
                <td><textarea type="text" name="" refer-id='mean' rows="1" class="form-control input-sm auto-resize"></textarea></td>
                <td class="hidden"><input type="hidden" name="" refer-id='audio' class="form-control input-sm" value=""></td>
                <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
            </tr>
        </tbody>
    </table>
  </div>
</div>


