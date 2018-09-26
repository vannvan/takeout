<?php
namespace Home\Controller;
use Think\Controller;
class AboutController extends Controller {
    public function index(){
    	$About=M('About');
    	$data=$About->order('addtime')->limit(1)->find();
    	//var_dump($data);
    	$this->assign(data,$data);
    	$this->display();
      }
}