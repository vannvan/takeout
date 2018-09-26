<?php
namespace Home\Controller;
use Think\Controller;
class SendcodeController extends Controller {
    public function index(){
    	$this->display();
      }
    public function Getcode($value='')
    {
	$appkey = "*************";//App key
	$secret = "**************";//App Secret:
	import('Org.Taobao.top.TopClient');
	import('Org.Taobao.top.ResultSet');
	import('Org.Taobao.top.RequestCheckUtil');
	import('Org.Taobao.top.TopLogger');
	import('Org.Taobao.top.request.AlibabaAliqinFcSmsNumSendRequest');
	//将需要的类引入，并且将文件名改为原文件名.class.php的形式
	$c = new \TopClient;
	$c->appkey = $appkey;
	$c->secretKey = $secret;
	$req = new \AlibabaAliqinFcSmsNumSendRequest;
	$req->setExtend("123456");//确定发给的是哪个用户，参数为用户id  可选参数
	$req->setSmsType("normal");//normal是固定的
	$code=strval(rand(1000,9999));//生成随机数
	var_dump($code);
	$uidoer='有爱Doer';//有爱doer的固定签名信息
	$_SESSION['code'] = md5($code);//md5加密验证码值并保存到session中
	//var_dump($_SESSION['code']);
	$tel=$_POST['mobile'];
	/*
	进入阿里大鱼的管理中心找到短信签名管理，输入已存在签名的名称，这里是身份验证。
	*/
	$req->setSmsFreeSignName("有爱Doer");//签名目前只能设置一个，必须和阿里大于工单号对应的签名一致
	$req->setSmsParam("{'code':'$code','uidoer':'$uidoer'}"); //设置签名参数对应上面产生的签名变量
	//这里设定的是发送的短信内容：验证码${code}，您正在进行${uideoer}身份验证，打死不要告诉别人哦！”
	$req->setRecNum("$tel");//参数为用户的手机号码
	$req->setSmsTemplateCode("SMS_109370434");//此模板ID为验证手机号码的ID
	$resp = $c->execute($req);
}
}