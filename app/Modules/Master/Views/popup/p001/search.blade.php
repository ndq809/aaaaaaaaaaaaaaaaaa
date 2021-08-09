<div class="panel-header padding-10-l">
    <h5 class="panel-title">Danh Sách Phòng Ban</h5>
</div>
<div class="panel-content padding-10-l">
    <div class="table-fixed-width no-padding-left" min-width='700px'>
        <table class="table table-hover table-bordered table-refer">
            <thead>
                <tr>
                    <th>ID</th>
                    <th width="100px">Mã Phòng Ban</th>
                    <th>Tên Phòng Ban</th>
                    <th>Tên Viết Tắt</th>
                    <th>Bộ Phận</th>
                    <th>Ghi Chú</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data)&&$data[0][0]['department_id'] != '')
                @foreach($data[0] as $value=>$row)
                <tr>
                    <td>{{$value+1}}</td>
                    <td class="refer-item">{!! $row['department_id'] !!}</td>
                    <td class="refer-item">{!! $row['department_nm'] !!}</td>
                    <td>{!! $row['department_ab_nm'] !!}</td>
                    <td>{!! $row['section_nm'] !!}</td>
                    <td>{!! $row['remark'] !!}</td>
                </tr>
                @endforeach
                @else
                 <tr>
                    @if(isset($data[0][0]['company_cd']))
                        <td colspan="7">Xin nhập điều kiện tìm kiếm</td>
                    @else
                        <td colspan="7">Không có bản ghi nào khớp với điều kiệm tìm kiếm</td>
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
        <div class=" text-center no-padding-left paging">
            {!!Paging::show($paging,0)!!}
        </div>
    @endif
</div>
