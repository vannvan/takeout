<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {
    public function _initialize(){
    	//判断是否验证过
		if((session("?openid")&&session("?sex"))||(session("?openid")&&session("?nickname"))){
			//已验证过
			 if(!session("?id")){
			 	$this->redirect('User/index','',2,"<h1>请先绑定账号再使用,将自动跳转到绑定页面</h1>");
			 }
		}else{
		//进入验证
			Check();
		}
	}
}