<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
	
	public function _initialize(){
		
		//处理自动登陆
		if(isset($_COOKIE['auto']) && !isset($_COOKIE['uid'])){
			$value = explode('|',encryption($_COOKIE['auto'],1));
			$ip=get_client_ip();
			//本次登陆IP与上一次登陆IP一致时
			if($ip==$value[1]){
				$account=$value[0];
				$where=array('account'=>$account);
				$user=M('user')->where($where)->field(array('id','lock'))->find();
				
			}
			//检索出用户信息并且该用户没有被锁定时候，保存登陆状态
 			if($user && !$user['lock']){
 				session('uid',$user['id']);
 			}
			
		}
		
		if(!isset($_SESSION['uid'])){
			redirect(U('Login/index'));
		}
	}
	
	/*
	 * 头像上传
	 */
	public function uploadFace(){
		 if(!IS_POST)$this->error('页面不存在');
		 $upload =$this->_upload('Face','180,80,50','180,80,50');
		 echo json_encode($upload);
	}
	
	/*
	 * 微博图片上传
	 */
	public function uploadPic(){
		if(!IS_POST)$this->error('页面不存在');
		$upload =$this->_upload('Pic','800,300,120','800,300,120');
		echo json_encode($upload);
	}
	
	/*
	 * 异步创建分组
	 */
	public function addGroup(){
		if(!IS_POST)$this->error('页面不存在');
		 $data=array(
		 	'name'=>I('name'),
		 	'uid'=>session('uid'),
		 );
		 if(M('group')->data($data)->add()){
		 	echo json_encode(array('status'=>1,'msg'=>'插入成功'));
		 }else {
		 	echo json_encode(array('status'=>0,'msg'=>'插入失败，请重试...'));
		 }
	}
	
	/*
	 * 异步添加关注
	 */
	public function addFollow(){
		if(!IS_POST)$this->error('页面不存在');
		$data=array(
			'follow'=>I('follow','','intval'),
			'fans'=>session('uid'),
			'gid'=>I('gid','','intval'),
		);
		if (M('follow')->data($data)->add()){
			$db =M('userinfo');
			$db->where(array('uid' => $data['follow']))->setInc('fans');
			$db->where(array('uid' => session('uid')))->setInc('follow');
			echo json_encode(array('status'=>1,'msg'=>'关注成功'));
		}else {
			echo json_encode(array('status'=>0,'msg'=>'关注失败，请重试...'));
		}
	}
	
	/*
	 * 处理图片上传
	 * @param [String] $path [保存文件夹名称]
	 * @param [String] $width [缩略图宽度,多个用逗号隔开]
	 * @param [String] $height [缩略图宽度,多个用逗号隔开]
	 * @return [Array] $path [图片上传信息]
	 */
	private function _upload($path,$width,$height){
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     C('UPLOAD_MAX_SIZE') ;				// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     C('UPLOAD_PATH'). $path . '/'; 	// 设置附件上传根目录
		$upload->saveName  =	array('uniqid','');					//上传文件的保存名称
		$upload->replace   =	true;								//覆盖同名文件
		$upload->exts      =	C('UPLOAD_EXTS');					// 允许上传类型
		$upload->subName   =	array('date','Y_m');				//使用日期为子目录名称
		// 上传文件
		$info   =   $upload->upload();
		if(!$info) {// 上传错误提示错误信息
			//p($upload->getError());
			return array('status'=>0,'msg'=>$upload->getError());
		}else{// 上传成功
 			$width=explode(',', $width);
 			$height=explode(',', $height);
 			$size=array(
 					'max',
 					'medium',
 					'mini'
 			);
 			$image = new \Think\Image();// 实例图片处理
 			$facepath=C('UPLOAD_PATH'). $path . '/'.$info['Filedata']['savepath'];
 			$open=$facepath.$info['Filedata']['savename'];
 			$image->open($open);
 			$sl=0;
 			$image_date=array();
 			while ($sl<count($width)){
 				$image->thumb($width[$sl], $height[$sl])->save($open.'_'.$width[$sl].'_'.$height[$sl].'.'.$info['Filedata']['ext']);
 				$image_date[$size[$sl]]=$info['Filedata']['savepath'].$info['Filedata']['savename'].'_'.$width[$sl].'_'.$height[$sl].'.'.$info['Filedata']['ext'];
 				$sl++;
 			}
 			//生成缩略图后，删除源文件
 			@unlink($open);
 			return array('status'=>1,'path'=>$image_date);
			//p($image_date);
			//echo count($width);
		
		}
	}
	
	
	
	
	
	
	
	
	
	
}


?>