<?php
define("DEBUG", true);
define("LKB_ROOT", __DIR__);
 // var_dump(LKB_ROOT);
Session_Start();  //开启session，系统同时会set了一个PHPSESSID的cookie，用来识别用户
// setcookie('name','lkb',time()+3600,'/');
// $_SESSION['name'] = 'lkb';
// var_dump($_COOKIE);exit;
require_once(LKB_ROOT . '/System/' . 'init.php');
require_once(LKB_ROOT . '/System/' . 'router.php');
