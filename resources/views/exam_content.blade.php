<div class="panel panel-default panel-contribute">
 <div class="panel-heading " data-toggle="collapse" data-parent="#example-list" href="#collapse-contribute">
    <h5 class="panel-title">
      <span>Đóng góp ví dụ cho từ vựng này</span>
    </h5>
  </div>
  <div id="collapse-contribute" class="panel-collapse collapse">
    <div class="panel-body">
        <div class="col-xs-12 no-padding">
            <div class="form-group">
                <label>Câu Tiếng Anh</label>
                 <div class="input-group">
                    <input type="text" name="" id="eng-clause" class="form-control input-sm" placeholder="Nội dung câu tiếng anh">
                </div>
            </div>
        </div>
        <div class="col-xs-12 no-padding">
            <div class="form-group">
                <label>Dịch Nghĩa</label>
                 <div class="input-group">
                    <input type="text" name="" id="vi-clause" class="form-control input-sm" placeholder="Nghĩa của câu đã nhập">
                </div>
            </div>
        </div>
        <button class="btn btn-sm btn-danger {{$raw_data[0][0]['btn-contribute-exa']==1?'btn-contribute-exa':'btn-disabled'}}" type="button">Đóng Góp</button>
    </div>
  </div>
</div>
@if(isset($data)&&$data[0][0]['row_id'] != '')
    @foreach($data[0] as $index => $row)        
        <div class="panel panel-default hidden example-item" word-id="{{$row['row_id']}}">
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
