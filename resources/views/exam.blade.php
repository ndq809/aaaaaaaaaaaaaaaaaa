<div class="panel panel-default panel-contribute">
 <div class="panel-heading " data-toggle="collapse" data-parent="#example-list" href="#collapse-contribute">
    <h5 class="panel-title">
      <span>Đóng góp ví dụ</span>
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
@include('exam_content')
