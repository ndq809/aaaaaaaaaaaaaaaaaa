<div class="col-sm-2 no-padding-right no-padding-left">
    <label>Tổng số nhóm cần học: {{isset($data[1][0])?$data[1][0]['group_count']:''}}</label>
</div>
<div class="col-sm-2 no-padding-right no-padding-left">
    <label>Tổng số bài cần học : {{isset($data[1][0])?$data[1][0]['post_sum']:''}}</label>
</div>
<div class="col-xs-12 no-padding-right no-padding-left">
    <div class="table-fixed-width no-padding-left" min-width="700px">
        <table class="table table-bordered table-input submit-table">
            <thead>
                <tr>
                    <th width="40px">STT</th>
                    <th >Tên Nhóm</th>
                    <th width="100px">Số Bài Học</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data[0])&&$data[0][0]['group_nm']!='')
                @foreach($data[0] as $index=>$value)
                <tr>
                    <td>{{$index+1}}</td>
                    <td refer-id="vocabulary_code">{{isset($value)?$value['group_nm']:''}}</td>
                    <td class="refer-item" refer_id="vocabulary_nm">{{$value['post_count']}}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>



