<?php
namespace Doeradmin\Controller;
use Think\Controller;
	class ProductController extends BaseController{
		public function index(){
			$pid=$_GET['id'];//餐厅id
			$Product=M('Product');
			$Merchname=M('Merchants')->where("id=$pid")->getField('name');//找出店铺名
			$map['pid']=$pid;
			$map['status']=array('neq',-1);
			$count=$Product->where($map)->count();
			$p=getpage($count,15);//第二个参数为每页显示条数
			$data=$Product->where($map)->order('addtime desc')->limit($p->firstRow, $p->listRows)->select();
			$this->assign(merchname,$Merchname);
			$this->assign(merchid,$pid);
			$this->assign(rows,$data);
			$this->assign('page', $p->show()); // 赋值分页输出
			$this->display();
		}

		public function add(){
			$pid=$_GET['id'];
			$this->assign(merchid,$pid);//商家id
			$this->display();
		}

		//添加操作
		public function create(){
			$Product=M('Product');
		 	$data=I('post.');
		 	$pid=I('post.pid');
		 	$data['addtime']=time();
		 	//var_dump($data);
		 	$rs=$Product->create();
		 	if($rs=$Product->create()){
	        $rs=$Product->add($data);
	        	//$this->success('添加成功',U('Product/index'));
	        	 $this->redirect('Product/index',array('id' => $pid));
		 	}else{
		 		$this->error('添加失败');
		 	}

		}
		//发布操作
			public function enabled(){
				$id=$_GET['id'];
				$pid=D('Product')->GetPidByid($id);//通过id获取pid的方法在model层
				$status=1;
				$rs=D("Product")->UpdateStatusById($id,$status);
				if($rs){
					$this->redirect('Product/index',array('id' => $pid));
				}else{
					return show(0,'发布失败');
				}
			}

			//取消发布操作
			public function disabled(){
				$id=$_GET['id'];
				$pid=D('Product')->GetPidByid($id);
				$status=0;
				$rs=D("Product")->UpdateStatusById($id,$status);
				//$rs=$Banner->where("id=$id")->sava($data);
				if($rs){
					$this->redirect('Product/index',array('id' => $pid));
				}else{
					return show(0,'取消失败');
				}
			}
			//删除操作
			public function del(){
				$id=$_POST['id'];
				$status=$_POST['status'];
				$rs=D('Product')->UpdateStatusById($id,$status);
				if($rs){
					return show(1,'删除成功');
				}else{
					return show(0,'删除失败');
				}
			}

			//更改信息页面
			public function mod(){
				$Product=M('Product');
				$id=$_GET['id'];
			 	$data=$Product->where("id=$id")->find();
				$this->assign(data,$data);
				$this->display();
			}

			//更改操作修改操作
			 public function update(){
			 	$Product=M('Product');
			 	$data=I('post.');
			 	//$data['modtime']=time();
			 	$pid=I('post.pid');	
			 	$Product->create($data);
		        $count=$Product->save();
		        if($count!==false){
		            $this->redirect('Product/index',array('id' => $pid));
		        }else{
		            $this->error('更改信息失败','',300);
		        }
			 }


}
