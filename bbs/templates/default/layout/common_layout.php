
	<!--公共-->
	<script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/common.js"></script>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/indexCommon.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/common.css" />
    <!---->
<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/3/9
 * Time: 15:55
 * QQ:  997823131 
 */
require_once($tpl_file);
?>
<div class="footer">
	<div class="col-xs-3 text-center" href_url="<?php echo urlBBS('index','index')?>">
		<?php if(!isset($_GET['act']) || $_GET['act'] == 'index'):?>
		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/home_s.png" class="img-responsive center-block" />
		<?php else:?>
		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/home_n.png" class="img-responsive center-block" />
		<?php endif;?>
		<span>首页</span>
	</div>
	<div class="col-xs-3 text-center" href_url="<?php echo urlBBS('activity','index')?>">
		<?php if($_GET['act'] == 'activity'):?>
		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/activity_s.png" class="img-responsive center-block" />
		<?php else:?>
		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/activity_n.png" class="img-responsive center-block" />
		<?php endif;?>
		<span>活动</span>
	</div>
	<div class="col-xs-3 text-center" href_url="<?php echo urlBBS('order','index')?>">
		<?php if($_GET['act'] == 'order'):?>
		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/order_s.png" class="img-responsive center-block" />
		<?php else:?>
		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/order_n.png" class="img-responsive center-block" />
		<?php endif;?>
		<span>订单</span>
	</div>
	<div class="col-xs-3 text-center" href_url="<?php echo urlBBS('mine','index')?>">
		<?php if($_GET['act'] == 'mine'):?>
		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/user_s.png" class="img-responsive center-block" />
		<?php else:?>
		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/user_n.png" class="img-responsive center-block" />
		<?php endif;?>
		<span>我的</span>
	</div>
</div>
