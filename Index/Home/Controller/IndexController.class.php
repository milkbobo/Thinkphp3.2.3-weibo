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
		
		//统计数据总条数，用于分页
		$count  = $db->where($where)->count();// 查询满足要求的 总记录数  
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$limit=$Page->firstRow.','.$Page->listRows;
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录 %FIRST% %UP_PAGE% %NOW_PAGE% / %TOTAL_PAGE% %DOWN_PAGE% %END% ");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		
		//读取所有微博
		$result= $db->getAll($where,$limit);
		//p($result);
		$this->page= $Page->show();// 分页显示输出
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
		//p($_POST);
		//原微博ID
		$id = I('id','','intval');
		$tid= I('tid','','intval');
		$content=I('content');
		
		//提取插入数据
		$data=array(
			'content'=>$content,
			'isturn'=>$tid ? $tid : $id,
			'time'=>time(),
			'uid'=>session('uid'),
		);

		//插入数据至微博表
		$db = M('weibo');
		if($db->data($data)->add()){
			//原微博转发数+1
			$db->where(array('id'=>$id))->setInc('turn');
			
			//转发+1
			if($tid){
				$db->where(array('tid'=>$tid))->setInc('turn');
			}
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
	 *  评论
	 */
	
	public function comment(){
		if(!IS_POST)$this->error('页面不存在');
		//提取评论数据
		$data=array(
			'content'=>I('content'),
			'time'=>time(),
			'uid'=>session('uid'),
			'wid'=>I('wid','','intval'),
		);
		
		if (M('comment')->data($data)->add()){
		//读取评论用户信息
		$field=array('username','face50'=>'face','uid');
		$where=array('uid'=>$data['uid']);
		$user=M('userinfo')->where($where)->field($field)->find();
		
		//被评论微博的发布者用户名
		$uid=I('uid','','intval');
		$username = M('userinfo')->where(array('uid'=>$uid))->getField('username');
		
		$db = M('weibo');
		//评论数+1
		$db->where(array('id'=>$data['wid']))->setInc('comment');
		
		//评论同时转发时处理
		if ($_POST['isturn']){
			//读取转发微博ID与内容
			$field = array('id','content','isturn');
			$weibo = $db->field($field)->find($data['wid']);
			$content = $weibo['isturn'] ? $data['content'] . '// @'.$username.' : '.$weibo['content'] : $data['content'];
			
			//同时转发到微博的数据
			$cons = array(
				'content'=>$content,
				'isturn'=>$weibo['isturn'] ? $weibo['isturn'] : $data['wid'],
				'time'=>$data['time'],
				'uid'=>$data['uid'],
			
			);
			if ($db->data($cons)->add()){
				$db->where(array('id'=>$weibo['id']))->setInc('turn');
			}
			
			echo 1;
			exit();
		}
		
		//组合评论样式字符串返回
		$str= '';
		$str.= '<dl class="comment_content">';
		$str.='<dt><a href="'.U('/'.$data['uid']).'">';
		$str.='<img src="';
		$str.=__ROOT__;
		if ($user['face']){
			$str .='/Uploads/Face/'.$user['face'];
		}else {
			$str .='/Public/Images/noface.gif';
		}
		$str.='"alt="'.$user['username'].'" width="30" height="30"/>';
		$str.='</a></dt><dd>';
		$str.='<a href="'.$data['uid'].'" class="comment_name">';
		$str.=$user['username']." : ".replace_weibo($data['content']);
		$str.="&nbsp;&nbsp;(".time_format($data['time']).")";
		$str.='<div class="reply">';
		$str.='<a href="">回复</a>';
		$str.='</div></dd></dl>';
		echo $str;
		}else {
			echo 'false';
		}
		
	}
	
	/*
	 * 异步获取评论内容
	 */
	public function getComment(){
		if(!IS_AJAX)$this->error('页面不存在');
		$wid = I('wid','','intval');
		$where=array('wid'=>$wid);
		
		//数据的总条数
		$count  = M('comment')->where($where)->count();// 查询满足要求的 总记录数
		//数据可分的总页数
		$total = ceil($count / 10);//总页数
		$page= $_POST['page'] ? I('page','','intval') :1;//现在第几页，默认第一页。
		$limit = $page < 2 ? '0,10' : (10*($page - 1)).',10';
		
		$result = D('Comment')->where($where)->order('time DESC')->limit($limit)->select();
		if ($result){
			$str = '';
			foreach ($result as $v){
				$str.= '<dl class="comment_content">';
				$str.='<dt><a href="'.U('/'.$v['uid']).'">';
				$str.='<img src="';
				$str.=__ROOT__;
				if ($v['face']){
					$str .='/Uploads/Face/'.$v['face'];
				}else {
					$str .='/Public/Images/noface.gif';
				}
				$str.='"alt="'.$v['username'].'" width="30" height="30"/>';
				$str.='</a></dt><dd>';
				$str.='<a href="'.$v['uid'].'" class="comment_name">';
				$str.=$v['username']." : ".replace_weibo($v['content']);
				$str.="&nbsp;&nbsp;(".time_format($v['time']).")";
				$str.='<div class="reply">';
				$str.='<a href="">回复</a>';
				$str.='</div></dd></dl>';
				}
				
				if($total>1){
					$str .= '<dl class="comment-page">';
					
					switch($page){
						case $page > 1 && $page < $total : //不是第一页和尾页
						$str .='<dd page=" '.($page - 1).' " wid=" '.$wid.' ">上一页</dd>';
						$str .='<dd page=" '.($page + 1).' " wid=" '.$wid.' ">下一页</dd>';
						break;
						
						case $page < $total : //第一页
							$str .= '<dd page="'.($page+1).'" wid="'.$wid.'">下一页</dd>';
						break;
						
						case $page == $total : //最后一页
							$str .= '<dd page=" '.($page - 1).' " wid="'.$wid.'">上一页</dd>';
						break;
					}
					
					$str .='</dl>';
					
				}
				
				echo $str;
		}else {
			echo 'false';
		}
		
		
	}
	
	/*
	 * 退出登录处理
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