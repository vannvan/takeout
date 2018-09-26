<?php
namespace Home\Controller;
use Think\Controller;
class CanteenController extends Controller {
    public function index(){
    	$Merchants=M("Merchants");
    	$id=$_GET['id'];
    	$map['status']=array('neq',-1);
    	$map['pid']=$id;
      //var_dump($id);
      $count=$Merchants->where($map)->count();
      $p=getpage($count,15);//第二个参数为每页显示条数
    	$data=$Merchants->where($map)->limit($p->firstRow, $p->listRows)->order("addtime")->select();
    	if($data==null){
        $this->redirect('Public/empty');
      }
    	$this->assign(rows,$data);
      $this->assign('page', $p->show()); // 赋值分页输出  
    	$this->display();
      }



      //用户个人餐厅
      public function mycanteen(){
        //var_dump('hello');
      	$Merchants=M("Merchants");
      	//$id=session('id');
        $id='40';
        if(isset($id)){
          $resid=M('Userinfo')->where("id=$id")->getField('resid');
        }else{
          $this->redirect('User/index');
        }
        
      	if($resid==null){
      		$this->redirect('Public/noid');
      	}
      	$map['status']=array('neq',-1);
      	$map['pid']=$resid;
      	$count=$Merchants->where($map)->count();
        $p=getpage($count,15);//第二个参数为每页显示条数
        $data=$Merchants->where($map)->limit($p->firstRow, $p->listRows)->order("addtime")->select();
        //var_dump($data);
      	$this->assign(rows,$data);
        $this->assign('page', $p->show()); // 赋值分页输出  
      	$this->display();
      }


      //产品列表
      public function foodlist(){
        $pid=$_GET['id'];
        //var_dump($pid);
        $Product=M('Product');
        $Merchants=M('Merchants');
        $map['status']=array('neq',-1);
        $map['pid']=$pid;
        $count=$Product->where($map)->count();
        $p=getpage($count,15);//第二个参数为每页显示条数
        $data=$Product->where($map)->order('addtime')->select();
        $labelimg=$Merchants->where("id=$pid")->limit($p->firstRow, $p->listRows)->getField('labelimg');//查询该店的副图
        $this->assign(labelimg,$labelimg);
        //var_dump($labelimg);
        //var_dump($data);
        $this->assign(rows,$data);
        $this->assign('page', $p->show()); // 赋值分页输出 
        $this->display();
      }

      //订单展示
      public function order(){
        $ordnum=build_order_no();//生成订单号
        $orderid=$_GET['id'];
        $UserId=session('id');
        //$UserId='40';
        //查询用户餐厅，不是所在餐厅前台改派送费用
        $UserResId=M('Userinfo')->where("id=$UserId")->getField('resid');
        //var_dump($ornum);
        //根据id查询产品信息
        $Product=M('Product');;
        $ProductData=$Product->where("id=$orderid")->field('id,pid,name,content,price')->find();
        //var_dump($ProductData);
        //根据该产品找到商铺信息
        $Merchantsid=$ProductData['pid'];
        $MerchantsData=M('Merchants')->where("id=$Merchantsid")->field('id,pid,name,prostatus,prompt')->find();
        //根据商铺id找到餐厅id
        //var_dump($MerchantsData);
        $resid=$MerchantsData['pid'];
        $ProductData['resid']=$resid;
        $ProductData['ordnum']=$ordnum;
        $ProductData['UserResId']=$UserResId;
        $this->assign(MerchantsData,$MerchantsData);
        $this->assign(ordnum,$ordnum);
        $this->assign(data,$ProductData);
        $this->display();
      }
      //该预支付是第一次生成订单时的
     public function pre_pay(){
        $orderid=session('orderid');
        $map['id']=$orderid;
        $Order=M("Order");
        $orderinfo=$Order->where($map)->field('id,ordnum,proname,paymoney')->find();
        $this->assign(data,$orderinfo);
        $this->display();
     }
}