<?php 
	//微信登陆接口的使用
	function Check(){
		if(!session("?userOpenid")){
			$data=getOpenid();
			session('userOpenid',$data);
		}else{
			$data=session('userOpenid');
		}
		$model=M("Userinfo");
		if($rst=$model->where("openid='{$data}'")->select()){
			session('openid',$rst[0]);
			return true;
		}else{
			//设置临时变量
			if(!session("?status")){
				unset($_GET['code']);
				session("status","1");
			}
			//获取用户所以信息
			getUserInfo();
		}
	}

	//获取用户openid
	function getOpenid(){
		if(!$_GET['code']){
			//获取当前的url地址
			$rUrl= urlEncode(_URL_.__ACTION__.'.html');
			$url="https://open.weixin.qq.com/connect/oauth2/authorize?appid="._APPID_."&redirect_uri=".$rUrl."&response_type=code&scope=snsapi_base&state=123456#wechat_redirect";
			//跳转页面
			redirect($url,0);
		}else{
			$aUrl="https://api.weixin.qq.com/sns/oauth2/access_token?appid="._APPID_."&secret="._APPSECRET_."&code=".$_GET['code']."&grant_type=authorization_code";
			//获取网页授权access_token和openid等
			$data=gettoken($aUrl);
			return $data['openid'];
		}
	}

	//获取用户详细信息
	function getUserInfo(){
		if(!$_GET['code']){
			//获取当前的url地址
			$rUrl=urlEncode(_URL_.__ACTION__.'.html');
			$url="https://open.weixin.qq.com/connect/oauth2/authorize?appid="._APPID_."&redirect_uri=".$rUrl."&response_type=code&scope=snsapi_userinfo&state=123456#wechat_redirect";
			//跳转页面
			redirect($url,0);
		}else{
			$getOpenidUrl="https://api.weixin.qq.com/sns/oauth2/access_token?appid="._APPID_."&secret="._APPSECRET_."&code=".$_GET['code']."&grant_type=authorization_code";
			//获取网页授权access_token和openid等
			$data=json_decode(gettoken($getOpenidUrl),true);
			//var_dump($data['openid']);
			$getUserInfoUrl="https://api.weixin.qq.com/sns/userinfo?access_token=".$data['access_token']."&openid=".$data['openid']."&lang=zh_CN";
			//获取用户数据，将json转换为数组
			$userInfo=json_decode(gettoken($getUserInfoUrl),true);
			//默认设置头像是960*960,此处截取链接最后一个字符0改为132即可成为132*132
			$userInfo['headimgurl']=substr($userInfo['headimgurl'],0,strlen($userInfo['headimgurl'])-1);
			$userInfo['headimgurl']=$userInfo['headimgurl'].'132';
			//var_dump($userInfo['userheadimg']);
			//删除不用的元素
			unset($userInfo['language']);
			unset($userInfo['country']);
			unset($userInfo['province']);
			$data=$userInfo;
			//var_dump($data);
			// 将信息插入数据库
			$data['addtime']=time();
			$userInfo=M('Userinfo');//实例化数据表
			$openid=$data['openid'];//获取当前openid
			$condition['openid']=$openid;
			//session无法永久保存用户的openid，此处需要查询当前用户的信息（以nickname为例）是否存在，如果存在，执行save方法，不存在则添加
			$nickname=M('Userinfo')->where($condition)->getField('nickname');
			if($nickname){
				$rst=$userInfo->where($condition)->save($data);
				session('openid',$data['openid']);
			}
			else if($rst=$userInfo->data($data)->add()){
				//获取当前id
				session('openid',$data['openid']);
			 	session('nickname',$data['nickname']);
			  	session('sex',$data['sex']);
			  	session('headimgurl',$data['headimgurl']);
			 	session('id',$rst);//当前id
				session("status",null);
				//var_dump($_SESSION);
			}else{
				echo "验证错误";
			}
		}
	}
	//curl方法
	function gettoken($url){ 
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_HEADER, 0);//输出远程服务器的header信息 
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36 SE 2.X MetaSr 1.0');
	curl_setopt($ch, CURLOPT_ENCODING,'gzip');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
	$output=curl_exec($ch);
	curl_close($ch); 
	return $output;
	}
	
	//ajax的json数据返回方法,$status:状态，$message:返回信息
	function show($status,$message,$data){
		$result=array(
			'status'=>$status,
			'message'=>$message,
			'data'=>$data,
		);
		exit(json_encode($result));
	}

	function getsex($sex){
		if($sex==1){
			return '老铁';
		}elseif($sex==2) {
			return '妹纸';
		}else{
			return '江湖人';
		}
	}

	function getdormitory($dormitory){
		if($dormitory==null){
			return '谜一样';
		}else{
			return $dormitory;
		}
	}
	//用户备注信息
	function getnote($note){
		if($note==null){
			return '无备注信息';
		}else{
			return $note;
		}
	}	
	//加钱速达
	function getquiksend($quiksend){
		if($quiksend==0){
			return '非加钱速达';
		}else{
			return $quiksend;
		}
	}
	//订单状态
	function getOrderStatus($status){
		switch($status){
			case "0":
				return "待付款";
				break;
			case "1":
				return "待接单";
				break;
			case "2":
				return "派送中";
				break;
			case "3":
				return "已完成";
				break;
			case "-2":
				return "已完成";
				break;
			case "-1":
				return "待退款";
				break;
		}
	}
	//生成订单号//太复杂 但是很好
	function create_guid($parameter = '')
	{
	$guid = '';
	$uid = uniqid("", true);
	$data = strlen(trim($parameter)) > 0 ? $parameter : time();
	$data .= $_SERVER['REQUEST_TIME'];
	$data .= $_SERVER['HTTP_USER_AGENT'];
	$data .= $_SERVER['LOCAL_ADDR'];
	$data .= $_SERVER['LOCAL_PORT'];
	$data .= $_SERVER['REMOTE_ADDR'];
	$data .= $_SERVER['REMOTE_PORT'];
	$hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
	$guid = substr($hash, 0, 8) . '-' . substr($hash, 8, 4) . '-' . substr($hash, 12, 4) . '-' . substr($hash, 16, 4) . '-' . substr($hash, 20, 12);
	return $guid;
	}

	function build_order_no(){
        $no = date('YmdHi').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 7);//7是随机数的位数
        //检测是否存在
        $db = M('Order');
        $info = $db->where(array('ordnum'=>$no))->find();
        (!empty($info)) && $no = $this->build_order_no();
        return $no;
    }

    
     //分页类方法，前台和后台不一样
	function getpage($count, $pagesize = 10) {
	  $p = new Think\Page($count, $pagesize);
	  //$p->setConfig('header', '<i class="rows">共<b>%TOTAL_ROW%</b>条记录 第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</i>');
	  $p->setConfig('prev', '<span class="glyphicon glyphicon-chevron-left page-prev"></span>');
	  $p->setConfig('next', '<span class="glyphicon glyphicon-chevron-right page-next"></span>');
	  $p->setConfig('last', '尾页');
	  $p->setConfig('first', '首页');
	 // $p->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
	  $p->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%');
	  //$p->setConfig('theme', '<ul class="pagination"><li>%FIRST%</li><li>%UP_PAGE%</li><li>%LINK_PAGE%</li><li>%DOWN_PAGE%</li><li>%END%</li></ul>');
	  $p->lastSuffix = false;//最后一页不显示为总页数
	  return $p;
	}


	//两日期做差得出相隔天数
	function diffBetweenTwoDays ($day1, $day2)
		{
		  $second1 = strtotime($day1);
		  $second2 = strtotime($day2); 
		  if ($second1 < $second2) {
		    $tmp = $second2;
		    $second2 = $second1;
		    $second1 = $tmp;
		  }
		  return ($second1 - $second2) / 86400;
		}
		/**
	 * 使用curl获取远程数据
	 * @param  string $url url连接
	 * @return string      获取到的数据
	 */
	function curl_get_contents($url){
	    $ch=curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);                //设置访问的url地址
	    // curl_setopt($ch,CURLOPT_HEADER,1);               //是否显示头部信息
	    curl_setopt($ch, CURLOPT_TIMEOUT, 5);               //设置超时
	    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);   //用户访问代理 User-Agent
	    curl_setopt($ch, CURLOPT_REFERER,$_SERVER['HTTP_HOST']);        //设置 referer
	    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);          //跟踪301
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //返回结果
	    $r=curl_exec($ch);
	    curl_close($ch);
	    return $r;
	}


	  //获取微信access_token
	 function getaccess_token(){
	    //appid与appsecret改成你自己的
	    $appid = 'wx5708b2e2bb7e07c7';
	    $appsecret = '918707fb2d349dbff141843eac11c4ab';
	    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
	    $data = curl_exec($ch);
	    curl_close($ch);
	    $data = json_decode($data,true);
	    //var_dump($data);
	    return $data['access_token'];
	 }