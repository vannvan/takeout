<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    public function index(){
      $Userinfo=M("Userinfo");
        $openid=session('openid');//此session既可能是save方法得到的，也可能是add方法得到的
        $condition['openid']=$openid;
        //$condition['id']='1';
        $data=$Userinfo->where($condition)->find();//此处不能用select语句引文select查询到的是对象，只适用于循环遍历,该方法一次查询数据太多，已不适用
        $data=$Userinfo->where($condition)->field('id,sex,nickname,headimgurl,dormitory,name')->find();
        //查询message数据表中是否存在status字段为0，如果存在，结合前端显示new标记，如果不存在前端则不显示
        session('id',$data['id']);//这里存储session是用于当用户openid存在是通过save方法登入信息时为获取其id值而存储的
        $userid=session('id');
        $map['status']=0;
        $map['sendid']=$userid;
        $new=M('Message')->where($map)->order('addtime desc')->getField('status',true);//获取最近时间的用户信息status是否为0
        //var_dump($new);
        if($new!=null){
             $new=1;//new存在
             $this->assign('new',$new);
        }
        //查询用户未完成订单数量
        $condition['status']=array('IN','0,1,2');
        $condition['orderid']=$userid;
        $CountOrder=M('Order')->where($condition)->count('id');
        $data['countorder']=$CountOrder;
        //查询用户未完成派送数量
        $condition1['status']=array('IN','2');
        $condition1['sendid']=$userid;
        $CountSend=M('Order')->where($condition1)->count('id');
        $data['countsend']=$CountSend;
        //查询用户签到积分
        $map['userid']=session('id');
        $integral=M('Sign')->where($map)->getField('integral');
        $data['integral']=$integral;
        session('id',$data['id']);
        session('UserResId',$data['resid']);//将用户的餐厅id存入session
        //M('Userinfo')->where($condition)->setInc('viewtime');//访问次数加1,每天加1 
        $this->assign('data',$data);
        $this->display();
      }
      //用户信息查看页面
      public function userinfo(){
        $Userinfo=M("Userinfo");
        $id=session('id');
        $condition['id']=$id;
        $data=$Userinfo->where($condition)->field('id,name,sex,headimgurl,dormitory,resname,mobile,nickname')->find();
        //var_dump($data);
        $this->assign('data',$data);
        $this->display();
      }
      //反馈插入操作
      public function feedin(){
         if(IS_AJAX){
             $Feedback = M('Feedback');
             $data=I('post.');
             if(!trim($data['content'])){
                return show(0,'内容不能为空');
             }
             $data['feedid']=session('id');
             $data['addtime']=time();
             $rs=$Feedback->create();
             if($rs=$Feedback->create()){
                    $rs=$Feedback->add($data);
                    return show(1,'感谢您的反馈');
                 }else{
                    return show(0);
                 }
             }else{
                return show(-1,'非法请求');
             }
      }

      //用户消息显示页面
      public function message(){
        $Message=M("Message");
        $id=$_GET['id'];
        $map['status']=array('neq',-1);
        $map['sendid']=$id;
        $count=$Message->where($map)->count();
        $p=getpage($count,10);//第二个参数为每页显示条数
        $message=$Message->where($map)->limit($p->firstRow, $p->listRows)->order('addtime desc')->select();
        //如果该用户没有消息
        $nomessage="<b style='margin-left:20px;line-height:35px;'>暂无消息！</b>";
        if($message==null){
          $this->assign(nomessage,$nomessage);
        }   
        $this->assign(rows,$message);
        $this->assign('page', $p->show()); // 赋值分页输出  
        $this->display();
      }
      //用户个人信息更改页面
       public function changeinfo(){
         $id=$_GET['id'];
         $map['id']=$id;
         $userinfo=M('Userinfo')->where($map)->field('id,sex,nickname,alipay')->find();
         //var_dump($userinfo);
         $this->assign(data,$userinfo);
         $this->display();
       }
     
      //预留用户钱包页面



      //信息详情页面
      public function messinfo(){
        $id=$_GET['id'];
        $status['status']=1;
        $userid=M('Message')->where("id=$id")->getField('sendid');
        $rst=M("Message")->where("id=$id")->save($status);
        $message=M('Message')->where("id=$id")->find();
        $this->assign(data,$message);  
        $this->assign(userid,$userid);
        $this->display();
      }

      //删除消息操作
      public function delmessage(){
        $id=$_POST['id'];
        $data['status']=$_POST['status'];
        //var_dump($data['status']);
        $rs=D('Message')->where("id=$id")->save($data);
        if($rs){
             return show(1,'删除成功');
         }else{
             return show(0,'删除失败');
         }
      }

      //用户注册信息操作
      public function register(){
        $userinfo=D('Userinfo');
        $data=I('post.');
        $data['paypass']=$_POST['paypass'];
        $data['md5password']=md5($_POST['paypass']);
        $userid=session('id');
        $code=$_POST['code'];
        $data=$userinfo->where("id=$useid")->create();
        if(md5($code)!=$_SESSION['code']){
            return show(0,'验证码错误');
            session('code',null);   
        }
        if($rs=$userinfo->where("id=$userid")->create()){
            $rs=$userinfo->where("id=$userid")->save($data);
            //给用户创建对应的钱包表和签到表
            $userid['userid']=$userid;
            M('sign')->add($userid);
            M('wallet')->add($userid);
            return show(1,'提交成功');
        }
        else{
            $errormeg=$userinfo->getError();
            return show(0,$errormeg);
        }
      }
       //更改信息操作
       public function modinfo(){
          $userinfo=D('Userinfo');
          $data=I('post.');
          $userid=$_POST['id'];
          //$code=$_POST['code'];
          $data=$userinfo->where("id=$useid")->create();
          if($rs=$userinfo->where("id=$userid")->create()){
              $rs=$userinfo->where("id=$userid")->save($data);
              return show(1,'更改成功');
          }else{
              $errormeg=$userinfo->getError();
              return show(0,$errormeg);
          }
       }


       //用户钱包
       public function wallet(){
         $userid=$_GET['id'];
         $wallet=D('wallet');
         $map['userid']=$userid;
         //从钱包查余额
         $wallet=$wallet->where($map)->field('userid,remain')->find();
         //从订单查消费金额
         $spend=M('order')->where("orderid=$userid")->Field('sum(paymoney)')->find();//paymony字段求和
         $wallet['spend']=$spend['sum(paymoney)'];
         $this->assign(data,$wallet);
         $this->display();
       }
        public function takeout(){
          $userid=$_GET['id'];
          $this->assign(userid,$userid);
          $this->display();
        }
       //提现操作
         public function dotakeout(){
           $data=I('post.');
           $userid=$data['userid'];
           //查询用户剩余余额
           $remain=M('wallet')->where("userid=$userid")->field('remain')->find();
           $data['money']=$data['money'];
           $data['userid']=$userid;
           $data['addtime']=time();
           $rs=$remain['remain']<$data['money'];
           if($rs){
                return show(0,'余额不足');
           }else{
                M('takeout')->add($data);
                $rst=M('wallet')->where("userid=$userid")->setDec('remain',$data['money']);
                return show(1,'提现成功,请等待转账');  
           }  
         }




       //无用的退出操作  
       public function logout(){
        session(null);
       }

}