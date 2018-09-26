<?php
namespace Doeradmin\Model;
use Think\Model;
class HelpModel extends Model{
	private $_db='';
	public function __construct(){
			$this->_db=M('Help');
	 }
	//通过sysname获取用户信息,数组
	public function getAdminBysysname($sysname){
		$rst=$this->_db->where('sysname="'.$sysname.'"')->find();
		return $rst;
	}
	public function UpdateStatusById($id, $status){
		$data['status']=$status;
		return  $this->_db->where('id="'.$id.'"')->save($data);

	}	
}