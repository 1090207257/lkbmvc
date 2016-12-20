<?php
    //自定义错误处理函数
	function errorShow($error_level,$error_message,$error_file,$error_line,$error_context){
		if(DEBUG){
			if($error_level>8){  //报错等级比较高才报错
				echo "<br /><b>Error Line[$error_level] :</b> $error_message<br />";
				echo "in file $error_file at line $error_line<br />";
				echo "Ending Script<br />";
				die();
			}
		}else{
			if($error_level>8){  //报错等级比较高才报错
				echo "<b>Error....</b>";
				echo "if get more information,please open the DEBUG in the index.php";
				die();
			}
		}
	}

	//自动加载类的函数
	function __autoload($className){
		$str = str_replace('\\','/',$className);
		$file_path = LKB_ROOT.'/Application/'.$str.'.php';
		if(is_file($file_path)){
			include_once($file_path);
		}
	}

	set_error_handler('errorShow');//自定义错误处理函数
	// mysqli_report(MYSQLI_REPORT_STRICT); //定义mysql报错等级,以抛出异常mysqli_sql_exception的方式替换警告错误。