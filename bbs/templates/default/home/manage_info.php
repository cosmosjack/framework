<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--监护人身份管理-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>好少年-监护人身份信息</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/id_manage.css" />
<body>
    <div class="id_manage">
    	<!--头部-->
    	<div class="reg_top overflow">
    		<button type="button" class="btn oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	        </button>
	        <span class="text-center col-xs-11 col-xs-offset-1">
	        <span class="pull-left">身份信息管理</span>
	        <span class="pull-right explain">说明？</span>
	        </span>
    	</div>
    	<div class="id_content container-fluid">
    		<!--监护人信息-->
    		<?php foreach ($output['list'] as $val): ?>
    		<div class="student">
    			<div class="overflow">
    				<div class="col-xs-12 overflow student_inf">
    				    <div class="pull-left">
	    					<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/guardian.png" />
	    					<span>监护人信息</span>
    					</div>
    					<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/remove.png" class="pull-right del" data-id="<?php echo $val['id']?>"/>
    				</div>
                    <div class="col-xs-12 user_avatar">
                        <img src="<?php echo $val['headimgurl']?$val['headimgurl']:BBS_RESOURCE_SITE_URL.'/bootstrap/img/logo.png'?>" />
                    </div>
    				<div class="col-xs-12 overflow student_inf_txt">
	    				<span class="col-xs-4 text-left">姓名:</span>
	    				<span class="col-xs-8"><?php echo $val['parents_name']?></span>
	    			</div>
	    			<!-- <div class="col-xs-12 overflow student_inf_txt">
                        <?php $arr = array('1'=>'身份证','2'=>'港澳通','3'=>'驾驶证');?>
	    				<span class="col-xs-4 text-left">证件类型:</span>
	    				<span class="col-xs-8"><?php echo $arr[$val['parents_papers_type']]?></span>
	    			</div>
	    			<div class="col-xs-12 overflow student_inf_txt">
	    				<span class="col-xs-4 text-left">证件号码:</span>
	    				<span class="col-xs-8"><?php echo $val['parents_papers_no']?></span>
	    			</div>
	    			<div class="col-xs-12 overflow student_inf_txt">
	    				<span class="col-xs-4 text-left">出生年月:</span>
	    				<span class="col-xs-8"><?php echo date('Y-m-d',$val['parents_brithday']);?></span>
	    			</div> -->
	    			<!-- <div class="col-xs-12 overflow student_inf_txt">
	    				<span class="col-xs-4 text-left">性别:</span>
	    				<span class="col-xs-8"><?php echo $val['parents_sex']==1?'男':'女'; ?></span>
	    			</div> -->
                    <div class="col-xs-12 overflow student_inf_txt">
                        <span class="col-xs-4 text-left">关系:</span>
                        <span class="col-xs-8"><?php echo $val['relation'];?></span>
                    </div>
                    <div class="col-xs-12 overflow student_inf_txt">
                        <span class="col-xs-4 text-left">手机号:</span>
                        <span class="col-xs-8"><?php echo $val['parents_phone'];?></span>
                    </div>
                    <div class="col-xs-12 overflow select_mo text-center" data-id="<?php echo $val['id']?>">
                        <?php if($val['is_default']):?>
                        <span class="col-xs-6" disabled="disabled">
                            <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/true_0.png" />
                            <span style="color: #a0a0a0;">设为默认</span>
                        </span>
                        <?php else:?>
                        <span class="col-xs-6">
                            <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/false_0.png" class="select_img" />
                            <span>设为默认</span>
                        </span>
                        <?php endif;?>
                        <span class="col-xs-6 modify_student" onclick="Href('<?php echo urlBBS('set','addManage',array('id'=>$val['id']))?>')">修改信息</span>
                    </div>
    			</div>
    		</div>
    		<?php endforeach ?>
    		<!--添加监护人-->
    		<div class="push_student text-center">
    			<span onclick="Href('<?php echo urlBBS('set','addManage')?>')">+ 新增监护人</span>
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
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/id_manage.js"></script>
</body>
</html>