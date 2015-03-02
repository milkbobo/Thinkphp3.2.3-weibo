<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
		
	public function Index(){
		echo '这里是首页';
		p($_SESSION);
	}
}



?>