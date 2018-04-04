<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--订单详情-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>少年宫-订单</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/order_deta.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/swiper-3.4.2.min.css" />
<body>
    <div class="order_deta">
    	<!--头部-->
    	<div class="home_top">
    	     <div class="row">
    	     	<div class="col-xs-12">
    	     		<span class="pull-left col-xs-4 glyphicon glyphicon-menu-left" onclick="javascript:history.back(-1);"></span>
    	     		<p class="col-xs-4 text-center od_title"></p>
    	     		<div class="col-xs-4 overflow">
    	     			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/share.png" class="pull-right share_icon">
    	     			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_n.png" class="pull-right collect_icon" />
    	     		</div>
    	     	</div>
    	     </div>
    	</div>
        <!--轮播图-->
    	<div class="swiper-container">
		    <div class="swiper-wrapper">
		        <div class="swiper-slide"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/banner0.jpg" /></div>
		        <div class="swiper-slide"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/banner1.jpg" /></div>
		        <div class="swiper-slide"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/banner2.jpg" /></div>
		    </div>
		    <!-- 如果需要分页器 -->
		    <div class="swiper-pagination"></div>
		</div>
		<div class="odpro_title overflow">
			<div class="col-xs-7">
				<span class="city">【惠州】</span>宝贝加油，亲子互动这里是标题这里是标题如果太长就这样换行【惠州】宝贝加油，亲子互动这里是标题这里是标题如果太长就这样换行
			</div>
			<div class="col-xs-5">
				<span>参与人数：</span><span class="join">16</span>/<span>20</span>
			</div>
		</div>
        <div class="pro_class overflow">
             <p class="col-xs-12">亲子活动 | 成长 | 挑战活动</p>
        </div>
        <div class="price_time overflow">
            <div class="col-xs-12 overflow">
                <span class="price">&yen;360.0</span>
                <span class="importance coupon">优惠券兑换>></span>
                <span class="time pull-right">报名截止3月12日</span>
            </div>
        </div>
        <div class="pro_content">
            <div class="pta overflow container-fluid">
                <div class="col-xs-12">
                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/place.png" class="col-xs-2" /><span>惠州市东湖西路5号</span>
                </div>
                <div class="col-xs-12">
                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/time.png" class="col-xs-2" /><span>3月15日一天</span>
                </div>
                <div class="col-xs-12">
                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/age.png" class="col-xs-2" /><span>6~13岁</span>
                </div>
            </div>
            <div class="order_info overflow container-fluid">
                <div class="order_number col-xs-12">
                    <span>订单号：<span class="importance">0123456789876543210</span></span>
                    <span class="ornum_time pull-right">3月10日10：22</span>
                </div>
                <div class="user col-xs-12">
                    <div>
                        <span>联系人：</span>
                        <span>武士彟</span>
                        <span class="user_phone">123 4567 8910</span>
                    </div>
                    <!--已付款的情况下-->
                    <div>
                        <span>消费码：</span>
                        <span>abcdefghijklmn总之这里是消费码</span>
                        <span class="pull-right importance">未验证</span>
                    </div>
                    <!--未付款的情况下-->
                    <!-- <div>
                        <span>消费码：</span>
                        <span>未下单</span>
                        <span class="pull-right importance">未付款</span>
                    </div> -->
                    <!--已完成的情况下-->
                    <!-- <div>
                        <span>消费码：</span>
                        <span>abcdefghijklmn总之这里是消费码</span>
                        <span class="pull-right importance">已完成</span>
                    </div> -->
                    <!--退款中的情况下-->
                    <!-- <div>
                        <span>消费码：</span>
                        <span>已失效</span>
                        <span class="pull-right importance">退款中</span>
                    </div> -->
                    <!--已退款的情况下-->
                    <!-- <div>
                        <span>消费码：</span>
                        <span>已失效</span>
                        <span class="pull-right importance">已退款</span>
                    </div> -->
                    <div>
                        <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/children.jpg" class="user_img" />
                        <span class="user_name">武则天</span>
                        <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/child_boy.png" class="gender_img" />
                        <span class="user_age">9岁</span>
                    </div>
                    <!--女-->
                    <!-- <div>
                        <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/children.jpg" class="user_img" />
                        <span class="user_name">武则天</span>
                        <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/child_girl.png" class="gender_img" />
                        <span class="user_age">9岁</span>
                    </div> -->
                    <!--男-->
                </div>
            </div>
            <div class="eventdetails text-center container-fluid overflow">
                <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/wap_order_detail.png" class="col-xs-12" />
                <div class="re_nav col-xs-12 overflow" id="or_nav">
                    <div class="col-xs-4"><span class="active">活动内容</span> </div>
                    <div class="col-xs-4"><span>活动信息 </span></div>
                    <div class="col-xs-4"><span>推荐活动 </span></div>  
                </div>
                <!--活动内容默认显示-->
                <div class="activityContent overflow col-xs-12 text-left">
                    <span>活动内容</span>
                </div>
                <!--活动信息-->
                <div class="activity_deta_info overflow col-xs-12 text-left">
                    <span>活动信息</span>
                </div>
                <!--推荐活动-->
                <div class="overflow col-xs-12 pro_recom">
                    <div class="index_pro col-xs-12">
                        <div class="row index_pro_Img">
                            <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/timg.jpg" class="col-xs-10 col-xs-offset-1 pro_img" />
                            <div class="col-xs-10 col-xs-offset-1 Prompt text-right"><span>已满额<span></div>
                            <div class="col-xs-10 col-xs-offset-1 mask">
                                <span class="pull-left">惠州市东湖西路5号 6-13岁</span>
                                <span class="pull-left text-right">亲子活动、成长</span>
                            </div>
                        </div>
                        <div class="row pro_tit">
                            <div class="col-xs-10 col-xs-offset-1">
                                <span class="pull-left">
                                    <span class="city">【惠州】</span>宝贝加油，亲子互动
                                </span>
                                <span class="people pull-right text-right">
                                    已参与 
                                    <span class="past">20</span>/<span class="sum">20</span>
                                </span>
                            </div>
                        </div>
                        <div class="row time_price">
                            <div class="col-xs-10 col-xs-offset-1">
                                <div class="pull-left text-left">
                                    <p>3月15日一天</p>
                                    <p class="price">&yen;360</p>
                                </div>
                                <div class="row pull-left text-right">
                                    <button class="pro_btn">去订票</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="index_pro col-xs-12">
                        <div class="row index_pro_Img">
                            <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/img0.jpg" class="col-xs-10 col-xs-offset-1 pro_img" />
                            <div class="col-xs-10 col-xs-offset-1 Prompt text-right"><span>已满额<span></div>
                            <div class="col-xs-10 col-xs-offset-1 mask">
                                <span class="pull-left">惠州市东湖西路5号 6-13岁</span>
                                <span class="pull-left text-right">亲子活动、成长</span>
                            </div>
                        </div>
                        <div class="row pro_tit">
                            <div class="col-xs-10 col-xs-offset-1">
                                <span class="pull-left">
                                    <span class="city">【惠州】</span>宝贝加油，亲子互动
                                </span>
                                <span class="people pull-right text-right">
                                    已参与 
                                    <span class="past">20</span>/<span class="sum">20</span>
                                </span>
                            </div>
                        </div>
                        <div class="row time_price">
                            <div class="col-xs-10 col-xs-offset-1">
                                <div class="pull-left text-left">
                                    <p>3月15日一天</p>
                                    <p class="price">&yen;360</p>
                                </div>
                                <div class="row pull-left text-right">
                                    <button class="pro_btn">去订票</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="or_footer overflow text-center">
        <span class="col-xs-6 total">订单总额：&yen;360.0</span>
        <span class="or_btn col-xs-6">取消订单</span>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/order_deta.js"></script>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/swiper-3.4.2.min.js"></script>
</body>
</html>