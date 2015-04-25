<?php
/*
 * 微博管理控制器
 */
namespace Home\Controller;
class WeiboController extends CommonController {
	
	/*
	 * 原创微博列表
	 */
    public function index(){
    	$where=array('isturn'=>0);//原创微博
    	
    	//统计数据总条数，用于分页
    	$count  = M('weibo')->where($where)->count();// 查询满足要求的 总记录数
    	$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
    	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    	$limit=$Page->firstRow.','.$Page->listRows;
    	$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录 %FIRST% %UP_PAGE% %NOW_PAGE% / %TOTAL_PAGE% %DOWN_PAGE% %END% ");
    	$Page->setConfig('prev','上一页');
    	$Page->setConfig('next','下一页');
    	
    	$this->weibo = D('WeiboView')->where($where)->limit($limit)->order('time DESC')->select();
    	//p($this->weibo);
    	$this->page= $Page->show();// 分页显示输出
    	$this->display();
    }
  
    /*
     * 删除微博
     */
    public function delWeibo(){
    	$id =I('id','','intval');
    	$uid = I('uid','','intval');
    	
    	//删除微博
    	if(D('WeiboRelation')->relation(true)->delete($id)){
    		M('userinfo')->where(array('uid'=>$uid))->setDec('weibo');
    		$this->success('删除成功',U('index'));
    	}else {
    		$this->error('删除失败，请重试。。。');
    	}
    }
    
    
    
    
    
    
    
    
    
    
    
}