<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--身份信息管理选择-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
	<title>少年宫-选择查看对象</title>
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/manager_select.css" />
<body>
    <div class="manager_select">
        <!--头部-->
    	<div class="reg_top overflow">
    		<button type="button" class="btn oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	        </button>
	        <span class="text-center col-xs-11 col-xs-offset-1">
	        <span class="pull-left">身份信息管理</span>
	        <span class="pull-right explain">说明？</span>
	        </span>
    	</div>
    	<div class="overflow manager">
    		<div class="col-xs-12" href_url="<?php echo urlBBS('set','manageInfo')?>">
    		   <div>
    		   	    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/guardian.png" />
    				<span>监护人</span>
    		   </div>
    			
    		</div>
    		<div class="col-xs-12" href_url="<?php echo urlBBS('set','studentInfo')?>"">
	    		<div>
	    			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/child.png" />
	    			<span>学员（儿童）</span>
	    		</div>
    		</div>
    	</div>
    	<!--弹框-->
        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-sm row" role="document">
            <div class="modal-content col-xs-10 point text-center col-xs-offset-1">
                  
            </div>
          </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/manager_select.js"></script>
</body>
</html>