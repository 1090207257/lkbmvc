<?php if( !defined('LKB_ROOT')) exit('No direct script access allowed');
	$smarty_config['compile_dir'] = LKB_ROOT.'/System/Smarty/templates_c/';
	$smarty_config['config_dir'] = LKB_ROOT.'/System/Smarty/config/';
	$smarty_config['cache_dir'] = LKB_ROOT.'/System/Smarty/cache/';
	return $smarty_config;