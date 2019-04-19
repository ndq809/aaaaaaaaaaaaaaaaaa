@if(isset($data[0]['row_id'])&&$data[0]['row_id'] != '')
    @foreach($data as $index => $row)
        <span class="date sub-text text-right example-item" target-id="{{$row['row_id']}}"><span class="fa fa-share-alt"></span> {{$row['cre_user']}}, {{$row['cre_date']}}</span>
        <div class="panel panel-default example-item" target-id="{{$row['row_id']}}">
            <div class="panel-heading" data-toggle="collapse" data-parent="#example-list" href="#collapse{{$row['id']}}">
                <h5 class="panel-title">
                    <span>{{$row['language1_content']}}</span>
                </h5>
                <span class="number-clap">{{$row['clap']}}</span>
                <a type="button" id="{{$row['id']}}" class="fa fa-signing {{$raw_data[0][0]['btn-effect']==1?'btn-effect':'btn-disabled'}} animated {{$row['effected']==1?'claped tada':''}}" title="{{$row['effected']==1?'Bỏ vỗ tay!!!':'Hay quá ! Vỗ tay!!!'}}"></a>
            </div>
            <div id="collapse{{$row['id']}}" class="panel-collapse collapse">
                <div class="panel-body">{{$row['language2_content']}}</div>
            </div>
        </div>
    @endforeach
@endif
