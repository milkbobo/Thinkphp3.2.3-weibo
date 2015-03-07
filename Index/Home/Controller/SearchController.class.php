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
		 
		if ($keyword){
		//检索出除自己外昵称含有关键字的用户
		$where = array(
			'username'=>array('LIKE','%'.$keyword.'%'), //$map['字段2']  = array('表达式','查询条件');
			'uid' => array('NEQ',session('uid')),
		);
		$field= array('username','sex','location','intro','face80','follow','fans','weibo','uid');
		$db = M('userinfo');
		
		//分页
		$count      = $db->where($where)->count('id');// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录 %FIRST% %UP_PAGE% %NOW_PAGE% / %TOTAL_ROW% %DOWN_PAGE% %END% ");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$result=$db->where($where)->field($field)->limit($Page->firstRow.','.$Page->listRows)->select();
		
		//重新组合结果集，得到是否已经与是否互相关注
		$result = $this->_getMutual($result);
		
		//分配搜索结果到视图
		$this->result = $result ? $result : false;
		
		//页码
		$this->count=$count;
		$this->page= $Page->show();// 分页显示输出
		}
		
		$this->keyword = $keyword;
	//	p($result);die;
		$this->display();
	}
	
	/*
	 * 返回搜索关键字
	 */
	private function _getKeyword(){
		return I('keyword') == '搜索微博、找人' ? Null : I('keyword');
	}
	/*
	 * 重新组合结果集，得到是否已经与是否互相关注
	 * @param [Array] $result [需要处理的结果集]
	 * $return [Array]		[处理完成后的结果集】
	 */
	Private function _getMutual($result){
		if(!$result) return false;//没有结果集，就返回 false;
		$db = M('follow');
		foreach ($result as $k => $v){
			//是否互相关注
			$sql = '(SELECT `follow` FROM `hd_follow` WHERE `follow` = '.$v['uid'].' 
					AND `fans` = '.session('uid').') UNION (SELECT `follow` FROM `hd_follow` WHERE 
					`follow` = '.session('uid').' AND `fans` ='.$v['uid'].')';
			$mutual = $db->query($sql);
			
			if(count($mutual) == 2){
				$result[$k]['mutual'] = 1;
				$result[$k]['followed'] = 1;
			}else {
				$result[$k]['mutual'] = 0;
				//未互相关注是检索是否已关注（有没有关注我）
				$where = array(
						'follow'=>$v['uid'],
						'fans'=>session('uid')//我（粉丝）关注了他
				);
				$result[$k]['followed'] = $db->where($where)->count();
			}
		}
		return $result;
	}
}

?>