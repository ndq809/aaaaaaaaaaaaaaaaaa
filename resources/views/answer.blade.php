@if(isset($data) && isset($data[0][0]['comment_id']) && $data[0][0]['comment_id'] != '')
    @foreach($data[0] as $index => $row)
    @if($row['reply_id']=='')
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
                    <li role="presentation"><a role="menuitem" tabindex="-1" class="btn-popup" popup-id="popup-box2" type='5' target="{{$row['comment_id']}}" report-div="2"><span class="fa fa-times-circle-o" ></span> Báo cáo vi phạm</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" class="btn-popup" popup-id="popup-box2" type='6' target="{{$row['account_id']}}" report-div="3"><span class="fa fa-times-circle-o" ></span> Báo cáo người dùng</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-times-circle-o"></span> Xóa câu trả lời</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-info-circle"></span> Xóa câu trả lời,cảnh cáo</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-minus-circle"></span> Xóa câu trả lời,khóa acc</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-times-circle"></span> Xóa câu trả lời,xóa acc</a></li>
                    </ul>
                </div>
                <span class="date sub-text float-right comment-date">{{$row['cre_date']}}</span>
            </div>
            <span class="commentText">{{$row['cmt_content']}}</span>
            <div class="bottomContent">
               <a class="btn-reply">Phản hồi</a>
               <div class="vote-comment">
                    <a class="vote-down {{$raw_data[0][0]['btn-cmt-vote']==1?'btn-cmt-vote':'btn-disabled'}} {{isset($row['effected'])&&(int)$row['effected']==-1?'active':''}}" type="button">
                        <i class="fa fa-arrow-down animated {{isset($row['effected'])&&(int)$row['effected']==-1?'rotateInLeft':''}}"></i>
                    </a>
                    <span style="font-family: Jersey" class="rating-value">{{(int)$row['cmt_like']}}</span>
                    <a class="vote-up {{$raw_data[0][0]['btn-cmt-vote']==1?'btn-cmt-vote':'btn-disabled'}} {{isset($row['effected'])&&(int)$row['effected']==1?'active':''}}" type="button">
                        <i class="fa fa-arrow-up animated {{isset($row['effected'])&&(int)$row['effected']==1?'rotateInRight':''}}"></i>
                    </a>
                </div>
            </div>
            @if(isset($row['load_more'])&&$row['load_more']>3)
            <a class="load-more prev hidden" page ='1'>Tải lại câu trả lời trước</a>
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
                                    <li role="presentation"><a role="menuitem" tabindex="-1" class="btn-popup" popup-id="popup-box2" type='5' target="{{$row1['comment_id']}}" report-div="2"><span class="fa fa-times-circle-o" ></span> Báo cáo vi phạm</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" class="btn-popup" popup-id="popup-box2" type='6' target="{{$row1['account_id']}}" report-div="3"><span class="fa fa-times-circle-o" ></span> Báo cáo người dùng</a></li>  
                                    <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-times-circle-o"></span> Xóa câu trả lời</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-info-circle"></span> Xóa câu trả lời,cảnh cáo</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-minus-circle"></span> Xóa câu trả lời,khóa acc</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1"><span class="fa fa-times-circle"></span> Xóa câu trả lời,xóa acc</a></li>
                                    </ul>
                                </div>
                               <span class="date sub-text comment-date float-right">{{$row1['cre_date']}}</span>
                            </div>
                            <span class="commentText">{{$row1['cmt_content']}}</span>
                            <div class="bottomContent">
                               <a class="btn-reply">Phản hồi</a>
                               <div class="vote-comment">
                                    <a class="vote-down {{$raw_data[0][0]['btn-cmt-vote']==1?'btn-cmt-vote':'btn-disabled'}} {{isset($row1['effected'])&&(int)$row1['effected']==-1?'active':''}}" type="button">
                                        <i class="fa fa-arrow-down animated {{isset($row1['effected'])&&(int)$row1['effected']==-1?'rotateInLeft':''}}"></i>
                                    </a>
                                    <span style="font-family: Jersey" class="rating-value">{{(int)$row1['cmt_like']}}</span>
                                    <a class="vote-up {{$raw_data[0][0]['btn-cmt-vote']==1?'btn-cmt-vote':'btn-disabled'}} {{isset($row1['effected'])&&(int)$row1['effected']==1?'active':''}}" type="button">
                                        <i class="fa fa-arrow-up animated {{isset($row1['effected'])&&(int)$row1['effected']==1?'rotateInRight':''}}"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif
            @endforeach
            </ul>
            <div class="input-group hidden comment-input">
                <textarea type="text" class="form-control input-sm comment-input" {{$raw_data[0][0]['btn-comment']==1?'':'disabled'}}
                placeholder="Phản hồi của bạn" rows="1"></textarea>
                <div class="input-group-btn">
                    <button class="btn btn-default btn-sm {{$raw_data[0][0]['btn-comment']==1?'btn-comment':'btn-disabled'}}" id="btBinhLuan">Phản hồi</button>
                </div>
            </div>
            @if(isset($row['load_more'])&&$row['load_more']>3)
            <a class="load-more next" page ='1'>Tải thêm câu trả lời</a>
            @endif
        </div>
    </li>
    @endif
    @endforeach
@endif