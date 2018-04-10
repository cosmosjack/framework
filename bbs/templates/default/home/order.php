<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--订单未付款-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>少年宫-订单</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/order.css" />
<body>
    <div class="order">
    	<div class="reg_top overflow">
	        <span class="col-xs-12 text-center">我的订单</span>
    	</div>
    	<div class="nav overflow text-center">
    		<div class="col-xs-3" href_url="<?php echo urlBBS('order','index')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/unpaid_s.png" class="col-xs-8 col-xs-offset-2" />
    			<span class=" active">待付款</span>
    		</div>
    		<div class="col-xs-3" href_url="<?php echo urlBBS('order','orderPaid')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/paid.png" class="col-xs-8 col-xs-offset-2" />
    			<span>已付款</span>
    		</div>
    		<div class="col-xs-3" href_url="<?php echo urlBBS('order','orderCompleted')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/completed.png" class="col-xs-8 col-xs-offset-2" />
    			<span>已完成</span>
    		</div>
    		<div class="col-xs-3" href_url="<?php echo urlBBS('order','orderRefund')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/refund.png" class="col-xs-8 col-xs-offset-2" />
    			<span>退款</span>
    		</div>
        </div>
        
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/order.js"></script>
</body>
</html>