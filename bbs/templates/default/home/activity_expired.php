<?php defined('InCosmos') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
	<title>好少年-往期活动</title>
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/activity_expired.css" />
<body>
    <div class="activity_expired">
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
    	  	   	   <div class="col-xs-6" href_url="<?php echo urlBBS('activity','index')?>"><span>推荐活动</span> </div>
    	  	   	   <div class="col-xs-6" href_url="<?php echo urlBBS('activity','activityExpired')?>"><span class="active">往期活动 </span></div>
    	  	   </div>
    	  </div>
    	  
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/activity_expired.js"></script>
</body>
</html>