<?php
/*
 * 系统设置控制器
 */
namespace Home\Controller;
class SystemController extends CommonController {
	
	/*
	 * 网站设置
	 */
	public function index(){
		$this->config2 = include './Index/Home/Conf/system.php';
		$this->display();
	}
	
	/*
	 * 修改网站设置
	 */
	public function runEdit(){
		$path='./Index/Home/Conf/system.php';
		$config = include $path;
		$config['WEBNAME']=I('webname');
		$config['COPY']=I('copy');
		$config['REGIS_ON']=I('regis_on');
		
		$data="<?php \r \n return ".var_export($config,ture)."; \r \n?>";
		
		if(file_put_contents($path, $data)){
			$this->success('修改成功',U('index'));
		}else {
			$this->error('修改失败，请修改'.$path.'的写入权限');
		}
	}
	
	
	/*
	 * 关键字设置视图
	 */
	public function filter(){
		$config=include './Index/Home/Conf/system.php';
		$this->filter = implode('|', $config['FILTER']);
		$this->display();
	}
	
	/*
	 * 执行修改关键词
	 */
	public function runEditFilter(){
		$path = './Index/Home/Conf/system.php';
		$config = include $path;
		$config['FILTER']=explode('|',I('filter'));
		//p($config);
		
		$data="<?php \r \n return ".var_export($config,ture)."; \r \n?>";
		
		if(file_put_contents($path, $data)){
			$this->success('修改成功',U('filter'));
		}else {
			$this->error('修改失败，请修改'.$path.'的写入权限');
		}
	}
}