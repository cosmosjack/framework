<?php defined('InCosmos') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
	<title>少年宫-我的</title>
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/mine.css" />
<body>
    <div class="mine container-fluid">
    	<div class="top row">
    	 	<div class="overflow">
    	 	 	<div class="fl col-xs-6 row set">
	    	 	 	<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/setting.png" />
	    	 	 	<span onclick="Href('<?php echo urlBBS('set','setUp')?>')">设置</span>
	    	 	</div>
    	 	 	<div class="fr col-xs-6 row text-right out">
	    	 	 	<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/signout.png" />
	    	 	 	<span>退出</span>
	    	 	</div>
    	 	</div>
    	 	<div class="logo text-center container-fluid">
	    		 <img src="<?php echo $output['info']['headimgurl']?$output['info']['headimgurl'].'!product-60':BBS_RESOURCE_SITE_URL.'/bootstrap/img/logo.png'?>" class="col-xs-4 col-xs-offset-4 img-circle" />
	    		 <h4 class="col-xs-12 test"><?php echo $output['info']['nick_name']?$output['info']['nick_name']:'好少年一号';?></h4>
	    		 <div class="grade_gender col-xs-12">
	    		    <div class="row">
	    		    	<div class="col-xs-5 text-right">
                            <?php if($output['info']['member_sex'] == 1):?>
                            <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/boy.png" />
                            <?php else:?>
                            <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/girl.png" />
                            <?php endif?>
                        </div>
		    		 	<div class="col-xs-1 text-left">|</div>
		    		 	<div class="col-xs-5 text-left"><span>我的勋章</span><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/level1.png" /></div>
	    		    </div>
	    		 	<div class="col-xs-12 text-center">电话号码：<span class="phone"><?php echo phoneLink($output['info']['member_phone'])?></span></div>
	    		 </div>
	    	</div>
    	</div>
    	<div class="ID row" onclick="Href('<?php echo urlBBS('set','manageSelect')?>')">
            <div class="col-xs-2 text-center">
                <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/manage.png" class=img-responsive/>
            </div>
    		<span class="col-xs-6">身份信息管理</span>
    		<span class="col-xs-4 text-right">+</span>
    	</div>
    	<div class="center">
    	  <!--成长相册-->
    		<div class="growth_record row" onclick="Href('<?php echo urlBBS('mine','album')?>')">
    		 	<div class="col-xs-3 img">
    		 		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/picture.png" class="img-responsive" />
    		 	</div>
    		 	<div class="col-xs-4 txt row">
    		 		<span class="col-xs-12">成长相册</span>
    		 		<div class="col-xs-12"><span class="col-xs-4">127</span></div>
    		 	</div>
    		 	<div class="col-xs-6 enter row">
    		 		<div class="col-xs-12 text-right">
    		 			<span class="added"></span><span class="glyphicon glyphicon-menu-right"></span>
    		 		</div>
    		 	</div>
    		</div>
    	  <!--成长记录-->
    		<div class="growth_record row" onclick="Href('<?php echo urlBBS('mine','growRecord')?>')">
    		 	<div class="col-xs-3 img">
    		 		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/record.png" class="img-responsive" />
    		 	</div>
    		 	<div class="col-xs-4 txt row">
    		 		<span class="col-xs-12">成长记录</span>
    		 		<div class="col-xs-12"><span class="col-xs-4">27</span></div>
    		 	</div>
    		 	<div class="col-xs-6 enter row">
    		 		<div class="col-xs-12 text-right">
    		 			<span class="added"></span><span class="glyphicon glyphicon-menu-right"></span>
    		 		</div>
    		 	</div>
    		</div>
    	    <!--我的收藏-->
    		<div class="growth_record row" onclick="Href('<?php echo urlBBS('mine','collect')?>')">
    		 	<div class="col-xs-3 img">
    		 		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect.png" class="img-responsive" />
    		 	</div>
    		 	<div class="col-xs-4 txt row" >
    		 		<span class="col-xs-12">我的收藏</span>
    		 		<div class="col-xs-12"><span class="col-xs-4">127</span></div>
    		 	</div>
    		 	<div class="col-xs-6 enter row">
    		 		<div class="col-xs-12 text-right">
    		 			<span class="glyphicon glyphicon-menu-right"></span>
    		 		</div>
    		 	</div>
    		</div>
            <!--优惠券兑换-->
            <div class="growth_record row" onclick="Href('<?php echo urlBBS('mine','coupon')?>')">
                <div class="col-xs-3 img">
                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/ticket.png" class="img-responsive" />
                </div>
                <div class="col-xs-4 txt row">
                    <span class="col-xs-12">优惠券兑换</span>
                    <div class="col-xs-12"><span class="col-xs-4">127</span></div>
                </div>
                <div class="col-xs-6 enter row">
                    <div class="col-xs-12 text-right">
                        <span class="glyphicon glyphicon-menu-right"></span>
                    </div>
                </div>
            </div>
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
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/mine.js"></script>
</body>
</html>