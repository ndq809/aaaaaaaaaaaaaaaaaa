<div class="table-fixed-width no-padding-left" min-width='700px'>
    <table class="table table-hover table-bordered table-preview table-custom">
        <thead>
            <tr>
                <th width="40px">Chọn</th>
                <th class="hidden"></th>
                <th width="50px">Mã TV</th>
                <th width="70px">Phiên Bản</th>
                <th width="250px">Tên Từ Vựng</th>
                <th width="100px">Chuyên Ngành</th>
                <th width="150px">Lĩnh Vực</th>
                <th width="100px">Loại Từ Vựng</th>
                <th width="150px">Phiên Âm</th>
                <th>Nghĩa</th>
                <th width="100px">Hình Ảnh</th>
                <th width="100px">Âm Thanh</th>
                <th class="hidden"></th>
            </tr>
        </thead>
        <tbody>
            @if(isset($data)&&$data[0][0]['vocabulary_id'] != '')
            @foreach($data[0] as $index => $row)
            <tr>
                <td><button class="btn btn-primary full-width btn-add" type="button"><span class="fa fa-arrow-down"></span></button></td>
                <td class="refer-item hidden" refer_id="vocabulary_code">{{$row['vocabulary_code']}}</td>
                <td >{{$row['vocabulary_id']}}</td>
                <td >{{$row['vocabulary_dtl_id']}}</td>
                <td class="refer-item text-left" refer_id="vocabulary_nm">{{$row['vocabulary_nm']}}</td>
                <td >{{$row['specialized_div_nm']}}</td>
                <td >{{$row['field_div_nm']}}</td>
                <td >{{$row['vocabulary_div_nm']}}</td>
                <td class="refer-item" refer_id="spelling">{{$row['spelling']}}</td>
                <td class="refer-item text-left" refer_id="mean">{{$row['mean']}}</td>
                <td class="refer-item" refer_id="image"><a title="<img src='{{$row['image']}}' />" class="preview">{{$row['image']!=''?'Xem trước':''}}</a></td>
                <td class="refer-item" refer_id="audio"><audio class="sound1" src="{{$row['audio']}}" ></audio><a type="button" class="preview-audio">{{$row['audio']!=''?'Nghe thử':''}}</a></td>
                <td class="refer-item hidden" refer_id="vocabulary_div">{{$row['vocabulary_div']}}</td>
            </tr>
            @endforeach
             @else
             <tr>
                @if(!isset($data))
                    <td colspan="11">Xin nhập điều kiện tìm kiếm</td>
                @else
                    <td colspan="11">Không có bản ghi nào khớp với điều kiệm tìm kiếm</td>
                @endif
            </tr>
            @endif
        </tbody>
    </table>
</div>
@if(!isset($paging))
    @php
        $paging=array('page' => 6,'pagesize' => 15,'totalRecord' => 0,'pageMax'=>10 )
    @endphp
@endif
@if($paging['totalRecord'] != 0)
    <div class=" text-center no-padding-left">
        {!!Paging::show($paging,0)!!}
    </div>
@endif
