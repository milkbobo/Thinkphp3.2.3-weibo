<?php
/*
 * 格式化打印数据
 */
function p ($arr){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
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

?>