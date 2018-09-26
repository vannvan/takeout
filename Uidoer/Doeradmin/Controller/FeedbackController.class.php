<?php
namespace Doeradmin\Controller;
use Think\Controller;
	class FeedbackController extends BaseController{
		public function index(){
			$Feedback=M('Feedback');
			$map['status']=array('neq',-1);
			$count=$Feedback->where($map)->count();
			$p=getpage($count,15);//第二个参数为每页显示条数
			$data=$Feedback->where($map)->order('addtime desc')->limit($p->firstRow, $p->listRows)->select();
			$this->assign('page', $p->show()); // 赋值分页输出
			$this->assign(rows,$data);
			$this->display();
		}

		//查看反馈信息
		public function view(){
			$id=$_GET['id'];
			$status=1;//将查看状态改为1
			$rs=D("Feedback")->UpdateStatusById($id,$status);
			$Feedback=M('Feedback');
			$data=$Feedback->where("id=$id")->find();//反馈信息数据
			$datamesage=M('Message')->where("id=$id")->find();			
			$this->assign(data,$data);
			$this->assign(data2,$datamesage);
			$this->display();
		}

		//回复反馈页面
		public function reply(){
			$id=$_GET['id'];
			$data=M('Feedback')->where("id=$id")->find();
			$this->assign(data,$data);
			$this->display();
		}
		//回复操作
		public function replycreate(){
			$Message=M('Message');
			$data=I('post.');
			$feedid=$_POST['id'];//反馈信息的id
			$restatus['restatus']=1;
			$data['addtime']=time();
			$rs=$Message->create();
		 	if($rs=$Message->create()){
		        $rs=$Message->add($data);
				$rst=M("Feedback")->where("id=$feedid")->save($restatus);
				$this->redirect('Feedback/view',array('id' => $feedid));
		 	}else{
		 		$this->error('添加失败');
		 	}
		}

		//删除操作
			public function del(){
				$id=$_POST['id'];
				$status=$_POST['status'];
				$rs=D('Feedback')->UpdateStatusById($id,$status);
				if($rs){
					return show(1,'删除成功');
				}else{
					return show(0,'删除失败');
				}
			}


}