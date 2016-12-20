<?php
namespace Common\Controller;
use Common\Common\CommonBase;
if( !defined('LKB_ROOT')) exit('No direct script access allowed');
/**
* author lkb
* class 所有控制器类都要继承的公共类
*/
	class Base extends CommonBase
	{
		private $smarty = null;

		public function __construct(){
			parent::__construct();
		}
		//加载model的方法,返回一个model对象
		public function load_model($model,$module=""){
			if(empty($module)){  //默认是当前控制器所在的模块
				$class = get_class($this);//获取调用此方法的对象的类名
				$arr = explode('\\', $class);  //用\分开
				$module = $arr[0];  //只获取第一部分,就是什么模块
			}
			$model_class = ucfirst($module).'\\Model\\'.ucfirst($model); //构造model的类名，带命名空间的
			$model_object = new $model_class();  //因为有命名空间和自动加载函数，所以可以自动加载
			if(empty($model_object)){
				return null;
			}else{
				return $model_object;
			}
		}
		//加载配置的方法，配置放在项目根目录的Config下
		public function load_config($config_name){
			if(empty($config_name)){  //默认的配置文件为Common.php，不过建议配置分开写，好区分
				$config_name = 'Common';
			}
			$file = LKB_ROOT.'/Config/'.ucfirst($config_name).'.php';
			if(is_file($file)){
				$config = require($file);
			}else{
				$config = array();
			}
			return $config;

		}

		//初始化smarty配置
		public function smarty_init()
		{

			require_once LKB_ROOT.'/System/Smarty/Smarty.class.php';
			$smarty = new \Smarty();
			$smarty_config = $this->load_config('smarty');
			$smarty->compile_dir = $smarty_config['compile_dir'];  //从配置文件中取
			$smarty->config_dir = $smarty_config['config_dir'];  //从配置文件中取
			$smarty->cache_dir = $smarty_config['cache_dir'];  //从配置文件中取

			$class = get_class($this);// 获取调用此方法的对象的类名
			$arr = explode('\\', $class);  // 用\分开
			$module = $arr[0];  // 只获取第一部分,就是什么模块
			$smarty->template_dir = LKB_ROOT.'/Application/'.ucfirst($module).'/View/';  //模板文件存放在对应模块的View文件中
			$this->smarty = $smarty;
			return $this->smarty;
		}

		//smarty模板的assign方法
		public function assign($key,$value)
		{
			if(empty($this->smarty)){
				$this->smarty_init();
			}
			$this->smarty->assign($key,$value);
		}

		//smarty模板的display方法
		public function display($template='')
		{
			if(empty($this->smarty)){
				$this->smarty_init();
			}
			$module = MODULE;  //模板只能存放在当前模块下
			if(empty($template)){
				$controller = CONTROLLER;
				$method = METHOD;
			}else{
				$arr = explode('/', $template);
				$arr = array_filter($arr);
				$i=0;
				if(count($arr) == 0){
					$controller = CONTROLLER;
					$method = METHOD;
				}else if(count($arr) == 1){
					$controller = CONTROLLER;
					foreach($arr as $vo){
						$method = $vo;
					}
				}else if(count($arr) == 2){
					foreach($arr as $vo){
						if($i == 0){
							$controller = ucfirst($vo);
						}else if($i == 1){
							$method = $vo;
						}
						$i++;
					}
				}else{
					die('模板不存在');
				}
				
			}
			$template_file = LKB_ROOT.'/Application/'.$module.'/View/'.$controller.'/'.$method.'.html';
			if(file_exists($template_file)){
				$this->smarty->display($controller.'/'.$method.'.html');
			}else{
				die('模板不存在');
			}
		}
	}