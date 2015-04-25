<?php
/*
 * 微博用户视图模型
 */
namespace Home\Model;
use Think\Model\ViewModel;
class UserViewModel extends ViewModel{
	
	Protected $viewFields = array(
		'user'=>array(
			'id','`lock`','registime',//lock是sql的关键词，所以用``号来区分
			'_type'=>'LEFT',
		),
		'userinfo'=>array(
			'username','face50'=>'face','follow','fans','weibo',
			'_on'=>'user.id = userinfo.uid',
		)
	);
}


?>