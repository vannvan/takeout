<?php
namespace Doeradmin\Model;
use Think\Model;
class FeedbackModel extends Model{
	private $_db='';
	public function __construct(){
			$this->_db=M('Feedback');
	 }
	public function UpdateStatusById($id, $status){
		$data['status']=$status;
		return  $this->_db->where('id="'.$id.'"')->save($data);

	}

	public function UpdateRestatusById($id, $restatus){
		$data['restatus']=$restatus;
		return  $this->_db->where('id="'.$id.'"')->save($data);

	}
}