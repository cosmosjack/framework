<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--订单退款-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>少年宫-订单</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/order_refund.css" />
<body>
    <div class="order_refund">
    	<div class="reg_top overflow">
	        <span class="col-xs-12 text-center">我的订单</span>
    	</div>
    	<!--导航-->
    	<div class="nav overflow text-center">
    		<div class="col-xs-3" href_url="<?php echo urlBBS('order','index')?>">
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/unpaid.png" class="col-xs-8 col-xs-offset-2" />
    			<span>待付款</span>
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
    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/refund_s.png" class="col-xs-8 col-xs-offset-2" />
    			<span class=" active">退款</span>
    		</div>
        </div>
        <!--如果无数据-->
        <!-- <div class="no_data container-fluid">
            <div class="row">
                 <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/null.png" class="col-xs-6 col-xs-offset-3" />
                 <p class="col-xs-12 text-center">还没有订单内容</p>
            </div>
        </div> -->
        <!--如果有数据-->
        <!--产品-->
        <!-- <div class="content container-fluid">
        	<div class="order_pro overflow">
        	 	<div class="col-xs-12 overflow">
        	 		<div class="orpro_img col-xs-4 overflow" href_url="../product_deta/product_deta.html">
        	 			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/img2.jpg" class="col-xs-12" />
        	 		</div>
        	 		<div class="col-xs-5 order_pro_txt" href_url="../product_deta/product_deta.html">
        	 			<p class="pro_title">宝贝加油！亲子互动宝贝加油！亲子互动宝贝加油！亲子互动</p>
        	 			<p class="pro_class">亲子活动 | 成长</p>
        	 			<p class="pro_Time">3月15日一天</p>
        	 		</div>
        	 		<div class="col-xs-3 price_sum">
        	 			<p class="price text-center">&yen;360</p>
        	 			<div class="text-center">
        	 				<span class="sum">数量：1</span>
        	 			</div>
        	 			<button class="pay" href_url="../product_deta/product_deta.html">处理中</button>
        	 		</div>
        	 	</div>
        	</div>
            <div class="order_pro overflow">
        	 	<div class="col-xs-12 overflow">
        	 		<div class="orpro_img col-xs-4 overflow" href_url="../product_deta/product_deta.html">
        	 			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/img2.jpg" class="col-xs-12" />
        	 		</div>
        	 		<div class="col-xs-5 order_pro_txt" href_url="../product_deta/product_deta.html">
        	 			<p class="pro_title">宝贝加油！亲子互动宝贝加油！亲子互动宝贝加油！亲子互动</p>
        	 			<p class="pro_class">亲子活动 | 成长</p>
        	 			<p class="pro_Time">3月15日一天</p>
        	 		</div>
        	 		<div class="col-xs-3 price_sum">
        	 			<p class="price text-center">&yen;360</p>
        	 			<div class="text-center">
        	 				<span class="sum">数量：1</span>
        	 			</div>
        	 			<button class="pay" href_url="../product_deta/product_deta.html">已退款</button>
        	 		</div>
        	 	</div>
        	</div>
            <div class="order_pro overflow">
        	 	<div class="col-xs-12 overflow">
        	 		<div class="orpro_img col-xs-4 overflow" href_url="../product_deta/product_deta.html">
        	 			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/img2.jpg" class="col-xs-12" />
        	 		</div>
        	 		<div class="col-xs-5 order_pro_txt" href_url="../product_deta/product_deta.html">
        	 			<p class="pro_title">宝贝加油！亲子互动宝贝加油！亲子互动宝贝加油！亲子互动</p>
        	 			<p class="pro_class">亲子活动 | 成长</p>
        	 			<p class="pro_Time">3月15日一天</p>
        	 		</div>
        	 		<div class="col-xs-3 price_sum">
        	 			<p class="price text-center">&yen;360</p>
        	 			<div class="text-center">
        	 				<span class="sum">数量：1</span>
        	 			</div>
        	 			<button class="pay" href_url="../product_deta/product_deta.html">处理中</button>
        	 		</div>
        	 	</div>
        	</div>
            <div class="order_pro overflow">
        	 	<div class="col-xs-12 overflow">
        	 		<div class="orpro_img col-xs-4 overflow" href_url="../product_deta/product_deta.html">
        	 			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/img2.jpg" class="col-xs-12" />
        	 		</div>
        	 		<div class="col-xs-5 order_pro_txt" href_url="../product_deta/product_deta.html">
        	 			<p class="pro_title">宝贝加油！亲子互动宝贝加油！亲子互动宝贝加油！亲子互动</p>
        	 			<p class="pro_class">亲子活动 | 成长</p>
        	 			<p class="pro_Time">3月15日一天</p>
        	 		</div>
        	 		<div class="col-xs-3 price_sum">
        	 			<p class="price text-center">&yen;360</p>
        	 			<div class="text-center">
        	 				<span class="sum">数量：1</span>
        	 			</div>
        	 			<button class="pay" href_url="../product_deta/product_deta.html">处理中</button>
        	 		</div>
        	 	</div>
        	</div>
        </div> -->
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/order_refund.js"></script>
</body>
</html>