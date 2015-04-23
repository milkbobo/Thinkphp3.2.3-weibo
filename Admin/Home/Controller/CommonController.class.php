<?php
/*
 * 公共控制器
 */
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {

	/*
	 * 判断用户是否已登陆
	 */
	public function _initialize(){
		if(!isset($_SESSION['uid']) || !isset($_SESSION['username'])){
			redirect(U('Login/index'));
		}
	}
}
	


?>