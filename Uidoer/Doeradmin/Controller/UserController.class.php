<?php
namespace Doeradmin\Controller;
use Think\Controller;
class UserController extends BaseController{
	//普通用户基本信息展示页面
	public function ordinary(){
		$Userinfo=M('Userinfo');
		$map['status']=array('neq',-1);
		$map['category']=array('eq',0);
		//根据name搜索
		$name=$_GET['name'];
		if($name){
			$map['name']=['like',"%$name%"];
		}
		$count=$Userinfo->where($map)->count();
		$p=getpage($count,20);//第二个参数为每页显示条数
		//$data=$Userinfo->where($map)->order('addtime desc')->limit($p->firstRow, $p->listRows)->select();
		$data=$Userinfo->where($map)->order('addtime desc')->limit($p->firstRow, $p->listRows)->join('LEFT JOIN __SIGN__ ON  __SIGN__.userid=__USERINFO__.id')->select();
		//var_dump($data);
		$this->assign(rows,$data);
		$this->assign('page', $p->show()); // 赋值分页输出
		$this->display();
	}
	//高级会员基本信息
	public function vip(){
		$Userinfo=M('Userinfo');
		$map['status']=array('neq',-1);
		$map['category']=array('eq',1);
		//根据name搜索
		$name=$_GET['name'];
		if($name){
			$map['name']=['like',"%$name%"];
		}
		$count=$Userinfo->where($map)->count();
		$p=getpage($count,20);//第二个参数为每页显示条数
		$data=$Userinfo->where($map)->order('addtime desc')->limit($p->firstRow, $p->listRows)->join('LEFT JOIN __SIGN__ ON  __SIGN__.userid=__USERINFO__.id')->select();
		$this->assign(rows,$data);
		$this->assign('page', $p->show()); // 赋值分页输出
		$this->display();
	}
	//拉黑用户基本信息
	public function baned(){
		$Userinfo=M('Userinfo');
		$map['status']=array('eq',-1);
		//根据name搜索
		$name=$_GET['name'];
		if($name){
			$map['name']=['like',"%$name%"];
		}
		$count=$Userinfo->where($map)->count();
		$p=getpage($count,10);//第二个参数为每页显示条数
		$data=$Userinfo->where($map)->order('addtime desc')->limit($p->firstRow, $p->listRows)->join('LEFT JOIN __SIGN__ ON  __SIGN__.userid=__USERINFO__.id')->select();
		$this->assign(rows,$data);
		$this->assign('page', $p->show()); // 赋值分页输出
		$this->display();
	}
	//用户详细信息
	public function userinfo(){
		$id=$_GET['id'];
		$userinfo=M('userinfo')->where("id=$id")->find();
		//查询用户消费信息
		$spend=M('order')->where("orderid=$id")->Field('sum(paymoney)')->find();//paymony字段求和
		//查询用户钱包余额
		$remain=M('wallet')->where("userid=$id")->Field('remain')->find();
		$userinfo['spend']=$spend['sum(paymoney)'];
		$userinfo['remain']=$remain['remain'];
		$this->assign(data,$userinfo);
		$this->display();
	}


	 //恢复操作
	 public function enabled(){
		$id=$_POST['id'];
		$status=$_POST['status'];
		//var_dump($data['status']);
		$rs=D('Userinfo')->UpdateStatusById($id,$status);
		if($rs){
			return show(1,'恢复成功');
		}else{
			return show(0,'恢复失败');
		}
	}
	 //拉黑操作
	 public function disable(){
	 	$id=$_POST['id'];
		$status=$_POST['status'];
		//var_dump($data['status']);
		$rs=D('Userinfo')->UpdateStatusById($id,$status);
		if($rs){
			return show(1,'拉黑成功');
		}else{
			return show(0,'拉黑失败');
		}
	}


	//用户提现
	public function takeout(){
		$takeout=M('takeout');
		$map['status']=array('IN','0,1');
		$btime=strtotime($_GET['btime']);
		$etime=strtotime($_GET['etime']);
		if($_GET['alipay']){
			$map['alipay']=$_GET['alipay'];
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
		$cur_date = strtotime(date('Y-m-d'));//今天
		$condition['addtime']=array('egt',$cur_date);
		$SumTakeout=$takeout->where($condition)->Field('sum(money)')->find();//今天的数据
		$SumTakeout1=$takeout->where($map)->Field('sum(money)')->find();//所有数据
		$Sum['todaysum']=$SumTakeout['sum(money)'];
		$Sum['allsum']=$SumTakeout1['sum(money)'];
		$count=$takeout->where($map)->count();
		$p=getpage($count,20);//第二个参数为每页显示条数
		$data=$takeout->where($map)->order('status,addtime desc')->limit($p->firstRow, $p->listRows)->select();
		$this->assign('rows',$data);
		$this->assign('data',$Sum);
		$this->assign('page', $p->show()); // 赋值分页输出
		$this->display();
	}
	//提现操作
	public function dotakeout(){
		$takeout=M('takeout');
		$getid=$_GET['id'];
		$id=I('post.id');
		if($getid){
			$map['id']=$getid;
		}else{
			$map['id']=array('IN',$id);
		}
		$data['status']=1;
		$data['modtime']=time();
		//批量更新字段，很赞
		$rst=$takeout->where($map)->save($data);
	    if($rst){
	    	return show(1,'操作成功');
	    }else{
	    	return show(0,'操作失败');
	    }
	}

	//取消提现
	public function cancel(){
		$takeout=M('takeout');
		$getid=$_GET['id'];
		$map['id']=$getid;
		$data['status']=0;
		$rst=$takeout->where($map)->save($data);
	    if($rst){
	    	return show(1,'操作成功');
	    }else{
	    	return show(0,'操作失败');
	    }
	}

	//用户充值
	public function recharge(){
		$recharge=M('recharge');
		$btime=strtotime($_GET['btime']);
		$etime=strtotime($_GET['etime']);
		if($_GET['ordnum']){
			$map['ordnum']=$_GET['ordnum'];
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
		$cur_date = strtotime(date('Y-m-d'));//今天
		$condition['addtime']=array('egt',$cur_date);
		$SumRechar=$recharge->where($condition)->Field('sum(paymoney)')->find();//今天的数据
		$SumRechar1=$recharge->where($map)->Field('sum(paymoney)')->find();//所有数据
		$Sum['todaysum']=$SumRechar['sum(paymoney)'];
		$Sum['allsum']=$SumRechar1['sum(paymoney)'];
		$count=$recharge->where($map)->count();
		$p=getpage($count,20);//第二个参数为每页显示条数
		$data=$recharge->where($map)->order('addtime desc')->limit($p->firstRow, $p->listRows)->select();
		$this->assign('data',$Sum);
		$this->assign('rows',$data);
		$this->assign('page', $p->show()); // 赋值分页输出
		$this->display();
	}
}