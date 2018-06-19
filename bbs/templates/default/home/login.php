<?php defined('InCosmos') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
	<title>好少年</title>
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/login.css" />
<body>
    <div class="login container-fluid">
    	<div class="logo text-center row">
    		 <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/logo.png" class="col-xs-4 col-xs-offset-4" />
    		 <h4 class="col-xs-12 test">好少年活动发布平台</h4>
    	</div>
    	<div class="form row">
    		<div class="phone col-xs-10 col-xs-offset-1 row">
    			<input type="text" name="" placeholder="请输入手机号码" class="col-xs-12" />
    		</div>
    		<div class="pwd col-xs-10 col-xs-offset-1 row">
    			<input type="password" name="" placeholder="请输入密码" class="col-xs-12" />
    			<span class="url" href_url="<?php echo urlBBS('index','findpw')?>">忘记密码？</span>
    		</div>
    	</div>
    	<div class="reg row">
    		<span class="col-xs-5 text-right url" href_url="<?php echo urlBBS('index','login_wx')?>">微信登录</span>
    		<span class="col-xs-2 text-center">|</span>
    		<span class="col-xs-5 text-left url" href_url="<?php echo urlBBS('index','login_sms')?>">短信登录</span>
    	</div>
    	<div class="Btn col-xs-8 col-xs-offset-2 row">
    		<span class="col-xs-5 text-center url" href_url="<?php echo urlBBS('index','register')?>">注册</span>
    		<span class="col-xs-2 text-center">|</span>
    		<span class="col-xs-5 text-center" href_url="<?php echo urlBBS('index','login')?>" id="login_btn">登录</span>
    	</div>
		<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		  <div class="modal-dialog modal-sm row" role="document">
		    <div class="modal-content col-xs-10 point col-xs-offset-1">
		         <h4 class="col-xs-12 text-center">提示</h4>
		         <h5 class="col-xs-12 text-center point_txt"></h5>
		    </div>
		  </div>
		</div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/login.js"></script>
</body>
</html>