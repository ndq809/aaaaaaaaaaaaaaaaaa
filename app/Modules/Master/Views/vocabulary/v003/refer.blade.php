<div class="col-sm-3 no-padding-right">
    <div class="form-group">
        <label>Block No</label>
        <div class="input-group" style="max-width: 200px">
          <span class="input-group-btn">
            <button class="btn btn-primary btn-sm btn-prev" type="button"><i class="fa fa-angle-double-left"></i></button>
          </span>
          <input type="text" name="" id="block_no" class="form-control input-sm submit-item text-center numberic" placeholder="Vị trí bắt đầu import trong file" value="{{isset($_COOKIE['page_readed'])?$_COOKIE['page_readed']:''}}" maxlength="10" >
          <span class="input-group-btn">
            <button class="btn btn-primary btn-sm btn-next" type="button"><i class="fa fa-angle-double-right"></i></button>
          </span>
        </div><!-- /input-group -->
    </div>
</div>
<div class="col-sm-12 no-padding-right">
   <div class="form-group table-fixed-width" min-width="1024px">
    <label>Danh Sách Các Từ Đọc Được</label>
    <table class="table table-bordered table-input submit-table table-hover" id="import-data">
       <thead>
           <th width="50px"><a id="btn-new-row" class="btn-add"><span class="fa fa-plus"></span></a></th>
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
                <td></td>
                <td><textarea type="text" name="" refer-id='word' rows="1" class="form-control input-sm auto-resize"></textarea></td>
                <td><input type="text" name="" refer-id='specialized' class="form-control input-sm" value=""></td>
                <td><input type="text" name="" refer-id='field' class="form-control input-sm" value=""></td>
                <td><input type="text" name="" refer-id='word_div' class="form-control input-sm" value=""></td>
                <td><input type="text" name="" refer-id='spell' class="form-control input-sm" value=""></td>
                <td><textarea type="text" name="" refer-id='mean' rows="1" class="form-control input-sm auto-resize"></textarea></td>
                <td refer-id='audio' class="audio hidden"></td>
                <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
            </tr>
        </tbody>
    </table>
  </div>
</div>


