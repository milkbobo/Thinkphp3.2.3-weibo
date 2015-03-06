<?php
/*
 * 搜索控制器
 */
namespace Home\Controller;
class SearchController extends CommonController {
	/*
	 * 搜索找人
	 */
	public function sechUser(){
		$keyword = $this->_getKeyword();
		
		$this->keyword = $keyword;
		$this->display();
	}
	
	/*
	 * 返回搜索关键字
	 */
	private function _getKeyword(){
		return I('keyword') == '搜索微博、找人' ? Null : I('keyword');
	}
}

?>