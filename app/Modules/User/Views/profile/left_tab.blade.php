<div class="col-lg-3 col-md-12 no-padding left-tab" style="padding-right: 1px;">
    <ul class="nav nav-tabs nav-justified">
        <li class="active col-sm-6 no-padding"><a data-toggle="tab" href="#sectionA" aria-expanded="true">Thông tin chung</a></li>
        <li class="col-sm-6 no-padding"><a data-toggle="tab" href="#sectionB" aria-expanded="false">Nhiệm Vụ</a></li>
    </ul>
    <div class="tab-content">
        <div id="sectionA" class="tab-pane fade active in">
            <div class="left-header " data-target=".newsfeed" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="95%">
                                <h5>Thứ Hạng Của Bạn</h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="newsfeed collapse in close-when-small">
                <div class="width-50 inline-block float-left" style="text-align: center;">
                    <div style="margin:0px auto;display: inline-block;"><canvas id="canvas_meter1" value="{{isset($data)?$data[5][0]['exp']:'0'}}" max="{{isset($data)?$data[5][0]['rank_exp']:'0'}}"></canvas></div>
                </div>
                <div class="width-50 inline-block" style="text-align: center;">
                    <div style="margin:0px auto;display: inline-block;"><canvas id="canvas_meter2" value="{{isset($data)?$data[5][0]['ctp']:'0'}}" max="{{isset($data)?$data[5][0]['rank_ctp']:'0'}}"></canvas></div>
                </div>
                <div class="left-hint ">
                    <h6 style="font-size: 16px"><span style="font-family: titlefont">Cấp Độ</span> : <span style="font-family: 'headerfont1'">{{isset($data)?$data[5][0]['rank']:''}}</span></h6>
                </div>
            </div>
            <div class="left-header" data-target=".radar-chart" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="90%">
                                <h5>Biểu Đồ Năng Lực</h5>
                            </td>
                            <td class="collapse-icon" width="10%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="collapse in radar-chart close-when-small">
                <div class="full-width inline-block" style="text-align: center;">
                    <div style="margin:0px auto;display: inline-block;"><canvas id="canvas_radar"></canvas></div>
                </div>
            </div>
            <div class="left-header" data-target=".mission" data-toggle="collapse">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td width="95%">
                                <h5>Thành Tích Của Bạn</h5>
                            </td>
                            <td class="collapse-icon" width="5%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mission collapse in close-when-small">
                <table class="table table-hover table-mission table-bordered">
                    <thead>
                        <th>Nhiệm vụ</th>
                        <th>Hoàn thành</th>
                        <th>Từ chối</th>
                        <th>Thất bại</th>
                    </thead>
                    <tbody>
                        @if(isset($data)&&$data[7][0]['catalogue_div_nm']!='')
                        @foreach($data[7] AS $index=>$row)
                        <tr>
                            <td>
                                <label class="mission-label">{{$row['catalogue_div_nm']}}</label>
                            </td>
                            <td>
                                <label >{{$row['success_count']}}</label>
                            </td>
                            <td>
                                <label >{{$row['ignore_count']}}</label>
                            </td>
                            <td>
                                <label >{{$row['failed_count']}}</label>
                            </td>
                            <td class="hidden mission-point">{{$row['point']}}</td>
                        </tr>
                        @endforeach
                       @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div id="sectionB" class="tab-pane fade">
            <div class="left-header" data-target=".top-rank" data-toggle="collapse">
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
            <div class="top-rank collapse in close-when-small">
                <table class="table table-hover table-left">
                    <tbody>
                        @foreach($raw_data[5] as $index=>$item)
                        @if($item['mission_id']!='')
                        <tr>
                            <td>
                                <a style="font-family: HapnaSlab" class="text-success btn-popup" popup-id="popup-box4" mission_id="{{$item['mission_id']}}" type="button">
                                    @if($item['condition']==0)
                                    <i class="fa fa-bullseye" style="font-size: 16px"></i>
                                    @elseif($item['condition']==1)
                                    <i class="fa fa-futbol-o fa-spin" style="font-size: 16px"></i>
                                    @elseif($item['condition']==2)
                                    <i class="fa fa-smile-o" style="font-size: 18px"></i>
                                    @elseif($item['condition']==3)
                                    <i class="fa fa-meh-o" style="font-size: 18px"></i>
                                    @elseif($item['condition']==4)
                                    <i class="fa fa-frown-o" style="font-size: 18px"></i>
                                    @endif
                                    {{$item['title']}}
                                </a>
                            </td>
                        </tr>
                        @else
                            <tr class="no-data">
                                <td>Bạn chưa đăng nhập hoặc không có nhiệm vụ nào</td>
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