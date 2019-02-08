@if(isset($data)&&$data[2][0]['post_id'] != '')
    @foreach($data[2] as $index => $row)
    @if($row['del_flg']==0)
        <div class="col-xs-12 no-padding reading-box" target-id="{{$row['row_id']}}">
            <div class="example-header title-header">
                <span>{{$row['post_title']}}</span>
            </div>
        </div>
        <div class="col-xs-12 no-padding reading-box" target-id="{{$row['row_id']}}">
             <div class="main-content" id="noiDungNP" style="border-left: #ccc solid 1px; border-bottom: #ccc solid 1px;">
                {!!$row['post_content']!!}
            </div>
        </div>
    @else
        @include('not_found',array('class'=>'reading-box','target_id'=>$row['row_id']))
    @endif
    @endforeach
@endif
<div class="col-xs-12 no-padding example-content">
    <div class="col-xs-12 no-padding">
          @include('vocabulary_content')
    </div>
    <div class="col-xs-12 no-padding margin-top">
        @include('comment_content')
    </div>
    <div class="col-xs-12 paging-list margin-top">
       @include('paging_content')
    </div>
</div>