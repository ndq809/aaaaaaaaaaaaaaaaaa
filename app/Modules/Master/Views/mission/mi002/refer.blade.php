<div class="col-sm-3 no-padding-right">
    <div class="form-group">
        <label>Mã Nhiệm Vụ</label>
        <div class="input-group">
            <input type="text" id="vocabulary_id" name="" class="form-control input-sm submit-item" placeholder="Mã từ vựng" value="{{isset($data[3])?$data[3][0]['vocabulary_id']:''}}">
        </div>
    </div>
</div>
<div class="col-sm-3 no-padding-right">
    <div class="form-group">
        <label>Loại Nhiệm Vụ</label>
        <select id="mission_div" class="submit-item required">
            @foreach($data_default[0] as $item)
                <option value="{{$item['number_id']}}">{{$item['content']}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-3 no-padding-right">
    <div class="form-group">
        <label>Loại Dữ Liệu Nhiệm Vụ</label>
        <select id="mission_data_div" class="submit-item required">
            @foreach($data_default[1] as $item)
                <option value="{{$item['number_id']}}">{{$item['content']}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-sm-3 no-padding-right">
    <div class="form-group">
        <label>Loại Danh Mục</label>
        <select id="catalogue_div" class="submit-item required">
            @foreach($data_default[2] as $item)
                <option value="{{$item['number_id']}}">{{$item['content']}}</option>
            @endforeach
        </select>
    </div>
</div>
 <div class="col-sm-3 no-padding-right transform-content" transform-div='1,2,3,4,5,11'>
    <div class="form-group">
        <label>Tên Danh Mục</label>
        <select class="submit-item allow-selectize required" id="catalogue_nm">
            <option value=""></option>
        </select>
    </div>
</div>
<div class="col-sm-3 no-padding-right transform-content" transform-div='1,2,3,4,5,11'>
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
            <input type="text" name="" id="mission_nm" class="form-control input-sm submit-item required" placeholder="Tên nhiệm vụ" value="{{isset($data[3])?$data[3][0]['vocabulary_nm']:''}}">
        </div>
    </div>
</div>
<div class="col-xs-12"></div>
<div class="col-sm-2 no-padding-right">
    <div class="form-group">
        <label>Điểm Kinh Nghiệm</label>
        <div class="input-group">
            <input type="text" name="" id="exp" class="form-control input-sm submit-item" placeholder="Điểm kinh nghiệm" value="{{isset($data[3])?$data[3][0]['vocabulary_nm']:''}}">
        </div>
    </div>
</div>
<div class="col-sm-2 no-padding-right">
    <div class="form-group">
        <label>Điểm Đóng Góp</label>
        <div class="input-group">
            <input type="text" name="" id="cop" class="form-control input-sm submit-item" placeholder="Điểm đóng góp" value="{{isset($data[3])?$data[3][0]['vocabulary_nm']:''}}">
        </div>
    </div>
</div>
<div class="col-sm-4 no-padding-right">
    <div class="form-group">
        <label>Giới Hạn Rank</label>
        <div class="input-group">
            <select id="rank-from" class="submit-item">
                @foreach($data_default[3] as $item)
                    <option value="{{$item['number_id']}}" placeholder="Rank bắt đầu">{{$item['content']}}</option>
                @endforeach
            </select>
            <span class="input-group-text">~</span>
            <select id="rank-to" class="submit-item">
                @foreach($data_default[3] as $item)
                    <option value="{{$item['number_id']}}" placeholder="Rank kết thúc" class="hidden">{{$item['content']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="col-sm-4 no-padding-right">
    <div class="form-group">
        <label>Thời Gian Thực Hiện</label>
        <div class="input-group picker">
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            <input type="text" name="" class="form-control input-sm" data-field="date" data-format="dd/MM/yyyy" value="" readonly="" id="date-from" placeholder="Thời gian bắt đầu">
            <span class="input-group-text">~</span>
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            <input type="text" name="" class="form-control input-sm" data-field="date" data-format="dd/MM/yyyy" value="" readonly="" id="date-to" placeholder="Thời gian kết thúc">
        </div>
    </div>
</div>
<div class="col-sm-12 no-padding-right">
    <div class="form-group">
        <label>Nội Dung</label>
        <div class="input-group content-box">
            <textarea name="gra-content" id="post_content" contenteditable="true" class="form-control input-sm ckeditor submit-item" rows="3"></textarea>
        </div>
    </div>
</div>
<div class="col-sm-12 no-padding-right transform-content" transform-div='1,3,4,5'>
    <div class="form-group table-fixed-width" min-width="1024px">
        <a type="button" href="/master/popup/p003" class="btn btn-sm btn-primary btn-popup">Duyệt danh sách bài viết</a>
        <div id="result">
            @include('Master::writing.w002.refer_voc')
        </div>
    </div>
</div>

