 {!!WebFunctions::public_url('web-content/js/common/library/jquery-3.2.1.min.js')!!}
 <script type="text/javascript" src="{{URL::asset('web-content/js/common/library/bootstrap.min.js')}}"></script>
 <link rel="stylesheet" href="{{URL::asset('web-content/css/common/library/bootstrap.min.css')}}">
 <script type="text/javascript" src="{{URL::asset('web-content/js/common/library/DateTimePicker.js?=time()')}}"></script>
 <link rel="stylesheet" href="{{URL::asset('web-content/css/common/library/DateTimePicker.css?=time()')}}">
 <script type="text/javascript" src="{{URL::asset('web-content/js/common/defined/common.js?=time()')}}"></script>
 <link rel="stylesheet" href="{{URL::asset('web-content/css/common/defined/common.css?=time()')}}">
 <header>
     <title>Template</title>
 </header>
 <body>
    <div class="col-lg-12 web-panel">
        <div class="row">
            <h1 class="text-center">HELLO WORLD</h1>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label>This is lable</label>
                    <div class="input-group">
                        <input type="text" name="" class="form-control input-sm" value="this is input text">
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="required">This is lable required</label>
                    <div class="input-group">
                        <input type="text" name="" class="form-control input-sm required" value="this is input text required">
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>This is lable</label>
                    <div class="input-group">
                        <select class="form-control input-sm">
                            <option>this is select box</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="required">This is lable required</label>
                    <div class="input-group">
                        <select class="form-control input-sm required">
                            <option>this is select box required</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label >Datepicker</label>
                    <div class="input-group picker">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <input type="text" name="" class="form-control input-sm" data-field="date" value="this is Datepicker" readonly="">
                    </div>
                    <div id="dtBox" style="border: 1px solid #ddd;"></div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label >Timepicker</label>
                    <div class="input-group picker">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        <input type="text" name="" class="form-control input-sm" data-field="time" value="this is timepicker" readonly="">
                    </div>
                    <div id="dtBox"></div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-5">
                <button type="button" class="btn btn-sm">Basic</button>
                <button type="button" class="btn btn-sm btn-default">Default</button>
                <button type="button" class="btn btn-sm btn-primary">Primary</button>
                <button type="button" class="btn btn-sm btn-success">Success</button>
                <button type="button" class="btn btn-sm btn-info">Info</button>
                <button type="button" class="btn btn-sm btn-warning">Warning</button>
                <button type="button" class="btn btn-sm btn-danger">Danger</button>
                <button type="button" class="btn btn-sm btn-link">Link</button> 
            </div>
            <div class="col-lg-3">
                <label class="radio-inline"><input type="radio" name="optradio">Option 1</label>
                <label class="radio-inline"><input type="radio" name="optradio">Option 2</label>
                <label class="radio-inline"><input type="radio" name="optradio">Option 3</label>
            </div>
            <div class="col-lg-3">
                <label class="checkbox-inline"><input type="checkbox" value="">Option 1</label>
                <label class="checkbox-inline"><input type="checkbox" value="">Option 2</label>
                <label class="checkbox-inline"><input type="checkbox" value="">Option 3</label>
            </div>
        </div>
        <div class="row" style="margin-top: 10px;">
            <div class="col-lg-1">
                <button data-toggle="collapse" data-target="#demo" class="btn btn-sm btn-danger">Collapsible</button>
                <div id="demo" class="collapse">
                    Lorem ipsum dolor text....
                </div>
            </div>
            <div class="col-lg-2">
                <div class="dropdown">
                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Dropdown Example
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">HTML</a></li>
                            <li><a href="#">CSS</a></li>
                            <li><a href="#">JavaScript</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2">
                    <ul class="pager">
                        <li><a href="#">Previous</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">Next</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <div class="input-group">
                    <input class="form-control input-sm" type="text" placeholder="Nhập từ khóa để tìm kiểm">
                    <div class="input-group-btn">
                        <a class="btn btn-primary btn-sm">Tìm kiếm </a>
                    </div>
                </div>
                </div>

            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="comment">Comment:</label>
                        <textarea class="form-control input-sm fix-size" rows="5" id="comment"></textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="active"><a data-toggle="tab" href="#sectionA">Section A</a></li>
                        <li><a data-toggle="tab" href="#sectionB">Section B</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="sectionA" class="tab-pane fade in active">
                            <p>Section A content…</p>
                        </div>
                        <div id="sectionB" class="tab-pane fade">
                            <p>Section B content…</p>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John</td>
                                <td>Doe</td>
                                <td>john@example.com</td>
                            </tr>
                            <tr>
                                <td>Mary</td>
                                <td>Moe</td>
                                <td>mary@example.com</td>
                            </tr>
                            <tr>
                                <td>July</td>
                                <td>Dooley</td>
                                <td>july@example.com</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                  </div>
                  <div class="modal-body">
                    <p>Some text in the modal.</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>

              </div>
            </div>
            <div class="row">
                <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal">Show popup</a>
            </div>
            <script type="text/javascript">
                jQuery('#myModal .modal-body').load('/popup/login'); 
            </script>
        </div> 
    </body>