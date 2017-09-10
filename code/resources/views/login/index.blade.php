<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>login</title>
	<link rel="icon" type="text/css" href="https://static.jianshukeji.com/highcharts/images/favicon.ico">
	  <link rel="stylesheet" href="{{ asset('static/css/logn.css') }}" type="text/css" />
	  <!-- 新 Bootstrap 核心 CSS 文件 -->
	<link href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
 
<!-- 可选的Bootstrap主题文件（一般不使用） -->
<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap-theme.min.css"></script>
 
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
 
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="mydiv">
	  	<div class="div_left">
		    <table>
			    <tr>
				    <td class="loginTd">
				       登录
				    </td>
			    </tr>
			    <tr>
			      	<td class="formTd">
		  				<div class="form-group">
			    			<div class="col-sm-10">
			      				<input type="text" class="form-control" id="username" name="username" placeholder="用户名" class="formInput">
			   				</div>
		  				</div>
			      	</td>
			    </tr>
			    <tr>
			      	<td class="formtd">
					  	<div class="form-group">
						    <div class="col-sm-10">
						      <input type="password" class="form-control" id="pwd" name="pwd" placeholder="密码" class="formInput">
						    </div>
					  	</div>
			      	</td>
			    </tr>
			    <tr>
			    	<td>
			    		<div id="info"  style="color: red;font-size: 12px;text-align: left;padding-left: 19%"></div>
			    	</td>
			    </tr>
			    <tr>

			      	<td class="logintd">
			         	<button type="button" class="btn btn-default btn-lg" id="sub" onmouseover="this.style.backgroundColor='#6fa7e8';" onmouseout="this.style.backgroundColor = '#6fa7e8';" style="width:64%;margin-left:2%">登陆</button>
			      	</td>
			    </tr>
		    </table>
	    </div>
	    <div class="div_right">
		    <div class="title">
		     	xxx房产记账结账系统
		    </div> 
		    <div class="content">
		     	我们提供不止于服务,更专注于客户体验
		     	<br>
		     	帮您高效办公
		    </div>
	  	</div> 
	</div>
	<div class="copyRight">
    <div >版权所有: © locqj
    </div>
</div>
</body>
<script>
	$(function(){
		$('input').click(function(event) {
			$('#info').text('');
		});
		$('#sub').click(function(event) {
			var username = $('#username').val();
			var pwd = $('#pwd').val();
			if (!username) {
				$('#info').text("用户名不得为空");
			}else if (!pwd) {
				$('#info').text("密码不得为空");
			} else {
				$.post('/login/sub', 
				{
					username: username,
					pwd: pwd
				}, function(data, textStatus, xhr) {
					if(data.status == 1){
						if(data.data == 'xs' || data.data == 'gh'){
							window.location.href = "/tree";
						}else{
							window.location.href = "/index";
						}
						
					}else{
						$('#info').text(data.msg);
					}
				});
			}
		});
	});
</script>
	
</html>