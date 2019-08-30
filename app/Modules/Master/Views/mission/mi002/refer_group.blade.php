<div class="col-sm-2 no-padding-right no-padding-left">
    <label>Tổng số bài cần học: {{isset($data[1][0])?$data[1][0]['post_count']:''}}</label>
    <input type="hidden" class="total_unit" name="" value="{{isset($data[1][0])?$data[1][0]['post_count']:'0'}}">
</div>
<div class="col-xs-12 no-padding-right no-padding-left">
    <div class="table-fixed-width no-padding-left" min-width="700px">
        <table class="table table-bordered table-input submit-table">
            <thead>
                <tr>
                    <th width="40px">STT</th>
                    <th >Tên Bài Học</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data[0])&&$data[0][0]['post_nm']!='')
                @foreach($data[0] as $index=>$value)
                <tr>
                    <td>{{$index+1}}</td>
                    <td refer-id="vocabulary_code">{{isset($value)?$value['post_nm']:''}}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>



