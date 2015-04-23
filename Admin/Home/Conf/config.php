<?php
return array(
		//数据库配置
		'DB_TYPE' => 'mysql', // 数据库类型
		'DB_HOST'               =>  'localhost', // 服务器地址
		'DB_NAME'               =>  'weibo',          // 数据库名
		'DB_USER'               =>  'root',      // 用户名
		'DB_PWD'                =>  '123456',          // 密码
		'DB_PREFIX'             =>  'hd_',    // 数据库表前缀
		
		//自定义模板替换
		'TMPL_PARSE_STRING'  =>array(
				'__PUBLIC__' =>'/'.APP_PATH.MODULE_NAME.'/View/Public', // 更改默认的/Public 替换规则
		)
);