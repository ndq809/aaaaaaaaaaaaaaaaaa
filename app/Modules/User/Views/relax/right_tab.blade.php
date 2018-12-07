@php($count = 0)
<div id="tab1" class="tab-pane fade active in">
    <div class="">
        <table class="table table-striped table-hover table-right relax-table">
            @if(isset($data)&&$data[0]['post_id'] != '')
                @foreach($data as $index => $row)
                    @if($row['post_type']==4)
                        <tbody id="{{$row['row_id']}}">
                            <tr>
                                <td><a><img alt="loadIcon" src="{{$row['post_media']}}"></a></td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> {{$row['post_title']}}</span> </a>
                                </td>
                            </tr>
                        </tbody>
                        @php($count = $count + 1)
                    @endif
                @endforeach
                <tbody id="-100" class="no-row {{$count!=0?'hidden':''}}">
                    <tr>
                         <td colspan="2" class="text-left">
                            <a class="radio-inline"><i class="fa fa-minus-circle"> </i> <span> Không có dữ liệu !</span> </a>
                        </td>
                    </tr>
                </tbody>
            @endif
            @php($count = 0)
        </table>
        
    </div>
    <button class="btn btn-sm btn-default btn-block btn-bottom {{isset($is_end) && $is_end[0]['catalogue_div'] == 7 && $is_end[0]['is_end'] == 0 ?'btn-load-more':'disabled'}}">Tải thêm bài viết</button>
</div>
<div id="tab2" class="tab-pane fade">
    <div class="">
        <table class="table table-striped table-hover table-right relax-table">
           @if(isset($data)&&$data[0]['post_id'] != '')
                @foreach($data as $index => $row)
                    @if($row['post_type']==5)
                        <tbody id="{{$row['row_id']}}">
                            <tr>
                                <td><a><img alt="loadIcon" src="https://img.youtube.com/vi/QdXdx9IaakA/0.jpg"></a></td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> {{$row['post_title']}}</span> </a>
                                </td>
                            </tr>
                        </tbody>
                        @php($count = $count + 1)
                    @endif
                @endforeach
                <tbody id="-100" class="no-row {{$count!=0?'hidden':''}}">
                    <tr>
                         <td colspan="2" class="text-left">
                            <a class="radio-inline"><i class="fa fa-minus-circle"> </i> <span> Không có dữ liệu !</span> </a>
                        </td>
                    </tr>
                </tbody>
            @endif
            @php($count = 0)
        </table>
        
    </div>
    <button class="btn btn-sm btn-default btn-block btn-bottom {{isset($is_end) && $is_end[1]['catalogue_div'] == 8 && $is_end[1]['is_end'] == 0 ?'btn-load-more':'disabled'}}">Tải thêm bài viết</button>
</div>
<div id="tab3" class="tab-pane fade">
    <div class="">
        <table class="table table-striped table-hover table-right relax-table">
           @if(isset($data)&&$data[0]['post_id'] != '')
                @foreach($data as $index => $row)
                    @if($row['post_type']==6)
                        <tbody id="{{$row['row_id']}}">
                            <tr class="no-background">
                                <td class="text-left">
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> {{$row['post_title']}}</span> </a>
                                </td>
                            </tr>
                        </tbody>
                        @php($count = $count + 1)
                    @endif
                @endforeach
                <tbody id="-100" class="no-row {{$count!=0?'hidden':''}}">
                    <tr>
                         <td colspan="2" class="text-left">
                            <a class="radio-inline"><i class="fa fa-minus-circle"> </i> <span> Không có dữ liệu !</span> </a>
                        </td>
                    </tr>
                </tbody>
            @endif
            @php($count = 0)
        </table>

    </div>
    <button class="btn btn-sm btn-default btn-block btn-bottom {{isset($is_end) && $is_end[2]['catalogue_div'] == 9 && $is_end[2]['is_end'] == 0 ?'btn-load-more':'disabled'}}">Tải thêm bài viết</button>
</div>