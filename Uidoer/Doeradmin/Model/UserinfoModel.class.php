<?php
namespace Doeradmin\Model;
use Think\Model;
class UserinfoModel extends Model{
	private $_db='';
	public function __construct(){
			$this->_db=M('Userinfo');
	 }
	public function UpdateStatusById($id, $status){
		$data['status']=$status;
		return  $this->_db->where('id="'.$id.'"')->save($data);

	}
	
}