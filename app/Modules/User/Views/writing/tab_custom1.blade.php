@if(isset($data)&&$data[2][0]['post_id'] != '')
    @foreach($data[2] as $index => $row)
    @if($row['my_post']==0)
    <div class="example-header title-header writing-box" target-id="{{$row['row_id']}}">
        <span>{{$row['post_title']}}</span>
    </div>
    @endif
    @endforeach
@endif
@if(isset($data)&&$data[2][0]['post_id'] != '')
    @foreach($data[2] as $index => $row)
    @if($row['my_post']==0)
         <div class="main-content writing-box" id="noiDungNP" style="border-left: #ccc solid 1px; border-bottom: #ccc solid 1px;" target-id="{{$row['row_id']}}">
            {!!$row['post_content']!!}
        </div>
    @endif
    @endforeach
@endif
