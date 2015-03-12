<?php
namespace Home\Controller;
class UserController extends CommonController {
	
	/*
	 * 用户个人页视图
	 */
	
	public function index(){
		$id = I('id','','intval');
		echo $id;
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