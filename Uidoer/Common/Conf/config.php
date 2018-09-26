<?php
return array(
	'URL_ROUTER_ON'   => true, //开启路由
	'DEFAULT_V_LAYER' =>  'Course', // 默认的视图层名称
	//'APP_USE_NAMESPACE'  =>    false,//不适用命名空间
	'DEFAULT_MODULE'        => 'Home', // 默认模块名称
	'MODULE_ALLOW_LIST' => array('Home','Doeradmin'),//此项特别重要允许访问这两个模块
	'URL_MODEL'       =>  2, //url模式
	'URL_CASE_INSENSITIVE'  =>  true,//不区分大小写
    //数据库配置
    'DB_TYPE'   => 'mysqli',           //数据库类型
    'DB_HOST' => 'localhost',       //数据库主机地址
    'DB_NAME' => 'uidoer',       //数据库名称
    'DB_USER' => 'root',           //数据库用户名
    'DB_PWD' => 'sewen744926',   //数据库用户密码
    'DB_PORT' => '3306',              //数据库端口
    'DB_PREFIX' => 'ui_',    //数据库表前缀
    'DB_CHARSET'=> 'utf8',          //数据库编码方式
    'DB_DEBUG' => TRUE,            //数据库调试模式 开启后可记录SQL日志
);
