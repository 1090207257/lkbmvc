<?php
namespace Common\Common;
use Common\Common\db_singleton;
if( !defined('LKB_ROOT')) exit('No direct script access allowed');
/*
**author lkb
**class 生产数据库处理的工厂类
*/
	class db_factory 
	{
		public $result = null;//存储query之后的返回值
		public $conn = null; //存储一个原生的mysqli对象
		public function __construct(){
			$this->init();
		}
		//初始化一个数据库连接
		public function init(){
			if($this->conn == null){
				$this->conn = db_singleton::get_db_con();
				$this->conn->query("set names 'utf8'"); //防止中文乱码
			}
		}
		//数据库查询query方法，返回当前对象
		public function query($sql){
			if($this->conn == null){
				$this->init();
			}
			$this->result = null;
			$this->result = $this->conn->query($sql);
			if($this->conn->error != ""){
				echo $this->conn->error;
				die();
			}
			return $this;
		}
		//获取返回数据，关联数组形式
		public function result_array(){
			if($this->result == null){
				return array();
			}
			$res = array();
			while($row = $this->result->fetch_assoc()){
				$res[] = $row;
			}
			return $res;
		}
		//获取返回的第一条数据，关联数组形式
		public function result_array_one(){
			if($this->result == null){
				return array();
			}
			return $this->result->fetch_assoc();
		}
		//获取返回数据，索引数组形式
		public function result_array_index(){
			if($this->result == null){
				return array();
			}
			$res = array();
			while($row = $this->result->fetch_row()){
				$res[] = $row;
			}
			return $res;
		}
		//获取返回数据，对象形式
		public function result_object(){
			if($this->result == null){
				return array();
			}
			$res = array();
			while($row = $this->result->fetch_object()){
				$res[] = $row;
			}
			return $res;
		}
		//返回影响的条数
		public function affected_rows(){
			if($this->conn == null){
				return 0;
			}
			return $this->conn->affected_rows;
		}
		//返回insert插入的id
		public function insert_id(){
			if($this->conn == null){
				return 0;
			}
			return $this->conn->insert_id;
		}
		//内置方法，用于数据库增加一条数据
		public function insert($table,$data){
			$fields = "";
			$values = "";
			foreach($data as $key=>$vo){
				$fields .= ",{$key}";  //截取出字段名的字符串
				$values .= ",'{$vo}'";  //截取出数值的字符串
			}
			$fields = ltrim($fields,',');  //去除前面的逗号
			$values = ltrim($values,',');  //去除前面的逗号
			$sql = "INSERT INTO {$table}({$fields}) VALUES({$values})";
			if($this->conn == null){
				$this->init();
			}
			$this->conn->query($sql);
			if($this->conn->error != ""){
				echo $this->conn->error;
				die();
			}
			return $this->conn->insert_id;
		}
		//内置方法，用于数据库修改数据
		public function update($table,$update_data,$where = array()){
			$update_string = "";
			foreach($update_data as $key=>$vo){		//将更新数据变成字符串形式
				$update_string .= ",{$key}='{$vo}'";
			}  
			$update_string = ltrim($update_string,',');  //去掉前面的逗号
			$where_string = "";
			if(!empty($where)){  //where不为空，所以构造where的字符串
				foreach($where as $key=>$vo){
					$where_string.="{$key}='{$vo}' AND ";
				}
				$where_string = rtrim($where_string,' AND ');
			}else{ 			//where为空。直接where 1
				$where_string = "1";
			}
			$sql = "UPDATE {$table} SET {$update_string} WHERE {$where_string}";  //构造sql语句
			// var_dump($sql);exit;
			if($this->conn == null){
				$this->init();
			}
			$this->conn->query($sql);  //执行sql语句
			if($this->conn->error != ""){
				echo $this->conn->error;
				die();
			}
			return $this->conn->affected_rows;
		}
		//内置方法，用于删除数据
		public function delete($table,$where = array()){
			$where_string = "";
			if(!empty($where)){  //where不为空，所以构造where的字符串
				foreach($where as $key=>$vo){
					$where_string.="{$key}='{$vo}' AND ";
				}
				$where_string = rtrim($where_string,' AND ');  //去掉后面的' AND '
			}else{ 			//where为空。直接where 1
				$where_string = "1";
			}
			$sql = "DELETE FROM {$table} WHERE {$where_string}";
			// var_dump($sql);exit;
			if($this->conn == null){
				$this->init();
			}
			$this->conn->query($sql);  //执行sql语句
			if($this->conn->error != ""){
				echo $this->conn->error;
				die();
			}
			return $this->conn->affected_rows;
		}
	}