<div class="form-group table-fixed-width" min-width="1024px">
    <label>Danh Sách Ví Dụ</label>
    <table class="table table-bordered table-input exa-table-body">
       <thead>
           <th width="50px"><a id="btn-new-body" class="btn-add"><span class="fa fa-plus"></span></a></th>
           <th width="100px"></th>
           <th></th>
           <th width="50px">Xóa</th>
       </thead>
        <tbody class="hidden">
            <tr>
                <td rowspan="2">1</td>
                <td style="font-weight: bold;">Câu Tiếng Anh</td>
                <td><input type="text" name="" refer-id='language1_content' class="form-control input-sm"></td>
                <td rowspan="2"><button type="button" class="btn-danger delete-tr-body"><span class="fa fa-close"></span></button></td>
            </tr>
           <tr>
                <td style="font-weight: bold;">Dịch Nghĩa</td>
                <td><input type="text" name="" refer-id='language2_content' class="form-control input-sm"></td>
            </tr>
        </tbody>
        @if(isset($data[3]))
            @foreach($data[3] as $index=>$value)
        <tbody>
            <tr>
                <td rowspan="2">{{$index+1}}</td>
                <td style="font-weight: bold;">Câu Tiếng Anh</td>
                <td><input type="text" name="" refer-id='language1_content' class="form-control input-sm" value="{{$value['language1_content']}}"></td>
                <td rowspan="2" ><button type="button" class="btn-danger delete-tr-body"><span class="fa fa-close"></span></button></td>
            </tr>
           <tr>
                <td style="font-weight: bold;">Dịch Nghĩa</td>
                <td><input type="text" name="" refer-id='language2_content' class="form-control input-sm" value="{{$value['language2_content']}}"></td>
            </tr>
        </tbody>
            @endforeach
        @endif   
    </table>
</div>
