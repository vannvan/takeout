<?php
namespace Doeradmin\Controller;
use Think\Controller;
	class AboutController extends BaseController{
		public function index(){
			$About=M('About');
			$map['status']=array('neq',-1);
			$count=$About->where($map)->count();
			$p=getpage($count,10);//第二个参数为每页显示条数
		 	$data = $About->where($map)->limit($p->firstRow, $p->listRows)->order('addtime')->select();//查询二维数组，无限制,根据最近时间排序
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
			$About=M('About');
		 	$data=I('post.','',false);//不过滤编辑器的html标签
		 	//var_dump($data);
		 	$data['addtime']=time();
		 	$rs=$About->create();
		 	if($rs=$About->create()){
	        $rs=$About->add($data);
	        	$this->success('添加成功',U('About/index'));
		 	}else{
		 		$this->error('添加失败');
		 	}

		}

		//发布操作
			public function enabled(){
				$id=$_GET['id'];
				$status=1;
				$rs=D("About")->UpdateStatusById($id,$status);
				if($rs){
					$this->redirect('About/index');
				}else{
					return show(0,'发布失败');
				}
			}

			//取消发布操作
			public function disabled(){
				$id=$_GET['id'];
				//var_dump($id);
				$status=0;
				$rs=D("About")->UpdateStatusById($id,$status);
				//$rs=$Banner->where("id=$id")->sava($data);
				if($rs){
					$this->redirect('About/index');
				}else{
					return show(0,'取消失败');
				}
			}

			//删除操作
			public function del(){
				$id=$_POST['id'];
				$status=$_POST['status'];
				//var_dump($data['status']);
				$rs=D('About')->UpdateStatusById($id,$status);
				if($rs){
					return show(1,'删除成功');
				}else{
					return show(0,'删除失败');
				}
			}


			//更改页面
			public function mod(){
				$About=M('About');
			 	$id=$_GET['id'];
			 	$data=$About->where("id=$id")->find();
			 	$this->assign(data,$data);
			 	$this->display();
			}
			//更改操作修改操作
			 public function update(){
			 	$About=M('About');
			 	$data=I('post.','',false);//不过滤编辑器的html标签
			 	//var_dump($data);	
			 	$About->create($data);
		        $count=$About->save();
		        //var_dump($count);
		        if($count!==false){
		            $this->redirect('About/index');
		        }else{
		            $this->error('更改信息失败','',300);
		        }
			 }



}	