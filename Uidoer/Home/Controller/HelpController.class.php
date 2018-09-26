<?php
namespace Home\Controller;
use Think\Controller;
class HelpController extends Controller {
    public function index(){
    	$Help=M('Help');
        $map['status']=array('neq',-1);
    	$data=$Help->where($map)->order('addtime')->select();
    	$this->assign(data,$data);
    	$this->display();
      }
    public function methods(){
    	$id=$_GET['id'];
    	$data=M('Help')->where("id=$id")->find();
    	//var_dump($data);
    	$this->assign(data,$data);
    	$this->display();
    }
}