<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>HDWeiBo 后台管理中心</title>
	<link rel="stylesheet" href="/./Admin/Home/View/Public/Css/index.css" />
	<script type="text/javascript" src='/./Admin/Home/View/Public/Js/jquery-1.8.2.min.js'></script>
	<script type="text/javascript" src='/./Admin/Home/View/Public/Js/index.js'></script>
	<base target="iframe" />
</head>
<body>
	<div id="top">
		<div class='logo'></div>
		<div class='t_title'>后台管理中心</div>
		<div class='menu'>
			<ul>
				<li class='first first_cur'>
					<a href="<?php echo U('copy');?>"><span>首&nbsp;页</span></a>
				</li>
				<li class='next'>
					<a href="<?php echo U('User/index');?>"><span>用户管理</span></a>
				</li>
				<li>
					<a href="<?php echo U('Weibo/index');?>"><span>微博管理</span></a>
				</li>
				<li class='last'>
					<a href="<?php echo U('System/index');?>"><span>系统设置</span><div></div></a>
				</li>
			</ul>
			<div id='user'>
				<span class='user_state'>当前管理员：[<span><?php echo (session('username')); ?></span>]</span>
				<a href="<?php echo U('loginOut');?>" target='_self' id='login_out'></a>
			</div>
		</div>
	</div>
	<div id='left'>
		<div class='nav'>
			<div class="nav_u"><span class="pos down">用户管理</span></div>
		</div>
		<ul class='option'>
			<li><a href='<?php echo U("User/index");?>'>微博用户</a></li>
			<li><a href='<?php echo U("User/sechUser");?>'>微博用户检索</a></li>
			<li><a href='<?php echo U("User/admin");?>'>后台管理员</a></li>
			<?php if(!$_SESSION["admin"]): ?><li><a href='<?php echo U("User/addAdmin");?>'>添加管理员</a></li><?php endif; ?>
		</ul>

		<div class='nav'>
			<div class="nav_u"><span class="pos down">微博管理</span></div>
		</div>
		<ul class='option'>
			<li><a href='<?php echo U("Weibo/index");?>'>原作微博</a></li>
			<li><a href='<?php echo U("Weibo/turn");?>'>转发微博</a></li>
			<li><a href='<?php echo U("Weibo/sechWeibo");?>'>微博检索</a></li>
		</ul>
		<div class='nav'>
			<div class="nav_u"><span class="pos down">评论管理</span></div>
		</div>
		<ul class='option'>
			<li><a href='<?php echo U("Weibo/comment");?>'>评论列表</a></li>
			<li><a href='<?php echo U("Weibo/sechComment");?>'>评论检索</a></li>
		</ul>
		<div class='nav'>
			<div class="nav_u"><span class="pos down">系统设置</span></div>
		</div>
		<ul class='option'>
			<li><a href='<?php echo U("System/filter");?>'>关键字过滤</a></li>
			<li><a href='<?php echo U("System/index");?>'>网站设置</a></li>
			<li><a href='<?php echo U("User/editPwd");?>'>修改密码</a></li>
		</ul>
	</div>
	<div id="right">
		<iframe src="<?php echo U('copy');?>" frameborder="0" name='iframe'></iframe>
	</div>
</body>
</html>