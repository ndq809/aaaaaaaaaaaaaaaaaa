@php($count = 0)
@php($temp = 0)
<div id="tab1" class="tab-pane fade active in">
    <div class="">
        <table class="table table-hover table-right">
            <tbody>
                @if(isset($data)&&$data[0]['id'] != '')
                    @foreach($data as $index => $row)
                        @php($temp = isset($data[$index-1])?$index-1:count($data)-1)
                        @if(($data[$index]['specialized_div'].$data[$index]['field_div'])!=($data[$temp]['specialized_div'].$data[$temp]['field_div'])||$count==0)
                           <tr class="tr-disabled">
                                <td colspan="2">
                                    <label style="font-size: 13px"><span> {{$data[$index]['specialized_div_nm'].$data[$index]['field_div_nm']==''?'☆ Nghĩa thông thường':(($row['specialized_div_nm']!=''?('☆ Chuyên nghành: '.$row['specialized_div_nm']).' ':'').($row['field_div_nm']!=''?('★ Lĩnh vực: '.$row['field_div_nm']):''))}}</span></label>
                                </td>
                            </tr>
                        @endif
                        <tr id="{{$row['row_id']}}">
                            <td>
                                <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> {{$row['mean']}}</span> </a>
                            </td>
                            <td width="100px">
                                <div class="vote float-right">
                                    <a class="vote-down {{$raw_data[0][0]['btn-vote-word']==1?'btn-vote-word':'btn-disabled'}} {{(int)$row['word_vote']==-1?'active':''}}" data-toggle="tooltip" data-placement="bottom" data-original-title="{{(int)$row['my_vote']==-1?'Bạn đã vote down cho từ vựng này!':'Từ vựng không chuẩn xác'}}" >
                                        <i class="fa fa-arrow-down animated {{(int)$row['my_vote']==-1?'rotateInLeft':''}}"></i>
                                    </a>
                                    <span style="font-family: Jersey" class="rating-value">{{(int)$row['word_vote']}}</span>
                                    <a class="vote-up {{$raw_data[0][0]['btn-vote-word']==1?'btn-vote-word':'btn-disabled'}} {{(int)$row['my_vote']==1?'active':''}}" data-toggle="tooltip" data-placement="bottom" data-original-title="{{(int)$row['my_vote']==1?'Bạn đã vote up cho từ vựng này!':'Từ vựng chuẩn xác'}}">
                                        <i class="fa fa-arrow-up animated {{(int)$row['my_vote']==1?'rotateInRight':''}}"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @php($count = $count + 1)
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
</div>
