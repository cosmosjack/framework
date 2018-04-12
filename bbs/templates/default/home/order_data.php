<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--订单详情-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>少年宫-订单</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/order_deta.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/swiper-3.4.2.min.css" />
<body>
    <div class="order_deta">
    	<!--头部-->
    	<div class="home_top">
    	     <div class="row">
    	     	<div class="col-xs-12">
    	     		<span class="pull-left col-xs-4 glyphicon glyphicon-menu-left" onclick="javascript:history.back(-1);"></span>
    	     		<p class="col-xs-4 text-center od_title"></p>
    	     		<div class="col-xs-4 overflow">
    	     			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/share.png" class="pull-right share_icon" id="share_icon">
    	     			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_n.png" class="pull-right collect_icon" id="collect_icon" />
    	     		</div>
    	     	</div>
    	     </div>
    	</div>
        <!--轮播图-->
    	<div class="swiper-container">
		    <div class="swiper-wrapper">
                <?php foreach($output['banner'] as $val):?>
		        <div class="swiper-slide"><img src="<?php echo $val['file_name']?>"></div>
		        <?php endforeach;?>
		    </div>
		    <!-- 如果需要分页器 -->
		    <div class="swiper-pagination"></div>
		</div>
		<div class="odpro_title overflow">
			<div class="col-xs-7">
				<span class="city">【<?php echo getAreaName($output['activityInfo']['activity_city'])?>】</span><?php echo $output['activityInfo']['activity_title']?>
			</div>
			<div class="col-xs-5">
				<span>参与人数：</span><span class="join"><?php echo $output['activityInfo']['already_num']?></span>/<span><?php echo $output['activityInfo']['total_number']?></span>
			</div>
		</div>
        <div class="pro_class overflow">
             <p class="col-xs-12">亲子活动 | 成长 | 挑战活动</p>
        </div>
        <div class="price_time overflow">
            <div class="col-xs-12 overflow">
                <span class="price">&yen;<?php echo $output['activityInfo']['activity_price']?></span>
                <!-- <span class="importance coupon">优惠券兑换>></span> -->
                <span class="time pull-right">报名截止:<?php echo date('m月d日 H:i:s',$output['activityInfo']['activity_begin_time']-3600*12)?></span>
            </div>
        </div>
        <div class="pro_content">
            <div class="pta overflow container-fluid">
                <div class="col-xs-12">
                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/place.png" class="col-xs-2" /><span><?php echo $output['activityInfo']['address']?></span>
                </div>
                <div class="col-xs-12">
                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/time.png" class="col-xs-2" /><span><?php echo $output['info']['activity_time']?></span>
                </div>
                <div class="col-xs-12">
                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/age.png" class="col-xs-2" /><span><?php echo $output['activityInfo']['min_age']?>~<?php echo $output['activityInfo']['max_age']?>岁</span>
                </div>
            </div>
            <div class="order_info overflow container-fluid">
                <div class="order_number col-xs-12">
                    <span>订单号：<span class="importance"><?php echo $output['info']['id']?></span></span>
                    <span class="ornum_time pull-right"><?php echo date('m月d日 H:i:s',$output['info']['order_time'])?></span>
                </div>
                <div class="user col-xs-12">
                    <?php $parents = unserialize($output['info']['parents_arr']);?>
                    <div>
                        <span>联系人：</span>
                        <span><?php echo $parents[0]['name']?></span>
                        <span class="user_phone"><?php echo $parents[0]['phone']?></span>
                    </div>
                    <!--订单状态-->
                    
                    <?php if($output['info']['order_status'] == 1):?>
                    <div>
                        <span>消费码：</span>
                        <span>未下单</span>
                        <span class="pull-right importance">未付款</span>
                    </div>
                    <?php elseif($output['info']['order_status'] == 2):?>
                    <div>
                        <span>消费码：</span>
                        <span><?php echo $output['info']['code']?></span>
                        <span class="pull-right importance">未验证</span>
                    </div>
                    <?php elseif($output['info']['order_status'] == 3):?>
                    <div>
                        <span>消费码：</span>
                        <span><?php echo $output['info']['code']?></span>
                        <span class="pull-right importance">已完成</span>
                    </div>
                    <?php elseif($output['info']['order_status'] == 4):?>
                    <div>
                        <span>消费码：</span>
                        <span>已失效</span>
                        <span class="pull-right importance">退款中</span>
                    </div>
                    <?php elseif($output['info']['order_status'] == 5):?>
                    <div>
                        <span>消费码：</span>
                        <span>已失效</span>
                        <span class="pull-right importance">已退款</span>
                    </div>
                    <?php else:?>
                    <?php endif;?>
                    <?php $childs = unserialize($output['info']['childs_arr']);?>
                    <?php foreach($childs as $val):?>
                    <div>
                        <img src="<?php echo $val['img']?>" class="user_img" />
                        <span class="user_name"><?php echo $val['name']?></span>
                        <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/<?php echo $val['sex']==1?'child_boy':'child_girl'; ?>.png" class="gender_img" />
                        <span class="user_age"><?php echo $val['age']?>岁</span>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="eventdetails text-center container-fluid overflow">
                <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/wap_order_detail.png" class="col-xs-12" />
                <div class="re_nav col-xs-12 overflow" id="or_nav">
                    <div class="col-xs-6"><span class="active">活动信息 </span></div>
                    <div class="col-xs-6"><span>推荐活动 </span></div>  
                </div>
                <!--活动信息-->
                <div class="activityContent overflow col-xs-12 text-left">
                    <span>活动信息</span>
                </div>
                <!--推荐活动-->
                <div class="overflow col-xs-12 pro_recom" style="display: none;">
                    <?php foreach($output['list'] as $val):?>
                    <div class="index_pro col-xs-12">
                        <div class="overflow index_pro_Img">
                            <img src="<?php echo $val['activity_index_pic']?>" class="pro_img" />
                            <div class="num_periods">
                                <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_n.png" />
                            </div>
                            <?php if($val['total_number']-$val['already_num'] == 0):?>
                            <div class="col-xs-10 col-xs-offset-1 Prompt text-right"><span>已满额<span></div>
                            <?php elseif($val['total_number']-$val['already_num'] < 5):?>
                                <div class="col-xs-10 col-xs-offset-1 Prompt text-right"><span>即将满额<span></div>
                            <?php else:?>
                                
                            <?php endif;?>
                            <div class="mask">
                                <span class="pull-left"><?php echo $val['address']?> <?php echo $val['min_age'].'-'.$val['max_age']?>岁</span>
                                <span class="pull-left text-right"><?php echo $val['activity_tag']?></span>
                            </div>
                        </div>
                        <div class="overflow pro_tit">
                            <div class="col-xs-10 col-xs-offset-1">
                                <span class="pull-left">
                                    <span class="city">【<?php echo getAreaName($val['activity_city'])?>】</span><?php echo mb_substr($val['activity_title'],0,6,'utf-8')?>
                                </span>
                                <span class="people pull-right text-right">
                                    已参与 
                                    <span class="past"><?php echo $val['already_num']?></span>/<span class="sum"><?php echo $val['total_number']?></span>
                                </span>
                            </div>
                        </div>
                        <div class="overflow time_price">
                            <div class="col-xs-10 col-xs-offset-1">
                                <div class="pull-left text-left">
                                    <p><?php echo date('m月d日',$val['activity_begin_time'])?>到<?php echo date('m月d日',$val['activity_end_time'])?></p>
                                    <p class="price">&yen;<?php echo $val['activity_price']?></p>
                                </div>
                                <div class="row pull-left text-right">
                                    <button class="pro_btn" onclick="Href('<?php echo urlBBS('activity','detail',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']))?>')">去订票</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
                
            </div>
        </div>
    </div>
    <div class="or_footer overflow text-center">
        <span class="col-xs-6 total">订单总额：&yen;<?php echo $output['info']['order_amount']?></span>
        <?php if($output['info']['order_status'] <= 2):?>
        <span class="or_btn col-xs-6 cancel">取消订单</span>
        <?php else:?>
        <span class="or_btn col-xs-6" style="background: #a0a0a0">取消订单</span>
        <?php endif;?>
        <input type="hidden" id="orderId" value="<?php echo $output['info']['id']?>">
    </div>
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm row" role="document">
            <div class="modal-content col-xs-10 point col-xs-offset-1" style="padding:15px,0;">
                
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/order_deta.js"></script>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/swiper-3.4.2.min.js"></script>
</body>
</html>