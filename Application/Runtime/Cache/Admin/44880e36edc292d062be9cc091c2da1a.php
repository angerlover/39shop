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
    <!--搜索表单-->
    <form action="/index.php/Admin/Goods/showlist" name="searchForm" method="get">
        <p>
            <?php $catid = I('get.catid');?>
            分类:
            <select  name="catid">
                <option value="">请选择</option>
                <?php foreach ($catData as $k =>$v):?>
                <?php if($v['id']==$catid) $select = 'selected="selected"'; else $select = ''; ?>
                <option <?php echo $select;?> value="<?php echo $v['id'];?>"><?php echo str_repeat('-',8*$v['level']).$v['cat_name']?></option>
                <?php endforeach;?>
            </select>
        </p>
        <p>
            <!--解决提交搜索后表单空白的问题-->
            品牌名称:
            <?php buildSelect('brand','brand_id','id','brand_name',I('get.brand_id'));?>
        </p>
        <p>
            <!--解决提交搜索后表单空白的问题-->
            商品名称:<input type="text" value="<?php echo I('get.gn') ?>" size="60" name="gn">
        </p>
        <p>
            价格
            从:<input type="text"  name="fp" value=<?php echo I('get.fp') ?>>
            到:<input type="text"  name="tp" value=<?php echo I('get.tp') ?>>
        </p>
        <p>
            是否上架
            <?php $ios = I('get.ios')?>
            <input type="radio"  name="ios" value="" <?php if($ios =='' ) echo 'checked="checked"'; ?>>全部
            <input type="radio" value="是" name="ios" <?php if($ios =='是' ) echo 'checked="checked"'; ?>>上架
            <input type="radio"  value="否" name="ios" <?php if($ios =='否' ) echo 'checked="checked"'; ?>>下架
        </p>
        <p>
            添加时间<nbsp></nbsp>
            从:<input id='ft' type="text" name="ft" value=<?php echo I('get.ft') ?>>
            到:<input id='tt' type="text" name="tt" value=<?php echo I('get.tt') ?>>
        </p>

        <!--排序-->
        <p>
            <?php $odby = I('get.odby','id_desc')?>
            <input onclick="this.parentNode.parentNode.submit()" <?php if($odby=='id_desc') echo 'checked="checked"'?> type="radio" name="odby" value="id_desc">以添加时间降序
            <input onclick="this.parentNode.parentNode.submit()" <?php if($odby=='id_asc') echo 'checked="checked"'?> type="radio" name="odby" value="id_asc">以添加时间升序
            <input onclick="this.parentNode.parentNode.submit()" <?php if($odby=='p_desc') echo 'checked="checked"'?> type="radio" name="odby" value="p_desc">以价格降序
            <input onclick="this.parentNode.parentNode.submit()" <?php if($odby=='p_asc') echo 'checked="checked"'?> type="radio" name="odby" value="p_asc">以价格升序
        </p>
        <p>
            <input type="submit" value="搜索">
        </p>
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="/index.php/Admin/Goods/showlist.html" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>id</th>
                <th>主分类</th>
                <th>扩展分类</th>
                <th>品牌名称</th>
                <th>商品名称</th>
                <th>市场价格</th>
                <th>本店价格</th>
                <th>是否上架</th>
                <th>添加时间</th>
                <th>logo</th>
                <th>操作</th>
            </tr>
            <?php foreach($data as $k => $v):?>
            <tr class="tron">
                <td align="center"><?php echo $v['id']?></td>
                <td align="center"><?php echo $v['cat_name']?></td>
                <td align="center"><?php echo $v['ext_cat_name']?></td>
                <td align="center"><?php echo $v['brand_name'];?></td>
                <td align="center" class="first-cell"><span><?php echo $v['goods_name']?></span></td>
                <td align="center"><span onclick=""><?php echo $v['market_price']?></span></td>
                <td align="center"><span><?php echo $v['shop_price']?></span></td>
                <td align="center"><span><?php echo $v['is_on_sale']?></span></td>
                <td align="center"><span><?php echo $v['addtime']?></span></td>
                <td align="center"><span><?php if($v['mid_logo']):showImage($v['mid_logo'])?> <?php endif;?></span></td>
                <td>
                    <a href="<?php echo U('goods_number?id='.$v['id']);?>">库存量</a>
                    <a href="<?php echo U('edit?goods_id='.$v['id']);?>">修改</a>&nbsp;
                    &nbsp;
                    <a  onclick="return confirm('确定删除吗')" href="<?php echo U('delete?id='.$v['id']);?>" >删除</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    <!-- 分页开始 -->
        <table id="page-table" cellspacing="0">
            <tr>
                <td width="80%">&nbsp;</td>
                <td align="center" nowrap="true">
                   <?php echo $pageString;?>
                </td>
            </tr>
        </table>
    <!-- 分页结束 -->
    </div>
</form>



<!-- 引入时间插件 -->
<script type="text/javascript" src="/Public/datetimepicker/jquery-1.7.2.min.js"></script>
<link href="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/datepicker-zh_cn.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.css" />
<script type="text/javascript" src="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="/Public/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>

<script>
    // 添加时间插件
    $.timepicker.setDefaults($.timepicker.regional['zh-CN']);  // 设置使用中文
    console.log('草泥马')
    $("#ft").datetimepicker();
    $("#tt").datetimepicker();
</script>
<!--表格换行显示不同颜色-->
<script type="text/javascript" src="/Public/Admin/Js/tron.js"></script>

<div id="footer"> 39shop </div>
</body>
</html>