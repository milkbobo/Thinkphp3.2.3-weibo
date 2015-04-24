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
    	$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录 %FIRST% %UP_PAGE% %NOW_PAGE% / %TOTAL_PAGE% 页 %DOWN_PAGE% %END% ");
    	$Page->setConfig('prev','上一页');
    	$Page->setConfig('next','下一页');
    	
    	$this->users=D('UserView')->limit($limit)->select();
    	$this->page = $Page->show();
    	
    	$this->display();
    }
    
    /*
     * 锁定用户
     */
    public function lockUser(){
    	$data = array(
    			'id'=>I('id','','intval'),
    			'lock'=>I('lock','','intval')
    			);
    	
    	$msg = $data['lock'] ? '锁定' : '解锁';
    	if(M('user')->save($data)){
    		$this->success($msg.'成功',$_SERVER['HTTP_REFERE']);//$_SERVER['HTTP_REFERE'] 提交时候的页面，连接的来源地址
    	}else {
    		$this->error($msg.'失败，请重试');
    	}
    }
    
    /*
     * 微博用户检索
     */
    
    public function sechUser(){
    	if(isset($_GET['sech']) && isset($_GET['type'])){
    		$where = array($where=$_GET['type'] ? array('user.id'=>I('sech','','intval')) : array('username'=>array('LIKE','%'.I('sech').'%')));
    		$user =D('UserView')->where($where)->select();
    		$this->user=$user ? $user : false;
    	}
    	$this->display();
    }
    
    /*
     * 后台管理员列表
     */
    public function admin(){
    	$this->admin=M('admin')->select();
    	$this->display();
    }
    
    /*
     * 添加后台管理员
     */
    public function addAdmin(){
    	$this->display();
    }
    
    /*
     * 锁定后天管理员
    */
    public function lockAdmin(){
		$data=array(
			'id'=>I('id','intval'),
			'lock'=>I('lock','intval'),
		);
		
		$msg = $data['lock'] ? '锁定' : '解锁';
		if(M('admin')->save($data)){
			$this->success($msg.'成功',U('admin'));//$_SERVER['HTTP_REFERE'] 提交时候的页面，连接的来源地址
		}else {
			$this->error($msg.'失败，请重试');
		}
		
    }
    
    /*
     * 删除后台管理员
     */
    public function delAdmin(){
    	$id = I('id','','intval');
    	
    	if(M('admin')->delete($id)){
    		$this->success('删除成功',$_SERVER['HTTP_REFERE']);
    	}else {
    		$this->error('删除失败,请重试。。。');
    	}
    }
    
    /*
     * 执行添加管理员炒作
     */
    public function runAddAdmin(){
    	if($_POST['pwd'] != $_POST['pwded']){
    		$this->error('两次密码不正确');
    	}
    	
    	$data = array(
    		'username'=>I('username'),
    		'password'=>I('pwd','','md5'),
    		'logintime'=>time(),
    		'loginip'=>get_client_ip(),
    		'admin'=>I('admin','','intval'),
    	);
    	
    	if(M('admin')->data($data)->add()){
    		$this->success('添加成功');
    	}else {
    		$this->error('添加失败，请重试');
    	}
    	
    }
    
    /*
     * 修改密码视图
     */
    public function editPwd(){
    	$this->display();
    }
    
    
    /*
     * 修改密码操作
     */
    public function runEditPwd(){
    	$db = M('admin');
    	$old = $db->where(array('id'=>session('uid')))->getField('password');
    	
    	if($old != md5(I('old')))$this->error('旧密码错误');
    	if(I('pwd') != I('pwded'))$this->error('两次密码不一致');
    	if($old == I('pwd','','md5'))$this->error('旧密码和新密码一样，请重试');
    	
    	$data = array(
    		'id'=>session('uid'),
    		'password'=>I('pwd','','md5')
    	);
    	
    	if($db->save($data)){
    		$this->success('修改成功',U('Index/copy'));
    	}else {
    		$this->error('修改失败，请重试...');
    	}
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}