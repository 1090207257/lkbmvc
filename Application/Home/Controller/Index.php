<?php 
namespace Home\Controller;
use Common\Controller\Base;
if( !defined('LKB_ROOT')) exit('No direct script access allowed');
	class Index extends Base
	{
		//构造方法，可以不写，不过写的话一定要先调用父类的构造方法
		public function __construct(){
			parent::__construct();
		}
		//加载model范例方法
		public function test_model(){
			$test_model = $this->load_model('test');  //加载model,支持第二个参数，可以加载不同模块下的model
			$res = $test_model->getAllInfo();  //使用model的方法
			var_dump($res);
		}
		//使用内置方法增加数据范例方法
		public function test_insert(){
			$data['username'] = 'test';
			$data['password'] = 'test';
			$insert_id = $this->db->insert('user',$data);
			var_dump($insert_id);
		}
		//使用内置方法修改数据范例方法
		public function test_update(){
			$update['password'] = '6543210';
			$update['age'] = '112';
			$update['username'] = '林';
			$where['id'] = '15';
			$affected_rows = $this->db->update('user',$update,$where);
			var_dump($affected_rows);
		}
		//使用内置方法删除数据范例方法
		public function test_delete(){
			$where['age'] = '112';
			$affected_rows = $this->db->delete('user',$where);
			var_dump($affected_rows); 
		}
		//模拟ajax返回数据范例方法
		public function test_ajax(){
			$id = empty($_GET['id'])?0:$_GET['id'];
			$sql = "SELECT * FROM user WHERE id={$id}";
			$result = $this->db->query($sql);
			$data = $result->result_array_one();
			echo json_encode($data,JSON_UNESCAPED_UNICODE);  //json_encode不转义中文为\u开头的字符串
		}
		//加载配置的范例方法
		public function test_config(){
			$config = $this->load_config('smarty');
			var_dump($config);
		}
		//使用session范例方法
		public function test_session(){
			session('name','lkb');
			session('name2','lkb2');
			var_dump(session());
		}
		//使用redirect范例方法
		public function test_redirect(){
			// var_dump(get_url('need?id=1234'));exit;
			redirect('test?id=3'); //支持不同的模块,不同控制器下的不同方法，如'Admin/Index/home'
		}
		public function test(){
			echo $_GET['id'];
		}
		//测试smarty模板
		public function test_smarty(){
			$this->assign('name','lkb');
			$this->display('/haha/hahaha/');  //可以加载不同控制器下的模板，默认是加载本控制器本方法的模板
		}
	}