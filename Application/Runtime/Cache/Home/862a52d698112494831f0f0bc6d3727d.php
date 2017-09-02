<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="keywords" content="<?php echo $_page_keywords; ?>" />
    <meta name="description" content="<?php echo $_page_description; ?>" />
    <title><?php echo $_page_title; ?></title>
    <link rel="stylesheet" href="/Public/Home/style/base.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/global.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/header.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/bottomnav.css" type="text/css">
    <link rel="stylesheet" href="/Public/Home/style/footer.css" type="text/css">

    <script type="text/javascript" src="/Public/Home/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/Public/Home/js/header.js"></script>
</head>
<body>
<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w1210 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li id="login_info"> </li>
                <li class="line">|</li>
                <li ><a href="<?php echo U('My/order');?>">我的订单</a></li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->
<div style="clear:both;"></div>



<!-- 引入这个页面专用的CSS和JS -->
<link rel="stylesheet" href="/Public/Home/style/goods.css" type="text/css">
<link rel="stylesheet" href="/Public/Home/style/common.css" type="text/css">
<link rel="stylesheet" href="/Public/Home/style/jqzoom.css" type="text/css">
<script type="text/javascript" src="/Public/Home/js/goods.js"></script>
<script type="text/javascript" src="/Public/Home/js/jqzoom-core.js"></script>
<!-- jqzoom 效果 -->
<script type="text/javascript">
    $(function(){
        $('.jqzoom').jqzoom({
            zoomType: 'standard',
            lens:true,
            preloadImages: false,
            alwaysOn:false,
            title:false,
            zoomWidth:400,
            zoomHeight:400
        });
    });
</script>
<!-- 引入导航条文件  -->
<!-- 头部 start -->
<div class="header w1210 bc mt15">
    <!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
    <div class="logo w1210">
        <h1 class="fl"><a target="_blank" href="<?php echo U('/');?>"><img src="/Public/Home/images/logo.png" alt="京西商城"></a></h1> <!-- 头部搜索 start -->
        <div class="search fl">
            <div class="search_form">
                <div class="form_left fl"></div>
                <form action="" name="serarch" method="get" class="fl">
                    <input id="key" type="text" class="txt" value="<?php echo I('get.key','请输入搜索关键字');?>" />
                    <input onclick="location.href='<?php echo U('Search/key_search','',false);?>/key/'+$('#key').val();" type="button" class="btn" value="搜索" />
                </form>
                <div class="form_right fl"></div>
            </div>

            <div style="clear:both;"></div>

            <div class="hot_search">
                <strong>热门搜索:</strong>
                <a href="">D-Link无线路由</a>
                <a href="">休闲男鞋</a>
                <a href="">TCL空调</a>
                <a href="">耐克篮球鞋</a>
            </div>
        </div>
        <!-- 头部搜索 end -->

        <!-- 用户中心 start-->
        <div class="user fl">
            <dl>
                <dt>
                    <em></em>
                    <a href="">用户中心</a>
                    <b></b>
                </dt>
                <dd>
                    <div class="prompt">
                        您好，请<a href="">登录</a>
                    </div>
                    <div class="uclist mt10">
                        <ul class="list1 fl">
                            <li><a href="">用户信息></a></li>
                            <li><a href="">我的订单></a></li>
                            <li><a href="">收货地址></a></li>
                            <li><a href="">我的收藏></a></li>
                        </ul>

                        <ul class="fl">
                            <li><a href="">我的留言></a></li>
                            <li><a href="">我的红包></a></li>
                            <li><a href="">我的评论></a></li>
                            <li><a href="">资金管理></a></li>
                        </ul>

                    </div>
                    <div style="clear:both;"></div>
                    <div class="viewlist mt10">
                        <h3>最近浏览的商品：</h3>
                        <ul>
                            <li><a href=""><img src="images/view_list1.jpg" alt="" /></a></li>
                            <li><a href=""><img src="images/view_list2.jpg" alt="" /></a></li>
                            <li><a href=""><img src="images/view_list3.jpg" alt="" /></a></li>
                        </ul>
                    </div>
                </dd>
            </dl>
        </div>
        <!-- 用户中心 end-->

        <!-- 购物车 start -->
        <div class="cart fl">
            <dl>
                <dt>
                    <a id="cart_list" target="_blank" href="<?php echo U('Cart/lst');?>">去购物车结算</a>
                    <b></b>
                </dt>
                <dd>
                    <div id="show_cart_list" class="prompt">
                        <img src="/Public/Home/images/loading.gif" alt="">
                    </div>
                </dd>
            </dl>
        </div>
        <!-- 购物车 end -->
    </div>
    <!-- 头部上半部分 end -->


    <div style="clear:both;"></div>

    <!-- 导航条部分 start -->
    <div class="nav w1210 bc mt10">
        <!--  商品分类部分 start-->
        <div class="category fl <?php if($_show_nav == 0) echo 'cat1'; ?>"> <!-- 非首页，需要添加cat1类 -->
            <div class="cat_hd <?php if($_show_nav == 0) echo 'off'; ?>">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
                <h2>全部商品分类</h2>
                <em></em>
            </div>

            <div class="cat_bd <?php if($_show_nav == 0) echo 'none'; ?>">
                <?php foreach($navData as $k =>$v):?>
                <div class="cat item1">
                    <h3>
                        <a href="<?php echo U('Search/cat_search?cat_id='.$v['id'],'',false);?>" target="_blank">
                            <?php echo $v['cat_name'];?>
                        </a> <b></b></h3>
                    <div class="cat_detail">
                        <?php foreach($v['children'] as $k1=>$v1):?>
                        <dl class="dl_1st">
                            <dt><a href="<?php echo U('Search/cat_search?cat_id='.$v1['id'],'',false);?>" target="_blank"><?php echo $v1['cat_name'];?></a></dt>
                            <dd>
                                <?php foreach($v1['children'] as $k2=>$v2):?>
                                <a href="<?php echo U('Search/cat_search?cat_id='.$v2['id'],'',false);?>" target="_blank"><?php echo $v2['cat_name'];?></a>
                                <?php endforeach;?>
                            </dd>
                        </dl>
                        <?php endforeach;?>
                    </div>
                </div>
                <?php endforeach;?>

            </div>

        </div>
        <!--  商品分类部分 end-->

        <div class="navitems fl">
            <ul class="fl">
                <li class="current"><a href="">首页</a></li>
                <li><a href="">电脑频道</a></li>
                <li><a href="">家用电器</a></li>
                <li><a href="">品牌大全</a></li>
                <li><a href="">团购</a></li>
                <li><a href="">积分商城</a></li>
                <li><a href="">夺宝奇兵</a></li>
            </ul>
            <div class="right_corner fl"></div>
        </div>
    </div>
    <!-- 导航条部分 end -->
</div>
<!-- 头部 end-->

<div style="clear:both;"></div>
<script>
    <?php $viewPath = C('IMAGE_CONFIG');?>
    var viewPath = "<?php echo $viewPath['viewPath'];?>";
    $('#cart_list').mouseover(function () {
        $.ajax({
            type:'get',
            url:"<?php echo U('Cart/ajaxGetCart');?>",
            dataType:'json',
            success:function (data)
            {
                console.log(data);
                // 拼出一个html结构
                html = '<table>';

                $(data).each(function (k,v) {

                    html += '<tr>';
                    html += "<td><img src='"+viewPath+v.logo+"'> </td>";
                    html += "<td>"+v.name+" </td>";
                    html += '</tr>';
                })

                html += '</table>';

                $('#show_cart_list').html(html);
             }
        });
    });
</script>




	<!-- 商品页面主体 start -->
	<div class="main w1210 mt10 bc">
		<!-- 面包屑导航 start -->
		<div class="breadcrumb">
			<h2>当前位置：<a href="">首页</a> > 
				<?php $length = count($parentPath);?>
				<?php for($i = $length-1;$i>=0;$i--):?>
				<a href=""><?php echo $parentPath[$i]['cat_name'];?></a> > 
				<?php endfor;?>
				<?php echo $info['goods_name'];?></h2>
		</div>
		<!-- 面包屑导航 end -->
		
		<!-- 主体页面左侧内容 start -->
		<div class="goods_left fl">
			<!-- 相关分类 start -->
			<div class="related_cat leftbar mt10">
				<h2><strong>相关分类</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li><a href="">笔记本</a></li>
						<li><a href="">超极本</a></li>
						<li><a href="">平板电脑</a></li>
					</ul>
				</div>
			</div>
			<!-- 相关分类 end -->

			<!-- 相关品牌 start -->
			<div class="related_cat	leftbar mt10">
				<h2><strong>同类品牌</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li><a href="">D-Link</a></li>
						<li><a href="">戴尔</a></li>
						<li><a href="">惠普</a></li>
						<li><a href="">苹果</a></li>
						<li><a href="">华硕</a></li>
						<li><a href="">宏基</a></li>
						<li><a href="">神舟</a></li>
					</ul>
				</div>
			</div>
			<!-- 相关品牌 end -->

			<!-- 热销排行 start -->
			<div class="hotgoods leftbar mt10">
				<h2><strong>热销排行榜</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li></li>
					</ul>
				</div>
			</div>
			<!-- 热销排行 end -->


			<!-- 浏览过该商品的人还浏览了  start 注：因为和list页面newgoods样式相同，故加入了该class -->
			<div class="related_view newgoods leftbar mt10">
				<h2><strong>浏览了该商品的用户还浏览了</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li>
							<dl>
								<dt><a href=""><img src="/Public/Home/images/relate_view1.jpg" alt="" /></a></dt>
								<dd><a href="">ThinkPad E431(62771A7) 14英寸电脑 (i5-3230 4G 1TB 2G独显 蓝牙 win8)</a></dd>
								<dd><strong>￥5199.00</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/Public/Home/images/relate_view2.jpg" alt="" /></a></dt>
								<dd><a href="">ThinkPad X230i(2306-3V9） 12.5英寸笔记本电脑 （i3-3120M 4GB 500GB 7200转 蓝牙 摄像头 Win8）</a></dd>
								<dd><strong>￥5199.00</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/Public/Home/images/relate_view3.jpg" alt="" /></a></dt>
								<dd><a href="">T联想（Lenovo） Yoga13 II-Pro 13.3英寸超极本 （i5-4200U 4G 128G固态硬盘 摄像头 蓝牙 Win8）晧月银</a></dd>
								<dd><strong>￥7999.00</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/Public/Home/images/relate_view4.jpg" alt="" /></a></dt>
								<dd><a href="">联想（Lenovo） Y510p 15.6英寸笔记本电脑（i5-4200M 4G 1T 2G独显 摄像头 DVD刻录 Win8）黑色</a></dd>
								<dd><strong>￥6199.00</strong></dd>
							</dl>
						</li>

						<li class="last">
							<dl>
								<dt><a href=""><img src="/Public/Home/images/relate_view5.jpg" alt="" /></a></dt>
								<dd><a href="">ThinkPad E530c(33662D0) 15.6英寸笔记本电脑 （i5-3210M 4G 500G NV610M 1G独显 摄像头 Win8）</a></dd>
								<dd><strong>￥4399.00</strong></dd>
							</dl>
						</li>					
					</ul>
				</div>
			</div>
			<!-- 浏览过该商品的人还浏览了  end -->

			<!-- 最近浏览 start -->
			<div class="viewd leftbar mt10">
				<h2><a href="">清空</a><strong>最近浏览过的商品</strong></h2>
				<div class="leftbar_wrap" id="display_history">

				</div>
			</div>
			<!-- 最近浏览 end -->

		</div>
		<!-- 主体页面左侧内容 end -->
		
		<!-- 商品信息内容 start -->
		<div class="goods_content fl mt10 ml10">
			<!-- 商品概要信息 start -->
			<div class="summary">
				<h3><strong><?php echo $info['goods_name'];?></strong></h3>
				
				<!-- 图片预览区域 start -->
				<div class="preview fl">
					<?php $viewPath = $viewPath['viewPath'];?>
					<div class="midpic">
						<a href="<?php echo $viewPath.$info['mbig_logo'];?>" class="jqzoom" rel="gal1">   <!-- 第一幅图片的大图 class 和 rel属性不能更改 -->
							<img src="<?php echo $viewPath.$info['big_logo'];?>" alt="" />               <!-- 第一幅图片的中图 -->
						</a>
					</div>
	
					<!--使用说明：此处的预览图效果有三种类型的图片，大图，中图，和小图，取得图片之后，分配到模板的时候，把第一幅图片分配到 上面的midpic 中，其中大图分配到 a 标签的href属性，中图分配到 img 的src上。 下面的smallpic 则表示小图区域，格式固定，在 a 标签的 rel属性中，分别指定了中图（smallimage）和大图（largeimage），img标签则显示小图，按此格式循环生成即可，但在第一个li上，要加上cur类，同时在第一个li 的a标签中，添加类 zoomThumbActive  -->

					<div class="smallpic">
						<a href="javascript:;" id="backward" class="off"></a>
						<a href="javascript:;" id="forward" class="on"></a>
						<div class="smallpic_wrap">
							<ul>
								<!--第一个是logo小图-->
								<li class="cur">
									<a class="zoomThumbActive" href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?php echo $viewPath.$info['big_logo'];?>',largeimage: '<?php echo $viewPath.$info['mbig_logo'];?>'}"><?php showImage($info['sm_logo']);?></a>
								</li>
								<!--第二个开始就是商品相册了-->
								<?php foreach($gpData as $k => $v):?>
								<li>
									<a href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?php echo $viewPath.$v['mid_pic'];?>',largeimage: '<?php echo $viewPath.$v['big_pic'];?>'}"><?php showImage($v['sm_pic']);?></a>
								</li>
								<?php endforeach;?>
							</ul>
						</div>
						
					</div>
				</div>
				<!-- 图片预览区域 end -->

				<!-- 商品基本信息区域 start -->
				<div class="goodsinfo fl ml10">
					<ul>
						<li><span>商品编号： </span><?php echo $info['id'];?></li>
						<li class="market_price"><span>定价：</span><em><?php echo $info['market_price'];?></em></li>
						<li class="shop_price"><span>本店价：</span><strong><?php echo $info['shop_price'];?></strong> <a href="">(降价通知)</a></li>
						<li><span>会员价：</span>
							<table border="1" cellpadding="5" width="50%">
								<?php foreach($gmpData as $k=>$v):?>
									<tr>
										<td><?php echo $v['level_name'];?></td>
										<td><?php echo $v['price'];?></td>
									</tr>
								<?php endforeach;?>
							</table>
						</li>
						<li class="shop_price"><span>购买价格：</span><strong id="real_price"></strong></li>
						<li><span>上架时间：</span><?php echo $info['addtime'];?></li>
						<li class="star"><span>商品评分：</span> <strong></strong><a href="">(已有21人评价)</a></li> <!-- 此处的星级切换css即可 默认为5星 star4 表示4星 star3 表示3星 star2表示2星 star1表示1星 -->
					</ul>
					<form action="<?php echo U('Cart/add')?>" method="post" class="choose">
						<ul>
							<input type="hidden" name="goods_id" value="<?php echo $info['id'];?>">
                            <?php foreach($mulAttr as $k => $v):?>
							<li class="product">
								<dl>
									<dt><?php echo $k?>：</dt>
									<dd>
                                        <?php foreach($v as $k1 =>$v1):?>
										<a <?php if($k1==0) echo 'class="selected"';?>  href="javascript:;"> <?php echo $v1['attr_value'];?>
                                            <input type="radio" name="goods_attr_id[<?php echo $v1['attr_id'];?>]" value="<?php echo $v1['id'];?>" <?php if($k1==0) echo 'checked="checked"';?>  />
                                        </a>
                                        <?php endforeach;?>
										<input type="hidden" name="" value="" />
									</dd>
								</dl>
							</li>
                            <?php endforeach;?>
							<li>
								<dl>
									<dt>购买数量：</dt>
									<dd>
										<a href="javascript:;" id="reduce_num"></a>
										<input type="text" name="goods_number" value="1" class="amount"/>
										<a href="javascript:;" id="add_num"></a>
									</dd>
								</dl>
							</li>

							<li>
								<dl>
									<dt>&nbsp;</dt>
									<dd>
										<input type="submit" value="" class="add_btn" />
									</dd>
								</dl>
							</li>
						</ul>
					</form>
				</div>
				<!-- 商品基本信息区域 end -->
			</div>
			<!-- 商品概要信息 end -->
			
			<div style="clear:both;"></div>

			<!-- 商品详情 start -->
			<div class="detail">
				<div class="detail_hd">
					<ul>
						<li class="first"><span>商品介绍</span></li>
						<li class="on"><span>商品评价</span></li>
						<li><span>售后保障</span></li>
					</ul>
				</div>
				<div class="detail_bd">
					<!-- 商品介绍 start -->
					<div class="introduce detail_div none">
						<div class="attr mt15">
							<ul>
                                <?php foreach ($uniAttr as $k => $v):?>
								<li><span><?php echo $v['attr_name'];?>:</span><?php echo $v['attr_value'];?></li>
                                <?php endforeach;?>
							</ul>
						</div>

						<div class="desc mt10">
							<!-- 此处的内容 一般是通过在线编辑器添加保存到数据库，然后直接从数据库中读出 -->
							<?php echo html_entity_decode($info['goods_desc']);?>
						</div>
					</div>
					<!-- 商品介绍 end -->
					
					<!-- 商品评论 start -->
					<div class="comment detail_div mt10">
						<div class="comment_summary">
							<div class="rate fl">
								<strong><em class="hao">90</em>%</strong> <br />
								<span>好评度</span>
							</div>
							<div class="percent fl">
								<dl>
									<dt>好评（<span class="hao"></span>%）</dt>
									<dd><div id="hao_width" style="width:90px;"></div></dd>
								</dl>
								<dl>
									<dt>中评（<span class="zhong"></span>%）</dt>
									<dd><div id="zhong_width" style="width:5px;"></div></dd>
								</dl>
								<dl>
									<dt>差评（<span class="cha"></span>%）</dt>
									<dd><div id="cha_width" style="width:5px;" ></div></dd>
								</dl>
							</div>
							<div class="buyer fl">
								<dl>
									<dt>买家印象：</dt>
								</dl>
							</div>
						</div>
						<div id="comment_area">

						</div>

						<!-- 分页信息 start -->
						<div class="page mt20">

						</div>
						<!-- 分页信息 end -->

						<!--  评论表单 start-->
						<div class="comment_form mt20">
							<form id="comment_form">
								<input type="hidden" name="goods_id" value="<?php echo $info['id'];?>">
								<ul>
									<li>
										<label for=""> 评分：</label>
										<input value="5" type="radio" name="star"/> <strong class="star star5"></strong>
										<input value="4" type="radio" name="star"/> <strong class="star star4"></strong>
										<input value="3" type="radio" name="star"/> <strong class="star star3"></strong>
										<input value="2" type="radio" name="star"/> <strong class="star star2"></strong>
										<input value="1" type="radio" name="star"/> <strong class="star star1"></strong>
									</li>

									<li>
										<label for="">评价内容：</label>
										<textarea name="content" id="" cols="" rows=""></textarea>
									</li>
									<li id="mjyx">
										<label for="">印象：</label>
										<input type="text" name="yx_name" size="60">
									</li>
									<li>
										<label for="">&nbsp;</label>
										<input type="button" value="提交评论"  class="comment_btn"/>
									</li>
								</ul>
							</form>
						</div>
						<!--  评论表单 end-->
						
					</div>
					<!-- 商品评论 end -->

					<!-- 售后保障 start -->
					<div class="after_sale mt15 none detail_div">
						<div>
							<p>本产品全国联保，享受三包服务，质保期为：一年质保 <br />如因质量问题或故障，凭厂商维修中心或特约维修点的质量检测证明，享受7日内退货，15日内换货，15日以上在质保期内享受免费保修等三包服务！</p>
							<p>售后服务电话：800-898-9006 <br />品牌官方网站：http://www.lenovo.com.cn/</p>

						</div>

						<div>
							<h3>服务承诺：</h3>
							<p>本商城向您保证所售商品均为正品行货，京东自营商品自带机打发票，与商品一起寄送。凭质保证书及京东商城发票，可享受全国联保服务（奢侈品、钟表除外；奢侈品、钟表由本商城联系保修，享受法定三包售后服务），与您亲临商场选购的商品享受相同的质量保证。本商城还为您提供具有竞争力的商品价格和运费政策，请您放心购买！</p> 
							
							<p>注：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。只能确保为原厂正货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！</p>

						</div>
						
						<div>
							<h3>权利声明：</h3>
							<p>本商城上的所有商品信息、客户评价、商品咨询、网友讨论等内容，是京东商城重要的经营资源，未经许可，禁止非法转载使用。</p>
							<p>注：本站商品信息均来自于厂商，其真实性、准确性和合法性由信息拥有者（厂商）负责。本站不提供任何保证，并不承担任何法律责任。</p>

						</div>
					</div>
					<!-- 售后保障 end -->

				</div>
			</div>
			<!-- 商品详情 end -->

			
		</div>
		<!-- 商品信息内容 end -->
		

	</div>
	<!-- 商品页面主体 end -->

	<!-- 底部导航 start -->
<div class="bottomnav w1210 bc mt10">
    <div class="bnav1">
        <h3><b></b> <em>购物指南</em></h3>
        <ul>
            <li><a href="">购物流程</a></li>
            <li><a href="">会员介绍</a></li>
            <li><a href="">团购/机票/充值/点卡</a></li>
            <li><a href="">常见问题</a></li>
            <li><a href="">大家电</a></li>
            <li><a href="">联系客服</a></li>
        </ul>
    </div>

    <div class="bnav2">
        <h3><b></b> <em>配送方式</em></h3>
        <ul>
            <li><a href="">上门自提</a></li>
            <li><a href="">快速运输</a></li>
            <li><a href="">特快专递（EMS）</a></li>
            <li><a href="">如何送礼</a></li>
            <li><a href="">海外购物</a></li>
        </ul>
    </div>


    <div class="bnav3">
        <h3><b></b> <em>支付方式</em></h3>
        <ul>
            <li><a target="_blank" href="<?php echo U("Admin/Login/login");?>">货到付款</a></li>
            <li><a href="">在线支付</a></li>
            <li><a href="">分期付款</a></li>
            <li><a href="">邮局汇款</a></li>
            <li><a href="">公司转账</a></li>
        </ul>
    </div>

    <div class="bnav4">
        <h3><b></b> <em>售后服务</em></h3>
        <ul>
            <li><a href="">退换货政策</a></li>
            <li><a href="">退换货流程</a></li>
            <li><a href="">价格保护</a></li>
            <li><a href="">退款说明</a></li>
            <li><a href="">返修/退换货</a></li>
            <li><a href="">退款申请</a></li>
        </ul>
    </div>

    <div class="bnav5">
        <h3><b></b> <em>特色服务</em></h3>
        <ul>
            <li><a href="">夺宝岛</a></li>
            <li><a href="">DIY装机</a></li>
            <li><a href="">延保服务</a></li>
            <li><a href="">家电下乡</a></li>
            <li><a href="">京东礼品卡</a></li>
            <li><a href="">能效补贴</a></li>
        </ul>
    </div>
</div>
<!-- 底部导航 end -->

<script>
	<?php $imagePath = C('IMAGE_CONFIG');?>
	var viewPath = "<?php echo $imagePath['viewPath'];?>";
	// ajax记录浏览历史
	/*$.ajax({
		type:"GET",
		url:"<?php echo U('Index/displayHistory?id='.$info['id']);?>",
		dataType:'json',
		success:function (data) {
		    alert(data);
            var html = '';
            $(data).each(function (k,v)
			{
				html += '<dl><dt><a href="<?php echo U('goods','',false);?>/id/'+v.id+'">
<img src="'+viewPath+v.sm_logo+'"/></a></dt><dd><a href="<a href=<?php echo U('goods','',false);?>/id/'+v.id+'"></a>">'+v.goods_name+'</a></dd></dl>'
            });

			$('#display_history').html(html);


        }
	});*/

    $.ajax({
        type : "GET",
        url : "<?php echo U('Index/displayHistory?id='.$info['id']); ?>",
        dataType : "json",
        success : function(data)
        {
            // 循环服务器返回的浏览历史数据放到页面中
            // 先拼HTML字符串
            var html = "";
            $(data).each(function(k,v){
                html += '<dl><dt><a href="<?php echo U('goods', '', FALSE); ?>/id/'+v.id+'"><img src="'+viewPath+v.sm_logo+'" /></a></dt><dd><a href="<?php echo U('goods', '', FALSE); ?>/id/'+v.id+'">'+v.goods_name+'</a></dd></dl>';
            });
            // 放到 页面中
            $("#display_history").html(html);
        }
    });


    // ajax获取会员价格
	$.ajax({
		type:'get',
		url:"<?php echo U('ajaxGetMemberPrice?goods_id='.$info['id']); ?>",
		success:function (data) {
			$('#real_price').html('Y'+data+'元');
        }
		});

	// ajax发表评论
	$('.comment_btn').click(function () {

	    var commentForm = $('#comment_form');
	    var commentData = commentForm.serialize();
		$.ajax({
		            type:'post',
		            url:"<?php echo U('Comment/add');?>",
					data: commentData,
		            dataType:'json',
		            success:function (data)
		            {
		               // 如果没成功
						if (data.status == 0)
						{
						    $('#dialog_login').dialog('open');
						}
						else
						{

                            // 触发reset 清空表单的内容
                            commentForm.trigger('reset');
                            // 拼出一个当前评论内容的html
                            var html = '<div class="comment_items mt10 none"><div class="user_pic"><dl><dt><a href=""><img src="'+data.info.face+'" alt="" /></a></dt><dd><a href="">'+data.info.username+'</a></dd></dl></div><div class="item"><div class="title"><span>'+data.info.addtime+'</span><strong class="star star'+data.info.star+'"></strong></div><div class="comment_content">'+data.info.content+'</div><div class="btns"><a href="javascript:void(0);" onclick="do_reply(this,'+data.info.id+');" class="reply">回复(0)</a><a href="" class="useful">有用(0)</a></div><div class="reply_form"></div><ul class="reply_container"></ul></div><div class="cornor"></div></div>';
                            html = $(html); // 转换为jquery对象
                            $('#comment_area').prepend(html);
                            $('body').animate(
                                {'scrollTop':'750px'},
                                1000,
                                function () {
                                    html.fadeIn(2000);
                                });
                        }

		            }

		        });
    });
</script>
<!--jquery ui的表单-->
<link href="/Public/jquery-ui-1.9.2.custom/css/blitzer/jquery-ui-1.9.2.custom.css" rel="stylesheet">
<script src="/Public/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js"></script>
<!--做一个给jquery ui用的登录的表单-->
<div id="dialog_login" class="none" title="登录">
	<form id="login_form">
		<ul>
			<li>
				<label for="">用户名：</label>
				<input type="text" class="txt" name="username" />
			</li>
			<li>
				<label for="">密码：</label>
				<input type="password" class="txt" name="password" />
				<a href="">忘记密码?</a>
			</li>
			<li class="checkcode">
				<label for="">验证码：</label>
				<input type="text"  name="chkcode" />
				<img style="cursor: pointer" onclick="this.src='<?php echo U('Member/chkcode');?>#'+Math.random()" src="<?php echo U('Member/chkcode');?>" alt="" />
				<span>看不清？<a href="">换一张</a></span>
			</li>
		</ul>
	</form>
</div>
<!--配置jquery ui的登录表单-->
<script>

	$('#dialog_login').dialog({
        resizable : false,
        position : {at: "center"},
        modal : true,
        autoOpen: false,
        width: 400,
		buttons:[
			{
			    text:'登录',
				click:function () {
					/*ajax登录网站*/
					$.ajax({
					            type:'post',
					            url:"<?php echo U('Member/login');?>",
								data:$('#login_form').serialize(),
					            dataType:'json',
					            success:function (data)
					            {
                                    if(data.status == 1)
                                    {
                                        $( "#dialog_login" ).dialog( "close" );
                                    }
                                    else
                                        alert(data.info);
					            }
					        });
                },
			},
			{
                text:'取消',
                click:function () {
					$(this).dialog('close');
                },
			}
		]
	});
</script>
<script>
	/*ajax获取某一页的评论*/
	 function ajaxGetPl (page)
	{
		$.ajax({
		            type:'get',
		            url:"<?php echo U('Comment/ajaxGetComment?goods_id='.$info['id'],'',false);?>"+"/p/"+page,
		            dataType:'json',
		            success:function (data)
		            {
		                is_login = data.memberId;
						var html = ''; // 待拼的字符串
						$(data.data).each(function (k,v)
						{
                            // 每条回复的html字符串
                            var replyHtml = '';
                            $(v.reply).each(function (k1,v1) {
                                replyHtml += '<li><img src="'+v1.face+'">'+v1.username+'【'+v1.addtime+'】回复：'+v1.content+'</li>';
                            });


							html += '<div class="comment_items mt10"><div class="user_pic"><dl><dt><a href=""><img src="'+v.face+'" alt="" /></a></dt><dd><a href="">'+v.username+'</a></dd></dl></div><div class="item"><div class="title"><span>'+v.addtime+'</span><strong class="star star'+v.star+'"></strong></div><div class="comment_content">'+v.content+'</div><div class="btns"><a href="javascript:void(0);" onclick="do_reply(this,'+v.id+');" class="reply">回复('+v.reply_count+')</a><a href="" class="useful">有用('+v.star+')</a></div><div class="reply_form"></div><ul class="reply_container">'+replyHtml+'</ul></div><div class="cornor"></div></div>';
                        });
						// 放到评论区覆盖原数据
						$('#comment_area').html(html);

						/*******根据返回的总页数拼出分页的html*****/

						var pageString = '';
						for(var i = 1;i<=data.pageCount;i++)
						{
						    if(page == i)
							{
							    var cls = "class = 'cur'";
							}
							else
							{
							    var cls = '';
							}
							  pageString += "<a "+cls+" onclick='ajaxGetPl("+i+")' href = 'javascript:void(0);'>"+i+" </a>"
						}


						$('.page').html(pageString);

						// 给好评数据
						$('.hao').html(data.hao);
						$('.zhong').html(data.zhong);
						$('.cha').html(data.cha);
						$('#hao_width').css('width',data.hao+'px');
						$('#zhong_width').css('width',data.zhong+'px');
						$('#cha_width').css('width',data.cha+'px');


						// 给印象的数据
						var yxhtml = ''; // 上面用于显示印象的
						var chkYxHtml = ''; // 表单里用于提交的已有印象
						$(data.yxData).each(function (k,v)
						{
							yxhtml += '<dd><span>'+v.yx_name+'</span><em>('+v.yx_count+')</em></dd>'
							chkYxHtml += '<input type="checkbox" name="yx_id[]" value="'+v.id+'"/> '+' '+v.yx_name;
                        });

						// 添加进去
						$('.buyer dl').append(yxhtml);
						if(chkYxHtml != '')
						{
                            $('#mjyx').before(chkYxHtml);
                        }
		            }
		        });
	};

	 ajaxGetPl(1);
	var is_login = 0;// 全局变量判断是否登录

    /**
	 * 生成回复评论的div区域
     * @param btn 点击的button
     * @param commentId 当前评论的id
     */
	function do_reply(btn,commentId)
	{
	    var div = $(btn).parent().next('div');
	    var html = '';
	    html += '<hr><form><input type="hidden" name="comment_id" value="'+commentId+'"><textarea name="content" rows="6" style="width:100%" > </textarea><br> <input onclick="post_reply(this);" type="button" value="确定"> <input onclick="close_reply(this);" type="button" value="取消"></form?';
        div.html(html)

        // 判断是否登录
        if(is_login <= 0)
        {
            $('#dialog_login').dialog('open');
        }
	}

    /**
	 *  关闭回复的表单
     * @param btn
     */
	function close_reply(btn) {
		var parent = $(btn).parent();
		parent.html('');
    }
    /**
	 * ajax发表回复
     * @param btn
     */
    function post_reply(btn)
	{
		var formData = $(btn).parent('form').serialize();
		$.ajax({
		            type:'post',
		            url:"<?php echo U('Comment/ajaxReply');?>",
					data:formData,
		            dataType:'json',
		            success:function (data)
		            {
						// 拼出一个用于显示回复的html字符串
						var html = '';
						html += '<li><img src="'+data.info.face+'">'+data.info.username+'【'+data.info.addtime+'】回复：'+data.info.content+'</li>';
                        $(btn).parent().parent().next("ul").append(html);
                        // 把表单去掉
                        $(btn).parent().parent().html('');

		                // 未登录现实登录窗口
						if(data.info == '必须先登录!')
						{
						 	$('#dialog_login').dialog('open');
						}
		            }
		        });
	}
</script>

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt10">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="/Public/Home/images/xin.png" alt="" /></a>
        <a href=""><img src="/Public/Home/images/kexin.jpg" alt="" /></a>
        <a href=""><img src="/Public/Home/images/police.jpg" alt="" /></a>
        <a href=""><img src="/Public/Home/images/beian.gif" alt="" /></a>
    </p>
</div>
<!-- 底部版权 end -->

</body>
</html>
<script>
    /*ajax判断登录状态*/
    $.ajax({
       type:'GET',
        url:"<?php echo U('Member/ajaxChkLogin');?>",
        dataType:"json",
        success:function (data) {
           console.log(data);
           var li = null;
           if(data.login == 1)
           {
                li = '您好，'+data.username+ '[<a href="<?php echo U('Member/logout');?>">退出</a>]';
           }
           else
            {
                 li = '您好a，欢迎来到京西！[<a href="<?php echo U("Member/login");?>">登录</a>] [<a href="<?php echo U('Member/regist');?>">免费注册</a>]';
            }
            $('#login_info').html(li);
        }

    });
</script>