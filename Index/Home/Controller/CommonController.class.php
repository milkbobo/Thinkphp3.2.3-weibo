<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
	
	public function _initialize(){
		
		//处理自动登陆
		if(isset($_COOKIE['auto']) && !isset($_COOKIE['uid'])){
			$value = explode('|',encryption($_COOKIE['auto'],1));
			$ip=get_client_ip();
			//本次登陆IP与上一次登陆IP一致时
			if($ip==$value[1]){
				$account=$value[0];
				$where=array('account'=>$account);
				$user=M('user')->where($where)->field(array('id','lock'))->find();
				
			}
			//检索出用户信息并且该用户没有被锁定时候，保存登陆状态
 			if($user && !$user['lock']){
 				session('uid',$user['id']);
 			}
			
		}
		
		if(!isset($_SESSION['uid'])){
			redirect(U('Login/index'));
		}
	}
	
	
	
	
}


?>