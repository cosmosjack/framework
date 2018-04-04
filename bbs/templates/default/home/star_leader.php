<?php defined('InCosmos') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>少年宫</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/star_leader.css" />
<body>
    <div class="star_leader container-fluid">
    	<div class="reg_top row">
    		<button type="button" class="btn oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	        </button>
	        <span class="col-xs-12 text-center">明星领队</span>
    	</div>
    	<div class="type_content">
    		<div class="row">
    			<div class="col-xs-4 text-center click" onclick="Href('<?php echo urlBBS('activity','leaderDetail')?>')">
    				<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/logo.png" class="img-responsive center-block" />
    				<span>好少年一号</span>
    			</div>
    			<div class="col-xs-4 text-center click">
    				<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/logo.png" class="img-responsive center-block" />
    				<span>好少年二号</span>
    			</div>
    			<div class="col-xs-4 text-center click">
    				<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/logo.png" class="img-responsive center-block" />
    				<span>好少年三号</span>
    			</div>
    			<div class="col-xs-4 text-center click">
    				<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/logo.png" class="img-responsive center-block" />
    				<span>好少年四号</span>
    			</div>
    			<div class="col-xs-4 text-center click">
    				<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/logo.png" class="img-responsive center-block" />
    				<span>好少年五号</span>
    			</div>
    			<div class="col-xs-4 text-center click">
    				<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/logo.png" class="img-responsive center-block" />
    				<span>好少年六号</span>
    			</div>
    		</div>
    	</div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/star_leader.js"></script>
</body>
</html>