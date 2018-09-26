<?php
namespace Home\Controller;
use Think\Controller;
class SendmesController extends Controller {
  //设置与发送模板信息
    public function set_msg(){
    //获取access_token
    $access_token = getaccess_token();
    //下面是要填充模板的信息
    $formwork = '{
           "touser":"o1hEn1Sk8wx1ZpXAKm30yyi9dbNY",
           "template_id":"B8oth3e5EPe6yH8LXcPZ6MFejqdGv9U_EgosRZlId1Q",
           "url":"http://www.uidoer.top/Order/index",            
           "data":{
                   "first":{
                       "value":"您在有爱Doer校园外卖的订单已购买成功!",
                       "color":"#173177"
                   },
                   "keyword1": {
                       "value":"3元",
                       "color":"#ff2929"
                   },
                   "keyword2": {
                       "value":"微信支付",
                       "color":"#ff2929"
                   },
                   "remark":{
                       "value":"我们会尽快给您派送，如有疑问，请联系:18329684862",
                       "color":"#ff2929"
                   }
           }
       }';
    $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$access_token}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$formwork);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
    //echo set_msg();
   }

}