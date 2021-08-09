<div class="col-xs-12 no-padding">
    <div class="col-lg-12 title-bar">
        <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-image">Hình ảnh</label>
        <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-audio">Âm thanh</label>
        <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-engword">Từ tiếng anh</label>
        <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-spell">Phiên âm</label>
        <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-div">Loại từ</label>
        <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-mean">Nghĩa</label>
    </div>
</div>
<div class="col-xs-12 no-padding slider-wrap">
    <div class="choose_slider vocal-image">
        <div class="choose_slider_items">
            <ul id="mySlider1">
                @if(isset($data)&&$data[2][0]['id'] != '')
                    @foreach($data[2] as $index => $row)
                        <li class="current_item"><a> <img src="{{$row['del_flg']==0&&$row['image']!=''?$row['image']:'/web-content/images/plugin-icon/no-image.jpg'}}" /></a></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
<div class="col-xs-12 no-padding hint-text">
    <h6 class="hint">Bạn có thể click vào hình ảnh để nghe đọc lại từ vựng</h6>
    <a id="btn-relationship"><span class="fa fa-sitemap"></span> Xem Họ Từ</a>
</div>
<div class="input-wrap col-xs-12 no-padding margin-top hidden">
    <input type="text" name="hidden" class="form-control input-sm vocal-engword-input text-center" value="" placeholder="Nhập từ hiện tại kết thúc bằng dấu # để kiểm tra">
    <i class="fa fa-check input-icon hidden"></i>
</div>
@if(isset($data)&&$data[2][0]['id'] != '')
    @foreach($data[2] as $index => $row)
        @if($row['del_flg']==0)
        <div class="col-xs-12 no-padding vocabulary-box hidden" target-id="{{$row['row_id']}}">
            <input type="text" name="" class="form-control input-sm vocal-engword" value="{{$row['vocabulary_nm']}}" disabled="">
            <input type="text" name="" class="form-control input-sm vocal-spell" value="{{$row['spelling']}}" disabled="">
            <input type="text" name="" class="form-control input-sm vocal-div" value="{{$row['vocabulary_div_nm']}}" disabled="">
            <textarea class="form-control input-sm vocal-mean" disabled="" rows="2">{{$row['mean']}}</textarea>
            <audio class="sound1 vocal-audio" src="{{$row['audio']}}"></audio>
            @if(isset($data)&&$data[4][0]['src_id'] != '')
            <div class="form-group relationship">
                <label>Những từ liên quan</label>
                <div class="analysis" type = "1">
                    <span>Từ đồng nghĩa: </span>
                    <span class="list">
                        @foreach($data[4] as $index1 => $row1)
                            @if($row1['src_id']==$row['id']&&$row1['relationship_div']==1)
                            <a target="_blank" href="/dictionary?v={{$row1['target_id']}}" title="{{$row1['mean']}}">{{$row1['vocabulary_nm']}} |</a>
                            @endif
                        @endforeach
                    </span>
                </div>
                <div class="analysis" type = "2">
                    <span>Từ trái nghĩa: </span>
                    <span class="list">
                        @foreach($data[4] as $index1 => $row1)
                            @if($row1['src_id']==$row['id']&&$row1['relationship_div']==2)
                            <a target="_blank" href="/dictionary?v={{$row1['target_id']}}" title="{{$row1['mean']}}">{{$row1['vocabulary_nm']}} |</a>
                            @endif
                        @endforeach
                    </span>
                </div>
            </div>
            @endif
        </div>
        @else
            @include('not_found',array('class'=>'vocabulary-box custom','target_id'=>$row['row_id'],'no_image'=>'1'))
        @endif
    @endforeach
@endif
<div class="col-xs-12 no-padding margin-top example-content">
    <div class="right-header">
        <h5 class="inline-block"><i class="glyphicon glyphicon-star-empty"></i> Ví Dụ Thực Tế</h5>
        <select class="select-header" id="exam-order">
            <option value="0">Tự động</option>
            <option value="1">Mới nhất</option>
            <option value="2">Đánh giá</option>
        </select>
    </div>
    <div class="panel-group" id="example-list">
        @include('exam',array('data'=>isset($data[0])?$data[0]:array()))
      </div> 
    <div class="paging-list">
       @include('paging_content')
    </div>
</div>