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
                                <h5>Danh Sách Đã Dịch</h5>
                            </td>
                            <td class="collapse-icon" width="10%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="collapse in question close-when-small">
                <table class="table table-hover table-center">
                    <tbody>
                        @if(isset($data_default)&&$data_default[0][0]['post_id'] != '')
                            @foreach($data_default[0] as $index => $row)
                            @if($row['post_div'] == 3)
                            <tr class="{{$row['selected']==1?'selected-row':''}}" row_id="{{$row['row_id']}}">
                                <td>
                                    <a>
                                        <i class="glyphicon glyphicon-hand-right">
                                        </i>
                                        {{$row['post_title']}}
                                    </a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            @else
                            <tr class="no-data">
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
            <div class="left-header" data-target=".new-question" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="95%">
                                <h5>Danh Sách Đang Dịch</h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="new-question collapse in close-when-small no-padding">
                <table class="table table-hover table-center">
                    <tbody>
                        @if(isset($data_default)&&$data_default[0][0]['post_id'] != '')
                            @foreach($data_default[0] as $index => $row)
                            @if($row['post_div'] == 1 || $row['post_div'] == 2)
                            <tr class="{{$row['selected']==1?'selected-row':''}}"  row_id="{{$row['row_id']}}">
                                <td>
                                    <a>
                                        <i class="glyphicon glyphicon-hand-right">
                                        </i>
                                        {{$row['post_title']}}
                                    </a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            @else
                            <tr class="no-data">
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
                        @if(isset($data_default)&&$data_default[0][0]['post_id'] != '')
                            @foreach($data_default[0] as $index => $row)
                            <tr class="{{$row['selected']==1?'selected-row':''}}" row_id="{{$row['row_id']}}">
                                <td>
                                    <a>
                                        <i class="glyphicon glyphicon-hand-right">
                                        </i>
                                        {{$row['post_title']}}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr class="no-data">
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
            <div class="left-header" data-target=".is-shared-post" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="95%">
                                <h5>Bài Viết Được Chia Sẻ</h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="is-shared-post collapse in close-when-small no-padding">
                <table class="table table-hover table-center">
                    <tbody>
                        @if(isset($data_default[3])&&$data_default[3][0]['post_id'] != '')
                            @foreach($data_default[3] as $index => $row)
                            <tr class="{{$row['selected']==1?'selected-row':''}}" row_id="{{$row['row_id']}}">
                                <td>
                                    <a>
                                        <i class="glyphicon glyphicon-hand-right">
                                        </i>
                                        {{$row['post_title']}}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr class="no-data">
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
                                <h5>Thông báo của bạn</h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="newsfeed collapse in close-when-small">
                <table class="table table-hover table-center">
                    <tbody>
                        @for($i=1;$i<=3;$i++)
                        <tr>
                            <td>
                                <a>
                                    <i class="glyphicon glyphicon-hand-right">
                                    </i>
                                    Nhóm từ vựng
                                    <span>
                                        Thiên nhiên
                                    </span>
                                    đã được thêm
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a>
                                    <i class="glyphicon glyphicon-hand-right">
                                    </i>
                                    Cập nhật ngữ pháp
                                    <span>
                                        Trợ động từ
                                    </span>
                                </a>
                            </td>
                        </tr>
                        @endfor
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
                        @for($i=1;$i<=5;$i++)
                        <tr>
                            <td width="70%">
                                <label class="radio-inline"><img src="web-content/images/icon/rank/rank{{$i}}.png" width="25px">Quy Nguyen</label>
                            </td>
                            <td>
                                <label class="radio-inline"><img src="web-content/images/icon/point.png" width="35px">10,000</label>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="left-header" data-target=".news" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="95%">
                                <h5>Tin tức mới nhất</h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="news collapse in close-when-small">
                <table class="table table-hover table-center">
                    <tbody>
                        @for($i=1;$i<=3;$i++)
                        <tr>
                            <td>
                                <a>
                                    <i class="glyphicon glyphicon-hand-right">
                                    </i>
                                    Nhóm từ vựng
                                    <span>
                                        Thiên nhiên
                                    </span>
                                    đã được thêm
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a>
                                    <i class="glyphicon glyphicon-hand-right">
                                    </i>
                                    Cập nhật ngữ pháp
                                    <span>
                                        Trợ động từ
                                    </span>
                                </a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>