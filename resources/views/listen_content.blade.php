@if(isset($data[0]['row_id'])&&$data[0]['row_id'] != '')
    <div class="panel panel-default">
        <div class="panel-heading" data-toggle="collapse" data-parent="#listen-list" href="#collapse0">
            <h5 class="panel-title">
                <span>Toàn bộ bài nghe</span>
            </h5>
        </div>
        <div id="collapse0" class="panel-collapse collapse">
            <div class="input-group">
                <div class="main-content full-width hidden"></div>
                <button class="btn btn-default btn-sm btn-show-content full-width" type="button">Xem nội dung</button>
            </div><!-- /input-group -->
        </div>
    </div>
    @foreach($data as $index => $row)
        <div class="panel panel-default listen-cut-box" target-id="{{$row['row_id']}}">
            <div class="panel-heading" data-toggle="collapse" data-parent="#listen-list" href="#collapse{{$row['listen_cut_id']}}">
                <h5 class="panel-title">
                    <span>Phần {{$row['part_code']}}</span>
                    <span class="float-right"></span>
                </h5>
            </div>
            <div id="collapse{{$row['listen_cut_id']}}" class="panel-collapse collapse">
                <div class="input-group">
                  <input type="text" class="form-control input-sm" placeholder="Nội dung nghe được">
                  <span class="input-group-btn">
                    <button class="btn btn-default btn-sm btn-check-listen" type="button">Kiểm tra</button>
                    <button class="btn btn-default btn-sm btn-show-answer" type="button">Đáp án</button>
                  </span>
                </div><!-- /input-group -->
            </div>
        </div>
    @endforeach
@endif
