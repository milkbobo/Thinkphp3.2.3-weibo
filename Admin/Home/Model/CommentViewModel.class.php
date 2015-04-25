<?php
/*
 * 评论视图模型
 */
namespace Home\Model;
use Think\Model\ViewModel;
class CommentViewModel extends ViewModel{
	
	protected  $viewFields = array(
		'comment'=>array(
			'id','content','time','wid',
			'_type'=>'LEFT',
		),
		'userinfo'=>array(
			'username','uid',
			'_on'=>'comment.uid = userinfo.uid',
		)
	);
}


?>