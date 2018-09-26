<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends Controller {
    public function index(){
        $addtime=$_GET['addtime'];
        //用户个人订单
        $userid=session('id');
        //$userid='40';
        $Order=M('order');
        //$map['status']=2;
        $map['orderid']=$userid;
        $map['status']=array('IN','-1,0,1,2,3');//不显示已删除的订单
        $cur_date = strtotime(date('Y-m-d'));//今天
        if($addtime==1){
            $map['addtime']=array('ELT',$cur_date);//历史记录
        }else if($addtime==0) {
            $map['addtime']=array('EGT',$cur_date);//今天记录
        }
        $count=$Order->where($map)->count();
        $p=getpage($count,10);//第二个参数为每页显示条数
        $rows=$Order->where($map)->field('id,proname,ordnum,status,paymoney')->limit($p->firstRow, $p->listRows)->order('addtime desc')->select();//找出今天的数据
        //var_dump($rows);
        $this->assign(rows,$rows);
        $this->assign('page', $p->show()); // 赋值分页输出  
    	  $this->display();
      }
      //订单详情页
      public function details(){
        $orderid=$_GET['id'];
        $map['id']=$orderid;
        $orderinfo=M('order')->where($map)->find();
        $sendid=$orderinfo['sendid'];
        if($sendid!=null){
           $sendinfo=M('Userinfo')->where("id=$sendid")->field('name,mobile')->find();
           $orderinfo['SendUserName']=$sendinfo['name'];
           $orderinfo['SendUserMobile']=$orderinfo['mobile'];
        }
        $this->assign('data',$orderinfo);
        $this->display();
      }


    //生成订单方法
    public function create(){
        if(IS_AJAX){
             $Order=D('Order');
             $data=I('post.');
             $map['id']=session('id');
             //$map['id']='40';
             //取出订餐者的必要信息
             $orderinfo=M('userinfo')->where($map)->field('id,name,dormitory,mobile')->find();
             $data['username']=$orderinfo['name'];
             $data['mobile']=$orderinfo['mobile'];
             $data['dormitory']=$orderinfo['dormitory'];
             $data['orderid']=$orderinfo['id'];
             $data['addtime']=time();
             $rs=$Order->create();
             if($rs=$Order->create()){
                    $rs=$Order->add($data);
                    //保存当前订单的id到session中
                    session('orderid',$rs);
                    return show(1,'订单已生成，正在进入付款页面');
                 }else{
                    return show(0,'系统错误，请稍后重试');
                    ///$this->error('添加失败')
                 }
             }else{
                return show(-1,'非法请求');
                 //$this->error('非法请求');
             }
      }

      //确认完成操作，还要添加给送餐方付款的操作
      public function orderok(){
        $id=$_POST['id'];
        $Order=D('Order');
        $data['status']=$_POST['status'];
        $data['finishtime']=time();
        $rs=$Order->where("id=$id")->save($data);
        $orderinfo=$Order->where("id=$id")->field('sendid,paymoney')->find();
        $sendid=$orderinfo['sendid'];
        $paymoney=$orderinfo['paymoney'];
        $map['userid']=$sendid;
        $UserWallet=M('wallet')->where($map)->find();//查询派送方是否存在钱包记录
        if($rs){
            //执行给派送放增加余额的操作
            if($UserWallet==null){
              $data['userid']=$sendid;
              $rst=M('wallet')->add($data);
              $map['userid']=$sendid;
              M('wallet')->where($map)->setInc('remain',$paymoney);//余额增加
              return show(1,'确认成功，感谢支持');
            }else{
              // $data['userid']=$sendid;
              // $rst=M('wallet')->save($data);
              $map['userid']=$sendid;
              M('wallet')->where($map)->setInc('remain',$paymoney);//余额增加
              return show(1,'确认成功，感谢支持');
            }    
        }else{
            return show(0,'确认失败');
        }
         
      }

      //取消订单操作
      public function ordercancel(){
        $id=$_POST['id'];
        $data['status']=$_POST['status'];
        //此操作是防止订餐者数据与数据库数据延迟不一致时的
        $status=D('Order')->where("id=$id")->getField('status');
        if($status=='2'){
            return show(1,'正在配送，不能取消');
        }else{
            $rs=D('Order')->where("id=$id")->save($data);
            if($rs){
                return show(1,'取消成功，等待退款');
            }else{
                return show(0,'取消失败');
            }
        }
      }

      //删除操作
      public function ordrebay(){
        $id=$_POST['id'];
        $data['status']=$_POST['status'];
        $rs=D('Order')->where("id=$id")->save($data);
        if($rs){
            return show(1,'购买成功，感谢支持');
        }else{
            return show(0,'购买失败');
        }
         
      }

      //删除操作
      public function orderdel(){
        $id=$_POST['id'];
        $data['status']=$_POST['status'];
        $rs=D('Order')->where("id=$id")->save($data);
        if($rs){
            return show(1,'删除成功');
        }else{
            return show(0,'删除失败');
        }
         
      }

      //在用户未付款状态下彻底删除操作
      public function orderdelete(){
        $id=$_POST['id'];
        $rs=D('Order')->where("id=$id")->delete();
        if($rs){
            return show(1,'删除成功');
        }else{
            return show(0,'删除失败');
        }   
      }

      //已生成订单付款
      public function re_pay(){
        $orderid=$_GET['id'];
        $map['id']=$orderid;
        $Order=M("Order");
        $orderinfo=$Order->where($map)->field('id,ordnum,proname,paymoney')->find();
        $this->assign(data,$orderinfo);
        $this->display();
      }


}