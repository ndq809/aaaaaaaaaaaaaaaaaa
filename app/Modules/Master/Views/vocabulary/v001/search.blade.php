<div class="panel-header padding-10-l">
    <h5 class="panel-title">Danh Sách Từ Vựng</h5>
</div>
<div class="panel-content padding-10-l">
    <div class="table-fixed-width no-padding-left" min-width='700px'>
        <table class="table table-hover table-bordered table-checkbox table-preview">
            <thead>
                <tr>
                    <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                    <th width="50px">ID</th>
                    <th width="50px">Mã TV</th>
                    <th width="70px">Phiên Bản</th>
                    <th width="150px">Tên Từ Vựng</th>
                    <th width="100px">Loại Từ Vựng</th>
                    <th width="150px">Phiên Âm</th>
                    <th>Nghĩa</th>
                    <th>Giải Thích</th>
                    <th width="100px">Hình Ảnh</th>
                    <th width="100px">Âm Thanh</th>
                    <th>Ghi Chú</th>
                    <th width="40px"></th>
                    <th class="hidden"></th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data)&&$data[0][0]['vocabulary_id'] != '')
                @foreach($data[0] as $index => $row)
                <tr>
                    <td><input type="checkbox" name="" class="sub-checkbox"></td>
                    <td>{{$index+1}}</td>
                    <td class="refer-item" refer_id="vocabulary_id">{{$row['vocabulary_id']}}</td>
                    <td class="refer-item" refer_id="vocabulary_dtl_id">{{$row['vocabulary_dtl_id']}}</td>
                    <td class="refer-item" refer_id="vocabulary_nm">{{$row['vocabulary_nm']}}</td>
                    <td >{{$row['vocabulary_div_nm']}}</td>
                    <td class="refer-item" refer_id="spelling">{{$row['spelling']}}</td>
                    <td class="refer-item" refer_id="mean">{{$row['mean']}}</td>
                    <td class="refer-item" refer_id="explain">{{$row['explain']}}</td>
                    <td class="refer-item" refer_id="image"><a title="<img src='{{$row['image']}}' />" class="preview">{{$row['image']!=''?'Xem trước':''}}</a></td>
                    <td class="refer-item" refer_id="audio"><audio class="sound1" src="{{$row['audio']}}" ></audio><a type="button" class="preview-audio">{{$row['audio']!=''?'Nghe thử':''}}</a></td>
                    <td class="refer-item" refer_id="remark">{{$row['remark']}}</td>
                    <td><a href="/master/vocabulary/v002?{{$row['vocabulary_id']}}?{{$row['vocabulary_dtl_id']}}" ><span class="fa fa fa-pencil-square-o fa-lg"></span></a></td>
                    <td class="refer-item hidden" refer_id="vocabulary_div">{{$row['vocabulary_div']}}</td>
                </tr>
                @endforeach
                 @else
                 <tr>
                    @if(!isset($data))
                        <td colspan="13">Xin nhập điều kiện tìm kiếm</td>
                    @else
                        <td colspan="13">Không có bản ghi nào khớp với điều kiệm tìm kiếm</td>
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
