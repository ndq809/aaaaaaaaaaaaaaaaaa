<div class="col-xs-12 no-padding slider-wrap">
    <div class="choose_slider vocal-image">
        <div class="choose_slider_items">
            <ul id="mySlider1">
                @if(isset($data)&&$data[2][0]['id'] != '')
                    @foreach($data[2] as $index => $row)
                        <li class="current_item" row_id='{{$row["row_id"]}}'><a> <img
                                src="{{$row['del_flg']==0&&$row['image']!=''?$row['image']:'/web-content/images/plugin-icon/no-image.jpg'}}" />
                        </a></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
<div class="col-xs-12 no-padding hint-text">
    <h6>Bạn có thể click vào hình ảnh để nghe đọc lại từ vựng</h6>
</div>
@if(isset($data)&&$data[2][0]['id'] != '')
    @foreach($data[2] as $index => $row)
        <div class="col-xs-12 no-padding vocabulary-box hidden" target-id="{{$row['row_id']}}">
            <input type="text" name="" class="form-control input-sm vocal-engword" value="{{$row['vocabulary_nm']}}" disabled="">
            <input type="text" name="" class="form-control input-sm vocal-type" value="{{(($row['specialized_div_nm']!=''?('☆ Chuyên nghành: '.$row['specialized_div_nm']).' ':'').($row['field_div_nm']!=''?('★ Lĩnh vực: '.$row['field_div_nm']):''))}}" disabled="">
            <input type="text" name="" class="form-control input-sm vocal-spell" value="{{$row['spelling']}}" disabled="">
            <input type="text" name="" class="form-control input-sm vocal-div" value="{{$row['vocabulary_div_nm']}}" disabled="">
            <textarea class="form-control input-sm vocal-mean" disabled="" rows="2">{{$row['mean']}}</textarea>
            <audio class="sound1 vocal-audio" src="{{$row['audio']}}"></audio>
            @if(isset($data)&&$data[6][0]['src_id'] != '')
            <div class="form-group relationship">
                <label>Những từ liên quan</label>
                <div class="analysis" type = "1">
                    <span>Từ đồng nghĩa: </span>
                    <span class="list">
                        @foreach($data[6] as $index1 => $row1)
                            @if($row1['src_id']==$row['id']&&$row1['relationship_div']==1)
                            <a target="_blank" href="/dictionary?v={{$row1['target_id']}}" title="{{$row1['mean']}}">{{$row1['vocabulary_nm']}} |</a>
                            @endif
                        @endforeach
                    </span>
                </div>
                <div class="analysis" type = "2">
                    <span>Từ trái nghĩa: </span>
                    <span class="list">
                        @foreach($data[6] as $index1 => $row1)
                            @if($row1['src_id']==$row['id']&&$row1['relationship_div']==2)
                            <a target="_blank" href="/dictionary?v={{$row1['target_id']}}" title="{{$row1['mean']}}">{{$row1['vocabulary_nm']}} |</a>
                            @endif
                        @endforeach
                    </span>
                </div>
            </div>
            @endif
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
        @include('exam',array('data'=>isset($data[0])?$data[0]:array()))
      </div> 
    <div class="paging-list">
       @include('paging_content')
    </div>
</div>