<?php
namespace Home\Controller;
use Think\Controller;
class SendController extends Controller {
    public function index(){
    	$addtime=$_GET['addtime'];
    	$sendid=session('id');
    	//$sendid='40';
    	$Order=M('Order');
    	$map['sendid']=$sendid;
    	$map['status']=array('IN','-2,2,3');
    	$cur_date = strtotime(date('Y-m-d'));//今天
        if($addtime==1){
            $map['addtime']=array('ELT',$cur_date);//历史记录
            $map['status']=array('IN','-2,2,3');
        }else if($addtime==0) {
            $map['addtime']=array('EGT',$cur_date);//今天记录
        }
      $count=$Order->where($map)->count();
      $p=getpage($count,10);//第二个参数为每页显示条数
    	$sendinfo=$Order->where($map)->field('id,ordnum,proname,paymoney,dormitory,status')->limit($p->firstRow, $p->listRows)->select();
    	$this->assign('rows',$sendinfo);
    	$this->assign('page', $p->show()); // 赋值分页输出  
    	$this->display();
    }
      //派送详细信息
      public function sendinfo(){
      	$orderid=$_GET['id'];
      	$Order=M('Order');
      	$map['id']=$orderid;
      	$orderinfo=$Order->where($map)->find();
      	$this->assign(data,$orderinfo);
      	$this->display();
      }

     //放弃接单操作
      public function giveup(){
        $id=$_POST['id'];
        $status['status']=$_POST['status'];
        $rs=D('Order')->where("id=$id")->save($status);
        if($rs){
             return show(1,'取消成功');
         }else{
             return show(0,'取消失败');
         }
      }

      //删除派送记录操作
      public function delsend(){
        $id=$_POST['id'];
        $status['status']=$_POST['status'];
        //var_dump($data['status']);
        $rs=D('Order')->where("id=$id")->save($status);
        if($rs){
             return show(1,'删除成功');
         }else{
             return show(0,'删除失败');
         }
      }
}