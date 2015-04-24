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
    	//p($_SERVER);
    	$this->display();
    }
    
    /*
     * 后台信息首页
     */
    public function copy(){
    	//p($_SESSION);
    	$db=M('user');
    	$this->user=$db->count();
    	$this->lock=$db->where(array('lock'=>1))->count();

    	$db=M('weibo');
    	$this->weibo = $db->where(array('isturn'=>0))->count();
    	$this->turn = $db->where(array('isturn'=>array('GT',0)))->count();//isturn大于0的是转发微博
    	$this->comment = M('comment')->count();
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