<div class="col-lg-9 col-md-12 no-padding change-content">

<div class="temp hidden" style="height:27px"></div>
<div class="right-header col-md-12 no-padding">
    <div class="col-md-12 no-padding">
        <table class="full-width">
            <tbody>
                <tr>
                    <td class="text-center"><h5><i class="fa fa-language"></i> CÔNG CỤ DỊCH THUẬT</h5></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<input type="hidden" id="post_id" class="submit-item" name="" value="">
<div class="col-md-6 col-xs-12 right-tab" >
    <div class="form-group">
        <label class="inline-block">Tiêu Đề Của Bài Dịch</label>
        <textarea class="form-control input-sm submit-item" rows="1" id="post_title" placeholder="Tiêu đề của bài dịch"></textarea>
    </div>
</div>
<div class="col-md-6 col-xs-12 right-tab" >
    <div class="form-group">
        <label class="inline-block">Tag Của Bài Dịch</label>
        <select class="tag-selectize submit-item post_tag_new selectized" style="opacity: 0" id="post_tag" multiple="multiple">
            @if(isset($data_default[1])&&$data_default[1][0]['tag_id'] != '')
            @foreach($data_default[1] as $item)
                <option value="{{$item['tag_id']}}" data-data ="{{json_encode( $item)}}">{{$item['tag_nm']}}</option>
            @endforeach
            @endif
        </select>
    </div>
</div>
 <div class="col-md-6 col-xs-12 right-tab" >
    <div class="form-group">
        <label class="inline-block">Nội Dung Tiếng Anh</label>
        <button class="btn btn-sm btn-default inline-block btn-fix" id="btn-clear" title="Xóa dữ liệu trên màn hình để nhập bản dịch mới">Làm mới</button>
        <button class="btn btn-sm btn-default inline-block btn-fix visible-sm visible-xs btn-extend" style="right: 75px">Thu nhỏ</button>
        <div class="default-background">
            <textarea class="form-control input-sm" id="en_text" rows="20" placeholder="Copy nội dung cần dịch của bạn vào"></textarea>
        </div>
    </div>
</div>
 <div class="col-md-6 col-xs-12 right-tab" >
    <div class="form-group">
        <label class="inline-block">Nội Dung Đã Dịch</label>
        <button class="btn btn-sm btn-default inline-block btn-fix visible-sm visible-xs btn-extend" title="">Thu nhỏ</button>
        <div class="default-background">
        <textarea  autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="form-control input-sm" id="vi_text" rows="20" placeholder="Nội dung đã được dịch"></textarea>
    </div>
    </div>
</div>
<div class="col-md-6 col-xs-12 right-tab margin-top" >
    <div class="form-group">
        <label class="inline-block">Câu Cần Dịch</label>
        <button class="btn btn-sm btn-default inline-block btn-fix btn-delete" title="Xóa câu này trên nội dung" tabindex="-1">Xóa câu</button>
        <button class="btn btn-sm btn-default inline-block btn-fix btn-merge" title="Nối câu này với cầu trước nó thành 1 câu" tabindex="-1">Nối câu</button>
        <textarea class="form-control input-sm" id="en_sentence" rows="5" placeholder="Câu đang dịch (bạn có thể ngắt câu thành 2 câu ngắn hơn bằng phím enter tại 1 vị trí bất kỳ)"></textarea>
    </div>
    <div class="form-group btn-move margin-top" style="height: 31px">
        <button class="btn btn-sm btn-primary float-left" id="btn-prev" tabindex="-1">Câu Trước</button>
        <button class="btn btn-sm btn-primary float-right" id="btn-next" tabindex="-1">Câu Tiếp</button>
    </div>
    <div class="form-group">
        <label>Phân Tách Câu (Mang tính tương đối)</label>
        <div class="analysis" type = "1">
            <span>Danh Từ: </span>
            <span class="list"></span>
        </div>
        <div class="analysis" type = "2">
            <span>Động Từ: </span>
            <span class="list"></span>
        </div>
        <div class="analysis" type = "3">
            <span>Tính Từ: </span>
            <span class="list"></span>
        </div>
    </div>
</div>
<div class="col-md-6 col-xs-12 right-tab margin-top" >
    <div class="form-group">
        <label class="inline-block">Nhập Bản Dịch</label>
        <button class="btn btn-sm btn-default inline-block btn-fix btn-delete" title="Xóa câu này trên nội dung" tabindex="-1">Xóa câu</button>
        <button class="btn btn-sm btn-default inline-block btn-fix btn-merge" title="Nối câu này với cầu trước nó thành 1 câu" tabindex="-1">Nối câu</button>
        <textarea  autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="form-control input-sm" id="vi_sentence" rows="5" placeholder="Nội dung đang dịch (bạn có thể ngắt câu thành 2 câu ngắn hơn bằng phím enter tại 1 vị trí bất kỳ)"></textarea>
    </div>
    <div class="form-group">
        <label class="inline-block">Bản Dịch Tự Động</label>
        <label class="checkbox-inline float-right"><input type="checkbox" id="auto-fill" checked="">Tự động thêm vào ô dịch</label>
        <textarea  autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="form-control input-sm" id="auto_trans" rows="5" placeholder="Bản dịch tự động từ hệ thống (dùng để tham khảo)" disabled=""></textarea>
    </div>
    @if($raw_data[0][0]['btn-forget']==1)
    <div class="form-group margin-top btn-group">
        <button class="btn btn-sm btn-info {{isset($post_id)?'btn-popup':'btn-popup'}}" popup-id="popup-box5">Lưu Lại</button>
        <button class="btn btn-sm btn-success" id="btn-share">Chia Sẻ</button>
        <button class="btn btn-sm btn-danger" id="btn-delete">Xóa Bài Viết</button>
    </div>
    @endif
</div>
</div>