<input type="hidden" id="post_type" value="{{isset($data)?$data[0][0]['catalogue_div']:''}}">
<div class="input-group">
    <div class="col-xs-12 no-padding">
        <div class="preview-label">
            <span class="text-danger">Loại Bài Viết: </span>{{isset($data)?$data[0][0]['content']:''}}
        </div>
    </div>
    @if(isset($data)&&$data[4][0]['tag_id']!='')
    <div class="col-xs-12 no-padding">
        <div class="preview-label">
        	<span class="text-danger">Tag Bài Viết: </span>
    		@foreach($data[4] as $index => $row)
				{{$row['tag_nm']}},
        	@endforeach
        </div>
    </div>
    @endif
    @if(isset($data)&&$data[0][0]['catalogue_nm']!='')
    <div class="col-xs-6 no-padding">
        <div class="preview-label">
            <span class="text-danger">Tên Danh Mục: </span>{{isset($data)?$data[0][0]['catalogue_nm']:''}}
        </div>
    </div>
    <div class="col-xs-6 no-padding">
        <div class="preview-label">
            <span class="text-danger">Tên Nhóm: </span>{{isset($data)?$data[0][0]['group_nm']:''}}
        </div>
    </div>
    @endif
    @if(isset($data)&&$data[0][0]['post_title']!='')
    <div class="col-xs-12 no-padding">
        <div class="preview-label has-border">
            <span class="text-danger">Tiêu Đề: </span>{{$data[0][0]['post_title']}}
        </div>
    </div>
    @endif
    @if(isset($data)&&$data[0][0]['post_content']!='')
    <div class="col-xs-12 no-padding margin-top" id="noiDungNP">
    	<div class="main-content">
        	{!!$data[0][0]['post_content']!!}
    	</div>
    </div>
    @endif
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
		                    <td class="refer-item" refer_id="vocabulary_nm">{{$row['vocabulary_nm']}}</td>
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
</div>