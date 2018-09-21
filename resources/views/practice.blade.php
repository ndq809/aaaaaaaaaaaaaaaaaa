<div class="form-group" min-width="1024px">
        @if(isset($data[0])&&Count($data[0])>1)
            @for($i = 1;$i<=Count($data[0]);$i=$i+4)
                <label>Câu {{$i==1?$i:($i+3)/4}}. {{$data[0][$i-1]['question_content']}}</label>
                @if($data[0][$i-1]['question_div']==0)
                    <div class="answer-box">
                        <span class="result-icon"></span>
                        <label class="radio"><input type="radio" name="optradio{{$i==1?$i:($i+3)/4}}">{{$data[0][$i-1]['answer_content']}}</label>
                        <label class="radio"><input type="radio" name="optradio{{$i==1?$i:($i+3)/4}}">{{$data[0][$i]['answer_content']}}</label>
                        <label class="radio"><input type="radio" name="optradio{{$i==1?$i:($i+3)/4}}">{{$data[0][$i+1]['answer_content']}}</label>
                        <label class="radio"><input type="radio" name="optradio{{$i==1?$i:($i+3)/4}}">{{$data[0][$i+2]['answer_content']}}</label>
                    </div>
                @else
                    <div class="answer-box">
                        <span class="result-icon"></span>
                        <label class="checkbox"><input type="checkbox">{{$data[0][$i-1]['answer_content']}}</label>
                        <label class="checkbox"><input type="checkbox">{{$data[0][$i]['answer_content']}}</label>
                        <label class="checkbox"><input type="checkbox">{{$data[0][$i+1]['answer_content']}}</label>
                        <label class="checkbox"><input type="checkbox">{{$data[0][$i+2]['answer_content']}}</label>
                    </div>
                @endif
            @endfor
        @else
            <h5 class="text-center">Hiện chưa có bài tập nào trong hệ thống!</h5>
        @endif   
</div>
