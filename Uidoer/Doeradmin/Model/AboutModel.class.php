<?php
namespace Doeradmin\Model;
use Think\Model;
class AboutModel extends Model{
	private $_db='';
	public function __construct(){
			$this->_db=M('About');
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
	
	public function AlterStatusById($id,$status){
		$data['status']=$status;
		return  $this->_db->where('id="'.$id.'"')->save($data);

	}
	
}