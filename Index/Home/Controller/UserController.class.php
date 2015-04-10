<?php
namespace Home\Controller;
class UserController extends CommonController {
	
	/*
	 * 用户个人页视图
	 */
	
	public function index(){
		$id = I('id','','intval');
		//echo $id;
		
		//读取用户个人信息
		$where=array('uid'=>$id);
		$field='truename,face50,face80,style';
		$userinfo = M('userinfo')->where($where)->field($field,true)->find();
		if (!$userinfo)redirect('/',3,'用户不存在，正在为您跳转至首页...');
		//p($userinfo);
		$this->userinfo=$userinfo;
		
		//导入分页处理页
		//统计分页
		$where = array('uid'=>$id);
		$count  = M('weibo')->where($where)->count();// 查询满足要求的 总记录数
		$Page= new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$limit=$Page->firstRow.','.$Page->listRows;
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录 %FIRST% %UP_PAGE% %NOW_PAGE% / %TOTAL_PAGE% %DOWN_PAGE% %END% ");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		//读取用户发布的微博
		$this->page=$Page->show();
		$this->weibo=D('weibo')->getAll($where,$limit);
		$this->display();
	}
	
	/*
	 * 空操作
	 */
	public function _empty($name){
		$this->_getUrl($name);
	}
	
	/*
	 * 处理用户名空操作、获取用户ID 跳转至用户个人页
	 */
	private function _getUrl($name){

		$name =htmlspecialchars($name);
		$where = array('username'=>$name);
		$uid = M('userinfo')->where($where)->getField('uid');

		if(!$uid){
			redirect(U('Index/index'));
		}else {
			redirect(U('/'.$uid));
		}
	}
}

	
?>