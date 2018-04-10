<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--活动足迹-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>少年宫</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/activity_pug.css" />
<body>
    <div class="activity_pug">
    	<!--头部-->
    	<div class="reg_top overflow">
    		<button type="button" class="btn oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	        </button>
	        <span class="col-xs-12 text-center">活动足迹</span>
    	</div>
    	<div class="pug_content overflow">
    		<div class="col-xs-12" href_url="../my_album/my_album.html">
    			<div class="overflow">
    				<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/timg.jpg" class="col-xs-3" />
    				<div class="col-xs-7 pug_txt">
    					<div>活动相册</div>
    					<div class="pug_sum"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/count.png" /><span>62</span></div>
    				</div>
    				<div class="col-xs-2 icon">
    					<span class="glyphicon glyphicon-menu-right"></span>
    				</div>
    			</div>
    		</div>
    		<div class="col-xs-12" href_url="../baby_video/baby_video.html">
    			<div class="overflow">
    				<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/activity_video.png" class="col-xs-3" />
    				<div class="col-xs-7 pug_txt">
    					<div>活动视频</div>
    					<div class="pug_sum"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/count.png" /><span>62</span></div>
    				</div>
    				<div class="col-xs-2 icon">
    					<span class="glyphicon glyphicon-menu-right"></span>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/activity_pug.js"></script>
</body>
</html>