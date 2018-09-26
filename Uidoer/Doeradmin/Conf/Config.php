<?php
return array(
	'URL_ROUTER_ON'   => true, //开启路由
    'SESSION_PREFIX' => 'Admin',  //session前缀
	'DEFAULT_V_LAYER' =>  'Course', // 默认的视图层名称
	'URL_MODEL'       =>  2, //url模式
	'URL_CASE_INSENSITIVE'  =>  true,//不区分大小写
	'TMPL_PARSE_STRING' => array(
    '__IMG__'=>__ROOT__.'/'.APP_NAME.'/'.Doeradmin.'/Public/img',
    '__CSS__'=>__ROOT__.'/'.APP_NAME.'/'.Doeradmin.'/Public/css',
    '__JS__'=>__ROOT__.'/'.APP_NAME.'/'.Doeradmin.'/Public/js',
    '__LAY__'=>__ROOT__.'/'.APP_NAME.'/'.Doeradmin.'/Public/layui',
    '__UEDITOR__'=>__ROOT__.'/'.APP_NAME.'/'.Doeradmin.'/Course/Public/ueditor',
    '__SOURCE__'=>__ROOT__.'/Source',
    ),
    'TMPL_ACTION_ERROR' =>'Public:dispatch_jump',
    'TMPL_ACTION_SUCCESS' =>'Public:dispatch_jump',
);