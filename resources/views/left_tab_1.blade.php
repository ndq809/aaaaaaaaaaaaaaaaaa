<div class="col-lg-3 col-md-12 no-padding" style="padding-right: 1px;">
    <ul class="nav nav-tabs nav-justified">
        <li class="active col-sm-6 no-padding"><a data-toggle="tab" href="#sectionA" aria-expanded="true">Thông tin chung</a></li>
        <li class="col-sm-6 no-padding"><a data-toggle="tab" href="#sectionB" aria-expanded="false">Thống kê</a></li>
    </ul>
    <div class="tab-content">
        <div id="sectionA" class="tab-pane fade active in">
            <div class="left-header " data-target=".newsfeed" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="95%">
                                <h5>Thứ Hạng Hiện Tại</h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="newsfeed collapse in close-when-small">
                <div class="width-50 inline-block float-left" style="text-align: center;">
                    <div style="margin:0px auto;display: inline-block;"><canvas id="canvas_meter1"></canvas></div>
                </div>
                <div class="width-50 inline-block" style="text-align: center;">
                    <div style="margin:0px auto;display: inline-block;"><canvas id="canvas_meter2"></canvas></div>
                </div>
                <div class="left-hint ">
                    <h6 style="font-size: 18px"><span style="font-family: 'headerfont1'">Rank </span>: <span style="font-family: 'ToetheLineless'">S+++</span></h6>
                </div>
            </div>
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
                <button class="btn btn-sm btn-primary answer-btn " type="button">Trả Lời</button>
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
                <button class="btn btn-sm btn-primary margin-top margin-bottom" type="button">Gửi Câu Hỏi</button>
            </div>
        </div>
        <div id="sectionB" class="tab-pane fade">
            <div class="left-header" data-target=".rank" data-toggle="collapse">
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
            <div class="rank collapse in close-when-small">
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