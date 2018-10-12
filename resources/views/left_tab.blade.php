<div class="col-lg-3 col-md-12 no-padding left-tab" style="padding-right: 1px;">
    <ul class="nav nav-tabs nav-justified">
        <li class="active col-sm-6 no-padding"><a data-toggle="tab" href="#sectionA" aria-expanded="true">Góc Học Tập</a></li>
        <li class="col-sm-6 no-padding"><a data-toggle="tab" href="#sectionB" aria-expanded="false">Tin Tức Mới</a></li>
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
            <div class="left-header" data-target=".question" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="90%">
                                <h5>Nghĩa của từ "<span>Hello</span>" là gì?</h5>
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
            <div class="left-header" data-target=".new-question" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="95%">
                                <h5>Đặt câu hỏi / Chủ đề mới</h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="new-question collapse in close-when-small">
                <label >Tiêu đề</label>
                <textarea class="form-control input-sm" rows="2"></textarea>
                 <label >Nội dung</label>
                <textarea class="form-control input-sm" rows="5"></textarea>
                <button class="btn btn-sm btn-primary margin-top margin-bottom {{$raw_data[0][0]['btn-question']==1?'btn-question':'btn-disabled'}}" type="button">Gửi Câu Hỏi</button>
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