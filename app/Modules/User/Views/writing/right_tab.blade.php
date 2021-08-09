@php($count = 0)
<div class="">
    <table class="table table-striped table-hover table-right">
        <tbody>
            @if(isset($data)&&$data[0]['post_id'] != '')
                @foreach($data as $index => $row)
                    @if($row['my_post']==0)
                        <tr id="{{$row['row_id']}}">
                            <td>
                                <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> {{$row['post_title']}}</span> </a>
                            </td>
                        </tr>
                        @php($count = $count + 1)
                    @endif
                @endforeach
                <tr id="-100" class="no-row {{$count!=0?'hidden':''}}">
                    <td colspan="2">
                        <a class="radio-inline"><i class="fa fa-minus-circle"> </i> <span> Không có dữ liệu !</span> </a>
                    </td>
                </tr>
            @endif
            @php($count = 0)
        </tbody>
    </table>
</div>

