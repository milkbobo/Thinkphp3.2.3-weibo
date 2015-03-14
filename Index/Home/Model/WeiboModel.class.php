<?php
/*
 * 读取微博视图模型
*/
namespace Home\Model;
use Think\Model\ViewModel;
class WeiboModel extends ViewModel{
	Protected $viewFields = array(
			'weibo'=>array('id','content','isturn','time','turn','keep','comment','uid',
							'_type'=>'LEFT'
							),
			
			'userinfo' => array(
					'username',
					'face50'=>'face',
					'_on'=>'weibo.uid = userinfo.uid',//键值后表示别面
					'_type'=>'LEFT'
			),
			'picture'=>array(
				'mini','medium','max',
				'_on' => 'weibo.id = picture.wid' //关联上一组数据的关系
			),
	);
	/*
	 * 返回查询记录
	 */
	public function getAll($where){
		return $this->where($where)->order('time DESC')->select();
	}
}


?>