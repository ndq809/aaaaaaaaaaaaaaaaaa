@if(isset($data)&&Count($data)>1&&isset($data[0]['question_num']))
    @for($i = 1;$i<=Count($data);$i=$i+4)
        <div class="{{isset($data[$i-1]['row_id'])?'question-box':''}}" target-id="{{isset($data[$i-1]['row_id'])?$data[$i-1]['row_id']:''}}">
            <label>Câu {{$data[$i-1]['question_num']==1?$data[$i-1]['question_num']:($data[$i-1]['question_num']+3)/4}}. {{$data[$i-1]['question_content']}}</label>
            @if($data[$i-1]['question_div']==0)
                <div class="answer-box">
                    <span class="result-icon"></span>
                    <label class="radio cool-link"><input type="radio" name="optradio{{$i==1?$i:($i+3)/4}}">{{$data[$i-1]['answer_content']}}</label>
                    <label class="radio cool-link"><input type="radio" name="optradio{{$i==1?$i:($i+3)/4}}">{{$data[$i]['answer_content']}}</label>
                    <label class="radio cool-link"><input type="radio" name="optradio{{$i==1?$i:($i+3)/4}}">{{$data[$i+1]['answer_content']}}</label>
                    <label class="radio cool-link"><input type="radio" name="optradio{{$i==1?$i:($i+3)/4}}">{{$data[$i+2]['answer_content']}}</label>
                </div>
            @else
                <div class="answer-box">
                    <span class="result-icon"></span>
                    <label class="checkbox cool-link"><input type="checkbox">{{$data[$i-1]['answer_content']}}</label>
                    <label class="checkbox cool-link"><input type="checkbox">{{$data[$i]['answer_content']}}</label>
                    <label class="checkbox cool-link"><input type="checkbox">{{$data[$i+1]['answer_content']}}</label>
                    <label class="checkbox cool-link"><input type="checkbox">{{$data[$i+2]['answer_content']}}</label>
                </div>
            @endif
        </div>
    @endfor
@else
    @if(isset($data))
    <h5 class="text-center">Hiện chưa có bài tập nào trong hệ thống!</h5>
    @else
    <h5 class="text-center">Bắt đầu tải câu hỏi...</h5>
    @endif
@endif   
