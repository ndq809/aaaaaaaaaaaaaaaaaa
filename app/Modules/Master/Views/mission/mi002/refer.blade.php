<div class="col-sm-3 no-padding-right">
    <div class="form-group">
        <label>Mã Nhiệm Vụ</label>
        <div class="input-group">
            <input type="text" id="mission_id" name="" class="form-control input-sm submit-item" placeholder="Mã từ vựng" value="{{isset($data_default[4])?$data_default[4][0]['mission_id']:''}}">
        </div>
    </div>
</div>
<div class="col-sm-3 no-padding-right">
    <div class="form-group">
        <label>Loại Nhiệm Vụ</label>
        <select id="mission_div" class="submit-item required">
            @foreach($data_default[0] as $item)
                <option value="{{$item['number_id']}}" {{isset($data_default[4])&&($data_default[4][0]['mission_div']==$item['number_id'])?'selected':''}}>{{$item['content']}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-3 no-padding-right">
    <div class="form-group">
        <label>Loại Dữ Liệu Nhiệm Vụ</label>
        <select id="mission_data_div" class="submit-item required">
            @foreach($data_default[1] as $item)
                <option value="{{$item['number_id']}}" {{isset($data_default[4])&&($data_default[4][0]['mission_data_div']==$item['number_id'])?'selected':''}}>{{$item['content']}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-3 no-padding-right">
    <div class="form-group">
        <label>Loại Danh Mục</label>
        <select id="catalogue_div" class="submit-item required">
            @foreach($data_default[2] as $item)
                <option value="{{$item['number_id']}}" {{isset($data_default[4])&&($data_default[4][0]['catalogue_div']==$item['number_id'])?'selected':''}}>{{$item['content']}}</option>
            @endforeach
        </select>
    </div>
</div>
 <div class="col-sm-3 no-padding-right">
    <div class="form-group">
        <label>Tên Danh Mục</label>
        <select class="submit-item allow-selectize required" id="catalogue_nm">
            <option value=""></option>
        </select>
    </div>
</div>
<div class="col-sm-3 no-padding-right">
    <div class="form-group">
        <label>Tên Nhóm</label>
        <select id="group_nm" class="submit-item allow-selectize required">
            <option value=""></option>
        </select>
    </div>
</div>
<div class="col-sm-6 no-padding-right">
    <div class="form-group">
        <label>Tên Nhiệm Vụ</label>
        <div class="input-group">
            <input type="text" name="" id="mission_nm" class="form-control input-sm submit-item required" placeholder="Tên nhiệm vụ" value=" {{isset($data_default[4])?$data_default[4][0]['title']:''}}">
        </div>
    </div>
</div>
<div class="col-xs-12"></div>
<div class="col-sm-2 no-padding-right">
    <div class="form-group">
        <label>Điểm Kinh Nghiệm</label>
        <div class="input-group">
            <input type="text" name="" id="exp" class="form-control input-sm submit-item" placeholder="Điểm kinh nghiệm" value="{{isset($data_default[4])?$data_default[4][0]['exp']:''}}">
        </div>
    </div>
</div>
<div class="col-sm-2 no-padding-right">
    <div class="form-group">
        <label>Điểm Đóng Góp</label>
        <div class="input-group">
            <input type="text" name="" id="cop" class="form-control input-sm submit-item" placeholder="Điểm đóng góp" value="{{isset($data_default[4])?$data_default[4][0]['cop']:''}}">
        </div>
    </div>
</div>
<div class="col-sm-2 no-padding-right">
    <div class="form-group">
        <label>Thời Gian Cần Thực Hiện</label>
        <div class="input-group">
            <input type="text" name="" class="form-control input-sm submit-item" value="{{isset($data_default[4])?$data_default[4][0]['period']:''}}" id="period" placeholder="Thời gian cần thực hiện">
            <span class="input-group-text">Giờ</span>
        </div>
    </div>
</div>
<div class="col-sm-4 no-padding-right">
    <div class="form-group">
        <label>Giới Hạn Rank</label>
        <div class="input-group">
            <select id="rank-from" class="submit-item">
                @foreach($data_default[3] as $item)
                    <option value="{{$item['number_id']}}" {{isset($data_default[4])&&($data_default[4][0]['rank_from']==$item['number_id'])?'selected':''}} placeholder="Rank bắt đầu">{{$item['content']}}</option>
                @endforeach
            </select>
            <span class="input-group-text">~</span>
            <select id="rank-to" class="submit-item">
                @foreach($data_default[3] as $item)
                    <option value="{{$item['number_id']}}" {{isset($data_default[4])&&($data_default[4][0]['rank_to']==$item['number_id'])?'selected':''}} placeholder="Rank kết thúc" class="hidden">{{$item['content']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="col-sm-2 no-padding-right">
    <div class="form-group">
        <label>Số lượng tối thiểu</label>
        <div class="input-group">
            <input type="text" name="" id="unit_per_times" class="form-control input-sm submit-item" placeholder="Số lượng tối thiểu 1 lần thực hiện" value="{{isset($data_default[4])?$data_default[4][0]['unit_per_times']:''}}">
        </div>
    </div>
</div>
<div class="col-sm-12 no-padding-right">
    <div class="form-group">
        <label>Nội Dung</label>
        <div class="input-group content-box">
            <textarea name="gra-content" id="mission_content" contenteditable="true" class="form-control input-sm ckeditor submit-item" rows="3">{{isset($data_default[4])?$data_default[4][0]['content']:''}}</textarea>
        </div>
    </div>
</div>