@if(isset($data)&&$data[2][0]['post_id'] != '')
    @foreach($data[2] as $index => $row)
    @if($row['del_flg']==0)
    <div class="col-xs-12 no-padding grammar-box" target-id="{{$row['row_id']}}">
        <div class="example-header title-header">
            <span>{{$row['post_title']}}</span>
        </div>
    </div>
    <div class="col-xs-12 no-padding grammar-box" target-id="{{$row['row_id']}}">
         <div class="main-content" id="noiDungNP" style="border-left: #ccc solid 1px; border-bottom: #ccc solid 1px;" >
            {!!$row['post_content']!!}
        </div>
    </div>
    @else
        @include('not_found',array('class'=>'grammar-box','target_id'=>$row['row_id']))
    @endif
    @endforeach
@endif
<div class="example-content">
    <div class="col-xs-12 no-padding margin-top">
        <div class="right-header">
            <h5 class="inline-block"><i class="glyphicon glyphicon-star-empty"></i> Ví Dụ Thực Tế</h5>
            <div class="dropdown inline-block float-right">
                <h5 class="dropdown-toggle" type="button" id="exam-order-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span value="0" class="option">Tự động</span>
                    <span class="caret"></span>
                </h5>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a value="0" class="exam-order">Tự động</a></li>
                    <li><a value="1" class="exam-order">Mới nhất</a></li>
                    <li><a value="2" class="exam-order">Đánh giá</a></li>
                </ul>
            </div>
        </div>
        <div class="panel-group" id="example-list">
            @include('exam',array('data'=>isset($data[0])?$data[0]:array()))
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
</div>
