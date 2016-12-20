<?php 
namespace Admin\Controller;
use Common\Controller\Base;
if( !defined('LKB_ROOT')) exit('No direct script access allowed');
	class Index extends Base
	{
		//构造方法，可以不写，不过写的话一定要先调用父类的构造方法
		public function __construct(){
			parent::__construct();
		}
		
	}