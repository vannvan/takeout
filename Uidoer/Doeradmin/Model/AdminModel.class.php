<?php
namespace Doeradmin\Model;
use \Think\Model;
class AdminModel extends Model{
	private $_db='';
	public function __construct(){
			$this->_db=M('admin');
	 }
	//通过sysname获取用户信息,数组
	public function getAdminBysysname($sysname){
		$rst=$this->_db->where('sysname="'.$sysname.'"')->find();
		return $rst;
	}
	
	
	
	protected $_validate=array(
		//array('name','require','验证码必须！'), 
		array('code','require','验证码必须！'), //默认情况下用正则进行验证
		array('code','checkcode','验证码有误！',1,'callback',1), 
	);
}