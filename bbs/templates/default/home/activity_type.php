<?php defined('InCosmos') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>好少年</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/activity_type.css" />
<body>
    <div class="activity_type container-fluid">
    	<div class="reg_top row">
    		<button type="button" class="btn oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	        </button>
	        <span class="col-xs-12 text-center">活动类型</span>
    	</div>
    	<div class="type_content">
    		<div class="row">
                <?php foreach($output['list'] as $val):?>
    			<div class="col-xs-3 text-center click" onclick="Href('<?php echo urlBBS('activity','introduce',array('id'=>$val['id']))?>')">
    				<img src="<?php echo $val['pic']?$val['pic'].'!product-240':BBS_RESOURCE_SITE_URL.'/bootstrap/img/activitylogo_0.jpg';?>" class="img-responsive center-block" />
    				<span><?php echo $val['cls_name']?></span>
    			</div>
    			<?php endforeach;?>
    		</div>
    	</div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/activity_type.js"></script>
</body>
</html>