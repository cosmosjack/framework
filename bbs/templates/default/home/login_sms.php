<?php defined('InCosmos') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
	<title>少年宫</title>
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/sms.css" />
<body>
    <div class="sms container-fluid">
    	 <div class="reg_top row">
    		<button type="button" class="btn oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	        </button>
	        <span class="col-xs-12 text-center">短信登录</span>
    	</div>
    	<div class="form">
            <div class="phone col-xs-10 col-xs-offset-1   row">
    			<input type="text" name="" placeholder="请输入手机号码" class="col-xs-12" />
    		</div>
    		<div class="code col-xs-10  col-xs-offset-1 row">
    			<input type="text" name="" placeholder="请输入验证码" class="col-xs-12" />
    			<button class="code_btn" href_url="<?php echo urlBBS('index','sendMessage')?>">验证码<span id="Time"></span></button>
    		</div>
    		<div class="col-xs-10  col-xs-offset-1 row text-center sms_btn">
    			<div class="col-xs-12" href_url="<?php echo urlBBS('index','login_sms')?>">登录</div>
    		</div>
    	</div>
    	<div class="sms_txt col-xs-12 text-center">好少年宫活动发布平台</div>
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
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/sms.js"></script>
</body>
</html>