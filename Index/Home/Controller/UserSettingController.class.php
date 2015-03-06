<?php
/*
 * 账号设置控制器
*/
namespace Home\Controller;
class UserSettingController extends CommonController {
	
	/*
	 * 用户基本信息设置视图
	 */
	public function index(){
		$where=array('uid'=>session('uid'));
		$field=array('username','truename','sex','location','constellation','intro','face180');
		$user = M('userinfo')->where($where)->field($field)->find();
		//p($user);die;
		$this->user=$user;
		$this->display();
	}
	
	/*
	 * 修改用户基本信息
	 */
	public function editBasic(){
		if(!IS_POST)$this->error('页面不存在');
		$data=array(
			'username'=>I('nickname'),
			'truename'=>I('truename'),
			'sex'=>I('sex','','intval'),
			'location'=>I('province').' '.I('city'),
			'constellation'=>I('night'),
			'intro'=>I('intro'),	
		);
		//p($_POST);die;
		$where=array('uid'=>session('uid'));
		if(M('userinfo')->where($where)->save($data)){
			$this->success('修改成功',U('index'));
		}else {
			$this->error('修改失败');
		}
	}
	
	/*
	 * 修改用户头像
	*/
	public function editFace(){
		if(!IS_POST)$this->error('页面不存在');
		$db = M('userinfo');
		$where = array('uid'=>session('uid'));
		$field = array('face50','face80','face180');
		$old=$db->where($where)->field($field)->find();
		if ($db->where($where)->save($_POST)){
			if (!empty($old['face180'])){
				@unlink('./Uploads/Face/'.$old['face180']);
				@unlink('./Uploads/Face/'.$old['face80']);
				@unlink('./Uploads/Face/'.$old['face50']);
			}
			$this->success('修改成功',U('index'));
		}else {
			$this->error('修改失败，请重试...');
		}
	}
	
	/*
	 * 修改密码
	 */
	public function editPwd(){
		if(!IS_POST)$this->error('页面不存在');
		
		//验证就密码
		$db=M('user');
		$where = array('uid'=>session('uid'));
		$old = $db->where($where)->getField('password');
		
		if(md5(I('old')) != $old)$this->error('旧密码错误');
		if(I('new') != I('newed'))$this->error('两次密码不一致');
		
		$newPwd = md5(I('new'));
		$data = array(
				'id'=>session('uid'),
				'password'=>$newPwd ,
				);
		if($db->save($data)){
			$this->success('修改成功',U('index'));
		}else {
			$this->error('修改失败，请重试...');
		}
	}
	
	
	
	
	
	
	
	
}


?>