<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'shop',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '134281',          // 密码
	'COO_KIE'					=>'as24^$fd9od',
    //调试设置
    'SHOW_PAGE_TRACE'=>true,
    //开启路由
    'URL_ROUTER_ON' => true,
    //  允许访问的模块列表
    'MODULE_ALLOW_LIST' => array('Home','Admin'),
//默认访问home模块
    'DEFAULT_MODULE' => 'Home',
    'DEFAULT_MODULE'        =>  'Home',
    // 默认模块
    //'DEFAULT_CONTROLLER'    =>  'Index',
    // // 默认控制器名称

    //'DEFAULT_ACTION'        =>  'index',

);
