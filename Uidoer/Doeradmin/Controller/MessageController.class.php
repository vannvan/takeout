<?php
namespace Doeradmin\Controller;
use Think\Controller;
	class MessageController extends BaseController{
		public function index(){
			$Message=M('Message');
			$map['status']=array('neq',-2);//用户删除为-1，系统删除为-2
			$count=$Message->where($map)->count();
			$p=getpage($count,15);//第二个参数为每页显示条数
		 	$data = $Message->where($map)->limit($p->firstRow, $p->listRows)->order('addtime desc')->select();//查询二维数组，无限制,根据最近时间排序
	        $this->assign('rows',$data);//分配二维数组
	        $this->assign('page', $p->show()); // 赋值分页输出
			$this->display();
		}
}