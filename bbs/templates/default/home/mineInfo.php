<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--个人信息-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
    <title>少年宫-个人信息</title>
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/mine_info.css" />
<body>
    <div class="mine_info container-fluid">
        <div class="reg_top row">
            <button type="button" class="btn oprev">
              <span class="glyphicon glyphicon-chevron-left"></span>
            </button>
            <span class="col-xs-12 text-right">
                <span class="alter" id="alter" href_url="<?php echo urlBBS('set','editInfo');?>">修改资料</span>
            </span>
        </div>
        <div class="content">
            <div class="row">
               <div class="col-xs-12 avatar">
                 <span>我的头像：</span>
                 <img src="<?php echo $output['info']['headimgurl']?$output['info']['headimgurl'].'!product-60':BBS_RESOURCE_SITE_URL.'/bootstrap/img/logo.png'?>" class="col-xs-3 pull-right" id="view_img" />
               </div>
            </div>
            <div class="row">
                <div class="col-xs-12 name">
                    <div class="row">
                        <span class="col-xs-4">我的昵称：</span>
                        <span class="col-xs-8 text-right"><?php echo $output['info']['nick_name']?></span>
                    </div>
                </div>
                <div class="col-xs-12 name">
                    <div class="row">
                        <span class="col-xs-4">联系电话：</span>
                        <span class="col-xs-8 text-right"><?php echo $output['info']['member_phone']?></span>
                    </div>
                </div>
                <div class="col-xs-12 name">
                    <div class="row">
                        <span class="col-xs-4">我的地址：</span>
                        <span class="col-xs-8 text-left city"><?php echo $output['info']['address']?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="management row overflow" id="management" href_url="<?php echo urlBBS('set','manageSelect')?>">
            <div class="col-xs-8">
                <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/manage.png" />
                <span>身份信息管理</span>
            </div>
            <div class="col-xs-4 text-right">
                <span class="glyphicon glyphicon-plus"></span>
            </div>
        </div>
    <div class="view_img">
        <img src="" class="col-xs-12" />
    </div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/mine_info.js"></script>
</body>
</html>