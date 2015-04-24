<?php
/*
 * 用户管理控制器
 */
namespace Home\Controller;
class UserController extends CommonController {
	
	/*
	 * 微博用户列表
	 */
    public function index(){
    	//统计数据总条数，用于分页
    	$count  = M('user')->where($where)->count();// 查询满足要求的 总记录数
    	$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
    	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    	$limit=$Page->firstRow.','.$Page->listRows;
    	$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录 %FIRST% %UP_PAGE% %NOW_PAGE% / %TOTAL_PAGE% %DOWN_PAGE% %END% ");
    	$Page->setConfig('prev','上一页');
    	$Page->setConfig('next','下一页');
    	
    	$this->users=D('UserView')->limit($limit)->select();
    	$this->page = $Page->show();
    	
    	$this->display();
    }
}