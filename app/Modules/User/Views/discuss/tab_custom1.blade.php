@if(isset($data)&&$data[2][0]['post_id'] != '')
    @foreach($data[2] as $index => $row)
    @if($row['del_flg']==0)
    <div class="col-xs-12 no-padding discuss-box" target-id="{{$row['row_id']}}">
        <div class="post-infor">
            <span data-toggle="tooltip" data-placement="bottom" data-original-title="Lượt xem" class="post-view"><i class="fa fa-leanpub"></i> {{$row['post_view']}}</span>
            <span data-toggle="tooltip" data-placement="bottom" data-original-title="Tác giả"><i class="fa fa-user"></i> {{$row['post_member']}}</span>
            <span data-toggle="tooltip" data-placement="bottom" data-original-title="Ngày chia sẻ" ><i class="fa fa-calendar"></i> {{date_format(date_create($row['cre_date']),"d/m/Y H:i")}}</span>
            @if(date_create($row['cre_date'])< date_create($row['edit_date']))
                <span data-toggle="tooltip" data-placement="bottom" data-original-title="Ngày cập nhật cuối"><i class="fa fa-edit"></i> {{date_format(date_create($row['edit_date']),"d/m/Y H:i")}}</span>
            @endif
        </div>
    </div>
    <div class="col-xs-12 no-padding discuss-box" style="margin-top: -5px;" target-id="{{$row['row_id']}}">
        <div class="example-header title-header">
            <span>{{$row['post_title']}}</span>
        </div>
    </div>
    <div class="col-xs-12 no-padding discuss-box" target-id="{{$row['row_id']}}">
         <div class="main-content" id="noiDungNP" style="border-left: #ccc solid 1px; border-bottom: #ccc solid 1px;">
            {!!$row['post_content']!!}
        </div>
    </div>
    <div class=" col-xs-12 no-padding rate-bar discuss-box" target-id="{{$row['row_id']}}">
        <span class="btn btn-sm btn-success col-md-3 col-sm-3 col-xs-5"><span style="font-weight: bold;">Điểm đánh giá</span></span>
        <div class="col-md-6 col-sm-6 col-xs-7">
            <div class="vote">
                <a class="vote-down {{$raw_data[0][0]['btn-vote-question']==1?'btn-vote-question':'btn-disabled'}} {{$raw_data[0][0]['btn-vote-question']==1?'':'rank='.$raw_data[0][0]['btn-vote-question']}} {{(int)$row['my_rate']==-1?'active':''}}" data-toggle="tooltip" data-placement="bottom" data-original-title="{{(int)$row['my_rate']==-1?'Bạn đã vote down cho bài viết này!':'Câu hỏi KHÔNG rõ ràng/ dễ hiểu/ thú vị/ hữu ích!'}}" type="button">
                    <i class="fa fa-arrow-down animated {{(int)$row['my_rate']==-1?'rotateInLeft':''}}"></i>
                </a>
                <span style="font-family: Jersey" class="rating-value">{{(int)$row['post_rate']}}</span>
                <a class="vote-up {{$raw_data[0][0]['btn-vote-question']==1?'btn-vote-question':'btn-disabled'}} {{$raw_data[0][0]['btn-vote-question']==1?'':'rank='.$raw_data[0][0]['btn-vote-question']}} {{(int)$row['my_rate']==1?'active':''}}" data-toggle="tooltip" data-placement="bottom" data-original-title="{{(int)$row['my_rate']==1?'Bạn đã vote up cho bài viết này!':'Câu hỏi rõ ràng/ dễ hiểu/ thú vị/ hữu ích!'}}" type="button">
                    <i class="fa fa-arrow-up animated {{(int)$row['my_rate']==1?'rotateInRight':''}}"></i>
                </a>
            </div>
        </div>
        <button class="btn btn-sm col-md-3 col-sm-3 col-xs-12 btn-popup" popup-id="popup-box2"><span style="font-weight: bold;">Báo Cáo Bài Viết !</span></button>
    </div>
    @else
        @include('not_found',array('class'=>'discuss-box','target_id'=>$row['row_id']))
    @endif
    @endforeach
@endif