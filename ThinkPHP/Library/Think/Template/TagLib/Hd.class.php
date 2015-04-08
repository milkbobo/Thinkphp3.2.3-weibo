<?php
namespace Think\Template\TagLib;
use Think\Template\TagLib;
class Hd extends TagLib {
	
	protected $tags = array(
		'test' => array('attr' => 'id,name','close'=>0)//attr是标签里面的属性（可以理解为jq里面的attr），close是否闭合标签. <test id='1' name='houdunwang'/>
	);
	
	public function _test($attr,$content){
		//$attr =$this->parseXmlAttr($attr);//TagLib标签属性分析 返回标签属性数组,
		$id = $attr['id'];
		$name = $attr['name'];
		$str = '';
		$str .='<?php echo '.$id.' ;?>';
		$str .='<?php echo "'.$name.'" ;?>';
		return $str;
	}
}


?>