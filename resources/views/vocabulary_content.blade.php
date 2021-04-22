<div class="panel-group" id="example-list">
    @if(isset($data)&&$data[4][0]['post_id'] != '')
    <div class="panel panel-default">
      <div class="panel-heading" data-toggle="collapse" data-parent="#example-list" href="#collapse1">
        <h5 class="panel-title">
          <span>Danh Sách Từ Mới</span>
        </h5>
      </div>
      <div id="collapse1" class="panel-collapse collapse in">
        <table class="table vocabulary-table table-hover">
            <tbody>
                @foreach($data[4] as $index => $row)
                <tr class="vocabulary-box" target-id="{{$row['row_id']}}">
                    <td width="33%"><a target="_blank" href="/dictionary?v={{$row['id']}}">{{$row['vocabulary_nm']}}</a></td>
                    <td width="33%">{{$row['spelling']}}</td>
                    <td>{{$row['mean']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
    @endif

    @if(isset($data[5][0]['question_id'])&&$data[5][0]['question_id'] != '')
    <div class="panel panel-default panel-contribute">
     <div class="panel-heading" data-toggle="collapse" data-parent="#example-list" href="#collapse6">
        <h5 class="panel-title">
          <span>Bài Tập Tự Luyện</span>
        </h5>
      </div>
      <div id="collapse6" class="panel-collapse collapse question-list">
        <div class="panel-body">
            <div class="form-group" min-width="1024px">
                @include('practice',array('data'=>$data[5]))
            </div>
        </div>
        <div class="panel-bottom">
            <button class="btn btn-primary btn-sm btn-refresh" type="button">
                Làm mới câu hỏi
            </button>
            <button class="btn btn-danger btn-sm {{$raw_data[0][0]['btn-check-answer']==1?'btn-check-answer':'btn-disabled'}}" {{$raw_data[0][0]['btn-check-answer']==1?'':'rank='.$raw_data[0][0]['btn-check-answer']}} type="button">
                Xem kết quả
            </button>
        </div>
      </div>
    </div>
    @endif
</div>