<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ECSHOP 管理中心--<?php echo $_page_title;?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
</head>
<body>
<h1>
    <?php if($_page_btn_name): ?>
    <span class="action-span"><a href="<?php echo $_page_btn_link; ?>"><?php echo $_page_btn_name;?></a>
    </span>
    <?php endif; ?>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心--></a></span>
    <span id="search_id" class="action-span1"> <?php echo $_page_title;?> </span>
    <div style="clear:both"></div>
</h1>

<!--内容-->

<div class="form-div">
</div>

<!-- 商品列表 -->
<form method="post" action="/index.php/Admin/Category/lst.html" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>分类名称</th>
                <th>操作</th>
            </tr>
            <?php foreach($data as $k => $v):?>
            <tr class="tron">
                <td align="left"><?php echo str_repeat('-',8*$v['level']) .$v['cat_name'];?></td>
                <td><a href="<?php echo U('edit?id='.$v['id']);?>">修改</a>&nbsp;&nbsp;<a  onclick="return confirm('确定删除吗')" href="<?php echo U('delete?id='.$v['id']);?>" >删除</a></td>
            </tr>
            <?php endforeach;?>
        </table>

    </div>
</form>

<!--表格换行显示不同颜色-->
<script type="text/javascript" src="/Public/Admin/Js/tron.js"></script>

<div id="footer"> 39shop </div>
</body>
</html>