<?php
/*
 * 用户与用户信息表关联模型
 * 关联模型要用RelationModel
 * 普通模型用Model
 * 视图模型viewModel
 */
namespace Home\Model;
use Think\Model\RelationModel;
class UserModel extends RelationModel{
	
	//定义主表名称
	Protected $tableName = 'user';
	
	//定义用户与用户信息处理表关系属性
	Protected $_link = array(
		'userinfo' =>array(
			'mapping_type'=>self::HAS_ONE,
			'foreign_key'=> 'uid',
		)	
	);
	
	/*
	 * 自动插入数据方法
	 * Relation(true)会关联保存User模型定义的所有关联数据，如果只需要关联保存部分数据，可以使用：relation("Profile");
	 */
	
	public function insert($data=NULL){
		$data= is_null($data) ? $_POST : $data;
		return $this->relation(true)->data($data)->add();
	}
	
}


?>