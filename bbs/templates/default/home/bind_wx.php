<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--绑定手机-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
	<title>少年宫-绑定手机</title>
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/binding.css" />
<body>
    <div class="binding container-fluid">
    	<div class="reg_top row">
    		<button type="button" class="btn oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	        </button>
	        <span class="col-xs-12 text-center">绑定手机</span>
    	</div>
    	<div class="form row">
    		 <div class="col-xs-12">
    		 	<div class="col-xs-6">请输入手机号：</div>
    		 </div>
    		 <div class="col-xs-12 phone">
    		 	<input type="text" name="" placeholder="手机号码" id="test" class="col-xs-6 col-xs-offset-4" />
    		 </div>
    		 <div class="col-xs-12 code">
    		 	<div class="col-xs-12 row text-center">
    		 		<input type="text" name="" placeholder="验证码" class="col-xs-4 col-xs-offset-4" />
    		 		<button class="binding_btn" href_url="<?php echo urlBBS('index','sendMessage')?>">验证码<span id="Time"></span></button>
    		 	</div>
    		 </div>
    	</div>
    	<div class="row text-center unbin_btn">
			<div class="col-xs-10 col-xs-offset-1" href_url="<?php echo urlBBS('index','bind_wx')?>">完成</div>
		</div>
		<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		  <div class="modal-dialog modal-sm row" role="document">
		    <div class="modal-content col-xs-10 point col-xs-offset-1">
		         <h4 class="col-xs-12 text-center">提示</h4>
		         <h5 class="col-xs-12 text-center point_txt"></h5>
		         <button class="btn btn-success col-xs-8 col-xs-offset-2 Hide">确定</button>
		    </div>
		  </div>
		</div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/binding.js"></script>
</body>
</html>