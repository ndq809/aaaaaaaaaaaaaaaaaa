<div class="form-group table-fixed-width" min-width="1024px">
    <a type="button" href="/master/popup/p003" class="btn btn-sm btn-primary btn-popup">Duyệt danh sách từ vựng</a>
    <table class="table table-bordered table-input submit-table">
        <thead>
            <tr>
                <th width="40px">STT</th>
                <th>Loại Từ</th>
                <th width="200px">Tên</th>
                <th width="200px">Phiên Âm</th>
                <th>Nghĩa</th>
                <th>Giải Thích (Tiếng Anh)</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($data_voc))
            @foreach($data_voc as $index=>$value)
            <tr>
                <td>{{$index+1}}</td>
                <td class="hidden" refer-id="vocabulary_code">{{isset($value)?$value['vocabulary_code']:''}}</td>
                <td refer-id="vocabulary_div">{{isset($value)?$value['vocabulary_div']:''}}</td>
                <td refer-id="vocabulary_nm" >{{isset($value)?$value['vocabulary_nm']:''}}</td>
                <td refer-id="spelling" >{{isset($value)?$value['spelling']:''}}</td>
                <td refer-id="mean">{{isset($value)?$value['mean']:''}}</td>
                <td refer-id="explain">{{isset($value)?$value['explain']:''}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
