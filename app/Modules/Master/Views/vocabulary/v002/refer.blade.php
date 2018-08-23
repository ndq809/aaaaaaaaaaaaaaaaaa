<div class="col-sm-3 no-padding-right">
    <div class="form-group">
        <label>Mã Từ Vựng</label>
        <div class="input-group">
            <input type="text" id="vocabulary_id" name="" class="form-control input-sm width-50 submit-item" placeholder="Mã từ vựng" value="{{isset($data[1])?$data[1][0]['vocabulary_id']:''}}">
            <input type="text" id="vocabulary_dtl_id" name="" class="form-control input-sm width-50 submit-item" placeholder="Mã Phiên Bản" value="{{isset($data[1])?$data[1][0]['vocabulary_dtl_id']:''}}">
        </div>
    </div>
</div>
<div class="col-sm-3 no-padding-right">
    <div class="form-group">
        <label>Tên Từ Vựng</label>
        <div class="input-group">
            <input type="text" name="" id="vocabulary_nm" class="form-control input-sm submit-item required" placeholder="Phiên âm từ vựng" value="{{isset($data[1])?$data[1][0]['vocabulary_nm']:''}}">
        </div>
    </div>
</div>
<div class="col-sm-3 no-padding-right">
    <div class="form-group">
        <label>Loại Từ Vựng</label>
        <select id="vocabulary_div" class="submit-item required allow-selectize">
            @foreach($data[0] as $item)
                @if(isset($data[1])&&$data[1][0]['vocabulary_div']==$item['number_id'])
                    <option value="{{$item['number_id']}}" selected="">{{$item['content']}}</option>
                @else
                    <option value="{{$item['number_id']}}">{{$item['content']}}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-3 no-padding-right">
    <div class="form-group">
        <label>Phiên Âm</label>
        <div class="input-group">
            <input type="text" id="spelling" class="form-control input-sm submit-item required" placeholder="Phiên âm từ vựng" value="{{isset($data[1])?$data[1][0]['spelling']:''}}">
        </div>
    </div>
</div>
<div class="col-sm-12 no-padding-right">
    <div class="form-group">
        <label>Nghĩa</label>
        <div class="input-group">
            <input type="text" id="mean" class="form-control input-sm submit-item required" placeholder="Nghĩa của từ vựng" value="{{isset($data[1])?$data[1][0]['mean']:''}}">
        </div>
    </div>
</div>
<div class="vocabulary-wrap">
    <div class="no-padding vocabulary-block">
        <div class="col-sm-12 no-padding">
            <div class="form-group old-item">
                <label>Hình Ảnh</label>
                <div id="imageContainer" style="background-image: url('{{isset($data[1])?$data[1][0]['image']:''}}');"></div>
            </div>
            <input type="hidden" class="submit-item" name="avarta" id="image" value="{{isset($data[1])?$data[1][0]['image']:''}}">
        </div>
    </div>
    <div class="no-padding infor-block" >
        <div class="col-sm-6 no-padding-right">
            <div class="form-group">
                <label>Giải Thích</label>
                <div class="input-group">
                    <textarea class="form-control input-sm submit-item" id="explain" placeholder="Giải thích về từ vựng" rows="4">{{isset($data[1])?$data[1][0]['explain']:''}}</textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-6 no-padding-right">
            <div class="form-group">
                <label>Ghi Chú</label>
                <div class="input-group">
                    <textarea id="remark" class="form-control input-sm submit-item" placeholder="Ghi chú của nhân viên này" rows="4">{{isset($data[1])?$data[1][0]['remark']:''}}</textarea>
                </div>
            </div>
        </div>
        @if(isset($data[1])&&$data[1][0]['audio']!='')
        <div class="col-sm-6 no-padding-right">
            <div class="form-group">
                <label>Âm Thanh Cũ</label>
                <div class="input-group">
                    <input type="file" id="" class="old-input-audio hidden" placeholder="ID của từ vựng" value="{{isset($data[1])?$data[1][0]['audio']:''}}">
                </div>
            </div>
        </div>
        @endif
        <form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="">
            <div class="col-sm-6 no-padding-right">
                <div class="form-group">
                    <label>Âm Thanh</label>
                    <div class="input-group">
                        <input type="file" id="audio" name="post_audio" class="input-audio" placeholder="ID của từ vựng">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="col-sm-12 no-padding-right">
   <div class="form-group table-fixed-width" min-width="1024px">
    <label>Danh Sách Ví Dụ</label>
    <table class="table table-bordered table-input submit-table-body">
       <thead>
           <th width="50px"><a id="btn-new-body" class="btn-add"><span class="fa fa-plus"></span></a></th>
           <th width="100px"></th>
           <th></th>
           <th width="50px">Xóa</th>
       </thead>
        <tbody class="hidden">
            <tr>
                <td rowspan="2">1</td>
                <td style="font-weight: bold;">Câu Tiếng Anh</td>
                <td><input type="text" name="" refer-id='language1_content' class="form-control input-sm"></td>
                <td rowspan="2"><button type="button" class="btn-danger delete-tr-body"><span class="fa fa-close"></span></button></td>
            </tr>
           <tr>
                <td style="font-weight: bold;">Dịch Nghĩa</td>
                <td><input type="text" name="" refer-id='language2_content' class="form-control input-sm"></td>
            </tr>
        </tbody>
        @if(isset($data[2]))
            @foreach($data[2] as $index=>$value)
        <tbody>
            <tr>
                <td rowspan="2">{{$index+1}}</td>
                <td style="font-weight: bold;">Câu Tiếng Anh</td>
                <td><input type="text" name="" refer-id='language1_content' class="form-control input-sm" value="{{$value['language1_content']}}"></td>
                <td rowspan="2" ><button type="button" class="btn-danger delete-tr-body"><span class="fa fa-close"></span></button></td>
            </tr>
           <tr>
                <td style="font-weight: bold;">Dịch Nghĩa</td>
                <td><input type="text" name="" refer-id='language2_content' class="form-control input-sm" value="{{$value['language2_content']}}"></td>
            </tr>
        </tbody>
            @endforeach
        @endif   
    </table>
  </div>
</div>

