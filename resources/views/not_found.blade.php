<div class="post-not-found col-xs-12 {{isset($class)?$class:''}}" {{isset($target_id)?'target-id='.$target_id:''}}>
	@if(!isset($no_image))
    <div class="image-nf">
        <img src="/web-content/images/icon/sad.png" width="100px">
    </div>
    @endif
    <div class="content">
        <h5 class="text-center" style="font-size: 30px;">BÀI VIẾT ĐÃ BỊ XÓA HOẶC KHÔNG TỒN TẠI !</h5>
    </div>
    <div class="text-center">
	    <button type="button" class="btn btn-success btn-reload">Làm Mới Trang</button>
	</div>
</div>