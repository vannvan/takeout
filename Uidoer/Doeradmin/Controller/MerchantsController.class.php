<?php
namespace Doeradmin\Controller;
use Think\Controller;
	class MerchantsController extends BaseController{
		public function index(){
			$pid=$_GET['id'];//餐厅id
			$Merchants=M('Merchants');	
			$ctname=M('Restaurant')->where("id=$pid")->getField('name');//找出餐厅名
			$map['pid']=$pid;
			$map['status']=array('neq',-1);
			$count=$Merchants->where($map)->count();
			$p=getpage($count,15);//第二个参数为每页显示条数
			$data=$Merchants->where($map)->order('addtime desc')->limit($p->firstRow, $p->listRows)->select();
			$this->assign(ctid,$pid);//餐厅id
			$this->assign(ctname,$ctname);//餐厅名称
			$this->assign(rows,$data);
			$this->assign('page', $p->show()); // 赋值分页输出
			$this->display();
		}
		//添加页面
		public function add(){
			$pid=$_GET['id'];
			$Restaurant=M('Restaurant');
			$ctname=$Restaurant->where("id=$pid")->getField('name');
			$this->assign(ctid,$pid);
			$this->assign(ctname,$ctname);
			$this->display();
		}
		//从入口直接添加餐厅页面
		public function add1(){
			$Restaurant=M('Restaurant');
			$map['status']=array('neq',-1);
			$data=$Restaurant->where($map)->select();
			$this->assign(ctrows,$data);
			$this->display();
		}

		public function create(){
			$Merchants=M('Merchants');
		 	$data=I('post.');
		 	$pid=I('post.pid');
		 	var_dump($data);
		 	exit();
		 	$data['addtime']=time();
		 	 if($_FILES['image']['tmp_name']!=''&&$_FILES['labelimg']['tmp_name']!=''){
			   $config = array(
				    'maxSize'    =>    1048576,
				    'rootPath'   =>    './',
				    'savePath'   =>    'Source/Merchants/',
				    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
				    //'subName'    =>   array('I','post.id'),
					);
			   $upload = new \Think\Upload($config);// 实例化上传类
	    		// 上传文件 
			   $info=$upload->upload();
			   //var_dump($info);
			   if(!$info){
			   	$this->error($upload->getError());
			   }else{
			   		$data['image']=$info['image']['savepath'].$info['image']['savename'];	//路径参考thinkphp3.2.3说明文档，和其他版本不一样
					$data['labelimg']=$info['labelimg']['savepath'].$info['labelimg']['savename'];	  
					   	//var_dump($data['labelimg']);
				}
			}	
			   if($Merchants->create($data))
			   {
			   	//var_dump($Banner->create($data));
				   	if($Merchants->add())
				   	{
				   		//return show(1,'添加成功');
				   		 $this->redirect('Merchants/index',array('id' => $pid));
				   		//$this->success('添加成功',U('Merchants/index'),1);
				   	}else{
				   		$this->error('添加失败',100);
				   	}
			   }else
			   {
			   	$this->error($upload->getError());
			   }
			   return;
		}
			public function mod(){
				$Merchants=M('Merchants');
				$id=$_GET['id'];
			 	$data=$Merchants->where("id=$id")->find();
				$this->assign(data,$data);
				$this->display();
			}

			//更改操作修改操作
			 public function update(){
			 	$Merchants=M('Merchants');
			 	$data=I('post.');
			 	$data['modtime']=time();
			 	$pid=I('post.pid');
			 	$config = array(
					    'maxSize'    =>    1048576,
					    'rootPath'   =>    './',
					    'savePath'   =>    'Public/sources/store/',
					    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
					    //'subName'    =>   array('I','post.id'),
						);
			 	//主图和副图分别判断
			 	if($_FILES['image']['tmp_name']!=''){
				   $upload = new \Think\Upload($config);// 实例化上传类
				   $info=$upload->uploadOne($_FILES['image']);
				   if(!$info){
				   	$this->error($upload->getError());
				   }else{
				   	//savapath 全部小写
				   	$data['image']=$info['savepath'].$info['savename'];
				   }
				}
				if($_FILES['labelimg']['tmp_name']!=''){
				   $upload = new \Think\Upload($config);// 实例化上传类
				   $info=$upload->uploadOne($_FILES['labelimg']);
				   if(!$info){
				   	$this->error($upload->getError());
				   }else{
				   	//savapath 全部小写
				   	$data['labelimg']=$info['savepath'].$info['savename'];
				   }
				}
			 	
				   if($Merchants->create($data))
				   {
				   	//var_dump($Store->create($data));
					   	if($Merchants->save())
					   	{
					   		//$this->success('修改成功',U('Store/index'));
					   		 $this->redirect('Merchants/index',array('id' => $pid));
					   	}else{
					   		$this->error('修改失败');
					   	}
				   }
				  	
			 }

			 //发布操作
			public function enabled(){
				$id=$_GET['id'];
				$pid=D('Merchants')->GetPidByid($id);//通过id获取pid的方法在model层
				$status=1;
				$rs=D("Merchants")->UpdateStatusById($id,$status);
				if($rs){
					$this->redirect('Merchants/index',array('id' => $pid));
				}else{
					return show(0,'发布失败');
				}
			}

			//取消发布操作
			public function disabled(){
				$id=$_GET['id'];
				$pid=D('Merchants')->GetPidByid($id);
				$status=0;
				$rs=D("Merchants")->UpdateStatusById($id,$status);
				//$rs=$Banner->where("id=$id")->sava($data);
				if($rs){
					$this->redirect('Merchants/index',array('id' => $pid));
				}else{
					return show(0,'取消失败');
				}
			}

			//推荐
			public function recom(){
				$id=$_GET['id'];
				$pid=D('Merchants')->GetPidByid($id);//通过id获取pid的方法在model层
				$recom=1;
				$rs=D("Merchants")->UpdateRecomById($id,$recom);
				if($rs){
					$this->redirect('Merchants/index',array('id' => $pid));
				}else{
					return show(0,'发布失败');
				}
			}

			//取消推荐操作
			public function disrecom(){
				$id=$_GET['id'];
				$pid=D('Merchants')->GetPidByid($id);
				$recom=0;
				$rs=D("Merchants")->UpdateRecomById($id,$recom);
				//$rs=$Banner->where("id=$id")->sava($data);
				if($rs){
					$this->redirect('Merchants/index',array('id' => $pid));
				}else{
					return show(0,'取消失败');
				}
			}

			//删除操作
			public function del(){
				$id=$_POST['id'];
				$status=$_POST['status'];
				$rs=D('Merchants')->UpdateStatusById($id,$status);
				if($rs){
					return show(1,'删除成功');
				}else{
					return show(0,'删除失败');
				}
			}


}