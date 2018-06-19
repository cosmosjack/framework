<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--自然教育-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>好少年-类型介绍</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/nature_teach.css" />
<body>
    <div class="nature_teach">
    	<!--头部-->
    	<div class="reg_top overflow">
    		<button type="button" class="btn oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	        </button>
	        <span class="col-xs-12 text-center"><?php echo $output['info']['cls_name']?></span>
    	</div>
        <!--头部end-->
        <div class="a_content three container-fluid">
          
        </div>
        <input type="hidden" value="<?php echo $output['info']['id']?>" id="cls_id">
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/nature_teach.js"></script>
</body>
</html>