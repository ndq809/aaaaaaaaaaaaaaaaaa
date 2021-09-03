<input type="hidden" id="post_type" value="{{isset($data)?$data[0][0]['catalogue_div']:''}}">
<div class="input-group">
    @if(isset($data)&&$data[4][0]['tag_id']!='')
    <div class="col-xs-12 no-padding">
        <div class="preview-label">
        	<span class="title">Tags:</span>
    		@foreach($data[4] as $index => $row)
				<span class="tag">{{$row['tag_nm']}}</span>
        	@endforeach
        </div>
    </div>
    @endif
	{{--
    @if(isset($data)&&$data[0][0]['post_title']!='')
    <div class="col-xs-12 no-padding">
        <div class="preview-label has-border">
            <span class="text-danger">Tiêu Đề: </span>{{$data[0][0]['post_title']}}
        </div>
    </div>
    @endif
	--}}
    @if(isset($data)&&$data[0][0]['post_content']!='')
    <div class="col-xs-12 no-padding margin-top" id="noiDungNP">
    	<div class="main-content">
        	{!!$data[0][0]['post_content']!!}
    	</div>
    </div>
    @endif
    {{--
	@if(isset($data)&&$data[0][0]['catalogue_div']==3)
        <div class="col-xs-3">
            <div class="form-group">
                <label>Âm thanh</label>
                <div class="input-group">
                    <input type="file" id="post_media" name="" class="input-audio hidden" title="{{$data[0][0]['post_media_nm']}}" link="{{$data[0][0]['post_media']}}" placeholder="ID của từ vựng">
                </div>
            </div>
        </div>
    @endif
	--}}
    @if(isset($data)&&$data[0][0]['catalogue_div']==7)
        <div class="image margin-bottom text-center">
            <img alt="loadIcon" src="{{$data[0][0]['post_media']}}">
        </div>
    @endif
    @if(isset($data)&&$data[0][0]['catalogue_div']==8)
    <div class="col-xs-12 no-padding text-center">
    	<div style="max-width: 640px;margin: 0px auto;">
    		<video id="video-player" width="640" height="360" style="max-width:100%;" preload="none">
	    		<source src="{{$data[0][0]['post_media']}}" type= "{{$data[0][0]['media_div']}}">
	    	</video>
    	</div>
    </div>
    @endif
    @if(isset($data)&&$data[1][0]['vocabulary_id']!='')
    <div class="col-xs-12 table-detail">
        <div class="padding-10-l">
		    <span class="table-title text-danger">Danh Sách Từ Vựng</span>
		</div>
		<div class="panel-content padding-10-l">
		    <div class="table-fixed-width no-padding-left" min-width='700px'>
		        <table class="table table-hover table-bordered table-checkbox table-preview">
		            <thead>
		                <tr>
		                    <th width="50px">ID</th>
		                    <th width="150px">Tên Từ Vựng</th>
		                    <th width="100px">Loại Từ Vựng</th>
		                    <th width="150px">Phiên Âm</th>
		                    <th>Nghĩa</th>
		                    <th width="100px">Hình Ảnh</th>
		                    <th width="100px">Âm Thanh</th>
		                </tr>
		            </thead>
		            <tbody>
		                @if(isset($data)&&$data[1][0]['vocabulary_id'] != '')
		                @foreach($data[1] as $index => $row)
		                <tr>
		                    <td>{{$index+1}}</td>
		                    <td class="refer-item" refer_id="vocabulary_nm"><a href='/master/vocabulary/v002?{{$row["vocabulary_id"]}}?{{$row["vocabulary_dtl_id"]}}' target="_blank">{{$row['vocabulary_nm']}}</a></td>
		                    <td >{{$row['vocabulary_div_nm']}}</td>
		                    <td class="refer-item" refer_id="spelling">{{$row['spelling']}}</td>
		                    <td class="refer-item" refer_id="mean">{{$row['mean']}}</td>
		                    <td class="refer-item" refer_id="image"><a title="<img src='{{$row['image']}}' />" class="preview">{{$row['image']!=''?'Xem trước':''}}</a></td>
		                    <td class="refer-item" refer_id="audio"><audio class="sound1" src="{{$row['audio']}}" ></audio><a type="button" class="preview-audio">{{$row['audio']!=''?'Nghe thử':''}}</a></td>
		                </tr>
		                @endforeach
		                @endif
		            </tbody>
		        </table>
		    </div>
		</div>
	</div>
    @endif
    @if(isset($data)&&$data[2][0]['language1_content']!='')
   	<div class="col-xs-12 table-detail">
        <div class="padding-10-l">
		    <span class="table-title text-danger">Danh Sách Ví Dụ</span>
		</div>
		<div class="panel-content padding-10-l">
		    <div class="table-fixed-width no-padding-left" min-width='700px'>
		        <table class="table table-hover table-bordered table-checkbox table-preview">
		            <thead>
		                <tr>
		                    <th width="50px">ID</th>
		                    <th >Nội Dung Tiếng Anh</th>
		                    <th >Nội Dung Đã Dịch</th>
		                </tr>
		            </thead>
		            <tbody>
		                @if(isset($data)&&$data[2][0]['language1_content'] != '')
		                @foreach($data[2] as $index => $row)
		                <tr>
		                    <td>{{$index+1}}</td>
		                    <td >{{$row['language1_content']}}</td>
		                    <td >{{$row['language2_content']}}</td>
		                </tr>
		                @endforeach
		                @endif
		            </tbody>
		        </table>
		    </div>
		</div>
	</div>
    @endif
    @if(isset($data)&&$data[3][0]['question_id']!='')
   	<div class="col-xs-12 table-detail">
        <div class="padding-10-l">
		    <span class="table-title text-danger">Danh Sách Câu Hỏi</span>
		</div>
		<div class="panel-content padding-10-l">
		    <div class="table-fixed-width no-padding-left" min-width='700px'>
		        <table class="table table-hover table-bordered table-checkbox table-preview">
		            <thead>
		                <tr>
		                    <th width="50px">ID</th>
		                    <th >Nội Dung Câu Hỏi</th>
		                    <th >Nội Dung Các Phương Án</th>
		                    <th width="80px">Đáp Án</th>
		                </tr>
		            </thead>
		            <tbody>
		                @php($check = -1)
		                @php($count = 1)
		                @if(isset($data)&&$data[3][0]['question_id'] != '')
		                @foreach($data[3] as $index => $row)
		                @if($check!=$row['question_id'])
		                <tr style="border-bottom-color: #111">
		                    <td rowspan="4">{{$count}}</td>
		                    <td rowspan="4">{{$row['question_content']}}</td>
		                    <td >{{$row['answer_content']}}</td>
		                    <td >
		                    	@if($row['verify']==0)
		                    	<i class="fa fa-close text-danger"></i>
		                    	@else
		                    	<i class="fa fa-check text-success"></i>
		                    	@endif
		                    </td>
		                </tr>
		                @php($count++)
		                @else
		                <tr>
		                    <td >{{$row['answer_content']}}</td>
		                    <td >
		                    	@if($row['verify']==0)
		                    	<i class="fa fa-close text-danger"></i>
		                    	@else
		                    	<i class="fa fa-check text-success"></i>
		                    	@endif
		                    </td>
		                </tr>
		                @endif
		                @php($check = $row['question_id'])
		                @endforeach
		                @endif
		            </tbody>
		        </table>
		    </div>
		</div>
	</div>
    @endif
	@if(isset($data)&&$data[5][0]['listen_cut_id']!='')
    <div class="col-xs-12 table-detail">
        <div class="padding-10-l">
		    <span class="table-title text-danger">Phân Tách Của Bài Nghe</span>
		</div>
		<div class="panel-content padding-10-l">
		    <div class="table-fixed-width no-padding-left" min-width='700px'>
		        <table class="table table-hover table-bordered table-checkbox table-preview">
		            <thead>
		                <tr>
		                    <th width="50px">ID</th>
		                    <th>Đoạn Nghe</th>
		                    <th width="100px">Âm Thanh</th>
		                </tr>
		            </thead>
		            <tbody>
		                @if(isset($data)&&$data[5][0]['listen_cut_id'] != '')
		                @foreach($data[5] as $index => $row)
		                <tr>
		                    <td>{{$index+1}}</td>
		                    <td class="refer-item" refer_id="listen_cut_content">{{$row['listen_cut_content']}}</td>
		                    <td class="refer-item" refer_id="post_media"><audio class="sound1" preload="auto" src=""></audio><a type="button" class="preview-audio" src="{{$row['post_media']}}#t={{$row['listen_cut_start']}},{{$row['listen_cut_end']}}">{{$row['post_media']!=''?'Nghe thử':''}}</a></td>
		                </tr>
		                @endforeach
		                @endif
		            </tbody>
		        </table>
		    </div>
		</div>
	</div>
    @endif
	<a class="btn-refresh-preview"><i class="fa fa-refresh"></i></a>
</div>