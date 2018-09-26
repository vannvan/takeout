<?php
namespace Doeradmin\Controller;
use Think\Controller;
	class MainController extends BaseController{
	public function index(){
		//磁盘总空间
		$disk_total=disk_total_space("C:")/(1024*1024*1024);
		$disk_total=round($disk_total,3);
		//磁盘剩余空间
	    $disk_free=disk_free_space("C:")/(1024*1024*1024);
	    $disk_free=round($disk_free,3);
	    $sysos = $_SERVER["SERVER_SOFTWARE"];      //获取服务器标识的字串
	    //获取当前ip
	    $adminip = getIP();
	    //获取当前用户登录次数
	    $adminid=session('sysid');
	    $admininfo=M('Admin')->where("sysid=$adminid")->field('sysname,lastlog,logtime,logip,class')->find();
	    session('adminclass',$admininfo['class']);//管理员级别存入session
	    $data['total'] = $disk_total;
	    $data['free'] = $disk_free;
	    $data['sysos']=$sysos;
	    $data['ip']=$adminip;
	    $data['logtime']=$logtime;
	    //统计当日新增用户
	    $cur_date = strtotime(date('Y-m-d'));//今天
		$countuser=M("Userinfo")->where("addtime >= '{$cur_date}'")->count('id');//用户
		$countorder=M("Order")->where("addtime >= '{$cur_date}'")->count('id');//订单
		$countfee=M("Feedback")->where("addtime >= '{$cur_date}'")->count('id');//反馈
		$counttake=M("takeout")->where("addtime >= '{$cur_date}'")->count('id');//提现
		$countrechar=M("recharge")->where("addtime >= '{$cur_date}'")->count('id');//充值
		$countme=M("merchants")->where("status=-1")->count('id');//已删除店铺
		$countpro=M("Product")->where("status=-1")->count('id');//已删除商品
		$countorder1=M("Order")->where("status=-1")->count('id');//已删除订单
		$countmessage=M("message")->where("status=-1")->count('id');//已删除消息
		$data['countuser']=$countuser;
		$data['countorder']=$countorder;
		$data['countfee']=$countfee;
		$data['countme']=$countme;
		$data['countpro']=$countpro;
		$data['countorder1']=$countorder1;
		$data['countmessage']=$countmessage;
		$data['counttake']=$counttake;
		$data['countrechar']=$countrechar;
		$this->assign('admin',$admininfo);
	    $this->assign('data',$data);
	    $this->display();  
	}
}