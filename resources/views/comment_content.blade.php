<div class="commentbox">
    <div class="right-header">
        <h5><i class="glyphicon glyphicon-star-empty"></i> Góc Bình Luận</h5>
    </div>
    <div class="actionBox" style="padding: 0px;">
        <div class="input-group">
            <textarea type="text" class="form-control input-sm comment-input" {{$raw_data[0][0]['btn-comment']==1?'':'disabled'}}
                placeholder="Bình luận của bạn" rows="1"></textarea>
            <div class="input-group-btn">
                <button class="btn btn-default btn-sm {{$raw_data[0][0]['btn-comment']==1?'btn-comment':'btn-disabled'}}" {{$raw_data[0][0]['btn-comment']==1?'':'rank='.$raw_data[0][0]['btn-comment']}} id="btBinhLuan">Bình Luận </button>
            </div>
        </div>
        <a href="" class="hidden see-back">Xem bình luận trước đó</a>
        <ul class="commentList">
            @include('comment',array('data'=>isset($data)?$data:'','cmt_div'=>isset($cmt_div)?$cmt_div:1))
        </ul>
    </div>
</div>
