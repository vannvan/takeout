<?php
namespace Home\Controller;
use Think\Controller;
class ServiceController extends Controller {
    public function myservice(){
        $getid=$_GET['resid'];
    	$order=M('order');
    	$userid=session('id');
        //$userid='40';
  		//查询用户的resid（餐厅id）
    	$resid=M('userinfo')->where("id=$userid")->getField('resid');
    	//优先查询与其对应resid的订单
        if(!$getid||$getid==null){
            $map['resid']=$resid;
        }elseif ($getid) {
            $map['resid']=$getid;
        }
        $map['status']=1;//限制已经付款且未完成的订单
        $count=$order->where($map)->count();
        $p=getpage($count,10);//第二个参数为每页显示条数
    	$order=M('order')->where($map)->field('id,proname,ordnum,paymoney,dormitory')->limit($p->firstRow, $p->listRows)->order('addtime desc')->select();
        //查询餐厅列表
        $Restaurant=M('Restaurant')->field('id,name')->select();
        //var_dump($Restaurant);
        $this->assign('resrows',$Restaurant);
    	$this->assign('rows',$order);
        $this->assign('page', $p->show()); // 赋值分页输出  
    	$this->display();
      }
    public function details(){
    	$orderid=$_GET['id'];
    	$map['id']=$orderid;
    	$orderinfo=M('Order')->where($map)->find();
        $resid=$orderinfo['resid'];
        $resname=M('Restaurant')->where("id=$resid")->getField('name');
        $orderinfo['resname']=$resname;
    	//var_dump($orderinfo);
    	$this->assign('data',$orderinfo);
    	$this->display();
    }


    //派送操作
      public function send(){
         if(IS_AJAX){
             $Order = M('Order');
             $data=I('post.');
             $orderid=$data['id'];
             $map['id']=$orderid;
             $data['sendid']=session('id');
             $data['status']='2';
             $rs=$Order->where($map)->create();
             if($rs=$Order->where($map)->create()){
                    $rs=$Order->where($map)->save($data);
                    return show(1,'接单成功，请及时派送哦！');
                 }else{
                    return show(0,'接单失败，请稍后重试！');
                 }
             }else{
                return show(-1,'非法请求');
             }
      }
}