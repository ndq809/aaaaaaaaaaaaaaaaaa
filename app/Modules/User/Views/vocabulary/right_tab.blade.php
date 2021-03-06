@php($count = 0)
<div id="tab1" class="tab-pane fade active in">
    <div class="">
        <table class="table table-striped table-hover table-right">
            <tbody>
                @if(isset($data)&&$data[0]['id'] != '')
                    @foreach($data as $index => $row)
                        @if($row['remembered']==0)
                            <tr id="{{$row['row_id']}}">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span class="voc_nm"> {{$row['vocabulary_nm']}}</span><span class="voc_pass hidden">*****</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default {{$raw_data[0][0]['btn-remember']==1?'btn-remember':'btn-disabled'}}" {{$raw_data[0][0]['btn-remember']==1?'':'rank='.$raw_data[0][0]['btn-remember']}}>Đã thuộc</button>
                                </td>
                            </tr>
                            @php($count = $count + 1)
                        @endif
                    @endforeach
                    <tr id="-100" class="no-row {{$count!=0?'hidden':''}}">
                        <td colspan="2">
                            <a class="radio-inline"><i class="fa fa-minus-circle"> </i> <span> Không có dữ liệu !</span> </a>
                        </td>
                    </tr>
                @endif
                @php($count = 0)
            </tbody>
        </table>
    </div>
</div>
<div id="tab2" class="tab-pane fade">
    <div class="">
        <table class="table table-striped table-hover table-right">
            <tbody>
                 @if(isset($data)&&$data[0]['id'] != '')
                    @foreach($data as $index => $row)
                        @if($row['remembered']==1)
                            <tr id="{{$row['row_id']}}">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span class="voc_nm"> {{$row['vocabulary_nm']}}</span><span class="voc_pass hidden">***</span> </a> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default {{$raw_data[0][0]['btn-forget']==1?'btn-forget':'btn-disabled'}}" {{$raw_data[0][0]['btn-forget']==1?'':'rank='.$raw_data[0][0]['btn-forget']}}>{{$row['del_flg']==0?'Đã quên':'Xóa'}}</button>
                                </td>
                            </tr>
                            @php($count = $count + 1)
                        @endif
                    @endforeach
                   <tr id="-100" class="no-row {{$count!=0?'hidden':''}}">
                        <td colspan="2">
                            <a class="radio-inline"><i class="fa fa-minus-circle"> </i> <span> Không có dữ liệu !</span> </a>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>