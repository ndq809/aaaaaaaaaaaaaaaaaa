<div id="tab1" class="tab-pane fade active in">
    <div class="">
        <table class="table table-striped table-hover table-right">
            <tbody>
                @if(isset($data)&&$data[0]['vocabulary_id'] != '')
                    @foreach($data as $index => $row)
                        @if($row['remembered']==0)
                            @if($index==0)
                            <tr id="{{$row['row_id']}}" class="activeItem">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> {{$row['vocabulary_nm']}}</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default" type-btn="btn-remember">Đã thuộc</button>
                                </td>
                            </tr>
                            @else
                            <tr id="{{$row['row_id']}}">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> {{$row['vocabulary_nm']}}</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default" type-btn="btn-remember">Đã thuộc</button>
                                </td>
                            </tr>
                            @endif
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
                 @if(isset($data)&&$data[0]['vocabulary_id'] != '')
                    @foreach($data as $index => $row)
                        @if($row['remembered']==1)
                            @if($index==0)
                            <tr id="{{$row['row_id']}}" class="activeItem">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> {{$row['vocabulary_nm']}}</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default" type-btn="btn-forget">Đã quên</button>
                                </td>
                            </tr>
                            @else
                            <tr id="{{$row['row_id']}}">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> {{$row['vocabulary_nm']}}</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default" type-btn="btn-forget">Đã quên</button>
                                </td>
                            </tr>
                            @endif
                        @endif
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>