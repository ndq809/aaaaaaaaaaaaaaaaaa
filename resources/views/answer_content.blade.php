<div class="commentbox">
    <div class="right-header">
        <h5><i class="glyphicon glyphicon-star-empty"></i> Trả Lời Câu Hỏi</h5>
    </div>
    <div class="actionBox" style="padding: 0px;">
        <div class="input-group">
            <textarea type="text" class="form-control input-sm comment-input" {{$raw_data[0][0]['btn-comment']==1?'':'disabled'}}
                placeholder="Câu trả lời của bạn" rows="1"></textarea>
            <div class="input-group-btn">
                <button class="btn btn-default btn-sm {{$raw_data[0][0]['btn-comment']==1?'btn-comment':'btn-disabled'}}" id="btBinhLuan">Trả lời </button>
            </div>
        </div>
        <a href="" class="hidden see-back">Xem bình luận trước đó</a>
        <ul class="commentList">
            @include('answer',array('data'=>isset($data)?$data:''))
        </ul>
    </div>
</div>
