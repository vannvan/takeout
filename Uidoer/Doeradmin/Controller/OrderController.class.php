<?php
namespace Doeradmin\Controller;
use Think\Controller;
	class OrderController extends BaseController{
		//已完成订单信息
		public function finish(){
		$Order=M('Order');
		$map['status']=array('IN','-2,-3,3');//状态需要改为正式的已完成的状态
		//筛选条件初始化
		$btime=strtotime($_GET['btime']);
		$etime=strtotime($_GET['etime']);
		if($_GET['ordnum']){
			$map['ordnum']=$_GET['ordnum'];
		}
		if($_GET['username']){
			$map['username']=$_GET['username'];
		}
		if($_GET['btime']&&$_GET['etime']){
			 $map['addtime']=array('BETWEEN','$btime,$etime');
		}
		if($_GET['btime']){
			 $map['addtime']=array('EGT',$btime);
		}
		if($_GET['etime']){
			 $map['addtime']=array('ELT',$etime);
		}
		$count=$Order->where($map)->count();
		$p=getpage($count,15);//第二个参数为每页显示条数
		$data=$Order->where($map)->order('addtime desc')->limit($p->firstRow, $p->listRows)->select();
		//var_dump($data);
		$this->assign(rows,$data);
		$this->assign('page', $p->show()); // 赋值分页输出
		$this->display();
		}
		//未完成订单信息
		public function unfinish(){
		$Order=M('Order');
		$map['status']=array('IN','0,1,2');
		//筛选条件初始化
		$btime=strtotime($_GET['btime']);
		$etime=strtotime($_GET['etime']);
		if($_GET['ordnum']){
			$map['ordnum']=$_GET['ordnum'];
		}
		if($_GET['username']){
			$map['username']=$_GET['username'];
		}
		if($_GET['btime']&&$_GET['etime']){
			 $map['addtime']=array('BETWEEN','$btime,$etime');
		}
		if($_GET['btime']){
			 $map['addtime']=array('EGT',$btime);
		}
		if($_GET['etime']){
			 $map['addtime']=array('ELT',$etime);
		}
		$count=$Order->where($map)->count();
		$p=getpage($count,20);//第二个参数为每页显示条数
		$data=$Order->where($map)->order('addtime desc')->limit($p->firstRow, $p->listRows)->select();
		//var_dump($data);
		$this->assign(rows,$data);
		$this->assign('page', $p->show()); // 赋值分页输出
		$this->display();
		}

		//失效订单信息
		public function failure(){
		$Order=M('Order');
		$map['status']=array('eq',-1);
		//筛选条件初始化
		$btime=strtotime($_GET['btime']);
		$etime=strtotime($_GET['etime']);
		if($_GET['ordnum']){
			$map['ordnum']=$_GET['ordnum'];
		}
		if($_GET['username']){
			$map['username']=$_GET['username'];
		}
		if($_GET['btime']&&$_GET['etime']){
			 $map['addtime']=array('BETWEEN','$btime,$etime');
		}
		if($_GET['btime']){
			 $map['addtime']=array('EGT',$btime);
		}
		if($_GET['etime']){
			 $map['addtime']=array('ELT',$etime);
		}
		$count=$Order->where($map)->count();
		$p=getpage($count,20);//第二个参数为每页显示条数
		$data=$Order->where($map)->order('addtime desc')->limit($p->firstRow, $p->listRows)->select();
		//var_dump($data);
		$this->assign(rows,$data);
		$this->assign('page', $p->show()); // 赋值分页输出
		$this->display();
		}

		//订单详细信息
		public function details(){
		$id=$_GET['id'];
		$Order=M('Order')->where("id=$id")->find();
		//var_dump($Order);
		$this->assign(data,$Order);;
		$this->display();
	}



}