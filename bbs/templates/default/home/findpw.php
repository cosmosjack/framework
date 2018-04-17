<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--找回密码-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
	<title>少年宫-找回密码</title>
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/get_back_pwd.css" />
<body>
    <div class="getBackPwd container-fluid">
    	<div class="reg_top row">
    		<button type="button" class="btn oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	        </button>
	        <span class="col-xs-12 text-center">找回密码</span>
    	</div>
    	<div class="form overflow">
    		<div class="pwd col-xs-10 col-xs-offset-1   row">
    			<input type="password" name="" placeholder="请输入密码" class="col-xs-12" />
    		</div>
    		<div class="again_pwd col-xs-10 col-xs-offset-1 row">
    			<input type="password" name="" placeholder="请再输入密码" class="col-xs-12" />
    		</div>
    		<div class="phone col-xs-10 col-xs-offset-1 row">
    			<input type="text" name="" placeholder="请输入绑定的手机号码" class="col-xs-12" />
    		</div>
    		<div class="code col-xs-10  col-xs-offset-1 row">
    			<input type="text" name="" placeholder="请输入验证码" class="col-xs-12" />
    			<button class="code_btn" href_url="<?php echo urlBBS('index','sendMessage')?>">验证码<span id="Time"></span></button>
    		</div>
    		<div class="col-xs-10 col-xs-offset-1">
	    		<div class="col-xs-10 col-xs-offset-1 text-center reg_btn" href_url="<?php echo urlBBS('index','findpw')?>">修改密码</div>
	    	</div>
    	</div>
    	<!--提示框-->
    	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		  <div class="modal-dialog modal-sm row" role="document">
		    <div class="modal-content col-xs-10 point col-xs-offset-1">
		         <h4 class="col-xs-12 text-center">提示</h4>
		         <h5 class="col-xs-12 text-center point_txt"></h5>
		    </div>
		  </div>
		</div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/get_back_pwd.js"></script>
</body>
</html>