<div class="panel-header padding-10-l">
    <h5 class="panel-title">Danh Sách Từ Vựng</h5>
</div>
<div class="panel-content padding-10-l">
    <div class="table-fixed-width no-padding-left" min-width='1200px'>
        <table class="table table-hover table-bordered table-checkbox table-preview">
            <thead>
                <tr>
                    <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                    <th width="50px">ID</th>
                    <th width="50px">Mã NV</th>
                    <th width="150px">Loại NV</th>
                    <th width="150px">Loại Dữ Liệu NV</th>
                    <th width="150px">Loại Danh Mục</th>
                    <th width="150px">Tên Danh Mục</th>
                    <th width="100px">Tên Nhóm</th>
                    <th>Tên NV</th>
                    <th width="150px">Điểm KN</th>
                    <th width="100px">Điểm ĐG</th>
                    <th width="100px">Thời Gian</th>
                    <th width="100px">Giới Hạn Rank</th>
                    <th width="100px">SL Tối Thiểu</th>
                    <th width="70px">Trạng Thái</th>
                    <th width="40px"></th>
                    <th class="hidden"></th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data)&&$data[0][0]['mission_id'] != '')
                @foreach($data[0] as $index => $row)
                <tr>
                    <td><input type="checkbox" name="" class="sub-checkbox"></td>
                    <td>{{$index+1}}</td>
                    <td class="refer-item" refer_id="mission_id">{{$row['mission_id']}}</td>
                    <td class="refer-item" refer_id="mission_div">{{$row['mission_div']}}</td>
                    <td class="refer-item" refer_id="mission_data_div">{{$row['mission_data_div']}}</td>
                    <td >{{$row['catalogue_div']}}</td>
                    <td >{{$row['catalogue_nm']}}</td>
                    <td >{{$row['group_nm']}}</td>
                    <td class="refer-item" refer_id="mission_nm">{{$row['mission_nm']}}</td>
                    <td class="refer-item" refer_id="exp">{{$row['exp']}}</td>
                    <td class="refer-item" refer_id="cop">{{$row['ctp']}}</td>
                    <td class="refer-item" refer_id="period">{{$row['period']}}</td>
                    <td class="refer-item" refer_id="rank">{{$row['rank']}}</td>
                    <td class="refer-item" refer_id="unit_per_times">{{$row['unit_per_times']}}</td>
                    <td class="record-div-icon">
                        @if($row['record_div']==0)
                        <i class="fa fa-ban text-danger" title="{{$row['record_div_nm']}}"></i>
                        @elseif($row['record_div']==1)
                        <i class="fa fa-check text-primary" title="{{$row['record_div_nm']}}"></i>
                        @else
                        <i class="fa fa-send text-success" title="{{$row['record_div_nm']}}"></i>
                        @endif
                    </td>
                    <td><a href="/master/mission/mi002?{{$row['mission_id']}}" ><span class="fa fa fa-pencil-square-o fa-lg"></span></a></td>
                    <td class="refer-item hidden" refer_id="mission_div">{{$row['mission_div']}}</td>
                </tr>
                @endforeach
                 @else
                 <tr>
                    @if(!isset($data))
                        <td colspan="16">Xin nhập điều kiện tìm kiếm</td>
                    @else
                        <td colspan="16">Không có bản ghi nào khớp với điều kiệm tìm kiếm</td>
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
