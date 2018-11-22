<div class="col-xs-12 no-padding">
    @if(isset($data)&&$data[2][0]['post_id'] != '')
        @foreach($data[2] as $index => $row)
        <div class="example-header title-header reading-box" target-id="{{$row['row_id']}}">
            <span>{{$row['post_title']}}</span>
        </div>
        @endforeach
    @endif
</div>
<div class="col-xs-12 no-padding">
     @if(isset($data)&&$data[2][0]['post_id'] != '')
        @foreach($data[2] as $index => $row)
             <div class="main-content reading-box" id="noiDungNP" style="border-left: #ccc solid 1px; border-bottom: #ccc solid 1px;" target-id="{{$row['row_id']}}">
                {!!$row['post_content']!!}
            </div>
        @endforeach
    @endif
</div>
<div class="col-xs-12 no-padding">
      @include('vocabulary_content')
</div>
<div class="col-xs-12 no-padding">
    
</div>
<div class="col-xs-12 no-padding margin-top">
    @include('comment_content')
</div>
<div class="col-xs-12 paging-list margin-top">
   @include('paging_content')
</div>