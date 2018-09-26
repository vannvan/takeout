<?php
namespace Doeradmin\Controller;
use Think\Controller;
class PublicController extends BaseController{
	//普通用户基本信息展示页面
	public function sendmessage(){
		$userid=$_GET['id'];
		$this->assign(userid,$userid);
		$this->display();
	}
	//回复操作
		public function replycreate(){
			$Message=M('Message');
			$data=I('post.');
			$feedid=$_POST['sendid'];//用户的id
			$data['addtime']=time();
			$data['cate']=2;
			$rs=$Message->create();
		 	if($rs=$Message->create()){
		        $rs=$Message->add($data);
		        $this->success('发送成功', 'javascript:history.back(-1);');
		 	}else{
		 		$this->error('发送失败');
		 	}
		}
}