<?php
namespace Doeradmin\Controller;
use Think\Controller;
	class BannerController extends BaseController{
			public function index(){
			$Banner=M('Banner');
			$map['status']=array('neq',-1);
			$count=$Banner->where($map)->count();
			$p=getpage($count,10);//第二个参数为每页显示条数
		 	$rows = $Banner->where($map)->limit($p->firstRow, $p->listRows)->select();//查询二维数组，无限制,根据最近时间排序
	        $this->assign('rows',$rows);//分配二维数组
	        $this->assign('page', $p->show()); // 赋值分页输出
			$this->display();
		}
		
		public function create(){
			$Banner=M('Banner');
		 	$data=I('post.');
		 	//var_dump($data);
		 	$data['addtime']=time();
		 	if($_FILES['image']['tmp_name']!=''){
			   $config = array(
				    'maxSize'    =>    1048576,
				    'rootPath'   =>    './',
				    'savePath'   =>    'Public/sources/store/',
				    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
				    //'subName'    =>   array('I','post.id'),
					);
			   $upload = new \Think\Upload($config);// 实例化上传类
	    		// 上传文件 
			   $info=$upload->uploadOne($_FILES['image']);
			   if(!$info){
			   	$this->error($upload->getError());
			   }else{
			   	//savapath 全部小写
			   	$data['image']=$info['savepath'].$info['savename'];
			   }
			}	
			   if($Banner->create($data))
			   {
			   	//var_dump($Banner->create($data));
				   	if($Banner->add())
				   	{
				   		$this->success('添加成功',U('Banner/index'));
				   	}else{
				   		$this->error('添加失败',100);
				   	}
			   }else
			   {
			   	$this->error($upload->getError());
			   }
			   return;
				
			}

			//发布操作
			public function enabled(){
				$id=$_GET['id'];
				$status=1;
				$rs=D("Banner")->UpdateStatusById($id,$status);
				if($rs){
					$this->redirect('Banner/index');
				}else{
					return show(0,'发布失败');
				}
			}

			//取消发布操作
			public function disabled(){
				$id=$_GET['id'];
				//var_dump($id);
				$status=0;
				$rs=D("Banner")->UpdateStatusById($id,$status);
				//$rs=$Banner->where("id=$id")->sava($data);
				if($rs){
					$this->redirect('Banner/index');
				}else{
					return show(0,'取消失败');
				}
			}
			//删除操作
			public function del(){
				$id=$_POST['id'];
				$status=$_POST['status'];
				//var_dump($data['status']);
				$rs=D('Banner')->UpdateStatusById($id,$status);
				if($rs){
					return show(1,'删除成功');
				}else{
					return show(0,'删除失败');
				}
			}
	}	
