@foreach($data as $index => $row)
@if(isset($row['my_post'])&&$row['my_post']==1)
<tr class="vocabulary-box" target-id="{{$row['row_id']}}">
	<td class="hidden" refer_id='id'>{{$row['id']}}</td>
    <td class="text-center">{{$index+1}}</td>
    <td class="text-center"><a target="_blank" href="/dictionary?v={{$row['id']}}">{{$row['vocabulary_nm']}}</a></td>
    <td class="text-center">{{$row['spelling']}}</td>
    <td class="text-center">{{$row['mean']}}</td>
</tr>
@endif
@endforeach
