<div class="form-group table-fixed-width" min-width="1024px">
    <label>Danh Sách Bài Tập</label>
    <table class="table table-bordered table-input pra-table-body">
       <thead>
           <th width="50px"><a id="btn-new-body" class="btn-add"><span class="fa fa-plus"></span></a></th>
           <th width="100px"></th>
           <th></th>
           <th width="50px"></th>
           <th width="50px">Xóa</th>
       </thead>
        <tbody class="hidden">
            <tr>
                <td rowspan="5">1</td>
                <td style="font-weight: bold;">Câu Hỏi</td>
                <td><input type="text" name="" refer-id='content' class="form-control input-sm"></td>
                <td>Đáp án</td>
                <td rowspan="5"><button type="button" class="btn-danger delete-tr-body"><span class="fa fa-close"></span></button></td>
            </tr>
           <tr>
                <td style="font-weight: bold;">Câu Trả Lời 1</td>
                <td><input type="text" name="" refer-id='content' class="form-control input-sm"></td>
                <td><input type="checkbox" name="" refer-id='verify'></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Câu Trả Lời 2</td>
                <td><input type="text" name="" refer-id='content' class="form-control input-sm"></td>
                <td><input type="checkbox" name="" refer-id='verify'></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Câu Trả Lời 3</td>
                <td><input type="text" name="" refer-id='content' class="form-control input-sm"></td>
                <td><input type="checkbox" name="" refer-id='verify'></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Câu Trả Lời 4</td>
                <td><input type="text" name="" refer-id='content' class="form-control input-sm"></td>
                <td><input type="checkbox" name="" refer-id='verify'></td>
            </tr>
        </tbody>
        @if(isset($data[4])&&Count($data[4])>1)
            @for($i = 1;$i<=Count($data[4]);$i=$i+4)
                <tbody>
                     <tr>
                        <td rowspan="5">{{$i==1?$i:($i+3)/4}}</td>
                        <td style="font-weight: bold;">Câu Hỏi</td>
                        <td><input type="text" name="" refer-id='content' class="form-control input-sm" value="{{$data[4][$i-1]['question_content']}}"></td>
                        <td>Đáp án</td>
                        <td rowspan="5"><button type="button" class="btn-danger delete-tr-body"><span class="fa fa-close"></span></button></td>
                    </tr>
                   <tr>
                        <td style="font-weight: bold;">Câu Trả Lời 1</td>
                        <td><input type="text" name="" refer-id='content' class="form-control input-sm" value="{{$data[4][$i-1]['answer_content']}}"></td>
                        <td><input type="checkbox" name="" refer-id='verify' {{$data[4][$i-1]['verify']==1?'checked':''}}></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Câu Trả Lời 2</td>
                        <td><input type="text" name="" refer-id='content' class="form-control input-sm" value="{{$data[4][$i]['answer_content']}}"></td>
                        <td><input type="checkbox" name="" refer-id='verify' {{$data[4][$i]['verify']==1?'checked':''}}></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Câu Trả Lời 3</td>
                        <td><input type="text" name="" refer-id='content' class="form-control input-sm" value="{{$data[4][$i+1]['answer_content']}}"></td>
                        <td><input type="checkbox" name="" refer-id='verify' {{$data[4][$i+1]['verify']==1?'checked':''}}></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Câu Trả Lời 4</td>
                        <td><input type="text" name="" refer-id='content' class="form-control input-sm" value="{{$data[4][$i+2]['answer_content']}}"></td>
                        <td><input type="checkbox" name="" refer-id='verify' {{$data[4][$i+2]['verify']==1?'checked':''}}></td>
                    </tr>
                </tbody>
            @endfor
        @endif   
    </table>
</div>
