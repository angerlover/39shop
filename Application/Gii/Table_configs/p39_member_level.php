<?php
return array(
	'tableName' => 'p39_member_level',    // 表名
	'tableCnName' => '',  // 表的中文名
	'moduleName' => 'Admin',  // 代码生成到的模块
	'withPrivilege' => FALSE,  // 是否生成相应权限的数据
	'topPriName' => '',        // 顶级权限的名称
	'digui' => 0,             // 是否无限级（递归）
	'diguiName' => '',        // 递归时用来显示的字段的名字，如cat_name（分类名称）
	'pk' => 'id',    // 表中主键字段名称
	/********************* 要生成的模型文件中的代码 ******************************/
	// 添加时允许接收的表单中的字段
	'insertFields' => "array('level_name','jifen_bottom','jifen_top')",
	// 修改时允许接收的表单中的字段
	'updateFields' => "array('id','level_name','jifen_bottom','jifen_top')",
	'validate' => "
		array('level_name', 'require', '不能为空！', 1, 'regex', 3),
		array('level_name', '1,30', '的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('jifen_bottom', 'require', '不能为空！', 1, 'regex', 3),
		array('jifen_bottom', 'number', '必须是一个整数！', 1, 'regex', 3),
		array('jifen_top', 'require', '不能为空！', 1, 'regex', 3),
		array('jifen_top', 'number', '必须是一个整数！', 1, 'regex', 3),
	",
	/********************** 表中每个字段信息的配置 ****************************/
	'fields' => array(
		'level_name' => array(
			'text' => '',
			'type' => 'text',
			'default' => '',
		),
		'jifen_bottom' => array(
			'text' => '',
			'type' => 'text',
			'default' => '',
		),
		'jifen_top' => array(
			'text' => '',
			'type' => 'text',
			'default' => '',
		),
	),

);