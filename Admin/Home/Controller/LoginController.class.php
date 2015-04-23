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
     * 验证码
     */
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
}