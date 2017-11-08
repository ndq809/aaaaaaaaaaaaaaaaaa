@extends('layout_master')
@section('button')
{{Button::menu_button(array('btn-list','btn-search'))}}
@endsection
@section('content')
<div class="panel main-panel">
	<div class="panel-header">
		<h5 class="panel-title">Danh Sách Ngữ Pháp</h5>
	</div>
	<div class="panel-content">
		<table class="table">
			<tbody>
				@for($i=1;$i<10;$i++)
				<tr>
					<td>1</td>
					<td>2</td>
					<td>3</td>
					<td>4</td>
				</tr>
				@endfor
			</tbody>
		</table>
	</div>
	<div class="panel-bottom"></div>
</div>
<div class="panel main-panel">
	<div class="panel-header">
		<h5 class="panel-title">Danh Sách Ngữ Pháp</h5>
	</div>
	<div class="panel-content">
		<table class="table">
			<tbody>
				@for($i=1;$i<10;$i++)
				<tr>
					<td>1</td>
					<td>2</td>
					<td>3</td>
					<td>4</td>
				</tr>
				@endfor
			</tbody>
		</table>
	</div>
	<div class="panel-bottom"></div>
</div>
@stop