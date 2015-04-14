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
		
		//我的关注
		if(S('follow_'.$id)){
			//缓存已存在并且缓存未过期
			$follow=S('follow_'.$id);
		}else {
			$where = array('fans'=>$id);
			$follow=M('follow')->where($where)->field('follow')->select();
			foreach($follow as $k=>$v){//二维数组变成一位数组
				$follow[$k]=$v['follow'];
			}
			$where=array('uid'=>array('IN',$follow));
			$field=array('username','face50'=>'face','uid');
			
			if(!empty($follow)){
				$follow=M('userinfo')->field($field)->where($where)->limit(8)->select();
			}
			S('follow_'.$id,$follow,3600);
		}
		
		//我的粉丝
		if(S('fans_'.$id)){
			//缓存已存在并且缓存未过期
			$follow=S('fans_'.$id);
		}else {
			$where = array('follow'=>$id);
			$fans=M('follow')->where($where)->field('fans')->select();
			foreach($fans as $k=>$v){//二维数组变成一位数组
				$fans[$k]=$v['fans'];
			}
			$where=array('uid'=>array('IN',$fans));
			$field=array('username','face50'=>'face','uid');
				
			if(!empty($follow)){
				$fans=M('userinfo')->field($field)->where($where)->limit(8)->select();
			}
			S('fans_'.$id,$fans,3600);
		}
		$this->follow=$follow;
		$this->fans=$fans;
		$this->display();
	}
	
	/*
	 * 用户关注与粉丝列表
	 */
	public function followList(){
// 		p($_GET);

 		$uid = I('uid','','intval');
 		
 		//区分关注 与 粉丝（1：关注，0：粉丝）
 		$type = I('type','','intval');
 		$db = M('follow');
 		
 		//根据type参数不同，读取用户关注与粉丝ID
 		$where = $type ? array('fans'=>$uid) : array('follow' => $uid);
 		$field = $type ? 'follow' : 'fans';
 		$count = $db->where($where)->count();
 		$Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
 		$limit=$Page->firstRow.','.$Page->listRows;
 		
 		$uids = $db->field($field)->where($where)->limit($limit)->select();
 		
		if ($uids){
			//把用户关注或者粉丝ID重组为一维数组
			foreach ($uids as $k => $v){
				$uids[$k]= $type ? $v['follow'] : $v['fans'];
			}
			
			//提取用户个人信息
			$where = array('uid' => array('IN',$uids));
			$field = array('face50'=>'face','username','location','follow','fans','weibo','uid');
			$users = M('userinfo')->where($where)->field($field)->select();
			
			//分配用户信息到视图
			$this->users=$users;
		}
		
		$where= array('fans'=>session('uid'));
		$follow=$db->field('follow')->where($where)->select();
		if($follow){
			foreach ($follow as $k=>$v){
				$follow[$k] = $v['follow'];
			}
		}
		
		$where=array('follow'=>session('uid'));
		$fans = $db->field('fans')->where($where)->select();
		
		if($fans){
			foreach ($follow as $k=>$v){
				$fans[$k] = $v['fans'];
			}
		}
		
		$this->type =$type;
		$this->count =$count;
		$this->follow=$follow;
		$this->fans=$fans;
		$this->display();
 		
	}
	
	/*
	 * 收藏列表
	 */
	public function keep(){
		$uid=session('uid');
		
		$count = M('keep')->where(array('uid'=>$uid))->count();
		$Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(10)
		$limit=$Page->firstRow.','.$Page->listRows;
		
		$where = array('keep.uid'=>$uid);
		$weibo=D('Keep')->getAll($where,$limit);
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录 %FIRST% %UP_PAGE% %NOW_PAGE% / %TOTAL_PAGE% %DOWN_PAGE% %END% ");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		
		$this->weibo=$weibo;
		$this->page2= $Page->show();
		$this->display('weiboList');
	}
	
	/*
	 * 异步取消收藏
	*/
	public function cancelKeep(){
		if(!IS_AJAX)$this->error('页面不存在');
		$kid =I('kid','','intval');
		$wid=I('wid','','intval');
		
		if (M('keep')->delete($kid)){
			M('weibo')->where(array('id'=>$wid))->setDec('keep');
			echo 1;
		}else {
			echo 0;
		}
	}
	
	/*
	 * 私信列表
	*/
	public function letter(){
		$uid=session('uid');
		
		$count=M('letter')->where($uid)->count();
		$Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(10)
		$limit=$Page->firstRow.','.$Page->listRows;
		$where = array('letter.uid'=>$uid);
		$letter =D('Letter')->where($where)->limit($limit)->order('time DESC')->select();
		
		$this->letter=$letter;
		$this->count=$count;
		$this->page= $Page->show();
		$this->display();
	}
	
	/*
	 * 异步删除私信
	*/
	public function delLetter(){
		if(!IS_AJAX)$this->error('页面不存在');
		$lid=I('lid','','intval');
		if(M('letter')->delete($lid)){
			echo 1;
		}else {
			echo 0;
		}
	}
	
	/*
	 * 私信发送表单处理
	*/
	public function letterSend(){
		if(!IS_POST)$this->error('页面不存在');
		$name=I('name');
		$where=array('username'=>$name);
		$uid=M('userinfo')->where($where)->getField('uid');
		
		if(!$uid){
			$this->error('用户不存在');
		}
		
		$data=array(
			'from'=>session('uid'),
			'content'=>I('content'),
			'time'=>time(),
			'uid'=>$uid,
		);
		
		if(M('letter')->data($data)->add()){
			$this->success('私信已发送',U('letter'));
		}
	}
	
	/*
	 * 评论列表
	 */
	
	public function comment(){
		$where=array('uid'=>session('uid'));
		$count =M('comment')->where($where)->count();
		$Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(10)
		$limit=$Page->firstRow.','.$Page->listRows;
		$comment =D('Comment')->where($where)->limit($limit)->order('time DESC')->select();
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录 %FIRST% %UP_PAGE% %NOW_PAGE% / %TOTAL_PAGE% %DOWN_PAGE% %END% ");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		
		$this->count=$count;
		$this->page= $Page->show();
		$this->comment=$comment;
		$this->display();
	}
	
	/*
	 * 评论回复
	*/
	public function reply(){
		if(!IS_AJAX)$this->error('页面不存在');

		$data=array(
			'content'=>I('content'),
			'time'=>time(),
			'uid'=>session('uid'),
			'wid'=>I('wid','','intval'),
		);
		if (M('comment')->data($data)->add()){
			M('weibo')->where(array('id'=>I('wid','','intval')))->setInc('comment');
			echo 1;
		}else {
			echo 0;
		}
	}
	
	/*
	 * 删除评论
	 */
	public function delComment(){
		if(!IS_AJAX)$this->error('页面不存在');
		$cid=I('cid','','intval');
		$wid=I('wid','','intval');
		
		if(M('comment')->delete($cid)){
			M('weibo')->where(array('id'=>$wid))->setDec('comment');
			echo 1;
		}else{
			echo 0;
		}
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