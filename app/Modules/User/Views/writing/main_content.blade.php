<div class="col-xs-12 no-padding margin-top control-btn">
    <button class="btn btn-sm btn-primary" id="btn_prev">Trước</button>
    <button class="btn btn-sm btn-primary" id="btn_next" style="float: right;">Tiếp</button>
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
