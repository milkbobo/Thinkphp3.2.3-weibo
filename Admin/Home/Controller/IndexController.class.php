<?php
/*
 * 后台首页控制器
 */
namespace Home\Controller;
class IndexController extends CommonController {
	
	/*
	 * 后台首页视图
	 */
    public function index(){
    	$this->display();
    }
    
    /*
     * 后台信息首页
     */
    public function copy(){
    	$this->display();
    }
    
    /*
     * 退出登陆
     */
    public function loginOut(){
    	session_unset();
    	session_destroy();
    	redirect(U('Login/index'));
    }
}