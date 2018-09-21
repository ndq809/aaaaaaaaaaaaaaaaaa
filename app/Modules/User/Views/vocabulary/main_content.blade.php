<div class="col-xs-12 no-padding">
    <div class="col-lg-12 title-bar">
        <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-image">Hình ảnh</label>
        <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-audio">Âm thanh</label>
        <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-engword">Từ tiếng anh</label>
        <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-spell">Phiên âm</label>
        <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-div">Loại từ</label>
        <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-mean">Nghĩa</label>
        <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-explain">Giải thích</label>
    </div>
</div>
<div class="col-xs-12 no-padding slider-wrap">
    <div class="choose_slider vocal-image">
        <div class="choose_slider_items">
            <ul id="mySlider1">
                @if(isset($data)&&$data[2][0]['id'] != '')
                    @foreach($data[2] as $index => $row)
                        <li class="current_item"><a> <img
                                src="{{$row['image']}}" />
                        </a></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
<div class="col-xs-12 no-padding hint-text">
    <h6>Bạn có thể click vào hình ảnh để nghe đọc lại từ vựng</h6>
    <a id="btn-relationship"><span class="fa fa-sitemap"></span> Xem Họ Từ</a>
</div>
<div class="col-xs-12 no-padding">
    <button class="btn btn-sm btn-primary" id="btn_prev">Trước</button>
    <button class="btn btn-sm btn-primary" id="btn_next" style="float: right;">Tiếp</button>
</div>
@if(isset($data)&&$data[2][0]['id'] != '')
    @foreach($data[2] as $index => $row)
        <div class="col-xs-12 no-padding vocabulary-box hidden" target-id="{{$row['row_id']}}">
            <input type="text" name="" class="form-control input-sm vocal-engword" value="{{$row['vocabulary_nm']}}" disabled="">
            <input type="text" name="" class="form-control input-sm vocal-spell" value="/{{$row['spelling']}}/" disabled="">
            <input type="text" name="" class="form-control input-sm vocal-div" value="{{$row['vocabulary_div']}}" disabled="">
            <textarea class="form-control input-sm vocal-mean" disabled="" rows="2">{{$row['mean']}}</textarea>
            <textarea class="form-control input-sm vocal-explain" disabled="" rows="2">{{$row['explain']}}</textarea>
            <audio class="sound1" src="{{$row['audio']}}"></audio>
        </div>
    @endforeach
@endif
<div class="col-xs-12 no-padding margin-top">
    <div class="right-header">
        <h5 class="inline-block"><i class="glyphicon glyphicon-star-empty"></i> Ví Dụ Thực Tế</h5>
        <select class="select-header" id="exam-order">
            <option value="0">Tự động</option>
            <option value="1">Mới nhất</option>
            <option value="2">Đánh giá</option>
        </select>
    </div>
    <div class="panel-group" id="example-list">
        @include('exam_content')
      </div> 
    <div class="paging-list">
       @include('paging_content')
    </div>
</div>