<div class="col-lg-3 col-md-12 no-padding left-tab" style="padding-right: 1px;">
    <ul class="nav nav-tabs nav-justified">
        <li class="active col-sm-6 no-padding"><a data-toggle="tab" href="#sectionA" aria-expanded="true">Góc Học Tập</a></li>
        <li class="col-sm-6 no-padding">
            <a data-toggle="tab" href="#sectionB" aria-expanded="false">
            <span>Tin Tức Mới</span>
            <span class="notify_count {{$raw_data[2][0]['notify_id']==''?'hidden':''}}">
                <img src="/web-content/images/icon/JD-23-512.png" width="42px" height="42px">
                <span class="animated tada">{{count($raw_data[2])}}</span>
            </span>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="sectionA" class="tab-pane fade active in">
            @if(isset($data_default[1][0]['catalogue_nm']))
             <div class="left-header" data-target=".lesson-list" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="95%">
                               <h5>Bài Học Đã Đăng Ký</h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="lesson-list collapse in close-when-small">
                <table class="table table-hover table-bordered table-click">
                    <thead>
                        <th width="30px"></th>
                        <th>Danh Mục</th>
                        <th width="50%">Nhóm</th>
                        <th width="30px">Xóa</th>
                    </thead>
                    <tbody>
                        @if(isset($data_default)&&$data_default[1][0]['catalogue_nm'] != '')
                        @php($focused = 0)
                            @foreach($data_default[1] as $index=>$item)
                            @if($item['focused']==1 && $focused == 0)
                            @php($focused = 1)
                            <tr class="selected-row">
                                <td>
                                    <input type="hidden" name="" class="lesson-id" value="{{$item['id']}}">
                                    <i class="glyphicon glyphicon-hand-right"></i>
                                </td>
                                <td class="text-overflow">
                                    {{$item['catalogue_nm']}}
                                </td>
                                <td class="text-overflow">
                                    {{$item['group_nm']}}
                                </td>
                                <td><button type="button" class="btn-danger btn-del-lesson"><span class="fa fa-close"></span></button></td>
                            </tr>
                            @else
                            <tr>
                                <td>
                                    <input type="hidden" name="" class="lesson-id" value="{{$item['id']}}">
                                    <i class="glyphicon glyphicon-hand-right"></i>
                                </td>
                                <td class="text-overflow">
                                    {{$item['catalogue_nm']}}
                                </td>
                                <td class="text-overflow">
                                    {{$item['group_nm']}}
                                </td>
                                <td><button type="button" class="btn-danger btn-del-lesson"><span class="fa fa-close"></span></button></td>
                            </tr>
                            @endif
                            @endforeach
                        @else
                            <tr class="no-data">
                                <td>
                                    <i class="glyphicon glyphicon-hand-right"></i>
                                </td>
                                <td colspan="3">Bạn chưa đăng nhập hoặc chưa đăng ký mục nào</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            @endif
            <div class="left-header" data-target=".mission" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="95%">
                               <h5><span>Nhiệm Vụ Hằng Ngày</span></h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mission collapse in close-when-small">
                <table class="table table-hover table-left">
                    <tbody>
                        <tr>
                            <td>
                                <a style="font-family: HapnaSlab" class="text-success btn-popup" popup-id="popup-box4">
                                    <img src="/web-content/images/icon/Mission-Icon.png" width="20px" height="20px">
                                    CHINH PHỤC TỪ VỰNG
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a style="font-family: HapnaSlab" class="text-success btn-popup" popup-id="popup-box4">
                                    <img src="/web-content/images/icon/Mission-Icon.png" width="20px" height="20px">
                                    LÀM CHỦ NGỮ PHÁP
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a style="font-family: HapnaSlab" class="text-success btn-popup" popup-id="popup-box4">
                                    <img src="/web-content/images/icon/Mission-Icon.png" width="20px" height="20px">
                                    BẬC THẦY ĐỌC HIỂU
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a style="font-family: HapnaSlab" class="text-success btn-popup" popup-id="popup-box4">
                                    <img src="/web-content/images/icon/Mission-Icon.png" width="20px" height="20px">
                                    TRÙM GIAO TIẾP
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a style="font-family: HapnaSlab" class="text-success btn-popup" popup-id="popup-box4">
                                    <img src="/web-content/images/icon/Mission-Icon.png" width="20px" height="20px">
                                    VIỆT NAM QUÊ HƯƠNG TÔI
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="left-header" data-target=".question" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="90%">
                                <h5><span>VIỆT NAM - ĐẤT NƯỚC - CON NGƯỜI</span></h5>
                            </td>
                            <td class="collapse-icon" width="10%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="collapse in question close-when-small">
                <div class="left-content ">
                    <label class="radio-inline"><input type="radio" name="optradio">Thời tiết</label>
                </div>
                <div class="left-content ">
                    <label class="radio-inline"><input type="radio" name="optradio">Gia đình</label>
                </div>
                <div class="left-content ">
                    <label class="radio-inline"><input type="radio" name="optradio">Chào buổi sáng</label>
                </div>
                <div class="left-content ">
                    <label class="radio-inline"><input type="radio" name="optradio">Xin chào</label>
                </div>
                <button class="btn btn-sm btn-primary margin-bottom margin-left {{$raw_data[0][0]['btn-answer']==1?'btn-answer':'btn-disabled'}}" type="button">Trả Lời</button>
                <div class="left-hint ">
                    <h6>Trả lời đúng mỗi câu được cộng 2 điểm sai bị trừ 1 điểm</h6>
                </div>
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
                                <a notify_id="{{$item['notify_id']}}">
                                    @if($item['notify_condition']==0)
                                    <span class="active-notify">
                                        <i class="glyphicon glyphicon-hand-right"></i>
                                        <span class="notify_content">{{$item['account_nm'].((int)$item['notify_count']!=0?' và '.$item['notify_count'].' người khác ':' ').$item['notify_content']}}</span>
                                    </span>
                                    @else
                                        <i class="glyphicon glyphicon-hand-right"></i>
                                        {{$item['account_nm'].((int)$item['notify_count']!=0?' và '.$item['notify_count'].' người khác ':' ').$item['notify_content']}}
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