<div class="modal-header">
    <button class="close" data-dismiss="modal" type="button">
        ×
    </button>
    <h5 class="modal-title">
        BÁO CÁO BÀI VIẾT
    </h5>
</div>
@if(!isset($denounce_data[0]['reported']))
<div class="modal-body report-box">
    @if(!isset($done))
    <input type="hidden" class="submit-item" id="target" value="{{$target}}">
    <input type="hidden" class="submit-item" id="report-div" value="{{$report_div}}">
    <div class="form-group">
        <label>
            Các Lỗi Vi Phạm
        </label>
        <div class="row">
        @foreach($denounce_data as $index=>$item)
            <div class="col-md-6 col-sm-6">
                <label class="checkbox-inline"><input type="checkbox" class="submit-item checkbox" checked="" id="report{{$item['denounce_remark']}}">{{$item['denounce_name']}}</label>
            </div>
        @endforeach
        </div>
    </div>
    <div class="form-group">
        <label>
            Ghi chú thêm
        </label>
        <div class="input-group">
            <textarea class="form-control input-sm submit-item" id="note" rows="2" ></textarea>
        </div>
    </div>
    @else
        <h5>Báo cáo của bạn đã được gửi đi!</h5>
    @endif
</div>
<div class="modal-footer">
    @if(!isset($done))
    <button class="btn btn-primary btn-sm btn-report" type="button">
        Gửi Báo Cáo
    </button>
    @endif
    <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">
        Đóng
    </button>
</div>
@else
<div class="modal-body report-box">
    <h5>Bạn đã báo cáo nội dung này rồi!</h5>
</div>
@endif