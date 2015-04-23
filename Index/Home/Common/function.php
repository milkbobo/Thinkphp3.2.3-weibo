<?php
/*
 * 格式化打印数据
 */
function p ($arr){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
	die();
}

function p2 ($arr){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';

}

function check_verify($code, $id = ''){
	$config = array(
			'reset' => false // 验证成功后是否重置，—————这里才是有效的。
	);
	$verify = new \Think\Verify($config);
	return $verify->check($code, $id);
}

/*异位或加密字符串
 * @param [String]	$value	[需要加密的字符串
 * @param [integer]	$type	[加密解密(0:加密，1：解密)]
 * @return[String]			[加密或解密后的字符串]
 */
function encryption($value,$type=0){
	$key = md5(C('ENCTYPTION_KEY'));
	if(!$type){
		return  str_replace('=','',base64_encode($value ^ $key));
		
	}
	$value = base64_decode($value);
	return $value ^ $key;
}

/*
 * 格式化时间戳
 */

function time_format($time){
	//当前时间
	$now = time();
	//今天时间零时零分
	$todoy = strtotime(date('y-m-d',$now));
	//传递时间与当前时秒相差的描述
	$diff= $now - $time;

	$str='';
//	switch ($time){
//		case $diff < 60;
//			$str= $diff.'秒前';
//			break;
//		case $diff < 3600;
//			$str= floor($diff / 60).'分钟前';
//			break;
//		case $diff < (3600*8);
//			$str= floor($diff / 3600).'小时前';
//			break;
//
//		case $time > $todoy;
//			$str= '今天  '.date('H:i',$time);
//			break;
//		default:
//			$str = date('Y-m-d H:i:s',$time);
//	}
    if($time > $todoy+(3600*24)){
         $str = date('Y-m-d H:i:s',$time);//未来或者出错时间
    }elseif($diff < 60){
        $str= $diff.'秒前'; 
    }elseif
        ($diff < 3600){
        $str= floor($diff / 60).'分钟前';
    }elseif
        ($diff < (3600*8)){
        $str= floor($diff / 3600).'小时前';
    }elseif
        ($time > $todoy){
        $str= '今天  '.date('H:i',$time);
    }else{
        $str = date('Y-m-d H:i:s',$time);
    }
    
	return $str;
}

/*
 * 替换微博内容的URL地址、@用户与表情
 */
function replace_weibo ($content){
	if(empty($content))return ;
	
	//$content= '后盾网： http://www.tongyingyang.com/dfas/sdf?p=2 @后盾视频 地方啊 @阿顿发送到 [嘻嘻] [睡觉]';
	
	//给URL地址加上<a>链接
	$preg = '/(?:http:\/\/)?([\w.]+[\w\/]*\.[\w.]+[\w\/]*\??[\w=\&\+\%]*)/is';// ? 0个或1个    // [\w.]是两个元字符 
	$content = preg_replace($preg, '<a href="http://\\1" target="black">\\1</a>', $content);
	
	//给@用户加<a>链接
	$preg = '/@(\S+)/is';
	$content = preg_replace($preg, '<a href="'.__MODULE__.'/User/\\1">@\\1</a>', $content);//preg_replace是直接搜索出来替换
	

	//提取微博内容中所有表情文件
	$preg='/\[(\S+?)\]/is';//问号，停止贪婪
	preg_match_all($preg,$content,$arr);//正则匹配出来，并且包含与整个模式匹配的文本。
	//载入表情包数组文件
	//$phiz = F('phiz','','./Public/Data/');
	$phiz = include './Public/Data/phiz.php';
	
	
	if (!empty($arr[1])){ //$arr不为空的时候
		foreach ($arr[1] as $k => $v){
			$name = array_search($v,$phiz);//array_search在数组中查找一个键值。如果找到了该值,匹配元素的键名并会被返回。
			if($name){
				$content = str_replace($arr[0][$k],'<img src="'.__ROOT__.'/Public/Images/phiz/'.$name.'.gif" title="'.$v.'"/>',$content);	
			}
			
		}
	}
	return $content;
}

/*
 * 往内存写入推送消息
 * @param [int] $uid [用户ID号]
 * @param [int] $type[1:评论；2：私信；3：@用户]
 * @param [boolean] $flush[是否清零]
 */
function set_msg($uid,$type,$flush=false){
		$name = '';
		switch($type){
			case 1:
				$name ='comment';
				break;
			
			case 2:
				$name ='letter';
				break;
			
			case 3:
				$name ='atme';
				break;
		}
		
		if($flush){
			$data=S('usermsg'.$uid);
			$data[$name]['total']=0;
			$data[$name]['status'] = 0;
			S('usermsg'.$uid,$data,0);
			return;
		}
		
// 		$msg2 = array(
// 			'comment'=>array('total'=>0,'status'=>0),
// 			'letter'=>array('total'=>0,'status'=>0),
// 			'atme'=>array('total'=>0,'status'=>0),
// 		);
// 		$msg2[$name]['total']++;

		//内存数据已存在时让相应数据+1
		if(S('usermsg'.$uid)){
			$data =S('usermsg'.$uid);
			$data[$name]['total']++;
			$data[$name]['status'] = 1;
			S('usermsg'.$uid,$data,0);
		//内存数据不存在时，初始化用户数据并写入到内存
		}else {
			$data = array(
				'comment'=>array('total'=>0,'status'=>0),
				'letter'=>array('total'=>0,'status'=>0),
				'atme'=>array('total'=>0,'status'=>0),
			);
			$data[$name]['total']++;
			$data[$name]['status'] = 1;
			S('usermsg'.$uid,$data,0);
		}
	}



?>










