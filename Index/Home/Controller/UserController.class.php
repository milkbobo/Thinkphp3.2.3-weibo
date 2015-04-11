<?php
namespace Home\Controller;
class UserController extends CommonController {
	
	/*
	 * 用户个人页视图
	 */
	
	public function index(){
		$id = I('id','','intval');
		//echo $id;
		
		//读取用户个人信息
		$where=array('uid'=>$id);
		$field='truename,face50,face80,style';
		$userinfo = M('userinfo')->where($where)->field($field,true)->find();
		if (!$userinfo)redirect('/',3,'用户不存在，正在为您跳转至首页...');
		//p($userinfo);
		$this->userinfo=$userinfo;
		
		//导入分页处理页
		//统计分页
		$where = array('uid'=>$id);
		$count  = M('weibo')->where($where)->count();// 查询满足要求的 总记录数
		$Page= new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$limit=$Page->firstRow.','.$Page->listRows;
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录 %FIRST% %UP_PAGE% %NOW_PAGE% / %TOTAL_PAGE% %DOWN_PAGE% %END% ");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		//读取用户发布的微博
		$this->page=$Page->show();
		$this->weibo=D('weibo')->getAll($where,$limit);
		
		//我的关注
		if(S('follow_'.$id)){
			//缓存已存在并且缓存未过期
			$follow=S('follow_'.$id);
		}else {
			$where = array('fans'=>$id);
			$follow=M('follow')->where($where)->field('follow')->select();
			foreach($follow as $k=>$v){//二维数组变成一位数组
				$follow[$k]=$v['follow'];
			}
			$where=array('uid'=>array('IN',$follow));
			$field=array('username','face50'=>'face','uid');
			
			if(!empty($follow)){
				$follow=M('userinfo')->field($field)->where($where)->limit(8)->select();
			}
			S('follow_'.$id,$follow,3600);
		}
		
		//我的粉丝
		if(S('fans_'.$id)){
			//缓存已存在并且缓存未过期
			$follow=S('fans_'.$id);
		}else {
			$where = array('follow'=>$id);
			$fans=M('follow')->where($where)->field('fans')->select();
			foreach($fans as $k=>$v){//二维数组变成一位数组
				$fans[$k]=$v['fans'];
			}
			$where=array('uid'=>array('IN',$fans));
			$field=array('username','face50'=>'face','uid');
				
			if(!empty($follow)){
				$fans=M('userinfo')->field($field)->where($where)->limit(8)->select();
			}
			S('fans_'.$id,$fans,3600);
		}
		$this->follow=$follow;
		$this->fans=$fans;
		$this->display();
	}
	
	/*
	 * 用户关注与粉丝列表
	 */
	public function followList(){
// 		p($_GET);

 		$uid = I('uid','','intval');
 		
 		//区分关注 与 粉丝（1：关注，0：粉丝）
 		$type = I('type','','intval');
 		$db = M('follow');
 		
 		//根据type参数不同，读取用户关注与粉丝ID
 		$where = $type ? array('fans'=>$uid) : array('follow' => $uid);
 		$field = $type ? 'follow' : 'fans';
 		$count = $db->where($where)->count();
 		$Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
 		$limit=$Page->firstRow.','.$Page->listRows;
 		
 		$uids = $db->field($field)->where($where)->limit($limit)->select();
 		
		if ($uids){
			//把用户关注或者粉丝ID重组为一维数组
			foreach ($uids as $k => $v){
				$uids[$k]= $type ? $v['follow'] : $v['fans'];
			}
			
			//提取用户个人信息
			$where = array('IN'=>array($uids));
			$field = array('face50'=>'face','username','location','follow','fans','weibo','uid');
			$users = M('userinfo')->where($where)->field($field)->select();
		}
		
 		p($users);
	}
	
	/*
	 * 空操作
	 */
	public function _empty($name){
		$this->_getUrl($name);
	}
	
	/*
	 * 处理用户名空操作、获取用户ID 跳转至用户个人页
	 */
	private function _getUrl($name){

		$name =htmlspecialchars($name);
		$where = array('username'=>$name);
		$uid = M('userinfo')->where($where)->getField('uid');

		if(!$uid){
			redirect(U('Index/index'));
		}else {
			redirect(U('/'.$uid));
		}
	}
}

	
?>