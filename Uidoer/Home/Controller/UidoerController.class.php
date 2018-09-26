<?php
namespace Home\Controller;
use Think\Controller;
class UidoerController extends BaseController {
    public function index(){
    	//先查询banner库
    	$Banner=M('Banner');
    	$map['status']=array('eq',1);
    	//思路：将数据表中第一条数据的id和image查出来，
    	//视图页单独输出第一列，之后查询的数据再将该列排除
    	$firstid=$Banner->where($map)->getField("id");
    	$firstimg=$Banner->where($map)->getField("image");
    	$map['id']=array('neq',$firstid);
    	$Banner=$Banner->where($map)->order('addtime')->limit(4)->select();
    	$this->assign(first,$firstimg);
    	$this->assign(Banner,$Banner);
    	//查询食堂
    	$Restaurant=M('Restaurant');
    	$Restaurant=$Restaurant->where("status!=-1")->limit(6)->select();
    	//var_dump($Restaurant);
    	$this->assign(Restaurant,$Restaurant);
    	//查询通知
    	$Notice=M("Notice");
        //查询出status为1（已发布）并且限制只能一条
    	$Notice=$Notice->where("status=1")->limit(1)->getField('content');
    	//var_dump($Notice);
    	$this->assign(Notice,$Notice);
    	$this->display();
      }
}