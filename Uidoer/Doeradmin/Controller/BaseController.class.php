<?php
namespace Doeradmin\Controller;
use Think\Controller;
class BaseController extends Controller{
	public function _initialize(){
	        //判断用户是否已经登录
	        if (!isset($_SESSION['Admin']['sysname'])||!isset($_SESSION['Admin']['sysid'])) {
	        	$this->redirect('Index/index');
	            //$this->error('你还没有登陆', U('Index/index'), 3);
	        }
	    }

	    //管理员退出操作
        public function logout(){
        session(null);
        //cookie(null,'Home_');
        $this->redirect('Index/index');
        //$this->success('退出成功',U('Dreamer/index'),1);
     }
	
}