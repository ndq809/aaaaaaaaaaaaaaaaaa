<div class="col-lg-3 col-md-12 no-padding left-tab" style="padding-right: 1px;">
    <ul class="nav nav-tabs nav-justified">
        <li class="active col-sm-6 no-padding"><a data-toggle="tab" href="#sectionA" aria-expanded="true">Điểm Nóng</a></li>
        <li class="col-sm-6 no-padding"><a data-toggle="tab" href="#sectionB" aria-expanded="false">Tin Tức Mới</a></li>
    </ul>
    <div class="tab-content">
        <div id="sectionA" class="tab-pane fade active in">
            <div class="left-header" data-target=".question" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="90%">
                                <h5>Các Tag Nổi Bật</h5>
                            </td>
                            <td class="collapse-icon" width="10%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="collapse in question close-when-small">
                @if(isset($data_default)&&$data_default[0][0]['tag_id'] != '')
                    @foreach($data_default[0] as $index => $row)
                    <a class="tag-list" value="{{$row['tag_id']}}">{{$row['tag_nm']}}</a>
                    @endforeach
                    @else
                    <a style="font-size: 12px;padding-left: 5px">
                        <i class="fa fa-frown-o">
                        </i>
                        Không có dữ liệu!
                    </a>
                @endif
            </div>
            <div class="left-header" data-target=".hot-question" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="95%">
                                <h5>Bài Viết Nổi Bật</h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="hot-question collapse in close-when-small no-padding">
                <table class="table table-hover table-center">
                    <tbody>
                        @if(isset($data_default)&&$data_default[1][0]['post_id'] != '')
                            @foreach($data_default[1] as $index => $row)
                            <tr>
                                <td>
                                    <a href="/discuss?v={{$row['post_id']}}">
                                        <i class="glyphicon glyphicon-hand-right">
                                        </i>
                                        {{$row['post_title']}}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>
                                    <a>
                                        <i class="fa fa-frown-o">
                                        </i>
                                        Không có dữ liệu!
                                    </a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="left-header" data-target=".your-post" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="95%">
                                <h5>Bài Viết Của Bạn</h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="your-post collapse in close-when-small no-padding">
                <table class="table table-hover table-center">
                    <tbody>
                        @if(isset($data_default)&&$data_default[3][0]['post_id'] != '')
                            @foreach($data_default[3] as $index => $row)
                            <tr>
                                <td>
                                    <a question_id="{{$row['post_id']}}" class="my-post-link">
                                        <i class="glyphicon glyphicon-hand-right">
                                        </i>
                                        {{$row['post_title']}}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>
                                    <a>
                                        <i class="fa fa-frown-o">
                                        </i>
                                        Bạn chưa có bài viết nào!
                                    </a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div id="sectionB" class="tab-pane fade">
             @if(isset(Auth::user()->account_nm))
            <div class="left-header" data-target=".newsfeed" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="95%">
                                <h5><span>Thông Báo Của Bạn</span></h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="newsfeed collapse in close-when-small">
                <table class="table table-hover table-center">
                    <tbody>
                        @foreach($raw_data[2] as $index=>$item)
                        @if($item['notify_id']!='')
                        <tr>
                            <td>
                                <a>
                                    @if($item['notify_condition']==0)
                                    <span>
                                        <i class="glyphicon glyphicon-hand-right"></i>
                                        <span class="notify_content">{{$item['account_nm'].' '.$item['notify_content']}}</span>
                                    </span>
                                    @else
                                        <i class="glyphicon glyphicon-hand-right"></i>
                                        {{$item['account_nm'].' '.$item['notify_content']}}
                                    @endif
                                </a>
                            </td>
                        </tr>
                        @else
                            <tr class="no-data">
                                <td>Bạn không có thông báo nào</td>
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                <a class="btn btn-sm btn-default full-width btn-refresh">Làm mới thông báo</a>
            </div>
            @endif
            <div class="left-header" data-target=".top-rank" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="95%">
                               <h5><span>Bảng Xếp Hạng Thành Viên</span></h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="top-rank collapse in close-when-small">
                <table class="table table-hover table-left">
                    <tbody>
                        @foreach($raw_data[3] as $index=>$item)
                        @if($item['account_id']!='')
                        <tr>
                            <td width="70%">
                                <label class="radio-inline"><img src="web-content/images/icon/rank/rank{{$index+1}}.png" width="25px">{{$item['account_nm']}}</label>
                            </td>
                            <td>
                                <label class="radio-inline"><img src="web-content/images/icon/point.png" width="35px">{{$item['ep']}}</label>
                            </td>
                        </tr>
                        @else
                            <tr class="no-data">
                                <td>Không có dữ liệu</td>
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="left-header" data-target=".news" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="95%">
                                <h5><span>Tin Tức Mới Nhất</span></h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="news collapse in close-when-small">
                <table class="table table-hover table-center">
                    <tbody>
                        @foreach($raw_data[4] as $index=>$item)
                        @if($item['notify_id']!='')
                        <tr>
                            <td>
                                <a>
                                    @if($item['notify_condition']==0)
                                    <span>
                                        <i class="glyphicon glyphicon-hand-right"></i>
                                        <span class="notify_content">{{$item['account_nm'].' '.$item['notify_content']}}</span>
                                    </span>
                                    @else
                                        <i class="glyphicon glyphicon-hand-right"></i>
                                        {{$item['account_nm'].' '.$item['notify_content']}}
                                    @endif
                                </a>
                            </td>
                        </tr>
                        @else
                            <tr class="no-data">
                                <td>Không có thông báo nào</td>
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>