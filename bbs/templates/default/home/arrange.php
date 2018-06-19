<?php defined('InCosmos') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>好少年-活动排期</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/arrange.css" />
<body>
    <div class="arrange">
    	<div class="reg_top overflow">
    		<button type="button" class="btn oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	        </button>
	        <span class="col-xs-12 text-center">活动排期</span>
    	</div>
    	<div class="nav">
    	  	   <div class="overflow text-center nav_index">    
    	  	   	   <div class="col-xs-4" href_url="three" data-id="<?php echo date('n',time())-1;?>"><span  class="active"><?php echo date('n',time())-1;?>月</span> </div>
                   <div class="col-xs-4" href_url="four" data-id="<?php echo date('n',time())?>"><span><?php echo date('n',time())?>月 </span></div>
                   <div class="col-xs-4" href_url="five" data-id="<?php echo date('n',time())+1;?>"><span><?php echo date('n',time())+1;?>月 </span></div>
    	  	   </div>
    	</div>
    	<!--3月-->
        <div class="a_content three container-fluid">
        	
        	
        </div>
        <!--4月-->
        <div class="a_content four container-fluid" style="display: none;">
        	
        	
        </div>
        <!--5月-->
        <div class="a_content five container-fluid" style="display: none;">
        	
        	
        </div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/arrange.js"></script>
</body>
</html>