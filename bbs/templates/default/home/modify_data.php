<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--修改资料-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
    <title>少年宫</title>
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/modify_data.css" />
    <!--地址插件-->
    <link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/layout.min.css" rel="stylesheet">
    <link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/scs.min.css" rel="stylesheet">
<body>
    <div class="modify_data">
        <div class="reg_top overflow">
            <button type="button" class="btn oprev">
              <span class="glyphicon glyphicon-chevron-left"></span>
            </button>
            <span class="col-xs-12 text-center">修改资料</span>
        </div>
        <form class="overflow mo_form" enctype="multipart/form-data" method="post" id="submitForm">
            <div class="mo_content">
                <div class="overflow">
                   <div class="col-xs-12 avatar oveflow">
                     <img src="<?php echo $output['info']['headimgurl']?$output['info']['headimgurl'].'!product-60':BBS_RESOURCE_SITE_URL.'/bootstrap/img/logo.png'?>" class="col-xs-3 pull-left" />
                     <div class="file-box pull-right" >
                        <input type="file" class="file-btn" id="up_img" name="photo"/>
                        <span>修改头像></span>
                    </div>
                   </div>
                </div>
                <div class="overflow">
                    <div class="col-xs-12 name">
                        <div class="row">
                            <span class="col-xs-4">我的昵称：</span>
                            <input type="text" name="nick_name" class="col-xs-8 u_name" placeholder="请填写昵称" 
                            value="<?php echo $output['info']['nick_name']?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 name">
                        <div class="row">
                            <span class="col-xs-4">联系电话：</span>
                            <input type="text" name="member_phone" class="col-xs-8 u_phone" placeholder="请填写手机号码" 
                            value="<?php echo $output['info']['member_phone']?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 name">
                        <div class="row">
                            <span class="col-xs-4">我的地址：</span>
                            <input type="text" class="col-xs-8 u_city" id="myAddrs" name="addr" data-key="<?php echo $output['info']['address1']?>" value="<?php echo $output['info']['address2']?>" placeholder="请选择城市" readonly=""  />
                            <input type="hidden" id="value2" name="" />
                            <textarea placeholder="详细地址" class="col-xs-8 pull-right u_cityData data" name="address"><?php echo $output['info']['address']?></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="address1" id="address1" value="<?php echo $output['info']['address1']?>">
                </div>
            </div>
        </form>
        <div class="management overflow">
            <div class="col-xs-8">
                <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/manage.png" />
                <span>身份信息管理</span>
            </div>
            <div class="col-xs-4 text-right">
                <span class="glyphicon glyphicon-plus"></span>
            </div>
        </div>
        <div class="overflow">
            <button class="col-xs-10 col-xs-offset-1 mo_btn">完成</button>
        </div>
        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-sm row" role="document">
            <div class="modal-content col-xs-10 point col-xs-offset-1">
                 <h4 class="col-xs-12 text-center">提示</h4>
                 <h5 class="col-xs-12 text-center point_txt"></h5>
                 <button class="btn btn-success col-xs-8 col-xs-offset-2 aHide">确定</button>
            </div>
          </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/modify_data.js"></script>
    <!--地址插件-->
    <script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/jquery.scs.min.js"></script>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/CNAddrArr.min.js"></script>
</body>
</html>