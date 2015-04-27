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
     * 登陆表单处理
     */
    public function login(){
        if(!IS_POST)$this->error('页面不存在');
    	$account=I('account');
    	$pwd=md5(I('pwd'));
    	$where=array('account'=>$account);
    	$user = M('user')->where($where)->find();
    	if (!$user || $user['password'] != $pwd)$this->error('用户不存在或者密码错误');
		if($user['lock'])$this->error('用户被锁定');
		
		//处理下一次自动登陆
		if(isset($_POST['auto'])){
// 			$value='tongyingyang';
// 			$value = encryption($value);
// 			echo $value;
// 			$value = encryption($value,1);

		$account=$user['account'];
		$ip=get_client_ip();
		$value=$account.'|'.$ip;
		$value=encryption($value);
		
// 		echo $value;
// 		echo'<br/>';
// 		echo encryption($value,1);

		@setcookie('auto',$value,C('AUTO_LOGIN_TIME'),'/');
		}
		
		//登陆成功写入SESSION并且跳转到到首页
		session('uid',$user['id']);
		header('Content-Type:text/html;Charset=UTF-8');
		redirect(__APP__,3,'登陆成功，正在为您跳转...');
    }
    
    /*
     * 注册页面
     */
    public function register(){
    	if(!C('REGIS_ON'))$this->error('网站暂停注册',U('index'));
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
    		'password'=>md5($pwd),
    		'registime'=>time(),
    		'userinfo'=>array(
    			'username'=>$uname,
    		),
    	);
    	$id = D('User')->insert($data);
    	if ($id){
    		//插入数据成功后把用户ID写SESSION
    		session('uid',$id);
    		header('Content-Type:text/html;Charset=UTF-8');
    		redirect(__APP__, 5, '注册成功，页面跳转中...');
    	}else {
    		$this->error('注册失败，请重试...');
    	}    	
    }
    
    public function verify(){
    	ob_clean();
		$config =    array(
		    'fontSize'    =>    140,    // 验证码字体大小
		    'length'      =>    4,     // 验证码位数
		    'useNoise'    =>    false, // 关闭验证码杂点
			'reset' => false // 验证成功后是否重置，————这里是无效的。
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
    	$where = array('username'=>$account);
    	if(M('user')->where($where)->getField('id')){
    		echo 'true';
    	}else{
    		echo 'false';
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
			echo 'flase';
			//echo 'false';//测试关闭
		}

    }
    
    
    
    
}