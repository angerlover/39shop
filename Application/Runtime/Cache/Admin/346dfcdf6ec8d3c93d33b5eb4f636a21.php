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
        <form enctype="multipart/form-data" action="/index.php/Admin/Goods/add" method="post">
            <table width="90%" class="tab_table" id="general-table" align="center">
                <!--通用信息-->
                <tr>
                    <td class="label">主分类</td>
                    <td>
                        <select  name="cat_id">
                            <option value="">请选择</option>
                            <?php foreach ($catData as $k =>$v):?>
                            <option value="<?php echo $v['id'];?>"><?php echo str_repeat('-',8*$v['level']).$v['cat_name']?></option>
                            <?php endforeach;?>
                        </select>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                <td class="label">扩展分类  <input onclick="$('#cat_list').append($('#cat_list li:eq(0)').clone())" type="button" id="btn_add_cat" value="添加一个"></td>
                    <td>
                        <ul id="cat_list">
                            <li>
                                <select  name="ext_cat_id[]">
                                    <option value="">请选择</option>
                                    <?php foreach ($catData as $k =>$v):?>
                                    <option value="<?php echo $v['id'];?>"><?php echo str_repeat('-',8*$v['level']).$v['cat_name']?></option>
                                    <?php endforeach;?>
                                </select>
                            </li>
                        </ul>
                    </td>

                </tr>
                <tr>
                    <td class="label">品牌名称：</td>
                    <td>
                    <?php buildSelect('brand','brand_id','id','brand_name') ;?>

                        <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value=""size="30" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="0" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_onsale" value="1"/> 是
                        <input type="radio" name="is_onsale" value="0"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否新品：</td>
                    <td>
                        <input type="radio" name="is_new" value="是"/> 是
                        <input type="radio" name="is_new" value="否" checked="checked"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否热卖：</td>
                    <td>
                        <input type="radio" name="is_hot" value="是"/> 是
                        <input type="radio" name="is_hot" value="否" checked="checked"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否精品：</td>
                    <td>
                        <input type="radio" name="is_best" value="是"/> 是
                        <input type="radio" name="is_best" value="否" checked="checked"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">促销价格：</td>
                    <td>
                        促销价格:￥<input type="text" name="promote_price" />
                        促销开始日期:<input id="psd" type="text" name="promote_start_date" />
                        促销结束日期:<input id="ped" type="text" name="promote_end_date" />
                    </td>
                </tr>
                <tr>
                    <td class="label">是否推荐到楼层：</td>
                    <td>
                        <input  type="radio" name="is_floor" value="是" />是
                        <input  type="radio" name="is_floor" value="否" checked="checked" />否
                    </td>
                </tr>
                <tr>
                    <td class="label">排序：</td>
                    <td>
                        <input type="text" name="sort_num" >
                    </td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="0" size="20" />
                    </td>
                </tr>
                <tr>
                    <td class="label">商品图片：</td>
                    <td>
                        <input type="file" name="logo" size="35" />
                    </td>
                </tr>

            </table>
            <table style="display:none;" width="100%" class="tab_table" align="center">
                <!--商品描述-->
                <tr>
                    <td class="label">商品简单描述：</td>
                    <td>
                        <textarea id="goods_desc" name="goods_desc" cols="40" rows="3"></textarea>
                    </td>
                </tr>
            </table>
            <table style="display:none;" width="90%" class="tab_table" align="center">
                <!--会员价格-->
                <tr>
                    <td>
                        <?php foreach($mlData as $k=>$v):?>
                        <p>
                        <?php echo $v['level_name'];?>:<input type="text" name="member_price[<?php echo $v['id'];?>]"  size="8"/>
                        </p>
                        <?php endforeach;?>
                    </td>


                </tr>
            </table>
            <table style="display:none;" width="90%" class="tab_table" align="center">
                <!--商品属性-->
                <tr align="center">
                    <td>商品类别:<?php buildSelect('Type','type_id','id','type_name');?></td>
                </tr >
                <tr align='center' id="attr_list">

                </tr>
            </table>
            <table style="display:none;" width="90%" class="tab_table" align="center">
                <!--商品相册-->
                <tr>
                    <td>
                        <input id="btn_add_pic" type="button" value="添加一张" />
                        <hr />
                        <ul id="ul_pic_list"></ul>
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

    /*添加一张图片*/
    $('#btn_add_pic').click(function () {
        var file = '<li><input type="file" name="pic[]"/></li>';
        $('#ul_pic_list').append(file);
    });

// 添加商品属性的操作
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
            newLi.find('a').text('[-]'); // 把克隆的li的+变成-
            li.after(newLi);
        }
        else{
            li.remove()
        }

    }
</script>

<div id="footer"> 39shop </div>
</body>
</html>