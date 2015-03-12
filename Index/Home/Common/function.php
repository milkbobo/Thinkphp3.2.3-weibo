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

function check_verify($code, $id = ''){
	$verify = new \Think\Verify();
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
?>









