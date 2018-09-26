<?php
namespace Doeradmin\Controller;
use Think\Controller;
	class IndexController extends Controller{
    public function Code(){
        Code();
        }
    public function index(){
        $this->display();
        }
		public function login(){
		$adminip=get_client_ip();//获取ip方法在commom/function里
    $IpMatchRst=preg_match('/127\.0\.0\.[0-9]+/', $adminip);
		//$IpMatchRst=preg_match($ipmatch,$adminip);//返回值为匹配次数，不匹配则为0
		if($IpMatchRst!=1){
			return show(1,'你没有访问权限，将回到首页！');
		}
    	$sysname=$_POST['sysname'];
    	$password=$_POST['password'];
    	$code=$_POST['code'];
    	if(!trim($sysname)){
    		return show(0,'用户名不能为空');
    	}
    	if(!trim($password)){
    		return show(0,'密码不能为空');
    	}
    	$rst=D('Admin')->getAdminBysysname($sysname);
  		if(!$rst){
  			return show(0,'管理员不存在');
 		}
 		  $errortime=$rst['errortime'];//查询密码已错误次数
	 		if($errortime>=3){
	 			return show(1,'密码错误次数已达上限，你已被禁！');
	 		}
 		if($rst['password']!=md5($password)){
 			M('Admin')->where('sysname="'.$sysname.'"')->setInc('errortime');//登陆次数加1
  			return show(0,'密码错误');	
  		}
  		if(!check_code($code)){
  			return show(0,'验证码错误');
  			session('code',null);
  		}
  		if($rst['status']==0){
  			return show(0,'你已被禁！');
  		}else{
  			session('sysname',$rst['sysname']);
  			session('sysid',$rst['sysid']);
        session('lastlog',$rst['lastlog']);//获取上次登录时间
  			$data=array(
  				'lastlog'=>time(),
  				'logip'=>$adminip,
  				'errortime'=>'0',
  			);
  			//$data['errortime']='0';
  			M('Admin')->where('sysname="'.$sysname.'"')->setInc('logtime');//登陆次数加1
  			M('Admin')->where('sysname="'.$sysname.'"')->save($data);   // 更新本次登陆数据
  			return show(2,'登陆成功！');
			//$this->redirect('Main/index');
  		}
       }
        
	}