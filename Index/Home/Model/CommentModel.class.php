<?php
/*
 * 评论视图模型
 */
namespace Home\Model;
use Think\Model\ViewModel;
class CommentModel extends ViewModel{
	Protected $viewFields = array(
		'comment'=>array(
			'id','content','time','wid',//'uid',
			'_type'=>'LEFT'
		),
		'userinfo'=>array(
			'username','face50'=>'face','uid',
			'_on'=>'comment.uid = userinfo.uid'
		),
	);
	
	

	
}
?>