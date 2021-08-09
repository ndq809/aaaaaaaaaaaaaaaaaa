@if(isset($data)&&$data[2][0]['post_id'] != '')
    @foreach($data[2] as $index => $row)
    <div class="col-xs-12 relax-box no-padding" target-id="{{$row['row_id']}}">
        <div class="post-infor">
            <div class="rateit average-rating" data-rateit-resetable="true" data-rateit-mode="font" data-rateit-readonly="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Đánh giá chung {{round($row['post_rate'],2)}} sao" data-rateit-value="{{$row['post_rate']}}" style="font-size:36px;min-width: 170px;"> </div>
            <span data-toggle="tooltip" data-placement="bottom" data-original-title="Lượt xem" class="post-view"><i class="fa fa-leanpub"></i> {{$row['post_view']}}</span>
            <span data-toggle="tooltip" data-placement="bottom" data-original-title="Tác giả"><i class="fa fa-user"></i> {{$row['post_member']}}</span>
            <span data-toggle="tooltip" data-placement="bottom" data-original-title="Ngày chia sẻ" ><i class="fa fa-calendar"></i> {{date_format(date_create($row['cre_date']),"d/m/Y H:i")}}</span>
            @if(date_create($row['cre_date'])< date_create($row['edit_date']))
                <span data-toggle="tooltip" data-placement="bottom" data-original-title="Ngày cập nhật cuối"><i class="fa fa-edit"></i> {{date_format(date_create($row['edit_date']),"d/m/Y H:i")}}</span>
            @endif
        </div>
    </div>
    <div class="col-xs-12 no-padding relax-box" style="margin-top: -5px;" target-id="{{$row['row_id']}}">
        <div class="example-header title-header">
            <span>{{$row['post_title']}}</span>
        </div>
    </div>
    <div class="col-xs-12 no-padding relax-box" target-id="{{$row['row_id']}}">
         <div class="main-content" id="noiDungNP" style="border-left: #ccc solid 1px; border-bottom: #ccc solid 1px;">
            {!!$row['post_content']!!}
            @if($row['post_type']==4)
            <div class="image margin-bottom">
                <img alt="loadIcon" src="{{$row['post_media']}}">
            </div>
            @endif
        </div>
        @if($row['post_type']==5)
            <div class="video-source hidden">
                <div class ='video-item' source-id ="{{$row['row_id']}}">{{$row['post_media']}}</div>
            </div>
        @endif
    </div>
    <div class=" col-xs-12 no-padding rate-bar relax-box" target-id="{{$row['row_id']}}">
        <button class="btn btn-sm col-md-3 col-sm-3 col-xs-5 {{$raw_data[0][0]['btn-vote']==1?'btn-vote':'btn-disabled'}}" {{$raw_data[0][0]['btn-vote']==1?'':'rank='.$raw_data[0][0]['btn-vote']}} disabled="disabled"><span style="font-weight: bold;">Đánh giá của bạn</span></button>
        <div class="col-md-6 col-sm-6 col-xs-7 ratestar-bar no-padding">
                <div class="rateit my-vote" data-rateit-resetable="true" data-rateit-mode="font" data-rateit-value="{{$row['my_rate']}}" style="font-size:36px"> </div>
        </div>
        <button class="btn btn-sm col-md-3 col-sm-3 col-xs-12 btn-popup" popup-id="popup-box2"><span style="font-weight: bold;">Báo Cáo Bài Viết !</span></button>
    </div>
    @endforeach
@endif