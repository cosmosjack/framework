<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--首页-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>好少年-首页</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/home.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/swiper-3.4.2.min.css" />
<body>
    <div class="home">
    	<div class="home_top">
            <div class="overflow">
                <div class="inp overflow">
                    <input type="text" name="" id="keyword" />
                    <span class="glyphicon glyphicon-search"></span>
                </div>
            </div>
            <input type="hidden" id="order" value="activity_begin_time desc,activity_click desc">
        </div>
        <div class="swiper-container">
		    <div class="swiper-wrapper">
                <?php foreach($output['data_adv']['adv_info'] as $val):?>
		        <div class="swiper-slide banner_url" href_url="<?php echo $val['url']?>">
                    <img title="<?php echo $val['title']?>" src="<?php echo $val['pic']?>!product-360" />
                </div>
                <?php endforeach;?>
		    </div>
		    <!-- 如果需要分页器 -->
		    <div class="swiper-pagination"></div>
		</div>
        <div class="nav overflow text-center">
    		<div class="col-xs-3" id="nav1" href_url="<?php echo urlBBS('activity','activityType')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/exercise.png" class="col-xs-12 center-block" />
    			<span class="col-xs-12">活动类型</span>
    		</div>
    		<div class="col-xs-3" id="nav2" href_url="<?php echo urlBBS('activity','hotActivity')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/activities.png" class="col-xs-12 center-block" />
    			<span class="col-xs-12">热门活动</span>
    		</div>
    		<div class="col-xs-3" id="nav3" href_url="<?php echo urlBBS('activity','arrange')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/schedule.png" class="col-xs-12 center-block" />
    			<span class="col-xs-12">活动排期</span>
    		</div>
    		<div class="col-xs-3" id="nav4" href_url="<?php echo urlBBS('activity','starLeader')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/leader.png" class="col-xs-12 center-block" />
    			<span class="col-xs-12">明星领队</span>
    		</div>
        </div>
        <div class="content">
        	 <div class="title overflow">
        	 	 <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/title.png" class="col-xs-12"  />
        	 </div>
        	 <!--产品-->
        	
        </div>
        <div class="foot_code"><a href="http://www.miitbeian.gov.cn">粤ICP备18047756号-1</a></div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/swiper-3.4.2.min.js"></script>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/home.js"></script>
</body>
</html>