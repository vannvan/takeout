<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller {
    public function noid(){
    	$this->display();
    }

    public function empty(){
    	$this->display();
    }
}