<?php
namespace Common\Common;
use Common\Common\db_factory;
if( !defined('LKB_ROOT')) exit('No direct script access allowed');
/*
**author lkb
**class 被所有model和controller类继承的最基础的类
*/
	class CommonBase 
	{
		public $db = null;  //存储一个数据库工厂对象db_factory
		public function __construct(){
			$this->CommonBase_init();
		}
		//初始化一个数据库连接
		public function CommonBase_init(){
			if($this->db == null){
				$this->db = new db_factory();
			}
		}
		
	}