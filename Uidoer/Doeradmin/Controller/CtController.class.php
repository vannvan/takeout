<?php
namespace Doeradmin\Controller;
use Think\Controller;
	class CtController extends BaseController{
		public function index(){
			$Restaurant=M('Restaurant');
			$map['status']=array('neq',-1);
			$data=$Restaurant->where($map)->order('addtime')->select();
			$this->assign(rows,$data);
			$this->display();
		}

		//添加餐厅操作
		public function create(){
			$Restaurant=M('Restaurant');
		 	$data=I('post.');
		 	$data['addtime']=time();
		 	//var_dump($data);
		 	$rs=$Restaurant->create();
		 	if($rs=$Restaurant->create()){
	        $rs=$Restaurant->add($data);
	        	$this->success('添加成功',U('Ct/index'));
		 	}else{
		 		$this->error('添加失败');
		 	}

		}


		//发布操作
			public function enabled(){
				$id=$_GET['id'];
				$status=1;
				$rs=D("Restaurant")->UpdateStatusById($id,$status);
				if($rs){
					$this->redirect('Ct/index');
				}else{
					return show(0,'发布失败');
				}
			}

			//取消发布操作
			public function disabled(){
				$id=$_GET['id'];
				//var_dump($id);
				$status=0;
				$rs=D("Restaurant")->UpdateStatusById($id,$status);
				//$rs=$Banner->where("id=$id")->sava($data);
				if($rs){
					$this->redirect('Ct/index');
				}else{
					return show(0,'取消失败');
				}
			}

			//删除操作
			public function del(){
				$id=$_POST['id'];
				$status=$_POST['status'];
				//var_dump($data['status']);
				$rs=D('Restaurant')->UpdateStatusById($id,$status);
				if($rs){
					return show(1,'删除成功');
				}else{
					return show(0,'删除失败');
				}
			}


			//更改页面
			public function mod(){
				$Restaurant=M('Restaurant');
			 	$id=$_GET['id'];
			 	$data=$Restaurant->where("id=$id")->find();
			 	$this->assign(data,$data);
			 	$this->display();
			}
			//更改操作修改操作
			 public function update(){
			 	$Restaurant=M('Restaurant');
			 	$data=I('post.');
			 	//var_dump($data);	
			 	$Restaurant->create($data);
		        $count=$Restaurant->save();
		        //var_dump($count);
		        if($count!==false){
		            $this->redirect('Ct/index');
		        }else{
		            $this->error('更改信息失败','',3);
		        }
			 }


}