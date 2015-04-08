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
		$this->display();
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