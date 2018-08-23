 @if(isset($data)&&$data[1][0]['row_id'] != '')
      @foreach($data[1] as $index => $paging) 
          @if($paging['totalRecord'] != 0)
              <div class="text-center no-padding-left margin-bottom paging-item" word-id="{{$paging['row_id']}}">
                  {!!Paging::show($paging,0)!!}
              </div>
          @endif
      @endforeach
  @endif