@if(isset($data)&&$data[2][0]['post_id'] != '')
    @foreach($data[2] as $index => $row)
    @if($row['del_flg']==0)
    <div class="col-xs-12 no-padding social-box" target-id="{{$row['row_id']}}">
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
    <div class="col-xs-12 no-padding social-box" style="margin-top: -5px;" target-id="{{$row['row_id']}}">
        <div class="example-header title-header">
            <span>{{$row['post_title']}}</span>
        </div>
    </div>
    <div class="col-xs-12 no-padding social-box" target-id="{{$row['row_id']}}">
         <div class="main-content" id="noiDungNP" style="border-left: rgb(97, 97, 97) solid 1px; border-bottom: #ccc solid 1px;">
            {!!$row['post_content']!!}
        </div>
    </div>
    <div class=" col-xs-12 no-padding rate-bar social-box" target-id="{{$row['row_id']}}">
        <button class="btn btn-sm col-md-3 col-sm-3 col-xs-5 {{$raw_data[0][0]['btn-vote']==1?'btn-vote btn-default':'btn-disabled'}}" {{$raw_data[0][0]['btn-vote']==1?'':'rank='.$raw_data[0][0]['btn-vote']}} disabled="disabled"><span style="font-weight: bold;">Đánh giá của bạn</span></button>
        <div class="col-md-6 col-sm-6 col-xs-7 ratestar-bar no-padding">
                <div class="rateit my-vote" data-rateit-resetable="true" data-rateit-mode="font" data-rateit-value="{{$row['my_rate']}}" style="font-size:36px"> </div>
        </div>
        <button class="btn btn-sm col-md-3 col-sm-3 col-xs-12 {{$row['reported']==0?'btn-warning':'btn-danger'}} btn-popup" popup-id="popup-box2" type='7' target="{{$row['post_id']}}" report-div="1">
            @if($row['reported']==0)
            <span style="font-weight: bold;">Báo Cáo Bài Viết !</span>
            @else
            <i class="fa fa-warning"></i>
            <span style="font-weight: bold;"> Đã Báo Cáo !</span>
            @endif
        </button>
    </div>
    @else
        @include('not_found',array('class'=>'social-box custom','target_id'=>$row['row_id']))
    @endif
    @endforeach
@endif
<div class=" example-content">
    <div class="col-xs-12 no-padding">
          @include('vocabulary_content')
    </div>
    <div class="col-xs-12 no-padding margin-top">
        <ul class="nav nav-tabs nav-justified comment-tabs">
            <li class="active"><a data-toggle="tab" href="#chemgio" aria-expanded="true">Bình Luận ,Chém Gió</a></li>
            <li class=""><a data-toggle="tab" href="#gopy" aria-expanded="false">Góp Ý Học Tập</a></li>
        </ul>
        <div class="tab-content">
            <div id="chemgio" class="tab-pane fade active in">
                @include('comment_content')
                <div class="col-xs-12 paging-list margin-top">
                   @include('paging_content',array('paging_div'=>1))
                </div>
            </div>
            <div id="gopy" class="tab-pane fade">
                @include('comment_content',array('cmt_div'=>2))
                <div class="col-xs-12 paging-list margin-top">
                   @include('paging_content',array('paging_div'=>2))
                </div>
            </div>
        </div>
    </div>
    
</div>
