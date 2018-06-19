<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--明星领队详情-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
	<title>好少年-领队详情</title>
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/leader_detail.css" />
<body>
    <div class="leader_detail">
    	<div class="top overflow">
    	 	<div class="overflow col-xs-12 top_opver">
    	 	 	<span class="glyphicon glyphicon-menu-left oprev"></span>
    	 	</div>
    	 	<div class="logo text-center container-fluid">
	    		 <img src="<?php echo $output['info']['headimgurl']?$output['info']['headimgurl']:BBS_RESOURCE_SITE_URL.'/bootstrap/img/logo.png'?>" class="u_img" />
	    		 <h4 class="col-xs-12 u_name"><?php echo $output['info']['nick_name']?$output['info']['nick_name']:$output['info']['member_name'];?></h4>
	    		 <div class="grade_gender col-xs-12">
	    		    <div class="row">
	    		    	<!-- <div class="col-xs-5 text-right"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/girl.png" class="u_gen" /></div> -->
		    		 	 <!-- <div class="col-xs-1 text-left">|</div> -->
		    		 	 <div class="col-xs-12 text-center"><span>勋章:</span><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/level<?php echo $output['level']?>.png" class="u_gra" /></div>
	    		    </div>
	    		 	<div class="col-xs-12 text-center">电话号码：<span class="phone"><?php echo phoneLink($output['info']['member_phone'])?></span></div>
	    		 </div>
	    	</div>
    	</div>
    	<div class="le_content overflow">
    		<div class="col-xs-12">
    			<div class="overflow le_data text-center">
    				<div class="col-xs-6">
    					<p><?php echo $output['childCount']?></p>
    					<p>带儿童数</p>
    				</div>
    				<div class="col-xs-6">
    					<p><?php echo $output['activityCount']?></p>
    					<p>活动次数</p>
    				</div>
    			</div>
    		</div>
    		<div class="col-xs-12">
    			<!-- <p class="le_txt">
    			好少年一号：此乃七娃合体，性格刚烈，指东打西，专治各
				种不服，上天入地下海无所不能：复员军人枪械修理师，专业休
				闲潜水教练，海豚海狮白鲸驯养师，街道办事处党委委员...深得
				宝爸宝妈青睐，好评如潮，好好少年奇葩领队之一，好好少年城
				市负责人。
				</p> -->
    		</div>
    	</div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/leader_detail.js"></script>
</body>
</html>