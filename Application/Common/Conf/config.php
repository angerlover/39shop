<?php
return array(
    //'配置项'=>'配置值'
//    'DEFAULT_MODULE'=>'Admin',
//    'MODULE_ALLOW_LIST'=>array('Admin','Home','Gii'), // 别忘了Gii
    'SHOW_PAGE_TRACE'=>true,
	//'配置项'=>'配置值'
	'DB_TYPE' =>  'pdo',     // mysql,mysqli,pdo
	'DB_DSN'    => 'mysql:host=localhost;dbname=39shop;charset=utf8',
	'DB_HOST'               =>  'localhost', // 服务器地址
	'DB_NAME'               =>  '39shop',          // 数据库名
	'DB_USER'               =>  'root',      // 用户名
	'DB_PWD'                =>  'root',          // 密码
	'DB_PORT'               =>  '3306',        // 端口
	'DB_PREFIX'             =>  'p39_',    // 数据库表前缀
	'DEFAULT_FILTER'        => 'trim,htmlspecialchars',
    // 上传图片
    'IMAGE_CONFIG'=>array(
        'ext'      => array('jpg', 'jpeg', 'png', 'gif'),
        'maxSize'  => 1024*1024,
        'rootPath' =>'./Public/Upload/', // 上传路径
        'viewPath' => '/Public/Upload/'  // html显示路径
    ),
);