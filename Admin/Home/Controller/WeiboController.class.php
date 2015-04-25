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
    
    /*
     * 转发微博列表
     */
    public function turn(){
    	
    	$where=array('isturn'=>array('GT',0));//原创微博
    	$count  = M('weibo')->where($where)->count();// 查询满足要求的 总记录数
    	$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
    	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    	$limit=$Page->firstRow.','.$Page->listRows;
    	$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录 %FIRST% %UP_PAGE% %NOW_PAGE% / %TOTAL_PAGE% %DOWN_PAGE% %END% ");
    	$Page->setConfig('prev','上一页');
    	$Page->setConfig('next','下一页');
    	
    	$db = D('WeiboView');
    	unset($db->viewFields['picture']);
    	//p($db->viewFields);
    	$this->turn = $db->where($where)->limit($limit)->order('time DESC')->select();
    	//p($this->turn);
    	$this->page= $Page->show();// 分页显示输出
    	$this->display();
    }
    
    /*
     * 微博检索
     */
    public function sechWeibo(){
    	if(isset($_GET['sech'])){
    		$where = array('content'=>array('LIKE','%'.I('sech').'%'));
    		$weibo =D('WeiboView')->where($where)->order('time DESC')->select();
    		$this->weibo=$weibo ? $weibo : false;
    	}
    	$this->display();
    }
    
    /*
     * 评论列表
     */
    public function comment(){
    	
    	$count  = M('weibo')->count();// 查询满足要求的 总记录数
    	$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
    	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    	$limit=$Page->firstRow.','.$Page->listRows;
    	$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录 %FIRST% %UP_PAGE% %NOW_PAGE% / %TOTAL_PAGE% %DOWN_PAGE% %END% ");
    	$Page->setConfig('prev','上一页');
    	$Page->setConfig('next','下一页');
    	
    	$this->comment = D('CommentView')->order('time DESC')->select();
    	$this->page= $Page->show();// 分页显示输出
    	$this->display();
    }
    
    /*
     * 删除评论
     */
    public function delComment(){
    	$id=I('id','','intval');
    	$wid = I('wid','','intval');
    	
    	if(M('comment')->delete($id)){
    		M('weibo')->where(array('id'=>$wid))->setDec('comment');
    		$this->success('删除成功',$_SERVER['HTTP_REFERER']);
    	}else {
    		$this->error('删除失败，请重试...');
    	}
    }
    
    /*
     * 评论检索
     */
    public function sechComment(){
    	if(isset($_GET['sech'])){
    		$where = array('content'=>array('LIKE','%'.I('sech').'%'));
    		$comment =D('CommentView')->where($where)->order('time DESC')->select();
    		$this->comment=$comment ? $comment : false;
    	}
    	$this->display();
    }
    
    
    
    
}