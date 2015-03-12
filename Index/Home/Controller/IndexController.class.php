<?php
namespace Home\Controller;
class IndexController extends CommonController {
		
	/*
	 * 首页视图
	 */
	public function Index(){
		$this->display();
		
	}
	
	/*
	 * 退出登录
	 */
	
	public function loginOut(){
		//卸载SESSION
		session_unset();
		session_destroy();
		
		//删除用于自动登陆的cookie
		@setcookie('auto','',time()-3600,'/');
		
		//跳转到等登陆页
		redirect(U('Login/index'));
	}
}



?>