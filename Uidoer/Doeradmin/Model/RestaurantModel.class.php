<?php
namespace Doeradmin\Model;
use Think\Model;
class RestaurantModel extends Model{
	private $_db='';
	public function __construct(){
			$this->_db=M('Restaurant');
	 }
	public function UpdateStatusById($id, $status){
		$data['status']=$status;
		return  $this->_db->where('id="'.$id.'"')->save($data);

	}
	
}