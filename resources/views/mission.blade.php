<div class="modal-header">
    <button class="close" data-dismiss="modal" type="button">
        ×
    </button>
    <h5 class="modal-title">
        CHI TIẾT NHIỆM VỤ
    </h5>
</div>
<div class="modal-body" style="padding: 0px 10px">
    <div class="form-group" min-width="1024px">
        <div class="row">
            <input type="hidden" id="mission-id" value="{{isset($data[0]['mission_id'])?$data[0]['mission_id']:''}}">
            <div class="col-xs-12">
                <label><span style="color: #009688;font-family: 'textfont';font-size: 20px">{{isset($data[0]['title'])?$data[0]['title']:''}}</span></label>
            </div>
            <div class="col-xs-12 no-padding" style="margin-left: 3px;">
                <div class="mission-content">
                    {!!isset($data[0]['content'])?$data[0]['content']:''!!}
                </div>
            </div>
            <div class="col-xs-12 mission-part">
                <div class="form-group margin-bottom">
                    <label class="title-label">Độ khó nhiệm vụ</label>
                    <div class="input-group">
                        <select style="width: 100px" class="inline-block form-control input-sm" id="mission-level" {{$data[0]['condition']==0?'':'disabled'}}>
                            @if(isset($data[0]['unit_per_times']))
                                @for($i=1;$i<=5;$i++)
                                <option value="{{$i}}" {{$data[0]['unit_per_times']*$i==$data[0]['unit_this_times']?'selected':''}}>{{$data[0]['unit_per_times']*$i}}</option>
                                @endfor
                            @endif
                        </select>
                        <span class="input-group-text text-follow">(Số bài phải học : <span id="unit_per_times">{{isset($data[0]['unit_per_times'])?$data[0]['unit_per_times']:'0'}}</span>)</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 no-padding mission-part">
                <div class="col-xs-12">
                    <label class="title-label">Nhiệm Vụ Thành Công</label>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <label>Điểm kinh nghiệm: <span style="color: #3c763d" id="exp" value ='{{isset($data[0]['exp'])?$data[0]['exp']:'0'}}'>{{isset($data[0]['exp'])&&$data[0]['exp']!=''?'+ '.$data[0]['exp']:'+ 0'}}</span></label>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <label>Điểm đóng góp: <span style="color: #3c763d" id="cop" value='{{isset($data[0]['ctp'])?$data[0]['ctp']:'0'}}'>{{isset($data[0]['ctp'])&&$data[0]['ctp']!=''?'+ '.$data[0]['ctp']:'+ 0'}}</span></label>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <div class="col-xs-12">
                    <label class="title-label">Nhiệm Vụ Thất Bại</label>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <label>Điểm kinh nghiệm: <span style="color: #d9534f" id="failed_exp" value ='{{isset($data[0]['failed_exp'])?$data[0]['failed_exp']:'0'}}'>{{isset($data[0]['failed_exp'])&&$data[0]['failed_exp']!=''?'- '.$data[0]['failed_exp']:'- 0'}}</span></label>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <label>Điểm đóng góp: <span style="color: #d9534f" id="failed_cop" value='{{isset($data[0]['failed_ctp'])?$data[0]['failed_ctp']:'0'}}'>{{isset($data[0]['failed_ctp'])&&$data[0]['failed_ctp']!=''?'- '.$data[0]['failed_ctp']:'- 0'}}</span></label>
                </div>
            </div>
        </div>
    </div>
</div>
@if(isset($data[0]['condition'])&&$data[0]['condition']==3)
<div class="modal-footer">
    <button class="btn btn-danger btn-sm" data-dismiss="modal" type="button" disabled="disabled">
        Bạn đã từ chối nhiệm vụ này!
    </button>
    <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">
        Đóng
    </button>
</div>
@elseif(isset($data[0]['condition'])&&$data[0]['condition']==2)
<div class="modal-footer">
    <button class="btn btn-success btn-sm" type="button" disabled="disabled">
        Bạn đã hoàn thành nhiệm vụ này!
    </button>
    <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">
        Đóng
    </button>
</div>
@elseif(isset($data[0]['condition'])&&$data[0]['condition']==4)
<div class="modal-footer">
    <button class="btn btn-danger btn-sm" type="button" disabled="disabled">
        Nhiệm vụ này đã thất bại!
    </button>
    <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">
        Đóng
    </button>
</div>
@elseif(Session::get('mission')!=null||(Session::get('doMission')!=null&&Session::get('doMission')==1))
<div class="modal-footer">
    <button class="btn btn-warning btn-sm" type="button" disabled="">
        {{isset($data[0]['mission_id'])&&$data[0]['mission_id']==Session::get('mission')['mission_id']?'Bạn đang thực hiện nhiệm vụ này':'Bạn đang thực hiện nhiệm vụ khác!'}}
    </button>
    <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">
        Đóng
    </button>
</div>
@elseif(isset($data[0]['condition'])&&$data[0]['condition']==0)
<div class="modal-footer">
    <button class="btn btn-primary btn-sm" id="btn-accept-mission" type="button">
        Chấp Nhận Nhiệm Vụ 
    </button>
    <button class="btn btn-default btn-sm" type="button" id="btn-refuse-mission">
        Từ Chối Nhiệm Vụ
    </button>
</div>
@else
<div class="modal-footer">
    <button class="btn btn-primary btn-sm" id="btn-do-mission" type="button" {{isset($data[0]['try_times_count'])&&$data[0]['try_times_count']>=$data[0]['try_times']?'disabled':''}}>
        Thực Hiện Nhiệm Vụ(Còn {{isset($data[0]['try_times_count'])?($data[0]['try_times']-$data[0]['try_times_count']):'0'}}/{{$data[0]['try_times']}})
    </button>
    <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">
        Đóng
    </button>
</div>
@endif