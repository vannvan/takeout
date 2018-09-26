<?php
//公众号授权域名
define("_URL_","");
//这里填入你公众号的APPID
define("_APPID_","");
//这里填入你公众号的APPSECRET
define('_APPSECRET_','');
return array(
	'URL_ROUTER_ON'   => true, //开启路由
	'URL_PARAMS_BIND'       =>  true, // URL变量绑定到操作方法作为参数
	'DEFAULT_V_LAYER' =>  'Course', // 默认的视图层名称
	//'APP_USE_NAMESPACE'  =>    false,//不适用命名空间
	//'DEFAULT_MODULE'        => 'Dreamer', // 默认模块名称
	'URL_MODEL'       =>  2, //url模式
	'DEFAULT_CONTROLLER'    =>  'Uidoer', // 默认控制器名称
	'URL_CASE_INSENSITIVE'  =>  true,//不区分大小写
	'TMPL_PARSE_STRING' => array(
        '__IMG__'=>__ROOT__.'/'.APP_NAME.'/'.Home.'/Public/img',
        '__CSS__'=>__ROOT__.'/'.APP_NAME.'/'.Home.'/Public/css',
        '__JS__'=>__ROOT__.'/'.APP_NAME.'/'.Home.'/Public/js',
        '__SOURCE__'=>__ROOT__.'/Source',
    ),

    //session前缀
    'SESSION_PREFIX'        =>  'Home', // session 前缀
    'SESSION_OPTIONS'=>array('name'=>'id','expire'=>7200),//session有效时间为两个小时
    'TMPL_ACTION_SUCCESS' =>'Public:dispatch_jump',
	'TMPL_ACTION_ERROR'=> 'Public:dispatch_jump',
    'TMPL_EXCEPTION_FILE'    =>  APP_DEBUG ? THINK_PATH.'Tpl/think_exception.tpl' : 'Public:empty',
	'WEIXINPAY_CONFIG'       => array(
        'APPID'              => '', // 微信支付APPID
        'MCHID'              => '', // 微信支付MCHID 商户收款账号
        'KEY'                => '', // 微信支付KEY
        'APPSECRET'          => '',  //公众帐号secert
        'NOTIFY_URL'         => 'http://www.uidoer.top/Weixinpay/notify', // 接收支付状态的连接
        ),	
);

