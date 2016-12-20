<?php
namespace Common\Common;
	//数据库单例
	class db_singleton
	{
		private static $conn = null;
		public static function get_db_con(){
			$db_config = require(LKB_ROOT.'/Config/Db.php');
			if(self::$conn == null){
				self::$conn = new \mysqli($db_config['host'],$db_config['user'],$db_config['password'],$db_config['database']);
				if (mysqli_connect_errno()){
					die('Unable to connect database!'.mysqli_connect_error());
				}
			}
			return self::$conn;
		}
	}