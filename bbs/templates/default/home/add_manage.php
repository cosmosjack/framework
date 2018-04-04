<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--添加监护人-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>好少年-添加监护人</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/push_student.css" />
    <link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/mobiscroll_002.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/mobiscroll.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/mobiscroll_003.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="push_student">
    	<!--头部-->
    	<div class="reg_top overflow">
    		<button type="button" class="btn oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	        </button>
	        <span class="text-center col-xs-11 col-xs-offset-1">
	        <span class="pull-left">新增监护人</span>
	        <span class="pull-right explain">说明？</span>
	        </span>
    	</div>
        <div class="id_content container-fluid">
            <!--监护人信息-->
            <form enctype="multipart/form-data" method="post" id="submitForm">
            <div class="student row">
                <div class="overflow">
                    <div class="col-xs-12 student_inf_txt">
                        <div class="overflow userImg">
                            <span class="col-xs-4 text-left">头像:</span>
                            <img src="<?php echo $output['info']['headimgurl']?$output['info']['headimgurl'].'!product-60':BBS_RESOURCE_SITE_URL.'/bootstrap/img/logo.png';?>" />
                            <div class="file-box pull-right" >
                                <input type="file" class="file-btn" id="up_img" name="photo"/>
                                <span>></span>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-xs-12 student_inf_txt">
                       <div class="overflow">
                           <span class="col-xs-4 text-left">姓名:</span>
                           <input type="text" name="u_name" class="col-xs-8 u_name" value="<?php echo $output['info']['parents_name']?>"/>
                       </div>
                    </div>
                    <div class="col-xs-12 overflow student_inf_txt">
                        <div class="overflow">
                            <span class="col-xs-4 text-left">证件类型:</span>
                            <span class="col-xs-8">内地身份证</span>
                        </div>
                    </div>
                    <div class="col-xs-12 overflow student_inf_txt">
                        <div class="overflow">
                            <span class="col-xs-4 text-left">证件号码:</span>
                            <input type="text" name="u_idnum" class="col-xs-8 u_idnum" value="<?php echo $output['info']['parents_papers_no']?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 overflow student_inf_txt">
                        <div class="overflow">
                            <span class="col-xs-4 text-left">出生年月:</span>
                            <input type="text" name="u_born" class="col-xs-8 u_born" id="appDate" value="<?php echo $output['info']['parents_brithday']?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 overflow student_inf_txt">
                        <div class="overflow">
                            <span class="col-xs-4 text-left">性别:</span>
                            <input type="text" name="u_gender" class="col-xs-8 u_gender" data-id="<?php echo $output['info']['child_sex'];?>" value="<?php echo $output['info']['parents_sex']==1?'男':'女'?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 overflow student_inf_txt">
                        <div class="overflow">
                            <span class="col-xs-4 text-left">手机号:</span>
                            <input type="text" name="u_phone" class="col-xs-8 u_phone" value="<?php echo $output['info']['parents_phone']?>"/>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $output['info']['id'];?>">
                </div>
            </div>
            </form>
            <!--完成按钮-->
            <div class="btn col-xs-12">
                <input type="hidden" id="flag" value="<?php echo $output['info']['id']?$output['info']['id']:'';?>">
                <button class="col-xs-12">完成</button>
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
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/push_manage.js"></script>
    <script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/mobiscroll_002.js" type="text/javascript"></script>
    <script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/mobiscroll_004.js" type="text/javascript"></script>
    <script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/mobiscroll.js" type="text/javascript"></script>
    <script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/mobiscroll_003.js" type="text/javascript"></script>
    <script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/mobiscroll_005.js" type="text/javascript"></script>
</body>
</html>