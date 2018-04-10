<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--设置页面-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
	<title>少年宫-设置</title>
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/setUp.css" />
<body>
    <div class="setUp container-fluid">
    	<div class="reg_top row">
    		<button type="button" class="btn oprev" >
	          <span class="glyphicon glyphicon-chevron-left"></span>
	        </button>
	        <span class="col-xs-12 text-center">设置</span>
    	</div>
    	<div class="content row">
    		 <div class="col-xs-12" href_url="<?php echo urlBBS('set','mineInfo')?>">
    		 	 <span>个人信息</span>
    		 	 <span class="glyphicon glyphicon-menu-right pull-right"></span>
    		 </div>
    		 <div class="col-xs-12" href_url="<?php echo urlBBS('set','unBind')?>">
    		 	 <span>绑定手机 </span>
    		 	 <span class="glyphicon glyphicon-menu-right pull-right"></span>
    		 </div>
    		 <div class="col-xs-12" href_url="<?php echo urlBBS('set','editPw')?>">
    		 	 <span>修改密码</span>
    		 	 <span class="glyphicon glyphicon-menu-right pull-right"></span>
    		 </div>
    		 <div class="col-xs-12" href_url="<?php echo urlBBS('set','aboutUs')?>">
    		 	 <span>关于我们</span>
    		 	 <span class="glyphicon glyphicon-menu-right pull-right"></span>
    		 </div>
    	</div>
    	<div class="row">
    		<button class="button out_btn col-xs-8 col-xs-offset-2">退出登录</button>
    	</div>
        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
           <div class="modal-dialog modal-sm row" role="document">
                <div class="modal-content col-xs-10 point col-xs-offset-1">
                        <h4 class="col-xs-12 text-center">是否退出登录</h4>
                        <button class="col-xs-6 Hide_url" onclick="Href('<?php echo urlBBS('mine','signOut')?>')">确定</button>
                        <button class="col-xs-6 aHide">取消</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/setUp.js"></script>
</body> 
</html>