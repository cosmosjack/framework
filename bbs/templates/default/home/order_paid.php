<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--订单已付款-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>好少年-订单</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/order_paid.css" />
<body>
    <div class="order_paid">
    	<div class="reg_top overflow">
	        <span class="col-xs-12 text-center">我的订单</span>
    	</div>
    	<!--导航-->
    	<div class="nav overflow text-center">
    		<div class="col-xs-3" href_url="<?php echo urlBBS('order','index')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/unpaid_s.png" class="orderImg" />
    			<span>待付款</span>
    		</div>
    		<div class="col-xs-3" href_url="<?php echo urlBBS('order','orderPaid')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/paid_s.png" class="orderImg" />
    			<span  class=" active">已付款</span>
    		</div>
    		<div class="col-xs-3" href_url="<?php echo urlBBS('order','orderCompleted')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/completed_s.png" class="orderImg" />
    			<span>已完成</span>
    		</div>
    		<div class="col-xs-3" href_url="<?php echo urlBBS('order','orderRefund')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/refund_s.png" class="orderImg" />
    			<span>退款</span>
    		</div>
        </div>
        
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/order_paid.js"></script>
</body>
</html>