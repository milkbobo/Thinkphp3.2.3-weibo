<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>后盾微博-注册</title>
	<link rel="stylesheet" href="/weibo/Public/Css/login.css" />

	
</head>
<body>
	<div id='top-bg'></div>
	<div id='login-form'>
		<div id='login-wrap'>
			<p>还没有微博帐号？<a href='<?php echo U('register');?>'>立即注册</a></p>
			<form action="" method='post' name='login'>
				<fieldset>
					<legend>用户登录</legend>
					<p>
						<label for="account">登录账号：</label>
						<input type="text" name='account' class='input'/>
					</p>
					<p>
						<label for="pwd">密码：</label>
						<input type="password" name='pwd' class='input'/>
					</p>
					<p>
						<input type="checkbox" name='auto' checked='1' class='auto' id='auto'/>
						<label for="auto">下次自动登录</label>
					</p>
					<p>
						<input type="submit" value='马上登录' id='login'/>
					</p>
				</fieldset>
			</form>
		</div>
	</div>
</body>
</html>