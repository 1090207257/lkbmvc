<?php  if ( ! defined('LKB_ROOT')) exit('No direct script access allowed');
	$request = $_SERVER['PATH_INFO'];  //拿到参数
	// var_dump($_SERVER);exit;
	if($request == ""){   //如果没有带参数就默认跳到Home/Index/index
		$request = "Home/Index/index.html";
	}
	$ze = '/^\/([a-zA-Z0-9])+\/([a-zA-Z0-9])+\/([a-zA-Z0-9])+/';  //正则匹配是否至少有3个字符串（模块/控制器/方法）
	if(!preg_match($ze, $request)){
		die("请至少保证存在（模块/控制器/方法）路径");
	}
	$parsed = explode('.', $request);  //把后面的.html去掉
	// var_dump($parsed);
	// echo "<br/>";
	$route = array();
	$route = explode('/',$parsed[0]);  //把参数分离开
	// var_dump($route);exit;

	$file_path = LKB_ROOT.'/Application/'.ucfirst($route[1]).'/Controller/'.ucfirst($route[2]).'.php';
	// var_dump($file_path);
	if(file_exists($file_path)){
		include_once($file_path);
		$class = ucfirst($route[1])."\\Controller\\".ucfirst($route[2]);
		if(class_exists($class)){
			include_once(LKB_ROOT.'/Application/Common/functions.php'); //加载函数库
			$method = $route[3];
			define('MODULE', ucfirst($route[1]));
			define('CONTROLLER', ucfirst($route[2]));
			define('METHOD', $method);
			$controller = new $class();
			if(is_callable(array($controller,$method))){
				$controller->$method();  
			}else{
				die("不存在此方法");
			}
		}else{
			die("请保证类名命名正确");
		}
	}else{
		die("不存在此控制器");
	}
