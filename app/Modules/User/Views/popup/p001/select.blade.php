<div class="table-fixed-width no-padding-left" min-width='700px'>
    <table class="table table-hover table-bordered table-refer table-preview table-custom">
        <thead>
            <tr>
                <th width="40px">Xóa</th>
                <th class="hidden"></th>
                <th width="150px">Tên Từ Vựng</th>
                <th width="100px">Loại Từ Vựng</th>
                <th width="150px">Phiên Âm</th>
                <th>Nghĩa</th>
                <th>Giải Thích</th>
                <th width="100px">Hình Ảnh</th>
                <th width="100px">Âm Thanh</th>
                <th>Ghi Chú</th>
                <th class="hidden"></th>
            </tr>
        </thead>
        <tbody>
            @if(isset($data)&&$data[0]['vocabulary_id'] != '')
            @foreach($data as $index => $row)
            <tr>
                <td><button class="btn btn-danger btn-delete-row" type="button"><span class="fa fa-close"></span></button></td>
                <td class="hidden" refer_id="row_id">{{$row['row_id']}}</td>
                <td class="hidden" refer_id="id">{{$row['id']}}</td>
                <td class="refer-item" refer_id="vocabulary_nm">{{$row['vocabulary_nm']}}</td>
                <td >{{$row['vocabulary_div_nm']}}</td>
                <td refer_id="spelling">{{$row['spelling']}}</td>
                <td refer_id="mean">{{$row['mean']}}</td>
                <td refer_id="explain">{{$row['explain']}}</td>
                <td refer_id="image"><a title="<img src='{{$row['image']}}' />" class="preview">{{$row['image']!=''?'Xem trước':''}}</a></td>
                <td refer_id="audio"><audio class="sound1" src="{{$row['audio']}}" ></audio><a type="button" class="preview-audio">{{$row['audio']!=''?'Nghe thử':''}}</a></td>
                <td refer_id="remark">{{$row['remark']}}</td>
                <td class="hidden" refer_id="vocabulary_div">{{$row['vocabulary_div']}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
