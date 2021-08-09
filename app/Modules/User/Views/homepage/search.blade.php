<div>
@if(isset($data)&&$data[0][0]['target_id'] != '')
    @foreach($data[0] as $index => $row)
    <div class='col-lg-6 col-md-6 col-xs-12'>
        <div class='form-group'>
            <a href="{{$row['link'].'?v='.$row['target_id'].$row['special_param']}}" title="{{$row['notes']}}">
                <i class="glyphicon glyphicon-hand-right">
                </i>
                {{$row['description1']}}
                <span class='target-nm'>
                {{$row['description2']}}
                </span>
                {{$row['description3']}}
            </a>
        </div>
    </div>
    @endforeach
@else
    @if(!isset($data))
    <div class='col-lg-6 col-md-6 col-xs-12'>
        <span colspan="14">Xin nhập điều kiện tìm kiếm</span>
    </div>
    @else
    <div class='col-lg-6 col-md-6 col-xs-12'>
        <span colspan="14">Không có bản ghi nào khớp với điều kiệm tìm kiếm</span>
    </div>
    @endif
@endif
</div>
<div class="col-xs-12 text-center">
@if(!isset($paging))
    @php
        $paging=array('page' => 6,'pagesize' => 15,'totalRecord' => 0,'pageMax'=>10 )
    @endphp
@endif
@if($paging['totalRecord'] != 0)
    <div class=" text-center no-padding-left">
        {!!Paging::show($paging,0)!!}
    </div>
@endif
</div>
