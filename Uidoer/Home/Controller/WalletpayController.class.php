<?php
namespace Home\Controller;
use Think\Controller;
class WalletpayController extends Controller {
	public function pay(){
		$orderid=I('post.id');
		$order=M('order');
		$orderinfo=$order->where("id=$orderid")->field('orderid,paymoney')->find();
		$userid=$orderinfo['orderid'];
		//查询用户余额是否足够
		$remain=M('wallet')->where("userid=$userid")->field('remain')->find();
		$rst=$remain['remain']>$orderinfo['paymoney'];
		if($rst){
			$rst=M('wallet')->where("userid=$userid")->setDec('remain',$orderinfo['paymoney']);
			return show(1,'支付成功');
		}else{
			return show(0,'余额不足，请充值！');
		}
	}

	public function notify(){
		$orderid=$_GET['id'];
		$showorder=U('Walletpay/showorder',"id=$orderid");
        //更新数据库status状态
        //var_dump($orderid);
        $map['id']=$orderid;
        $order=M('order');
        $data['status']=1;//完成支付状态为1
        $data['paytime']=time();
        $data['paymethod']='余额支付';
        $rst=$order->where($map)->save($data);
        //查询订单数据反馈给用户
        redirect($showorder);
	}

	//用户点赞操作
    public function zan(){
        $orderid=I('post.');
        $data['zan']=1;
        $map['id']=$orderid['orderid'];
        $rst=D('order')->where($map)->save($data);
        //查看用户是否已经赞过
        $zan=D('order')->where($map)->getfield('zan');
        if($rst){
            return show(1,'点赞成功，感谢支持');

        }else if($zan==1){
            return show(1,'你已经赞过啦！');
        }else{
            return show(0,'尴尬了，点赞失败！');
        }
    }

	public function showorder(){
		$orderid=$_GET['id'];
        $map['id']=$orderid;
        $order=M('order');
        $orderinfo=$order->where($map)->field('id,paymoney,ordnum,proname,addtime,paytime,paymethod')->find();
        $this->assign(data,$orderinfo);
        $this->display();
	}
}