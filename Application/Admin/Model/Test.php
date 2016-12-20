<?php 
namespace Home\Model;
use Common\Model\Base;
if( !defined('LKB_ROOT')) exit('No direct script access allowed');

	class Test extends Base
	{
		public function getAllInfo(){
			$sql = "select * from user";
			$result = $this->db->query($sql);
			$arr = $result->result_array();
			return $arr;
		}
	}