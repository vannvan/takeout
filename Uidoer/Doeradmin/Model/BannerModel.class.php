<?php
namespace Doeradmin\Model;
use Think\Model;
class BannerModel extends Model{
	private $_db='';
	public function __construct(){
			$this->_db=M('Banner');
	 }
	public function UpdateStatusById($id, $status){
		$data['status']=$status;
		return  $this->_db->where('id="'.$id.'"')->save($data);

	}
}