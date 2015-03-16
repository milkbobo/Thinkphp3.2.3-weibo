<?php
namespace Home\Controller;
class IndexController extends CommonController {
		
	/*
	 * 首页视图
	 */
	public function Index(){
		
		//replace_weibo('adsf');
		
		$db=D('Weibo');
		//取得当前用户的ID与当前用户 所有关注好友的ID
		$uid = array(session('uid'));
		$where=array('fans'=>session('uid'));
		$result =M('follow')->where($where)->field('follow')->select();
		if($result){
			foreach ($result as $v){
				$uid[] = $v['follow'];
			}
		}
		
		//组合WHERE条件,条件为当前用户自身的ID与当前用户所关注好友的ID
		$where = array('uid'=>array('IN',$uid));
		
		//读取所有微博
		$result= $db->getAll($where);
		p($result);
		$this -> weibo = $result;
		$this->display();
		
	}
	
	/*
	 * 微博发布处理 
	 */
	public function sendWeibo(){
		if(!IS_POST)$this->error('页面不存在');
		$data=array(
			'content'=>I('content'),
			'time'=> time() ,
			'uid'=>session('uid')
		);
		$wid = M('weibo')->data($data)->add();
		if($wid){
			if(!empty($_POST['max'])){
				$img=array(
					'max'=>I('max'),
					'medium'=>I('medium'),
					'mini'=>I('mini'),
					'wid'=>$wid,	
				);
				M('picture')->data($img)->add();
			}
			$this->success('发布成功',U('index'));
		}else {
			$this->error('发布失败，请重试...');
		}
	}
	
	/*
	 * 转发微博
	 */
	
	Public function turn(){
		if(!IS_POST)$this->error('页面不存在');
		
		//原微博ID
		$id = I('id','','intval');
		$content=I('content');
		
		//提取插入数据
		$data=array(
			'content'=>$content,
			'isturn'=>$id,
			'time'=>time(),
			'uid'=>session('uid'),
		);

		//插入数据至微博表
		$db = M('weibo');
		if($db->data($data)->add()){
			//原微博转发数+1
			$db->where(array('id'=>$id))->setInc('turn');
			//用户发布微博数+1
			M('userinfo')->where(array('uid'=>session('uid')))->setInc('weibo');
			
			//如果点击了同时评论插入内容到评论表
			if(isset($_POST['becomment'])){
				$data=array(
					'content'=>$content,
					'time'=>time(),
					'uid'=>session('uid'),
					'wid'=>$id,
				);
			if(M('comment')->data($data)->add()){
				$db->where(array('id'=>$id))->setInc('comment');
			}
			}
			
			$this->success('转发成功...','index');
		}else {
			$this->error('转发失败，请重试！');
		}
	}
	
	/*
	 * 退出登录
	 */
	
	public function loginOut(){
		//卸载SESSION
		session_unset();
		session_destroy();
		
		//删除用于自动登陆的cookie
		@setcookie('auto','',time()-3600,'/');
		
		//跳转到等登陆页
		redirect(U('Login/index'));
	}
}



?>