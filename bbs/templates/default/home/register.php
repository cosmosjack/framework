<?php defined('InCosmos') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
	<title>少年宫</title>
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/regist.css" />
<body>
    <div class="regist container-fluid">
    	<div class="reg_top row">
    		<button type="button" class="btn oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	        </button>
	        <span class="col-xs-12 text-center">注册账号</span>
    	</div>
    	<div class="logo text-center row">
    		 <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/logo.png" class="col-xs-4 col-xs-offset-4" />
    		 <h4 class="col-xs-12 test">好少年宫活动发布平台</h4>
    	</div>
    	<div class="form row">
    		<div class="phone col-xs-10 col-xs-offset-1   row">
    			<input type="text" name="" placeholder="请输入手机号码" class="col-xs-12" />
    		</div>
    		<div class="pwd col-xs-10 col-xs-offset-1 row">
    			<input type="password" name="" placeholder="请设置密码" class="col-xs-12" />
    		</div>
    		<div class="code col-xs-10  col-xs-offset-1 row">
    			<input type="text" name="" placeholder="请输入验证码" class="col-xs-12" />
    			<button class="code_btn" href_url="<?php echo urlBBS('index','sendMessage')?>">验证码<span id="Time"></span></button>
    		</div>
    		<div class="pact text-center col-xs-10 col-xs-offset-1 row" id="pact">
			        <span class="re_radio" id="re_radio"><span></span></span>
			       我已阅读并同意 <span class="href_url" href_url='url'>《好少年宫活动协议》</span>
			</div>
    	</div>
    	<div class="col-xs-10 col-xs-offset-1">
    		<div class="col-xs-10 col-xs-offset-1 text-center reg_btn" href_url="<?php echo urlBBS('index','register')?>" >注册</div>
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
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/regist.js"></script>
</body>
</html>