<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--成长记录页面-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>好少年</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/growth_record.css" />
<body>
    <div class="growth_record">
    	<!--头部-->
    	<div class="reg_top oveflow">
    		<button type="button" class="btn oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	        </button>
	        <span class="col-xs-12 text-center">成长记录</span>
    	</div>
    	<div class="title overflow">
           <ul class="title_ul">
               <li class="active">全部</li>
               <li>夏冬令营</li>
               <li>城市实践体验</li>
               <li>少年独立团</li>
               <li>植树节</li>
               <li>亲子活动</li>
           </ul> 
        </div>
        <div class="gr_content overflow">
          <!--当有数据时展现-->
        	 <div class="col-xs-12">
        	   <div class="overflow gr_pro">
	        	   	<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/img2.jpg" class="col-xs-4 gr_img" />
	        		<div class="col-xs-8 gr_txt">
	        			 <p class="gr_title">
	        			 	<span>3.12大型植树节活动</span><span class="glyphicon glyphicon-menu-right pull-right"></span>
	        			 </p>
	        			 <p class="vice_title">3.12植树节组织植树自然体验活动，当日好少年一号带领4名学员前往惠州西湖门口进行...</p>
	        			 <p class="time_class"><span>2018-3-12</span><span>植树 | 体验 | 自然</span></p>
	        		</div>
        	   </div>
        	</div>
        	<div class="col-xs-12">
        	   <div class="overflow gr_pro">
	        	   	<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/img2.jpg" class="col-xs-4 gr_img" />
	        		<div class="col-xs-8 gr_txt">
	        			 <p class="gr_title">
	        			 	<span>3.12大型植树节活动</span><span class="glyphicon glyphicon-menu-right pull-right"></span>
	        			 </p>
	        			 <p class="vice_title">3.12植树节组织植树自然体验活动，当日好少年一号带领4名学员前往惠州西湖门口进行...</p>
	        			 <p class="time_class"><span>2018-3-12</span><span>植树 | 体验 | 自然</span></p>
	        		</div>
        	   </div>
        	</div> 
           <!--当无数据时展现-->
           <!--<div class="no_data container-fluid">
	            <div class="row">
	                 <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/null.png" class="col-xs-6 col-xs-offset-3" />
	                 <p class="col-xs-12 text-center">还没有订单内容</p>
	            </div>
	        </div>-->
        </div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/growth_record.js"></script>
</body>
</html>