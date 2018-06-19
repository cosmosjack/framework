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
               <li class="active" data-id="0">全部</li>
               <?php foreach($output['cls_data'] as $val):?>
               <li data-id="<?php echo $val['id'];?>"><?php echo $val['cls_name'];?></li>
             <?php endforeach;?>
           </ul> 
        </div>
        <div class="gr_content overflow">
           
        </div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/growth_record.js"></script>
</body>
</html>