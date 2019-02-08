@php($cmt_div = isset($cmt_div)?$cmt_div:1)
@if(isset($data) && isset($data[0][0]['comment_id']) && $data[0][0]['comment_id'] != '')
    @foreach($data[0] as $index => $row)
    @if($row['reply_id']=='' && $row['cmt_div']==$cmt_div)
    <li class="commentItem {{isset($row['row_id'])?'comment-box':''}}" id="{{$row['comment_id']}}" target-id="{{isset($row['row_id'])?$row['row_id']:''}}">
        <div class="commenterImage">
            <img src="{{$row['avarta']}}">
        </div>
        <div class="commentContent">
            <div class="commentHeader">
                <a href="#">{{$row['cre_user']}}</a>
                <span class="rank">{{$row['rank']}}</span>
                <div class="dropdown">
                  <a class="setting fa fa-gear dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  </a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                      <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-times-circle-o"></span> Xóa bình luận</a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-info-circle"></span> Xóa bình luận,cảnh cáo</a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-minus-circle"></span> Xóa bình luận,khóa acc</a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-times-circle"></span> Xóa bình luận,xóa acc</a></li>
                    </ul>
                </div>
                <span class="date sub-text float-right comment-date">{{$row['cre_date']}}</span>
            </div>
            <span class="commentText">{{$row['cmt_content']}}</span>
            <div class="bottomContent">
               <a class="btn-reply">Trả lời</a>
               <a class="fa fa-thumbs-o-up {{$raw_data[0][0]['btn-like']==1?'btn-like':'btn-disabled'}} animated {{isset($row['effected'])&&$row['effected']!=0?'liked bounceIn':''}}"> {{$row['cmt_like']}} {{isset($row['effected'])&&$row['effected']!=0?'Đã Thích':'Thích'}}</a>
            </div>
            @if(isset($row['load_more'])&&$row['load_more']>3)
            <a class="load-more prev hidden" page ='1'>Tải lại bình luận trước</a>
            @endif
            <ul class="commentList">
            @foreach($data[0] as $index1 => $row1)
                @if($row1['reply_id']==$row['comment_id'])
                    <li class="commentItem" id="{{$row1['comment_id']}}">
                        <div class="commenterImage">
                            <img src="{{$row1['avarta']}}">
                        </div>
                        <div class="commentContent">
                            <div class="commentHeader">
                                <a href="#">{{$row1['cre_user']}}</a>
                                <span class="rank">{{$row1['rank']}}</span>
                                <div class="dropdown">
                                  <a class="setting fa fa-gear dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  </a>
                                  <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                      <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-times-circle-o"></span> Xóa bình luận</a></li>
                                      <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-info-circle"></span> Xóa bình luận,cảnh cáo</a></li>
                                      <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-minus-circle"></span> Xóa bình luận,khóa acc</a></li>
                                      <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-times-circle"></span> Xóa bình luận,xóa acc</a></li>
                                    </ul>
                                </div>
                               <span class="date sub-text comment-date float-right">{{$row1['cre_date']}}</span>
                            </div>
                            <span class="commentText">{{$row1['cmt_content']}}</span>
                            <div class="bottomContent">
                               <a class="btn-reply">Trả lời</a>
                               <a class="fa fa-thumbs-o-up {{$raw_data[0][0]['btn-like']==1?'btn-like':'btn-disabled'}} animated {{isset($row1['effected'])&&$row1['effected']!=0?'liked bounceIn':''}}"> {{$row1['cmt_like']}} {{isset($row1['effected'])&&$row1['effected']!=0?'Đã Thích':'Thích'}}</a>
                            </div>
                        </div>
                    </li>
                @endif
            @endforeach
            </ul>
            <div class="input-group hidden comment-input">
                <textarea type="text" class="form-control input-sm comment-input" {{$raw_data[0][0]['btn-comment']==1?'':'disabled'}}
                placeholder="Bình luận của bạn" rows="1"></textarea>
                <div class="input-group-btn">
                    <button class="btn btn-default btn-sm {{$raw_data[0][0]['btn-comment']==1?'btn-comment':'btn-disabled'}}" id="btBinhLuan">Bình Luận </button>
                </div>
            </div>
            @if(isset($row['load_more'])&&$row['load_more']>3)
            <a class="load-more next" page ='1'>Tải thêm bình luận</a>
            @endif
        </div>
    </li>
    @endif
    @endforeach
@endif