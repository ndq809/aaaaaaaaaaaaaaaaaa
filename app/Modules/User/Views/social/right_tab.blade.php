@php($count = 0)
<div id="tab1" class="tab-pane fade active in">
    <div class="">
        <table class="table table-striped table-hover table-right">
            <tbody>
                @if(isset($data)&&$data[0]['post_id'] != '')
                    @foreach($data as $index => $row)
                        @if($row['remembered']==0)
                            <tr id="{{$row['row_id']}}">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> {{$row['post_title']}}</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default {{$raw_data[0][0]['btn-remember']==1?'btn-remember':'btn-disabled'}}">Theo dõi</button>
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
    <button class="btn btn-sm btn-default btn-block btn-load-more {{isset($is_end) && $is_end ==0?'':'disabled'}}" id="{{isset($is_end) && $is_end== 0?'btn-load-more':''}}">Tải thêm bài viết</button>
</div>
<div id="tab2" class="tab-pane fade">
    <div class="">
        <table class="table table-striped table-hover table-right">
            <tbody>
                 @if(isset($data)&&$data[0]['post_id'] != '')
                    @foreach($data as $index => $row)
                        @if($row['remembered']==1)
                            <tr id="{{$row['row_id']}}">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> {{$row['post_title']}}</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default {{$raw_data[0][0]['btn-forget']==1?'btn-forget':'btn-disabled'}}">{{$row['del_flg']==0?'Bỏ theo dõi':'Xóa'}}</button>
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