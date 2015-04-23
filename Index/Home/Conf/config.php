<?php
return array(
		//数据库配置
		'DB_TYPE' => 'mysql', // 数据库类型
		'DB_HOST'               =>  'localhost', // 服务器地址
		'DB_NAME'               =>  'weibo',          // 数据库名
		'DB_USER'               =>  'root',      // 用户名
		'DB_PWD'                =>  '123456',          // 密码
		'DB_PREFIX'             =>  'hd_',    // 数据库表前缀
		
		'DEFAULT_THEME'         =>  'default', // 默认模板主题名称
		
		//用于异位或加密的KEY
		'ENCTYPTION_KEY'=>'www.tongyingyang.com',
		
		//自动登陆保存时间
		'AUTO_LOGIN_TIME'=>time() +3600*24*7 , //一个星期
		
		//图片上传
		'UPLOAD_MAX_SIZE'=>2000000,//最大上传大小
		'UPLOAD_PATH'=> './Uploads/', //文件上传保存路径
		'UPLOAD_EXTS'=>array('jpg', 'gif', 'png', 'jpeg'),// 允许上传类型
		
		//URL路由
		'URL_ROUTER_ON'   => true,  //开启路由功能
		'URL_ROUTE_RULES'=>array(	//定义路由规则
				':id\d'=>'User/index',
				'follow/:uid\d'=>array('User/followList','type=1'),
				'fans/:uid\d'=>array('User/followList','type=0')
		),
		
		//自定义标签配置
 		'TAGLIB_BUILD_IN'=>'Cx,Hd',//加入系统标签库
 		
		//缓存设置
		'DATA_CACHE_SUBDIR'=>true, //开启哈希形式生成缓存目录
// 		'DATA_PATH_LEVEL'=>2,//目录层次
// 		'DATA_CACHE_TYPE'=>'Memcache',
// 		'MEMCACHE_HOST'=>'127.0.0.1',
// 		'MEMCACHE_PORT'=>11211,
		
);