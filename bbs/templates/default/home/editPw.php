<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--修改密码-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
    <title>好少年-修改密码</title>
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/amend_pwd.css" />
</head>
<body>
    <div class="amend_pwd">
        <!--头部-->
        <div class="reg_top oveflow">
            <button type="button" class="btn oprev">
              <span class="glyphicon glyphicon-chevron-left"></span>
            </button>
            <span class="col-xs-12 text-center">修改密码</span>
        </div>
        <div class="amend_content overflow">
            <div class="col-xs-12 overflow student_inf_txt">
                <div class="overflow">
                    <span class="col-xs-4 text-center">输入新密码:</span>
                    <input type="password" name="" class="col-xs-8 pwd" />
                </div>
            </div>
            <div class="col-xs-12 overflow student_inf_txt">
                <div class="overflow">
                    <span class="col-xs-4 text-center">确认新密码:</span>
                    <input type="password" name="" class="col-xs-8 pwd_n" />
                </div>
            </div>
            <div class="col-xs-12 overflow student_inf_txt">
                <div class="overflow amend_code">
                    <span class="col-xs-4 text-center">短信验证码:</span>
                    <input type="text" name="" class="col-xs-4 code" />
                    <button data-id="<?php echo $_SESSION['userInfo']['member_phone']?>" href_url="<?php echo urlBBS('index','sendMessage')?>">验证码<span id="Time"></span></button>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <button class="amend_btn col-xs-10 col-xs-offset-1" href_url="<?php echo urlBBS('set','editPw')?>">完成</button>
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
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/amend_pwd.js"></script>
</body>
</html>