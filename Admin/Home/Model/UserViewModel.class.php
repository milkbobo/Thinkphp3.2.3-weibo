<?php
/*
 * 微博用户视图模型
 */
namespace Home\Model;
use Think\Model\ViewModel;
class UserViewModel extends ViewModel{
	
	Protected $viewFields = array(
		'user'=>array(
			'id','`lock`','registime',
			'_type'=>'LEFT',
		),
		'userinfo'=>array(
			'username','face50'=>'face','follow','fans','weibo',
			'_on'=>'user.id = userinfo.uid',
		)
	);
}


?>