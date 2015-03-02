<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
	
	public function _initialize(){
		if(!isset($_SESSION['uid'])){
			redirect(U('Login/index'));
		}
	}
	
	
	
	
}


?>