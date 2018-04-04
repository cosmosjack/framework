<?php defined('InCosmos') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
	<title>少年宫-推荐活动</title>
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/activity.css" />
    
<body>
     <div class="activity">
     	<div class="home_top">
             <div class="overflow">
                <div class="inp overflow">
                    <input type="text" name="" id="keyword" />
                    <span class="glyphicon glyphicon-search"></span>
                </div>
             </div>
        </div>
    	  <div class="nav">
    	  	   <div class="overflow text-center nav_index">    
    	  	   	   <div class="col-xs-6" href_url="<?php echo urlBBS('activity','index')?>"><span  class="active">推荐活动</span> </div>
                   <!-- <div class="col-xs-4" href_url=""><span>活动直播 </span></div> -->
                   <div class="col-xs-6" href_url="<?php echo urlBBS('activity','activityExpired')?>"><span>往期活动 </span></div>
    	  	   </div>
    	  </div>
    	  <!-- <div class="content container-fluid">
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
          </div> -->
		  
     </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/activity.js"></script>
</body>
</html>