<?php
namespace Home\Controller;
use Think\Controller;
class Weixinpay1Controller extends Controller {
    //用于余额充值
      /**
     * notify_url接收页面
     */
    public function notify(){
        $userid=session('id');
        $map['userid']=$userid;
        $UserWallet=M('wallet')->where($map)->find();//查询用户是否存在钱包记录
        $WalletUrl=U('Weixinpay1/recharok');
        $IncMoney=session('wallet');
        if($UserWallet==null){
              $data['userid']=$userid;
              //增加新的钱包记录
              $rst=M('wallet')->add($data);
              $map['userid']=$userid;
              M('wallet')->where($map)->setInc('remain',$IncMoney);//余额增加
              //增加新的充值记录
              $data['userid']=session('id');
              $data['paymoney']=session('wallet');
              $data['ordnum']=session('ordnum');
              $data['addtime']=time();
              $recha=M('recharge')->where($map)->add($data);
              //改变用户级别
              $cate['category']='1';
              M('Userinfo')->where("id=$userid")->save($cate);
              session('wallet',null);
              redirect($WalletUrl);
            }else{
              $map['userid']=$userid;
              M('wallet')->where($map)->setInc('remain',$IncMoney);//余额增加
              //增加新的充值记录
              $data['userid']=session('id');
              $data['paymoney']=session('wallet');
              $data['ordnum']=session('ordnum');
              $data['addtime']=time();
              $recha=M('recharge')->where($map)->add($data);
              //改变用户级别
              $cate['category']='1';
              M('Userinfo')->where("id=$userid")->save($cate);
              session('wallet',null);
              redirect($WalletUrl);
            }
      }
      public function recharok(){
        $ordnum=session('ordnum');
        $RecharInfo=M('recharge')->where("ordnum=$ordnum")->find();
        $this->assign(data,$RecharInfo);
        $this->display();
      }     

    //充值信息接受页面
    public function pre_pay(){
        $data=I('post.');
        session('wallet',$data['paymoney']);
        $out_trade_no=build_order_no();//订单号，交给微信
        session('ordnum',$out_trade_no);
        // 组合url
        $url=U('Weixinpay1/pay',array('out_trade_no'=>$out_trade_no));
        // 前往支付
        redirect($url);
    }

    /**
     * 公众号支付 必须以get形式传递 out_trade_no 参数
     * 示例请看 /Application/Home/Controller/IndexController.class.php
     * 中的weixinpay_js方法
     */
    public function pay(){
        // 导入微信支付sdk
        Vendor('Weixinpay.Weixinpay1');
        $wxpay=new \Weixinpay1();
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