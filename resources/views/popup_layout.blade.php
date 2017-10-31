<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
		<meta content="IE=edge" http-equiv="X-UA-Compatible">
		<meta content="width=device-width, initial-scale=1" name="viewport">
		<meta content="{{ csrf_token() }}" name="csrf-token"/>
        <link rel="shortcut icon" href="web-content/images/icon/title-icon2.ico" />
		<title>
			@yield('title','English Plus')
		</title>
		<script src="{{URL::asset('web-content/js/common/library/jquery-3.2.1.min.js')}}" type="text/javascript">
		</script>
		<script src="{{URL::asset('web-content/js/common/library/bootstrap.min.js')}}" type="text/javascript">
		</script>
		<link href="{{URL::asset('web-content/css/common/library/bootstrap.min.css')}}" rel="stylesheet">
		<script src="{{URL::asset('web-content/js/common/library/DateTimePicker.js?=time()')}}" type="text/javascript">
		</script>
		<link href="{{URL::asset('web-content/css/common/library/DateTimePicker.css?=time()')}}" rel="stylesheet">
		<script src="{{URL::asset('web-content/js/common/defined/common.js?=time()')}}" type="text/javascript">
		</script>
		<link href="{{URL::asset('web-content/css/common/defined/common.css?=time()')}}" rel="stylesheet">
		<link href="{{URL::asset('web-content/css/common/defined/screencontroller.css?=time()')}}" rel="stylesheet">
		@yield('asset_header')
    </head>
    <body>
      @yield('content')
    </body>
</html>
