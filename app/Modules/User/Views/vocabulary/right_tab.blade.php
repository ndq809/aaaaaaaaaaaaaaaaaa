<div id="tab1" class="tab-pane fade active in">
    <div class="">
        <table class="table table-striped table-hover table-right">
            <tbody>
                @if(isset($data)&&$data[0]['id'] != '')
                    @foreach($data as $index => $row)
                        @if($row['remembered']==0)
                            <tr id="{{$row['row_id']}}">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> {{$row['vocabulary_nm']}}</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default {{$raw_data[0][0]['btn-remember']==1?'btn-remember':'btn-disabled'}}">Đã thuộc</button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
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
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> {{$row['vocabulary_nm']}}</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default {{$raw_data[0][0]['btn-forget']==1?'btn-forget':'btn-disabled'}}">Đã quên</button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>