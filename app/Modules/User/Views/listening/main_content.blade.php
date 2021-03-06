<div class="col-xs-12 no-padding margin-top">
    <div id="jquery_jplayer_2" class="jp-jplayer"></div>
    <div id="jp_container_2" class="jp-audio" role="application"
        aria-label="media player">
        <div class="jp-type-playlist">
            <div class="jp-gui jp-interface">
                <div class="jp-controls">

                    <button class="jp-play" role="button" tabindex="0">play</button>

                    <button class="jp-stop" role="button" tabindex="0">stop</button>
                </div>
                <div class="jp-progress">
                    <div class="jp-seek-bar">
                        <div class="jp-play-bar"></div>
                    </div>
                </div>
                <div class="jp-volume-controls">
                    <button class="jp-mute" role="button" tabindex="0">mute</button>
                    <button class="jp-volume-max" role="button" tabindex="0">max
                        volume</button>
                    <div class="jp-volume-bar">
                        <div class="jp-volume-bar-value"></div>
                    </div>
                </div>
                <div class="jp-time-holder">
                    <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                    <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                </div>
                <div class="jp-toggles"></div>
                <div class="jp-title">&nbsp;</div>
            </div>

            <div class="jp-playlist">
                <ul>
                    <li>&nbsp;</li>
                </ul>
            </div>

        </div>
    </div>
</div>
{{--<div class="col-xs-12 no-padding listen-check-box">
    <textarea class="form-control input-sm margin-top col-xs-12 no-padding" id="check-listen-data" rows="3" placeholder="Nghe kỹ bài nghe sau đó nghi lại những gì bạn nghe được tại đây rồi nhấn ' Kiểm tra kết quả '"></textarea>
    <button class="btn btn-sm btn-primary margin-top {{$raw_data[0][0]['btn-check-answer']==1?'btn-check-answer':'btn-disabled'}}" popup-id="popup-box3">Kiểm tra kết quả</button>
    @if(isset($data)&&$data[2][0]['post_id'] != '')
        @foreach($data[2] as $index => $row)
            @if($row['del_flg']==0)
                 <div class="main-content listen-answer hidden" target-id="{{$row['row_id']}}">
                    {!!$row['post_content']!!}
                </div>
            @else
                @include('not_found',array('class'=>'listen-answer custom','target_id'=>$row['row_id'],'no_image'=>'1'))
            @endif
        @endforeach
    @endif
</div>--}}

<div class="example-content col-xs-12 no-padding">
    <div class="panel-group" id="listen-list">
          @include('listen_content',array('data'=>isset($data[5])?$data[5]:array()))
    </div>
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
