<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <meta content="{{ csrf_token() }}" name="csrf-token"/>
        <style>
		body {
		    font-family: serif;
		}

		.panel {
		    width: 100%;
		    background: #fff;
		    padding: 10px;
		    background-color: #eee6da;
		    margin: 0px;
		}
		.panel-title{
			font-weight: bold;
			color: green;
		}
		.panel-content{
			/*padding: 0px 20px;*/
		}
		.slogan{
			color: #d9534f;
			font-weight:bold;
		}
		.line{
			width: 100%;
			border: 1px solid #aaa;
		}
		.main-content{
			color: red;
			font-weight: bold;
		}
		.user-name{
			color: #4CAF50;
			font-weight: bold;
		}
		.warning{
			color: red;
		} 
		</style>
    </head>
    <body>
		<div class="panel">
			<div class="panel-header">
				<span class="panel-title">EPLUS SYSTEM</span>
			</div>
			<div class="panel-content">
				<p>Xin Chào <span class="user-name">{!! isset($username)?$username:'' !!}</span></p>
				<p>Cảm ơn bạn đã tham gia cộng đồng Eplus!</p>
				<p>Mật khẩu của bạn đã được thay đổi thành <span class="main-content">{!! isset($password)?$password:'' !!}</span></p>
				<p>Để không quên xin hãy đăng nhập để đổi sang mật khẩu bạn thích</p>
				<p>Xin cảm ơn</p>
			</div>
			<div class="panel-bottom">
				<span class="slogan">WITH EPLUS ENGLISH SO EASY !!!</span>
				<div class="line"></div>
				<p>Xin lưu ý đây là email được gửi tự động từ hệ thống !</p>
			</div>
		</div>
    </body>
</html>
