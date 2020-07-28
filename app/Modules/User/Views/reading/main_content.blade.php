@if(isset($data)&&$data[2][0]['post_id'] != '')
    @foreach($data[2] as $index => $row)
    @if($row['del_flg']==0)
        <div class="col-xs-12 no-padding reading-box" target-id="{{$row['row_id']}}">
            <div class="col-xs-6 padding-custom">
                <div class="example-header title-header">
                    <span>{{$row['post_title']}}</span>
                </div>
            </div>
             <div class="col-xs-6 padding-custom">
                <div class="example-header title-header">
                    <span>{{$row['post_title_tran']}}</span>
                </div>
            </div>
        </div>
        <div class="col-xs-12 no-padding reading-box" target-id="{{$row['row_id']}}">
            <div class="col-xs-6 padding-custom">
                <div class="main-content hidden en_content" id="noiDungNP" style="border-left: #ccc solid 1px; border-bottom: #ccc solid 1px;">
                    {!!$row['post_content']!!}
                </div>
            </div>
             <div class="col-xs-6 padding-custom">
                <div class="main-content vi_content hidden" id="noiDungNP" style="border-left: #ccc solid 1px; border-bottom: #ccc solid 1px;">
                    {!!$row['post_content_tran']!!}
                </div>
            </div>
        </div>
    @else
        @include('not_found',array('class'=>'reading-box','target_id'=>$row['row_id']))
    @endif
    @endforeach
@endif
<div class="col-xs-12 no-padding">
    <div class="col-xs-6 padding-custom">
        <textarea class="form-control input-sm" readonly="readonly" id="en_textarea" rows="30" placeholder=""></textarea>
    </div>
     <div class="col-xs-6 padding-custom">
        <textarea class="form-control input-sm" readonly="readonly" id="vi_textarea" rows="30" placeholder=""></textarea>
    </div>
</div>
<div class="col-xs-12 padding-custom">
    <button class="btn btn-sm btn-primary col-xs-12 margin-top" id="btn-separate" type="button">Phân tách thành từng câu</button>
</div>
<div class="col-xs-12 padding-custom example-content">
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