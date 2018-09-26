<?php
namespace Home\Controller;
use Think\Controller;
class WeixinpayController extends Controller {
    //用于商品支付
      /**
     * notify_url接收页面
     */
    public function notify(){
        $showorder=U('Weixinpay/showorder');
        //更新数据库status状态
        $orderid=session('orderid');
        //var_dump($orderid);
        $map['id']=$orderid;
        $order=M('order');
        $data['status']=1;//完成支付状态为1
        $data['paytime']=time();
        $data['paymethod']='微信支付';
        $rst=$order->where($map)->save($data);
        //查询订单数据反馈给用户
        redirect($showorder);
    }

    public function showorder(){
        $orderid=session('orderid');
        $map['id']=$orderid;
        $order=M('order');
        $orderinfo=$order->where($map)->field('id,paymoney,ordnum,proname,addtime,paytime,paymethod')->find();
        $this->assign(data,$orderinfo);
        $this->display();
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

    /**
     * 公众号支付 必须以get形式传递 out_trade_no 参数
     * 示例请看 /Application/Home/Controller/IndexController.class.php
     * 中的weixinpay_js方法
     */
    public function pay(){
        // 导入微信支付sdk
        Vendor('Weixinpay.Weixinpay');
        $wxpay=new \Weixinpay();
        // 获取jssdk需要用到的数据
        $data=$wxpay->getParameters();
        // 将数据分配到前台页面
        $assign=array(
            'data'=>json_encode($data)
            );
        $this->assign($assign);
        $this->display();
    }

}