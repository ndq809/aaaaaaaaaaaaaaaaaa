<div class="col-xs-12 no-padding">
    @if(isset($data)&&$data[2][0]['post_id'] != '')
        @foreach($data[2] as $index => $row)
        <div class="example-header title-header grammar-box" target-id="{{$row['row_id']}}">
            <span>{{$row['post_title']}}</span>
        </div>
        @endforeach
    @endif
</div>
<div class="col-xs-12 no-padding">
     @if(isset($data)&&$data[2][0]['post_id'] != '')
        @foreach($data[2] as $index => $row)
             <div class="main-content grammar-box" id="noiDungNP" style="border-left: #ccc solid 1px; border-bottom: #ccc solid 1px;" target-id="{{$row['row_id']}}">
                {!!$row['post_content']!!}
            </div>
        @endforeach
    @endif
   
</div>
<div class="col-xs-12 no-padding margin-top">
    <button class="btn btn-sm btn-primary" id="btn_prev">Trước</button>
    <button class="btn btn-sm btn-primary" id="btn_next" style="float: right;">Tiếp</button>
</div>
<div class="col-xs-12 no-padding margin-top">
    <div class="right-header">
        <h5 class="inline-block"><i class="glyphicon glyphicon-star-empty"></i> Ví Dụ Thực Tế</h5>
        <select class="select-header" id="exam-order">
            <option value="0">Tự động</option>
            <option value="1">Mới nhất</option>
            <option value="2">Đánh giá</option>
        </select>
    </div>
    <div class="panel-group" id="example-list">
        @include('exam_content')
      </div> 
    <div class="paging-list">
       @include('paging_content')
    </div>
</div>
<div style="display: table" class="full-width">
    <span style="display: table-cell;font-size: 22px" class="fa fa-hand-o-right text-center text-success"></span>
    <button class="btn btn-sm btn-primary full-width btn-popup" popup-id="popup-box1">Làm Bài Tập Vận Dụng</button>
    <span style="display: table-cell;font-size: 22px" class="fa fa-hand-o-left text-center text-success"></span>
</div>
