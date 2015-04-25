<?php
/*
 * 微博用户视图模型
 */
namespace Home\Model;
use Think\Model\ViewModel;
class WeiboViewModel extends ViewModel{
	
	Protected $viewFields = array(
		'weibo'=>array(
			'id','content','isturn','time','turn','keep','comment',
			'_type'=>'LEFT',
		),
		'picture'=>array(
			'max'=>'pic',
			'_on'=>'weibo.id = picture.wid',
			'_type'=>'LEFT',
		),
		'userinfo'=>array(
			'username','uid',
			'_on'=>'weibo.uid = userinfo.uid',
		)
	);
}


?>