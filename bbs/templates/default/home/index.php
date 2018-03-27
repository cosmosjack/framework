<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--首页-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>少年宫-首页</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/home.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/swiper-3.4.2.min.css" />
<body>
    <div class="home">
    	<div class="home_top">
    	     <div class="row">
    	     	<!-- <span class="col-xs-3 text-center">惠州<span class="glyphicon glyphicon-menu-down"></span></span> -->
    	     	<div class="inp row col-xs-12">
    	     		<input type="text" name="" class="col-xs-12" />
    	     		<span class="glyphicon glyphicon-search"></span>
    	     	</div>
    	     </div>
    	</div>
        <div class="swiper-container">
		    <div class="swiper-wrapper">
		        <div class="swiper-slide"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/banner0.jpg" /></div>
		        <div class="swiper-slide"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/banner1.jpg" /></div>
		        <div class="swiper-slide"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/banner2.jpg" /></div>
		    </div>
		    <!-- 如果需要分页器 -->
		    <div class="swiper-pagination"></div>
		</div>
        <div class="nav overflow text-center">
    		<div class="col-xs-3" href_url="<?php echo urlBBS('activity','activityType')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/exercise.png" class="col-xs-12 center-block" />
    			<span class="col-xs-12">活动类型</span>
    		</div>
    		<div class="col-xs-3" href_url="<?php echo urlBBS('activity','babyVideo')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/video.png" class="col-xs-12 center-block" />
    			<span class="col-xs-12">宝贝视频</span>
    		</div>
    		<div class="col-xs-3" href_url="<?php echo urlBBS('activity','arrange')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/schedule.png" class="col-xs-12 center-block" />
    			<span class="col-xs-12">活动排期</span>
    		</div>
    		<div class="col-xs-3" href_url="<?php echo urlBBS('activity','starLeader')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/leader.png" class="col-xs-12 center-block" />
    			<span class="col-xs-12">明星领队</span>
    		</div>
        </div>
        <div class="content container-fluid">
        	 <div class="title row">
        	 	 <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/title.png" class="col-xs-12"  />
        	 </div>
        	 <!--产品-->
        	<div class="index_pro">
        	 	<div class="row index_pro_Img">
        	 		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/img0.jpg" class="col-xs-10 col-xs-offset-1 pro_img" />
                    <!-- <div class="col-xs-10 col-xs-offset-1 Prompt text-right"><span>已经满额<span></div> -->
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
        	 				<span class="past">13</span>/<span class="sum">20</span>
        	 			</span>
        	 		</div>
        	 	</div>
        	 	<div class="row time_price">
        	 		<div class="col-xs-10 col-xs-offset-1">
        	 			<div class="pull-left">
        	 				<p>3月15日一天</p>
                            <p class="price">&yen;360</p>
        	 			</div>
        	 			<div class="row pull-left text-right">
        	 				<button class="pro_btn">去订票</button>
        	 			</div>
        	 		</div>
        	 	</div>
        	</div>
        	<div class="index_pro">
        	 	<div class="row index_pro_Img">
        	 		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/img0.jpg" class="col-xs-10 col-xs-offset-1 pro_img" />
                    <div class="col-xs-10 col-xs-offset-1 Prompt text-right"><span>即将满额<span></div>
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
        	 				<span class="past">16</span>/<span class="sum">20</span>
        	 			</span>
        	 		</div>
        	 	</div>
        	 	<div class="row time_price">
        	 		<div class="col-xs-10 col-xs-offset-1">
        	 			<div class="pull-left">
        	 				<p>3月15日一天</p>
                            <p class="price">&yen;360</p>
        	 			</div>
        	 			<div class="row pull-left text-right">
        	 				<button class="pro_btn">去订票</button>
        	 			</div>
        	 		</div>
        	 	</div>
        	</div>
        	<div class="index_pro">
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
        	 			<div class="pull-left">
        	 				<p>3月15日一天</p>
                            <p class="price">&yen;360</p>
        	 			</div>
        	 			<div class="row pull-left text-right">
        	 				<button class="pro_btn">已售罄</button>
        	 			</div>
        	 		</div>
        	 	</div>
        	</div>
         </div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/swiper-3.4.2.min.js"></script>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/home.js"></script>
</body>
</html>