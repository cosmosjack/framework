<?php defined('InCosmos') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>好少年-<?php echo $output['info']['activity_title']?></title>
    <meta name="description" content="<?php echo $output['info']['activity_ptitle']?>"/>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/recom_active.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/swiper-3.4.2.min.css" />
</head>
<body>
    <div class="recom_active">
    	<!--头部-->
    	<div class="home_top">
    	     <div class="row">
    	     	<div class="col-xs-12">
    	     		<span class="pull-left col-xs-4 glyphicon glyphicon-menu-left" onclick="javascript:history.back(-1);"></span>
    	     		<p class="col-xs-4 text-center od_title"></p>
    	     		<div class="col-xs-4 overflow">
    	     			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/share.png" class="pull-right share_icon">
                        <?php if($output['info']['collect'] == 1):?>
    	     			   <img href_url="<?php echo urlBBS('activity','collect',array('activity_no'=>$output['info']['activity_no'],'activity_periods'=>$output['info']['activity_periods']))?>" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_s_red.png" class="pull-right collect_icon" />
                        <?php else:?>
                            <img href_url="<?php echo urlBBS('activity','collect',array('activity_no'=>$output['info']['activity_no'],'activity_periods'=>$output['info']['activity_periods']))?>" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_n.png" class="pull-right collect_icon" />
                        <?php endif;?>
    	     		</div>
    	     	</div>
    	     </div>
    	</div>
        <!--轮播图-->
    	<div class="swiper-container">
		    <div class="swiper-wrapper">
		        <?php if(empty($output['banner'])):?>
                    <div class="swiper-slide"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/banner0.jpg" /></div>
                    <div class="swiper-slide"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/banner1.jpg" /></div>
                    <div class="swiper-slide"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/banner2.jpg" /></div>
                <?php endif;?>
                <?php foreach($output['banner'] as $val):?>
                    <div class="swiper-slide"><img src="<?php echo $val['file_name']?>!product-360" /></div>
                <?php endforeach;?>
		    </div>
		    <!-- 如果需要分页器 -->
		    <div class="swiper-pagination"></div>
		</div>
		<div class="odpro_title overflow">
			<div class="col-xs-7">
				<span class="city">【<?php echo getAreaName($output['info']['activity_city'])?>】</span><?php echo $output['info']['activity_title']?>
			</div>
			<div class="col-xs-5">
				<span>参与人数：</span><span class="join"><?php echo $output['info']['already_num']?></span>/<span><?php echo $output['info']['total_number']?></span>
			</div>
		</div>
        <div class="pro_class overflow">
            <!-- <p class="col-xs-12"><?php echo $output['info']['activity_tag']?></p> -->
            <p class="col-xs-12"><?php echo $output['info']['activity_ptitle']?></p>
        </div>
        <div class="price_time overflow">
            <div class="col-xs-12 overflow">
                <span class="price">&yen;<?php echo $output['info']['activity_price']?></span>
                <!-- <span class="importance coupon" onclick="Href('<?php echo urlBBS('mine','coupon')?>')">优惠券兑换>></span> -->
                <span class="time pull-right">报名截止:<?php echo date('m月d日 H:i:s',$output['info']['activity_begin_time']-3600*12)?></span>
            </div>
        </div>
        <div class="overflow" style="background: #FFF">
            <div class="col-xs-12 pad_none">
                <?php if(!empty($output['periods'])):?>
                <span>活动选期：</span>
                <div class="title overflow col-xs-12">
                   <ul class="title_ul text-center">
                    <?php foreach($output['periods'] as $val):?>
                        <li class="session <?php if($val['activity_periods'] == $output['info']['activity_periods']) echo 'active'?>" onclick="Href('<?php echo urlBBS('activity','detail',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']))?>')">
                            <div <?php if($val['activity_periods'] == $output['info']['activity_periods']) echo 'style="color:#f5f5f5"'?> >
                                <p><?php echo date('m月d日',$val['activity_begin_time'])?>~<?php echo date('m月d日',$val['activity_end_time'])?></p>
                                    <?php if($val['activity_begin_time'] > time()+3600*12):?>
                                    <p>第<?php echo $val['activity_periods']?>期 报名中</p>
                                    <?php else:?>
                                    <p>第<?php echo $val['activity_periods']?>期 报名已截止</p>
                                    <?php endif;?>
                            </div>
                        </li>
                    <?php endforeach;?>
                   </ul> 
                </div>
                <?php endif;?>
            </div>
        </div>
        <div class="pro_content">
            <div class="pta overflow container-fluid">
                <div class="col-xs-12">
                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/place.png" class="col-xs-2" /><span class="col-xs-10"><?php echo $output['info']['address']?></span>
                </div>
                <div class="col-xs-12">
                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/time.png" class="col-xs-2" /><span class="col-xs-10"><?php echo $output['info']['activity_time']?></span>
                </div>
                <div class="col-xs-12">
                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/age.png" class="col-xs-2" /><span class="col-xs-10"><?php echo $output['info']['min_age'].'~'.$output['info']['max_age']?>岁</span>
                </div>
            </div>
            <!--推荐-->
            <div class="eventdetails text-center container-fluid overflow">
                <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/wap_order_detail.png" class="col-xs-12" />
                <div class="re_nav col-xs-12 overflow" id="or_nav">
                    <div class="col-xs-6"><span class="active">活动信息 </span></div>
                    <div class="col-xs-6"><span>推荐活动 </span></div>  
                </div>
                <!--活动信息-->
                <div class="activity_deta_info overflow col-xs-12 text-left">
                    <span><?php echo $output['info']['activity_desc']?></span>
                </div>
                <!--推荐活动-->
                <div class="overflow col-xs-12 pro_recom" style="display: none;">
                    <?php foreach($output['list'] as $val):?>
                    <div class="index_pro col-xs-12">
                        <div class="overflow index_pro_Img" href_url="<?php echo urlBBS('activity','detail',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']))?>">
                            <img src="<?php echo $val['activity_index_pic'].'!product-360'?>" class="pro_img" />
                            <div class="num_periods">
                                <?php if($val['collect'] == 1):?>
                                <img href_url="<?php echo urlBBS('activity','collect',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']))?>" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_s_red.png" />
                                <?php else:?>
                                <img href_url="<?php echo urlBBS('activity','collect',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']))?>" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_n.png" />   
                                <?php endif;?>
                            </div>
                            <?php if($val['total_number']-$val['already_num'] == 0):?>
                            <div class="Prompt text-right"><span>已满额<span></div>
                            <?php elseif($val['total_number']-$val['already_num'] < 5):?>
                                <div class="Prompt text-right"><span>即将满额<span></div>
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
                                    <p><?php echo $val['activity_time']?></p>
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
        <!--收藏弹框-->
        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm row" role="document">
                <div class="modal-content col-xs-10 point col-xs-offset-1">
                    <h4 class="col-xs-12 text-center">已收藏</h4>
                    <button class="col-xs-12 aHide">确定</button>
                </div>
            </div>
        </div>
        <!--分享弹框-->
        <div class="share_it" id="share_it">
            <div class="bdsharebuttonbox col-xs-12 text-center overflow">
                <div class="col-xs-3 overflow">
                    <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                    <p class="col-xs-12">QQ空间</p>
                </div>
                <div class="col-xs-3 overflow">
                    <a href="#" class="bds_qzone col-xs-12" data-cmd="qzone" title="分享到QQ空间"></a>
                    <p class="col-xs-12">QQ空间</p>
                </div>
                <div class="col-xs-3 overflow">
                    <a href="#" class="bds_tsina col-xs-12" data-cmd="tsina" title="分享到新浪微博"></a>
                    <p class="col-xs-12">新浪</p>
                </div>
                <div class="col-xs-3 overflow">
                    <a href="#" class="bds_sqq col-xs-12" data-cmd="sqq" title="分享到QQ好友"></a>
                    <p class="col-xs-12">QQ</p>
                </div>
            </div>
        </div>
    </div>
    <div class="or_footer overflow text-center">
        <?php if($output['info']['total_number']-$output['info']['already_num'] == 0):?>
            <span class="col-xs-6 homeclick" onclick="Href('<?php echo Urlbbs()?>')">首页</span>
            <span class="or_btn col-xs-6" style="background:#ccc">已满额</span>
        <?php elseif($output['info']['activity_begin_time']-3600*12 < time()):?>
            <span class="col-xs-6 homeclick" onclick="Href('<?php echo Urlbbs()?>')">首页</span>
            <span class="or_btn col-xs-6" style="background:#ccc">报名已截止</span>
        <?php elseif($output['info']['activity_end_time'] < time()):?>
            <span class="col-xs-6 homeclick" onclick="Href('<?php echo Urlbbs()?>')">首页</span>
            <span class="or_btn col-xs-6" style="background:#ccc">活动已结束</span>
        <?php else:?>
            <span class="col-xs-6 homeclick" onclick="Href('<?php echo Urlbbs()?>')">首页</span>
            <span class="or_btn col-xs-6" onclick="Href('<?php echo urlBBS('activity','defray',array('activity_no'=>$output['info']['activity_no'],'activity_periods'=>$output['info']['activity_periods']))?>')">购买</span>
        <?php endif;?>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/recom_active.js"></script>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/swiper-3.4.2.min.js"></script>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.1.0.js"></script>
<script type="text/javascript">
    wx.config({
        debug: false,
        appId:'wxa286179f364df0be',
        timestamp: '<?php echo $output['data']['timestamp'];?>',
        nonceStr: '<?php echo $output['data']['noncestr'];?>',
        signature: '<?php echo $output['data']['signature'];?>',
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            'translateVoice',
            'startRecord',
            'stopRecord',
            'onRecordEnd',
            'playVoice',
            'pauseVoice',
            'stopVoice',
            'uploadVoice',
            'downloadVoice',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'getNetworkType',
            'openLocation',
            'getLocation',
            'hideOptionMenu',
            'showOptionMenu',
            'closeWindow',
            'scanQRCode',
            'chooseWXPay',
            'openProductSpecificView',
            'addCard',
            'chooseCard',
            'openCard'
        ]
    });

    wx.ready(function () {


        var shareData = typeof(shareData) === 'undefined' ? {
            title: '好少年-<?php echo $output['info']['activity_title']?>',
            desc: '<?php echo $output['info']['activity_ptitle']?>',
            link: '<?php echo $output['data']['url'];?>',
            imgUrl: '<?php echo $output['banner'][0]['file_name']?>!product-360'
        } : shareData;

        wx.onMenuShareAppMessage(shareData);
        wx.onMenuShareTimeline(shareData);
    });

    wx.error(function (res) {
        alert(res.errMsg);
    });
</script>

<script>
   /* wx.config({
        debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: '', // 必填，公众号的唯一标识
        timestamp: , // 必填，生成签名的时间戳
        nonceStr: '', // 必填，生成签名的随机串
        signature: '',// 必填，签名，见附录1
        jsApiList: [] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });*/

</script>
</body>
</html>