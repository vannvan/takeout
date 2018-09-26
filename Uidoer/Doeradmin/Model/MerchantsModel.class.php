<?php
namespace Doeradmin\Model;
use Think\Model;
class MerchantsModel extends Model{
	private $_db='';
	public function __construct(){
			$this->_db=M('Merchants');
	 }
	public function UpdateStatusById($id, $status){
		$data['status']=$status;
		return  $this->_db->where('id="'.$id.'"')->save($data);

	}

	public function UpdateRecomById($id, $recom){
		$data['recommend']=$recom;
		return  $this->_db->where('id="'.$id.'"')->save($data);

	}

	public function GetPidByid($id){
		return $this->_db->where('id="'.$id.'"')->getField('pid');
	}
	
}