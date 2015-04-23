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
	$verify = new \Think\Verify();
	return $verify->check($code, $id);
}

?>