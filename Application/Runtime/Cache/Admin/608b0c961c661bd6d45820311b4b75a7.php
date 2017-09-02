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

<style>
    #ul_pic_list li{margin:5px;list-style-type:none;}
    #old_pic_list li{float:left;width:150px;height:150px;margin:5px;list-style-type:none;}
</style>

<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" >通用信息</span>
            <span class="tab-back" >商品描述</span>
            <span class="tab-back" >会员价格</span>
            <span class="tab-back" >商品属性</span>
            <span class="tab-back" >商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/index.php/Admin/Goods/edit/goods_id/112.html" method="post">
            <input type="hidden" name="id" value="<?php echo $data['id'] ;?>" />
            <table class="tab_table" width="90%" id="general-table" align="center">
                <!--通用信息-->
                <tr>
                    <td class="label">主分类</td>
                    <td>
                        <select  name="cat_id">
                            <option value="">请选择</option>
                            <?php foreach ($catData as $k =>$v):?>
                            <?php if($v['id']==$data['cat_id']) $select = 'selected="selected"'; else $select = ''; ?>
                            <option <?php echo $select;?> value="<?php echo $v['id'];?>"><?php echo str_repeat('-',8*$v['level']).$v['cat_name']?></option>
                            <?php endforeach;?>
                        </select>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">扩展分类  <input onclick="$('#cat_list').append($('#cat_list li:eq(0)').clone())" type="button" id="btn_add_cat" value="添加一个"></td>
                    <td>
                        <ul id="cat_list">
                            <?php if($gcData):?>
                            <?php foreach($gcData as $k1=>$v1):?>
                            <li>
                                <select  name="ext_cat_id[]">
                                    <option value="">删除</option>
                                    <?php foreach ($catData as $k =>$v): if($v['id'] == $v1['cat_id']) $select = 'selected="selected"'; else $select = ''; ?>
                                    <option <?php echo $select;?> value="<?php echo $v['id'];?>"><?php echo str_repeat('-',8*$v['level']).$v['cat_name']?></option>
                                    <?php endforeach;?>

                                </select>
                            </li>
                            <?php endforeach;?>
                            <?php else:?>
                                <li>
                                    <select name="ext_cat_id[]">
                                        <option value="">删除</option>
                                        <option  value="<?php echo $v['id'];?>"><?php echo str_repeat('-',8*$v['level']).$v['cat_name']?></option>
                                    </select>
                                </li>
                            <?php endif;?>

                        </ul>
                    </td>
                </tr>
                <tr>
                    <td class="label">品牌名称：</td>
                    <td>
                        <select name="brand_id">
                            <option value="">请选择</option>
                            <?php foreach($brandData as $k=> $v):?>
                            <?php
 if($v['id']==$data['brand_id']) $select = 'selected="selected"'; else $select = ''; ?>
                            <option <?php echo $select;?> value="<?php echo $v['id'];?>" > <?php echo $v['brand_name'];?> </option>
                            <?php endforeach;?>
                        </select>
                        <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value="<?php echo($data['goods_name'])?>"size="30" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="<?php echo($data['shop_price'])?>" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <?php $ios = $data['is_on_sale'];?>
                    <td class="label">是否上架：</td>
                    <td>
                        <input <?php if($ios=='是') echo 'checked="checked"';?> type="radio" name="is_onsale" value="1"/> 是
                        <input <?php if($ios=='否') echo 'checked="checked"';?> type="radio" name="is_onsale" value="0"/> 否
                    </td>
                </tr>

                <tr>
                    <?php $is_new = $data['is_new'];?>
                    <td class="label">是否新品：</td>
                    <td>
                        <input type="radio" name="is_new" value="是" <?php if($is_new=='是') echo 'checked="checked"';?> /> 是
                        <input type="radio" name="is_new" value="否" <?php if($is_new=='否') echo 'checked="checked"';?>/> 否
                    </td>
                </tr>
                <tr>
                    <?php $is_hot = $data['is_hot'];?>
                    <td class="label">是否热卖：</td>
                    <td>
                        <input type="radio" name="is_hot" value="是" <?php if($is_hot=='是') echo 'checked="checked"';?>/> 是
                        <input type="radio" name="is_hot" value="否" <?php if($is_hot=='否') echo 'checked="checked"';?>/> 否
                    </td>
                </tr>
                <tr>
                    <?php $is_best = $data['is_best'];?>
                    <td class="label">是否精品：</td>
                    <td>
                        <input type="radio" name="is_best" <?php if($is_best=='是') echo 'checked="checked"';?> value="是"/> 是
                        <input type="radio" name="is_best"  value="否" <?php if($is_best=='否') echo 'checked="checked"';?>/> 否
                    </td>
                </tr>
                <tr>
                    <?php $promote_price = $data['promote_price'];?>
                    <?php $promote_start_date = $data['promote_start_date'];?>
                    <?php $promote_end_date = $data['promote_end_date'];?>
                    <td class="label">促销价格：</td>
                    <td>
                        促销价格:￥<input type="text" name="promote_price" value="<?php echo $promote_price ;?>" />
                        促销开始日期:<input id="psd" value="<?php echo $promote_start_date ;?>" id="psd" type="text" name="promote_start_date" />
                        促销结束日期:<input id="ped" value="<?php echo $promote_end_date ;?>" id="ped" type="text" name="promote_end_date" />
                    </td>
                </tr>
                <tr>
                    <td class="label">是否推荐到楼层：</td>
                    <td>
                        <?php $is_floor = $data['is_floor'];?>
                        <input  type="radio" value="是" name="is_floor" <?php if($is_floor == '是') echo 'checked="checked"';?>  />是
                        <input  type="radio" name="is_floor" value="否" <?php if($is_floor == '否') echo 'checked="checked"';?>  />否
                    </td>
                </tr>
                <tr>
                    <td class="label">排序：</td>
                    <td>
                        <input type="text" name="sort_num" value="<?php echo $data['sort_num'];?>" >
                    </td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="<?php echo($data['market_price'])?>" size="20" />
                    </td>
                </tr>
                <tr>
                    <td class="label">商品图片：
                    </td>
                    <td>
                    <?php if($data['logo']) showImage($data['mid_logo']);?>
                        <input type="file" name="logo" size="35" />
                    </td>
                </tr>
            </table>
            <table style="display:none;" width="100%" class="tab_table" align="center">
                <!--商品描述-->
                <tr>
                    <td class="label">商品简单描述：</td>
                    <td>
                        <textarea id="goods_desc" name="goods_desc" cols="40" rows="3"><?php echo $data['goods_desc'];?></textarea>
                    </td>
                </tr>
            </table>
            <table style="display:none;" width="90%" class="tab_table" align="center">
                <!--会员价格-->
                <tr>
                    <td>
                        <?php foreach($mlData as $k=>$v):?>
                        <p>
                            <?php echo $v['level_name'];?>:<input type="text" name="member_price[<?php echo $v['id'];?>]" value="<?php echo $mpData[$v['id']-1]['price'] ?>" size="8"/>
                        </p>
                        <?php endforeach;?>
                    </td>


                </tr>
            </table>
            <table style="display:none;" width="90%" class="tab_table" align="center">
                <!--商品属性-->
                <tr align="center">
                    <td>
                        商品类别:<?php buildSelect('Type','type_id','id','type_name',$data['type_id']);?>
                    </td>
                </tr >
                <tr align='center' id="attr_list">
                    <td class="attr_list">
                    <ul>
                        <?php $attrId = array();?>
                    <?php foreach($gaData as $k=>$v):?>
                        <!--对于属性，第二个出现的属性应该是减号：判断这个属性id是否出现过，没有就是加号，并且添加进去，有的话就是减号-->
                        <?php
 if(in_array($v['attr_id'],$attrId)) $opt = '-'; else { $attrId[] = $v['attr_id']; $opt = '+'; } ?>
                            <li>
                                <!--隐藏域-->
                                <input type="hidden" name="goods_attr_id[]" value="<?php echo $v['id'];?>">
                                <?php if($v['attr_type']=='可选'):?>
                                <!--如果是可选类型的话就加一个加号-->
                                <a onclick="addAttr(this)">[<?php echo $opt;?>]</a>
                                <?php endif;?>
                                <?php echo $v['attr_name'];?>
                                <!--属性值-->
                                <?php if($v['attr_option_values']): $attr = explode(',',$v['attr_option_values']); ?>
                                <!--有可选值做一个下拉框-->
                                <select name="attr_value[<?php echo $v['attr_id'];?>][]">
                                    <option value="">请选择</option>
                                    <?php foreach($attr as $k1 => $v1): if($v1 == $v['attr_value']) $select = 'selected="selected"'; else $select = ''; ?>
                            <option <?php echo $select;?> value="<?php echo $v1; ?>" > <?php echo $v1;?> </option>
                                    <?php endforeach;?>
                                </select>

                                <?php else:?>
                                <!--没有可选值做一个输入框-->
                                <input name="attr_value[<?php echo $v['attr_id'];?>][]" type="text" value="<?php echo $v['attr_value'];?>">
                                <?php endif;?>
                            </li>
                    <?php endforeach;?>
                    </ul>
                    </td>
                </tr>
            </table>
            <table style="display:none;" width="90%" class="tab_table" align="center">
                <!--商品相册-->
                <tr>
                    <td>
                        <input id="btn_add_pic" type="button" value="添加一张" />
                        <hr />
                        <ul id="ul_pic_list"></ul>
                        <hr />
                        <ul id="old_pic_list">
                            <?php foreach ($gpData as $k => $v): ?>
                            <li>
                                <input pic_id="<?php echo $v['id']; ?>" class="btn_del_pic" type="button" value="删除" /><br />
                                <?php showImage($v['mid_pic'], 150); ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>



<!--导入在线编辑器 -->
<link href="/Public/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>
<script>
    UM.getEditor('goods_desc', {
        initialFrameWidth : "100%",
        initialFrameHeight : 350
    });

    /*切换tab*/
    $('#tabbar-div p span').click(function () {
        var i = $(this).index(); // 索引
        // 先取消所有的选中状态
        $('.tab_table').hide();
        // 显示第i个
        $('.tab_table').eq(i).show();
        // 取消原来的tab_front
        $('.tab-front').removeClass('tab-front').addClass('tab-back');
        // 重新设置为现在的
        $(this).removeClass('tab-back').addClass('tab-front');
    })

    // 添加一张
    $("#btn_add_pic").click(function(){
        var file = '<li><input type="file" name="pic[]" /></li>';
        $("#ul_pic_list").append(file);
    });

    // ajax删除图片
    $('.btn_del_pic').click(function () {

        if(confirm('确认要删除吗？')){
            // 图片所在的li标签
            var li = $(this).parent();
            // 图片的id
            var pid = $(this).attr('pic_id');

            console.log('pid='+pid);

            // ajax
            $.ajax({
                type:'GET',
                url:"<?php echo U('ajaxDelPic', '', FALSE); ?>/picid/"+pid,
                success:function (data) {
                    li.remove();
                }

                }
            );
        }
    });

    // 下拉框change事件
    $('select[name=type_id]').change(function () {

        var typeId = $(this).val();
        // 发送ajax请求
        if(typeId > 0){
            $.ajax({
                type:'GET',
                url:"<?php echo U('ajaxAttrAdd','',false);?>/type_id/"+typeId,
                dataType:'json',
                success:function (data) {
                    // 返回的data是二维数组
                    var li = ''; // 要拼出很多个li
                    $(data).each(function (k,v) {
                        // 拼凑成一个li
                        li += '<li>';
                        if(v.attr_type == '可选'){
                            // 添加一个加号
                            li += '<a onclick="addAttr(this);" href="#">[+]</a>';
                        }
                        // 添加属性名字
                        li += v.attr_name+":";
                        // 根据属性的可选值类型判断是下拉框还是文本框
                        if(v.attr_option_values == ''){
                            li += '<input type="text" name="attr_value['+v.id+'][]"/>'
                        }else{ // 下拉框
                            li += '<select name="attr_value['+v.id+'][]"><option value="">请选择</option>';
                            // 可选属性值设置为数组
                            var _attr = v.attr_option_values.split(',');
                            for(var i=0;i<_attr.length;i++){
                                li += '<option value="'+_attr[i]+'">';
                                li += _attr[i];
                                li += '</option>';
                            }
                            li += '</select>';
                        }

                        li += '</li>';

                        // 拼接到ul中
                        $('#attr_list').html(li);
                    });
                },
            });


        }
        else{
            $('#attr_list').html('');
        }


    })

    function addAttr(a){
        // 获取a的父节点li
        var li =  $(a).parent();
        // 判断a是+还是-
        if($(a).text() == '[+]'){
            newLi = li.clone();
            newLi.find('option:selected').removeAttr('selected');
            newLi.find('a').text('[-]'); // 把克隆的li的+变成-
            // 把克隆出来的隐藏域id清空
            newLi.find("input[name='goods_attr_id[]']").val('');
            li.after(newLi);
        }
        else{
            // 先获取这个属性值的id
            var gaid = li.find("input[name='goods_attr_id[]']").val();
            // 如果没有ID就直接删除，如果有ID说明是旧的属性值需要AJAX删除
            if(gaid == '')
                li.remove();
            else
            {
                if(confirm('如果删除了这个属性，那么相关的库存量数据也会被一起删除，确定要删除吗？'))
                {
                    $.ajax({
                        type : "GET",
                        url : "<?php echo U('ajaxDelAttr?goods_id='.$data['id'], '', FALSE); ?>/gaid/"+gaid,
                        success : function(data)
                        {
                            // 再把页面中的记录删除
                            li.remove();
                        }
                    });
                }
            }
        }

    }

</script>
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
    $("#psd").datetimepicker();
    $("#ped").datetimepicker();
</script>

<div id="footer"> 39shop </div>
</body>
</html>