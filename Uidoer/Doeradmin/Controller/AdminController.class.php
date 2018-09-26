<?php
namespace Doeradmin\Controller;
use Think\Controller;
	class AdminController extends BaseController{
	public function view(){
		$Admin=M('Admin');
		$admininfo=$Admin->order('sysid')->select();
		$this->assign(rows,$admininfo);
		$this->display();
	}

	 //启用操作
	 public function enabled(){
	 	$Admin=M('Admin');
	 	$id=$_GET['id'];
	 	var_dump($id);
        $data['status'] = 1;
        $rs=$Admin->where("sysid=$id")->save($data);
        if($rs!==false){
            //$this->success('操作完成','',1);
            $this->redirect('Admin/view');
        }else{
            $this->error('操作失败');
        }
	 }
	 //禁用操作
	 public function disable(){
	 	$Admin=M('Admin');
	 	$id=$_GET['id'];
	 	var_dump($id);
        $data['status'] = 0;
        $rs=$Admin->where("sysid=$id")->save($data);
        if($rs!==false){
            //$this->success('操作完成','',1);
            $this->redirect('Admin/view');
        }else{
            $this->error('操作失败');
        }
	 }

	 //添加管理员
	 public function create(){
	 	$Admin=M('Admin');
	 	$data=I('post.');
	 	$data['password']=md5(I('post.password'));
	 	$data['addtime']=time();
	 	//var_dump($data);
	 	$rs=$Admin->create();
	 	if($rs=$Admin->create()){
        $rs=$Admin->add($data);
        	$this->success('添加成功',U('Admin/view'));
	 	}else{
	 		$this->error('添加失败');
	 	}

	 }

	 //更改管理员页面
	 public function mod(){
	 	$Admin=M('Admin');
	 	$sysid=$_GET['id'];
	 	//var_dump($sysid);
		$admininfo=$Admin->where("sysid=$sysid")->find();
		//var_dump($admininfo);
		$this->assign(data,$admininfo);
		$this->display();
	 }
	 //管理员信息修改操作
	 public function update(){
	 	$Admin=M('Admin');
	 	$data=I('post.');
	 	$data['password']=md5(I('post.password'));
	 	$Admin->create($data);
        $count=$Admin->save();
        if($count!==false){
            //$this->success('投放信息更改成功',U('User/demanded'),1);
            $this->redirect('Admin/view');
        }else{
            $this->error('更改管理员信息失败','',300);
        }
	 }

	 //删除管理员操作
	 public function deladmin(){
	 	$id=$_GET['id'];
        if($id){
             $Admin=M('Admin');
             $rs=$Admin->where("sysid=$id")->delete();
            if($rs){
            	$this->redirect('Admin/view');
                //$this->success('删除完成','',1);
            }else{
                $this->error('删除失败','',2);
            }
        }else{
            $this->error('删除失败','',2);
        }
	 }


	 
}