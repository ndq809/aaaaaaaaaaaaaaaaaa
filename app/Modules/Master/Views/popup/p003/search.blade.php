<div class="panel-header padding-10-l">
    <h5 class="panel-title">Danh Sách Từ Vựng</h5>
</div>
<div class="panel-content padding-10-l">
    <div class="table-fixed-width no-padding-left" min-width='700px'>
        <table class="table table-hover table-bordered table-refer">
            <thead>
                <tr>
                    <th width="50px">ID</th>
                    <th width="100px">Mã Từ Vựng</th>
                    <th width="70px">Mã Con</th>
                    <th width="150px">Tên Từ Vựng</th>
                    <th width="100px">Loại Từ Vựng</th>
                    <th width="150px">Phiên Âm</th>
                    <th>Nghĩa</th>
                    <th>Giải Thích</th>
                    <th>Ghi Chú</th>
                    <th class="hidden"></th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data)&&$data[0][0]['vocabulary_id'] != '')
                @foreach($data[0] as $index => $row)
                <tr>
                    <td>{{$index+1}}</td>
                    <td class="refer-item" refer_id="vocabulary_id">{{$row['vocabulary_id']}}</td>
                    <td class="refer-item" refer_id="vocabulary_dtl_id">{{$row['vocabulary_dtl_id']}}</td>
                    <td class="refer-item" refer_id="vocabulary_nm">{{$row['vocabulary_nm']}}</td>
                    <td >{{$row['vocabulary_div_nm']}}</td>
                    <td class="refer-item" refer_id="spelling">{{$row['spelling']}}</td>
                    <td class="refer-item" refer_id="mean">{{$row['mean']}}</td>
                    <td class="refer-item" refer_id="explain">{{$row['explain']}}</td>
                    <td class="refer-item" refer_id="remark">{{$row['remark']}}</td>
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
</div>
