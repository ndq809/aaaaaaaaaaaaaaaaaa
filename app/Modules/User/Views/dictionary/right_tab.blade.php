@php($count = 0)
@php($temp = 0)
<div id="tab1" class="tab-pane fade active in">
    <div class="">
        <table class="table table-hover table-right">
            <tbody>
                @if(isset($data)&&$data[0]['id'] != '')
                    @foreach($data as $index => $row)
                        @php($temp = isset($data[$index-1])?$index-1:count($data)-1)
                        @if(($data[$index]['specialized_div'].$data[$index]['field_div'])!=($data[$temp]['specialized_div'].$data[$temp]['field_div'])||$count==0)
                           <tr class="tr-disabled">
                                <td colspan="2">
                                    <label style="font-size: 13px"><span> {{$data[$index]['specialized_div_nm'].$data[$index]['field_div_nm']==''?'☆ Nghĩa thông thường':(($row['specialized_div_nm']!=''?('☆ Chuyên nghành: '.$row['specialized_div_nm']).' ':'').($row['field_div_nm']!=''?('★ Lĩnh vực: '.$row['field_div_nm']):''))}}</span></label>
                                </td>
                            </tr>
                        @endif
                        <tr id="{{$row['row_id']}}">
                            <td>
                                <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> {{$row['mean']}}</span> </a>
                            </td>
                            <td width="100px">
                                <div class="vote float-right">
                                    <a class="vote-down {{$raw_data[0][0]['btn-vote-word']==1?'btn-vote-word':'btn-disabled'}} {{(int)$row['word_vote']==-1?'active':''}}" data-toggle="tooltip" data-placement="bottom" data-original-title="{{(int)$row['my_vote']==-1?'Bạn đã vote down cho từ vựng này!':'Từ vựng không chuẩn xác'}}" >
                                        <i class="fa fa-arrow-down animated {{(int)$row['my_vote']==-1?'rotateInLeft':''}}"></i>
                                    </a>
                                    <span style="font-family: Jersey" class="rating-value">{{(int)$row['word_vote']}}</span>
                                    <a class="vote-up {{$raw_data[0][0]['btn-vote-word']==1?'btn-vote-word':'btn-disabled'}} {{(int)$row['my_vote']==1?'active':''}}" data-toggle="tooltip" data-placement="bottom" data-original-title="{{(int)$row['my_vote']==1?'Bạn đã vote up cho từ vựng này!':'Từ vựng chuẩn xác'}}">
                                        <i class="fa fa-arrow-up animated {{(int)$row['my_vote']==1?'rotateInRight':''}}"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @php($count = $count + 1)
                    @endforeach
                    <tr id="-100" class="no-row {{$count!=0?'hidden':''}}">
                        <td colspan="2">
                            <a class="radio-inline"><i class="fa fa-minus-circle"> </i> <span> Không có dữ liệu !</span> </a>
                        </td>
                    </tr>
                @endif
                @php($count = 0)
            </tbody>
        </table>
    </div>
</div>
<div id="tab2" class="tab-pane fade">
    <div class="col-xs-12 no-padding add-voc-box" style="height: 100%">
        <input type="hidden" class="submit-item" id="word-id" value="{{isset($data)?$data[0]['id']:''}}">
        <div class="form-group text-center">
            <label>Từ tiếng anh</label>
            <input type="text" id="engword" class="form-control input-sm text-center submit-item" value="{{isset($data)?$data[0]['vocabulary_nm']:''}}" disabled="">
        </div>
        <div class="form-group text-center">
            <label>Phiên âm</label>
            <input type="text" id="word-spelling" class="form-control input-sm submit-item text-center" value="{{isset($data)?$data[0]['spelling']:''}}">
        </div>
        <div class="form-group text-center margin-bottom">
            <label>Nghĩa</label>
            <textarea id="word-mean" class="form-control input-sm submit-item text-center" rows="2"></textarea>
        </div>
        <div class="form-group text-center" style="margin-top: 10px">
            <label>Hình ảnh</label>
            <div id="imageContainer" class="" style="margin: auto"></div>
            <input type="hidden" class="submit-item" id="word-image" value="/web-content/images/plugin-icon/no-image.jpg">
        </div>
        <form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="">
            <div class="form-group text-center">
                <label>Âm Thanh</label>
                <div class="input-group">
                    <input type="file" id="word-audio" name="post_audio" class="input-audio" placeholder="ID của từ vựng">
                </div>
            </div>
        </form>
        <input type="hidden" class="submit-item" id="old-audio" value="">
        <button class="btn btn-sm btn-primary margin-top full-width {{$raw_data[0][0]['btn-add-voc']==1?'btn-add-voc':'btn-disabled'}}" style="bottom: 0px;">Đóng góp</button>
    </div>
</div>

