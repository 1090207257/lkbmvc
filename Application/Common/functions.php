<?php
	function test()
	{
		echo "111";
	}
	//session函数,第一个参数为key。第二个参数传值为赋值
	function session($key,$value)
	{
		$vars = get_defined_vars();//获取当前所有设置的变量及值，由于变量的生命周期，所以最多只有key和value两个变量
		/*****
		if(array_key_exists('key',$vars) && isset($key) && strpos($key, '*')===0){  //传了key并且存在通配符*在最前面的情况
			$like_key = substr($key,1);

		}
		if(array_key_exists('key',$vars) && isset($key) && strpos($key, '*')===(strlen($key)-1) ){  //传了key并且存在通配符*在最后面的情况
			$like_key = substr($key,0,strlen($key)-1);
		}
		******/
		if(!array_key_exists('key',$vars) && !isset($key)){   //没有传key，那就可以判断是拿全部session
			return $_SESSION;
		}else{	//传了key
			if(!array_key_exists('value',$vars) && !isset($value)){  //没有传value，就是要返回对应key的值
				if(isset($_SESSION[$key])){
					return $_SESSION[$key];
				}else{
					return null;
				}
			}else if(array_key_exists('value',$vars) && !isset($value)){  //value传了null
				if(isset($_SESSION[$key])){
					unset($_SESSION[$key]);
					return;
				}
			}else{  //设置对应的key的值为value
				$_SESSION[$key] = $value;
				return;
			}
		}
		return;
	}
	//获取URL的字符串形式
	function get_url($uri = '')
	{
		$param = explode('?', $uri);  //分离get的参数
		$input_arr = explode('/', $param[0]);  //将模块，控制器，方法什么的都分离出来
		$input_arr = array_filter($input_arr); //去掉数组空值
		$request_uri_arr = explode('?',$_SERVER['REQUEST_URI']);  //只取问号前面部分 $request_uri_arr[0]
		$old_uri_arr = array_filter(explode('/', $request_uri_arr[0]));
		$new_request_uri = "";
		$i = 1;
		foreach($old_uri_arr as $vo){
			if($i<=(count($old_uri_arr)-count($input_arr))){
				$new_request_uri .='/'.$vo;
			}
			$i++;
		}
		foreach($input_arr as $vo){
			$new_request_uri .='/'.$vo;
		}
		if(!empty($param[1])){
			$new_request_uri .='?'.$param[1];
		}

		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = $protocol.$_SERVER['HTTP_HOST'].$new_request_uri;
		return $url;
	}

	//跳转链接
	function redirect($uri = '', $http_response_code = 302)
	{
		if(strpos($uri,'http://')!==0 && strpos($uri,'https://')!==0){
			$uri = get_url($uri);
		}
		header("Location: ".$uri, TRUE, $http_response_code);
		exit;
	}
