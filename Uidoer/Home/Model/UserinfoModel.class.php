<?php
namespace Home\Model;
use Think\Model;
class UserinfoModel extends Model{
	protected $_validate = array(
		//空值验证
		array('name', 'require', '姓名不能为空'), 
		array('name','/^[\x7f-\xff]+$/','姓名不符合要求'),//正则验证姓名是否是中文
		array('dormitory', 'require', '宿舍不能为空'), 
		array('resid', 'require', '餐厅不能为空'), 
		array('alipay', 'require', '支付宝账号不能为空'), 
  		array('paypass', 'require', '密码不能为空'),
  		array('repaypass', 'require', '确认密码不能为空'),
  		array('repaypass','paypass','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
  		array('paypass','6,16','密码在6-16位之间',3,'length'), // 验证密码长度
  		array('paypass','/^[A-Za-z0-9]+$/','密码只能为字母和数字'),//正则验证密码
  		array('mobile', 'require', '手机号不能为空'),
  		array('mobile','11','电话长度不符！',3,'length'), // 验证电话号码长度
  		array('code', 'require', '验证码不能为空'),
  		array('dormitory', '3,8', '只支持3-8个字符', 0, 'length'),
  		array('nickname', '1,7', '只支持1-7个字符', 0, 'length'),

		);
	protected $_auto=array(
		//array('paypass','md5','1','function'),//自动为password加密后插入
		//array('lastdate', 'time', 1, 'function'), // 更新登录时间
		//array('regip', 'get_client_ip', 1, 'function'), // 对regip字段在新增的时候写入当前注册ip地址
    );

}