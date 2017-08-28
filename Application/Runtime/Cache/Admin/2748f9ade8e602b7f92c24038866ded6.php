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


<!-- 列表 -->
<div class="list-div" id="listDiv">
	<form action="/index.php/Admin/Goods/goods_number/id/106.html" method="post">
	<table cellpadding="3" cellspacing="1">
    	<tr>
			<?php $gaCount = count($gaData);?>
			<?php foreach($gaData as $k=>$v):;?>
            <th><?php echo $k?></th>
			<?php endforeach;?>
            <th >库存量</th>
			<th width="60">操作</th>
        </tr>
		<?php if($gnData):?>
		<!--循环库存量的记录-->
		<?php foreach($gnData as $k0 => $v0):?>
		<tr class="tron">
			<!--循环select-->
			<?php foreach ($gaData as $k => $v):?>
			<td align="center">
				<select name="attr_value[]">
						<option value="">请选择</option>
							<?php foreach($v as $k1=>$v1): $_attr = explode(',',$v0['goods_attr_id']); if(in_array($v1['id'],$_attr)) $select = 'selected="selected"'; else $select = '';?>
								<option <?php echo $select;?> value="<?php echo $v1['id'];?>"><?php echo $v1['attr_value'];?></option><!--存的是商品属性表的id-->
							<?php endforeach;?>
				</select>
			</td>
			<?php endforeach;?>
			<td align="center"><input value="<?php echo $v0['goods_number'];?>" type="text" name="goods_number[]"></td>
			<td><input type="button" value="<?php echo $k0==0?'+':'-';?>" name="" onclick="addNewAttr(this)"></td>
		</tr>
		<?php endforeach;?>
		<?php else:?><!--如果没有设置过库存量 就直接给一行-->
		<tr class="tron">
			<!--循环select-->
			<?php foreach ($gaData as $k => $v):?>
			<td align="center">
				<select name="attr_value[]">
					<option value="">请选择</option>
					<?php foreach($v as $k1=>$v1):?>
					<option  value="<?php echo $v1['id'];?>"><?php echo $v1['attr_value'];?></option><!--存的是商品属性表的id-->
					<?php endforeach;?>
				</select>
			</td>
			<?php endforeach;?>
			<td align="center"><input type="text" name="goods_number[]"></td>
			<td><input type="button" value="<?php echo $k0==0?'+':'-';?>" name="" onclick="addNewAttr(this)"></td>
		</tr>
		<?php endif;?>
		<tr>
			<td id="submit" align="center" colspan="<?php echo $gaCount+2;?>"><input type="submit" value="提交"></td>
		</tr>
		<?php if(preg_match('/\d/', $page)): ?>
        <tr><td align="right" nowrap="true" colspan="99" height="30"><?php echo $page; ?></td></tr> 
        <?php endif; ?> 
	</table>
	</form>
</div>
<script src="/Public/Admin/Js/tron.js"></script>
<script>
	function addNewAttr(a){
        var tr = $(a).parent().parent();
        if($(a).val()=='+'){ // +变-
			tr.find('td').css('backgroundColor','');
            var newAttr = tr.clone();
            newAttr.find(':button').val('-'); // 表单选择器
            $('#submit').parent().before(newAttr);
        }else{
            tr.remove();
		}
    }
</script>

<div id="footer"> 39shop </div>
</body>
</html>