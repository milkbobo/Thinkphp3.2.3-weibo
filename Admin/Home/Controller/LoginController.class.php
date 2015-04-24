<?php
/*
 * 后台登陆控制器
 */
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    
	/*
	 * 登陆页面视图
	 */
	public function index(){
    	$this->display();
    }
    
    /*
     * 登陆操作处理
     */
    public function login(){
    	if(!IS_POST)$this->error('页面不存在');
    	//p($_POST);
    	if(!isset($_POST['submit']))return false;//安全一点再判断一下
    	
    	//验证码对比
    	$code=I('verify');
		//if(!check_verify($code))$this->error('验证码错误');//测试系统，忽略认证
		
		$name=I('uname');
		$pwd=md5(I('pwd'));
		$db=M('admin');
		$user = $db ->where(array('username'=>$name))->find();
		
		if(!$user || $user['password'] != $pwd){
			$this->error('账号或密码错误');
		}
		
		if($user['lock']){
			$this->error('账号被锁定');
		}
		
		$data=array(
				'id'=>$user['id'],
				'logintime'=>time(),
				'loginip'=>get_client_ip(),
		);
		$db->save($data);
		
		session('uid',$user['id']);
		session('username',$user['username']);
		session('logintime',date('Y-m-d H:i',$user['logintime']));
		session('now',date('Y-m-d H:i',time()));
		session('loginip',$user['loginip']);
		session('admin',$user['admin']);
		$this->success('正在登陆...',__APP__);
    }
    
    /*
     * 验证码
     */
    public function verify(){
    	ob_clean();
    	$config =    array(
    			'fontSize'    =>    160,    // 验证码字体大小
    			'length'      =>    4,     // 验证码位数
    			'useNoise'    =>    false, // 关闭验证码杂点
    			'reset' => false // 验证成功后是否重置，————这里是无效的。
    	);
    	$Verify =     new \Think\Verify($config);
    	$Verify->entry();
    }
}