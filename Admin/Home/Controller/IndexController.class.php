<?php
/*
 * 后台首页控制器
 */
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	
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
    
}