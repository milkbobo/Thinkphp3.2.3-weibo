<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
	/*
	 * 登陆页面
	 */
    public function index(){
		$this->display();
    }
    /*
     * 注册页面
     */
    public function register(){
    	$this->display();
    }
    
    /*
     * 注册表单处理
     */
    public function runRegis(){
    	if(!IS_POST){
    		$this->error('页面不存在');
    	}
    	$account=I('account');
    	$pwd=I('pwd');
    	$pwded=I('pwded');
    	$uname=I('uname');
    	$verify=I('verify');
//     	if(!check_verify($verify)){
// 			$this->error('验证码错误');
// 		}
    	if($pwd != $pwded ){
    		$this->error('两次密码不一样');
    	}
    	
    	//提交POST数据
    	$data=array(
    		'account'=>$account,
    		'pwd'=>md5($pwd),
    		'registime'=>time(),
    		'userinfo'=>array(
    			'username'=>$uname,
    		),
    	);
    	p($data);
    }
    
    public function verify(){
		$config =    array(
		    'fontSize'    =>    40,    // 验证码字体大小
		    'length'      =>    4,     // 验证码位数
		    'useNoise'    =>    false, // 关闭验证码杂点
		);
		$Verify =     new \Think\Verify($config);
		$Verify->entry();
    }
    
    /*
     * 异步账号是否已存在
    */
    
    public function checkAccount(){
	   if(!IS_AJAX){
	   	$this->error('页面不存在');
	   }
	   $account = I('account');
	   $where = array('account'=>$account);
	   if(M('user')->where($where)->getField('id')){
	   	echo 'false';
	   }else{
	   	echo 'true';
	   }
    }
    
    /*
     * 异步验证昵称是否已存在
     */
    public function checkUname(){
    	if(!IS_AJAX){
    		$this->error('页面不存在');
    	}
    	$account = I('username');
    	$where = array('username'=>$username);
    	if(M('user')->where($where)->getField('id')){
    		echo 'false';
    	}else{
    		echo 'true';
    	}
    	
    }
    
    /*
     * 异步验证验证码
     */

	public function checkVerify(){
		$code=I('verify');
		if(check_verify($code)){
			echo 'true';
		}else {
			echo 'false';
		}

    }
    
    
    
    
}