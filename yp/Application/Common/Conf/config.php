<?php
return array(
	//'配置项'=>'配置值'

	//URL地址不区分大小写
	'URL_CASE_INSENSITIVE' => true,

	'LOAD_EXT_CONFIG' => 'imysql',
	'MD5_PRE' => 'sunchao',

	'SHOW_PAGE_TRACE' => false,
	'DEFAULT_MODULE' => 'Home',
	'TMPL_ACTION_SUCCESS' => 'Public:dispatch_jump',
	'TMPL_ACTION_ERROR' => 'Public:dispatch_jump',
);