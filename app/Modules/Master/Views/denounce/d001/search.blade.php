<div class="panel main-panel col-xs-12">
    <div class="panel-header padding-10-l">
        <h5 class="panel-title">Danh Sách Tố Cáo</h5>
    </div>
    <div class="panel-content padding-10-l">
        <div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-input table-hover-body" id="denounce-header">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã Người Dùng</th>
                        <th>Tên Người Dùng</th>
                        <th>Loại Bị Tố Cáo</th>
                        <th>Số lượng Bị Tố Cáo</th>
                        <th>Lịch Sử Vi Phạm</th>
                        <th width="180px">Xử Lý</th>
                        <th width="180px">Kết Quả Xử Lý</th>
                    </tr>
                </thead>
                    @if(isset($data)&&$data[0][0]['id'] != '')
                    @php($temp=-1)
                    @foreach($data[0] as $index => $row)
                @if($temp!=$row['id'])
                {!!'<tbody>'!!}
                @php($temp=$row['id'])
                @endif
                    <tr>
                        @if($row['row_id']==1)
                        <td rowspan="{{$row['target_count']}}">
                            {{$row['id']}}
                        </td>
                        <td rowspan="{{$row['target_count']}}">
                            <span>{{$row['target_own_id']}}</span>
                            <input type="hidden" value="{{$row['target_own_id']}}" refer-id='target_own_id'/>
                        </td>
                        <td rowspan="{{$row['target_count']}}"><a class="data-filter" own="{{$row['target_own_id']}}">{{$row['target_own_nm']}}</a></td>
                        @endif
                        <td><a class="data-filter" own="{{$row['target_own_id']}}" role="{{$row['denounce_div']}}">{{$row['denounce_div_nm']}}</a></td>
                        <td class="dropdown">
                            {{$row['denounce_count']}}
                        </td>
                        <td class="edit-flag">Không</td>
                        <td>
                            <select class="form-control do-denounce" disabled>
                                @foreach($data[5] as $item)
                                    <option value="{{$item['number_id']}}">{{$item['content']}}</option>
                                @endforeach
                            </select>
                        </td>
                        @if($row['row_id']==1)
                        <td class="result-flag" rowspan="{{$row['target_count']}}">
                            <span></span>
                            <input type="hidden" value="0" refer-id='result_flag'/>
                        </td>
                        @endif
                    </tr>
                @if($temp!=(isset($data[0][$index+1]['id'])?$data[0][$index+1]['id']:-1))
                {!!'</tbody>'!!}
                @endif
                @endforeach
                    @else
                <tbody>
                <tr>
                        @if(!isset($data))
                            <td colspan="13">Xin nhập điều kiện tìm kiếm</td>
                        @else
                            <td colspan="13">Không có bản ghi nào khớp với điều kiệm tìm kiếm</td>
                        @endif
                    </tr>
                </tbody>
                @endif
            </table>
        </div>
        @if(isset($paging)&&$paging['totalRecord'] != 0)
            <div class=" text-center no-padding-left">
                {!!Paging::show($paging,0)!!}
            </div>
        @endif
    </div>
</div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header padding-10-l">
        <h5 class="panel-title">Chi Tiết Tố Cáo</h5>
    </div>
    <div class="panel-content padding-10-l">
        <div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table id="denounce-detail" class="table table-hover table-bordered table-focus table-input" id="denounce-detail">
            <thead>
                    <tr>
                        <th width='50px'>ID</th>
                        <th width='150px'>Chủ Của Đối Tượng</th>
                        <th width='150px'>Mã Đối Tượng</th>
                        <th>Nội Dung Bị Tố Cáo</th>
                        <th width='200px'>Loại Tố Cáo</th>
                        <th width='150px'>Số Người Tố Cáo</th>
                        <th width='150px'>Số Lượng Note</th>
                        <th width="180px">Xử Lý</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($data)&&$data[1][0]['id'] != '')
                    @foreach($data[1] as $index => $row)
                    <tr own="{{$row['target_own_id']}}" role="{{$row['denounce_div']}}" class="hidden">
                        <td rowspan='2'>{{$index+1}}</td>
                        <td refer-id='target_own_nm' rowspan='2'>
                            {{$row['target_own_nm']}}
                            <input type="hidden" value="{{$row['target_own_id']}}" refer-id='target_own_id'/>
                        </td>
                        <td refer-id='target_id' rowspan='2'>
                            {{$row['target_id']}}
                            <input type="hidden" value="{{$row['target_id']}}" refer-id='target_id'/>
                        </td>
                        <td refer-id='target_nm'><span>{{$row['target_nm']}}</span></td>
                        <td refer-id='denounce_div_nm' rowspan='2'>
                            <span>{{$row['denounce_div_nm']}}</span>
                            <input type="hidden" value="{{$row['denounce_div']}}" refer-id='denounce_div'/>
                        </td>
                        <td refer-id='denounce_count' class="dropdown" rowspan='2'>
                            <a class="dropdown-toggle" type="button" id="dropdownMenu5{{$index+1}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">{{$row['denounce_count']}}</span> </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu5{{$index+1}}">
                                @foreach ($data[3] as $item)
                                    @if($item['id']==$row['id'])
                                        <li><a href="#">{{$item['type_nm'].'('.$item['type_count'].')'}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                        <td refer-id='note_count' class="dropdown" rowspan='2'>
                            <a class="dropdown-toggle" type="button" id="dropdownMenu6{{$index+1}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">{{$row['note_count']}}</span> </a>
                            @if($row['note_count']!=0)
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu6{{$index+1}}">
                                @foreach ($data[4] as $item)
                                    @if($item['id']==$row['id'])
                                        <li><a href="#">{{$item['comment']}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                            @endif
                        </td>
                        <td rowspan='2'>
                            <select class="form-control do-denounce-detail" refer-id='result_flag_detail'>
                                @foreach($data[5] as $item)
                                    <option value="{{$item['number_id']}}">{{$item['content']}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr own="{{$row['target_own_id']}}" role="{{$row['denounce_div']}}" class="hidden">
                        <td refer-id='target_nm'>
                            <button class="btn btn-sm btn-default btn-detail full-width">Chi Tiết</button>
                            <span class="detail margin-top" style="display:none;">
                            @switch($row['denounce_div'])
                                @case(1)
                                    {!!$row['target_nm_detail']!!}
                                    @break
                                @case(2)
                                    {!!$row['target_nm_detail']!!}
                                    @break
                                @case(3)
                                    <img src="{!!$row['target_nm_detail']!!}" alt="avarta" width="100px" height="100px" >
                                    @break
                            @endswitch
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="13">Xin chọn một mục ở danh sách phía trên để hiển thị chi tiết</td>
                    </tr>
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
    </div>
</div>

