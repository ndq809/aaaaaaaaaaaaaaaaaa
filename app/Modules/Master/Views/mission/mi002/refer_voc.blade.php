<table class="table table-bordered table-input submit-table">
    <thead>
        <tr>
            <th width="40px">STT</th>
            <th width="250px">Tên Từ Vựng</th>
            <th width="100px">Chuyên Ngành</th>
            <th width="150px">Lĩnh Vực</th>
            <th width="100px">Loại Từ Vựng</th>
            <th width="150px">Phiên Âm</th>
            <th>Nghĩa</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($data_voc)&&$data_voc[0]['vocabulary_code']!='')
        @foreach($data_voc as $index=>$value)
        <tr>
            <td>{{$index+1}}</td>
            <td class="hidden" refer-id="id">{{isset($value)?$value['vocabulary_code']:''}}</td>
            <td class="hidden" refer-id="vocabulary_code">{{isset($value)?$value['vocabulary_code']:''}}</td>
            <td class="refer-item" refer_id="vocabulary_nm">{{$value['vocabulary_nm']}}</td>
            <td class="refer-item" refer_id="specialized">{{$value['specialized_div_nm']}}</td>
            <td class="refer-item" refer_id="field">{{$value['field_div_nm']}}</td>
            <td class="refer-item" refer_id="vocabulary_div">{{$value['vocabulary_div_nm']}}</td>
            <td class="refer-item" refer_id="spelling">{{$value['spelling']}}</td>
            <td class="refer-item" refer_id="mean">{{$value['mean']}}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
<input type="hidden" class="total_unit" name="" value="{{isset($data_voc)?count($data_voc):'0'}}">

