<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>HDSHOP 系统信息</title>
	<link rel="stylesheet" href="/./Admin/Home/View/Public/Css/copy.css" />
	<script type="text/javascript" src='/./Admin/Home/View/Public/Js/jquery-1.8.2.min.js'></script>
	<script type="text/javascript">
		window.onload = function () {
			$('#main').fadeIn(2000);
		}
	</script>
</head>
<body>
	<div id='main'>
		<dl>
			<dt>个人信息</dt>
			<dd>上一次登录时间：<span><?php echo (session('logintime')); ?></span></dd>
			<dd>上一次登录IP：<span><?php echo (session('loginip')); ?></span></dd>
			<dd>本次登录时间：<span><?php echo (session('now')); ?></span></dd>
			<dd>本次登录IP：<span><?php echo get_client_ip();?></span></dd>
		</dl>
		<dl>
			<dt>服务器信息</dt>
			<dd>操作系统：<span><?php echo (PHP_OS); ?></span></dd>
			<dd>PHP版本： <span><?php echo (PHP_VERSION); ?></span></dd>
			<dd>服务器环境：<span><?php echo ($_SERVER['SERVER_SOFTWARE']); ?></span></dd>
			<dd>MySQL版本：<span><?php echo mysql_get_server_info();?></span></dd>
		</dl>
		<dl>
			<dt>用户信息</dt>
			<dd>共有注册用户：<span><?php echo ($user); ?></span></dd>
			<dd>被锁定用户：<span><?php echo ($lock); ?></span></dd>
		</dl>
		<dl>
			<dt>微博信息</dt>
			<dd>原作微博：<span><?php echo ($weibo); ?></span>条</dd>
			<dd>转发微博：<span><?php echo ($turn); ?></span>条</dd>
			<dd>评论总数：<span><?php echo ($comment); ?></span>条</dd>
		</dl>
		<dl>
			<dt>版权信息</dt>
			<dd>版权所有：后盾网 京ICP备10027771号-1</dd>
			<dd>系统开发：黄永成</dd>
		</dl>
	</div>
</body>
</html>