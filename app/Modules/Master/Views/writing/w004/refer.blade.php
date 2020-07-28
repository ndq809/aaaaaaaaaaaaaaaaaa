<div class="col-sm-3 no-padding-right">
    <div class="form-group col-xs-12 no-padding">
        <label>Số Hiệu Bài Viết</label>
        <div class="input-group" style="max-width: 200px">
          <span class="input-group-btn">
            <button class="btn btn-primary btn-sm btn-prev" type="button"><i class="fa fa-angle-double-left"></i></button>
          </span>
          <input type="text" name="" id="block_no" class="form-control input-sm text-center numberic" placeholder="STT của bài viết" value="{{isset($index)?$index:''}}" maxlength="10" >
          <span class="input-group-btn">
            <button class="btn btn-primary btn-sm btn-next" type="button"><i class="fa fa-angle-double-right"></i></button>
          </span>
        </div><!-- /input-group -->
    </div>
</div>
<div class="col-xs-12"></div>
<div class="col-sm-6 no-padding-right transform-content" transform-div='1,2,3,4,5,11'>
    <div class="form-group">
        <label>Tiêu Đề Tiếng Anh</label>
        <input type="text" class="submit-item input-sm form-control" id="en_title" name="" value="{{isset($result)?$result['title']:''}}">
    </div>
</div>
<div class="col-sm-6 no-padding-right transform-content" transform-div='1,2,3,4,5,11'>
    <div class="form-group">
        <label>Tiêu Đề Đã Dịch</label>
        <input type="text" class="submit-item input-sm form-control" id="vi_title" name="">
    </div>
</div>
<div class="col-sm-6 no-padding-right transform-content" transform-div='1,2,3,4,5,11'>
    <div class="form-group">
        <label>Nội Dung Tiếng Anh</label>
        <textarea autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="form-control" id="en_content" rows="20">{{isset($result)?$result['en_content']:''}}</textarea>
    </div>
</div>
<div class="col-sm-6 no-padding-right transform-content" transform-div='1,2,3,4,5,11'>
    <div class="form-group">
        <label>Nội Dung Đã Dịch</label>
        <textarea autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="form-control" id="vi_content" rows="20">{{isset($result['vi_content'])?$result['vi_content']:''}}</textarea>
    </div>
</div>
<div class="col-xs-12 no-padding-right">
    <button class="btn btn-sm btn-edit btn-primary form-control" mode='0'>Chỉnh Sửa</button>
</div>
<div class="col-sm-12 no-padding-right">
   <div class="form-group table-fixed-width" min-width="1024px">
    <label>Danh Sách Từ Vựng</label>
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
            @if(isset($result)&&$result['vocabulary'][0]['vocal_en']!='')
                @foreach($result['vocabulary'] as $index => $row)
                <tr>
                    <td class="row-index">{{$index+1}}</td>
                    <td class="hidden"><input type="hidden" name="" refer-id='id' class="form-control input-sm"></td>
                    <td>
                        <select class="form-control input-sm" refer-id='status'>
                            <option value="0">Thêm mới</option>
                            <option value="1">Lấy từ DB</option>
                            <option value="2">Thêm phiên bản mới</option>
                        </select>
                    </td>
                    <td><input type="text" name="" refer-id='word' class="form-control input-sm auto-fill" value="{{$row['vocal_en']}}"></td>
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
                    <td><textarea type="text" name="" refer-id='mean' rows="1" class="form-control input-sm auto-resize">{{$row['vocal_vi']}}</textarea></td>
                    <td class="hidden"><input type="hidden" name="" refer-id='audio' class="form-control input-sm" value=""></td>
                    <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
  </div>
</div>


