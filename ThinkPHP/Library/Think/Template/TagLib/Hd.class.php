<?php
namespace Think\Template\TagLib;
use Think\Template\TagLib;
class Hd extends TagLib {
	
	protected $tags = array(
		//'test' => array('attr' => 'id,name','close'=>0)//attr是标签里面的属性（可以理解为jq里面的attr），close是否闭合标签. <test id='1' name='houdunwang'/>
		'userinfo' => array('attr' => 'id','close'=>1),//默认闭合标签//闭合标签会替换闭合标签内的内容，发送到$content里面
		'maybe'=> array('attr' => 'uid','close'=>1),
	);
	
//   	public function _test($attr,$content){
//   		//$attr =$this->parseXmlAttr($attr);//TagLib标签属性分析 返回标签属性数组,
//   		$id = $attr['id'];
//   		$name = $attr['name'];
//   		$str = '';
//  		$str .='<?php echo '.$id.' ;?/>'; //去掉注释，不要问号后面的斜杠
//   		$str .='<?php echo "'.$name.'" ;?/>'; //因为name是字符串，所以要加多一个双引号
//   		return $str;
//   	}

	/*
	 * 读取用户信息标签
	 */
	public function _userinfo($attr,$content){
		$id=$attr['id'];//新版本thinkphp不用写$this->parseXmlAttr($attr)来解析
		$id=$attr['id'];
		$str.='<?php ';
		$str.='$where =array("uid"=>'.$id.');';
		$str.='$field = array("username","face80"=>"face","follow","fans","weibo","uid");';
		$str.='$userinfo = M("userinfo")->where($where)->field($field)->find();';
		$str.='extract($userinfo);';
		$str.='?>';
		$str.=$content;
		return $str;
	}
	
	public function _maybe($attr,$content){
		$uid=$attr['uid'];
		$str='';
		//如果太长，可以用php定界符
		$str.='<?php ';
		$str.='$uid='.$uid.';';
		$str.='$db = M("follow");';
		$str.='$where =array("fans"=>$uid);';
		$str.='$follow = $db->where($where)->field("follow")->select();';
		$str.='foreach($follow as $k=>$v) :';
		$str.='$follow[$k]=$v["follow"];';
		$str.='endforeach;';//必须用PHP替代语法
		//echo implode(',',$follow);
		$str.='$sql="SELECT `uid`,`username`,`face50` AS `face`,COUNT(f.`follow`) AS `count` FROM `hd_follow` f LEFT JOIN `hd_userinfo` u ON f.`follow` = u.`uid` WHERE f.`fans` IN(".implode(\',\',$follow).") AND f.`follow` NOT IN(".implode(\',\',$follow).") AND f.`follow` <>".$uid." GROUP BY f.`follow` ORDER BY `count` DESC LIMIT 4";';
		// 转义符号\ 例如： \'
		$str.='$friend =$db->query($sql);';
		//$str.='p2($friend);';
		$str.='foreach($friend as $k=>$v){extract($v);}';
		$str.='?>';
		
		return $str.$content;
	}
}


?>