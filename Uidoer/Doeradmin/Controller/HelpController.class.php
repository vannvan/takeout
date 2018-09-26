<?php
namespace Doeradmin\Controller;
use Think\Controller;
	class HelpController extends BaseController{
		public function index(){
			$Help=M('Help');
			$map['status']=array('neq',-1);
			$count=$Help->where($map)->count();
			$p=getpage($count,15);//第二个参数为每页显示条数
		 	$data = $Help->where($map)->limit($p->firstRow, $p->listRows)->order('addtime')->select();//查询二维数组，无限制,根据最近时间排序
	        $this->assign('rows',$data);//分配二维数组
	        $this->assign('page', $p->show()); // 赋值分页输出
			$this->display();
		}
		//添加页面
		public function add(){
			$this->display();
		}


		//添加操作
		public function create(){
			$Help=M('Help');
		 	$data=I('post.','',false);//不过滤编辑器的html标签
		 	//var_dump($data);
		 	$data['addtime']=time();
		 	$rs=$Help->create();
		 	if($rs=$Help->create()){
	        $rs=$Help->add($data);
	        	$this->success('添加成功',U('Help/index'));
		 	}else{
		 		$this->error('添加失败');
		 	}

		}

		//发布操作
			public function enabled(){
				$id=$_GET['id'];
				$status=1;
				$rs=D("Help")->UpdateStatusById($id,$status);
				if($rs){
					$this->redirect('Help/index');
				}else{
					return show(0,'发布失败');
				}
			}

			//取消发布操作
			public function disabled(){
				$id=$_GET['id'];
				//var_dump($id);
				$status=0;
				$rs=D("Help")->UpdateStatusById($id,$status);
				//$rs=$Banner->where("id=$id")->sava($data);
				if($rs){
					$this->redirect('Help/index');
				}else{
					return show(0,'取消失败');
				}
			}

			//删除操作
			public function del(){
				$id=$_POST['id'];
				$status=$_POST['status'];
				//var_dump($data['status']);
				$rs=D('Help')->UpdateStatusById($id,$status);
				if($rs){
					return show(1,'删除成功');
				}else{
					return show(0,'删除失败');
				}
			}


			//更改页面
			public function mod(){
				$Help=M('Help');
			 	$id=$_GET['id'];
			 	$data=$Help->where("id=$id")->find();
			 	$this->assign(data,$data);
			 	$this->display();
			}
			//更改操作修改操作
			 public function update(){
			 	$Help=M('Help');
			 	$data=I('post.','',false);//不过滤编辑器的html标签
			 	$Help->create($data);
		        $count=$Help->save();
		        //var_dump($count);
		        if($count!==false){
		            $this->redirect('Help/index');
		        }else{
		            $this->error('更改信息失败','',300);
		        }
			 }



}	