<?php
	//结合ajax返回值
	function show($status,$message,$data=[]){
		$result=array(
			'status'=>$status,
			'message'=>$message,
			'data'=>$data,
		);
		exit(json_encode($result));
	}
	function getstatus($status){
		return $status==1?'<b style="color:#008a00">已发布</b>':'<b style="color:#f00">未发布</b>';
	}

	function getrestatus($status){
		return $status==1?'<b style="color:#008a00">已回复</b>':'<b style="color:#f00">未回复</b>';
	}
	function getstatus1($restatus){
		return $restatus==1?'<b style="color:#008a00">已查看</b>':'<b style="color:#f00">未查看</b>';
	}
	function getsex($sex){
		if($sex==1){
			return '男';
		}elseif($sex==2) {
			return '女';
		}else{
			return '未知';
		}
	}
	//是否充值用户
	function getusercate($category){
		return $category==1?'<b style="color:#008a00">是</b>':'<b style="color:#f00">否</b>';
	}
	//加钱速达
	function getquiksend($quiksend){
		if($quiksend==0){
			return '<b style="color:#f00">非加急</b>';
		}else{
			return $quiksend;
		}
	}
	//订单状态
    function getOrderStatus($status){
        switch($status){
            case "0":
                return '<b style="color:#f00">待付款</b>';
                break;
            case "1":
                return '<b style="color:#ff3451">待接单</b>';
                break;
            case "2":
                return '<b style="color:#008a00">派送中</b>';
                break;
            case "3":
                return '<b style="color:#008a00">已完成</b>';
                break;
            case "-2":
                return '<b style="color:#008a00">已完成</b>';
                break;
            case "-3":
                return '<b style="color:#008a00">已完成</b>';
                break;
            case "-1":
                return '<b style="color:#ff3451">待退款</b>';
                break;
        }
    }
	//管理员级别
	function getclass($class){
		return $class==1?'<b>超级管理员</b>':'普通管理员';
	}
	
	function getcate($cate){
		return $cate==1?'<b style="color:#008a00">反馈回复</b>':'<b style="color:#f00">系统信息</b>';
	}
	//分页类方法
	function getpage($count, $pagesize = 10) {
	  $p = new Think\Page($count, $pagesize);
	  $p->setConfig('header', '<i class="rows">共<b>%TOTAL_ROW%</b>条记录 第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</i>');
	  $p->setConfig('prev', '上一页');
	  $p->setConfig('next', '下一页');
	  $p->setConfig('last', '末页');
	  $p->setConfig('first', '首页');
	  $p->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
	  $p->lastSuffix = false;//最后一页不显示为总页数
	  return $p;
	}

	function getIP() /*获取客户端IP*/ 
	{ 
	if (@$_SERVER["HTTP_X_FORWARDED_FOR"]) 
	$ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
	else if (@$_SERVER["HTTP_CLIENT_IP"]) 
	$ip = $_SERVER["HTTP_CLIENT_IP"]; 
	else if (@$_SERVER["REMOTE_ADDR"]) 
	$ip = $_SERVER["REMOTE_ADDR"]; 
	else if (@getenv("HTTP_X_FORWARDED_FOR")) 
	$ip = getenv("HTTP_X_FORWARDED_FOR"); 
	else if (@getenv("HTTP_CLIENT_IP")) 
	$ip = getenv("HTTP_CLIENT_IP"); 
	else if (@getenv("REMOTE_ADDR")) 
	$ip = getenv("REMOTE_ADDR"); 
	else 
	$ip = "Unknown"; 
	return $ip; 
	} 