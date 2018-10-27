<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--成长记录详情-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>好少年</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/grow_detail.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/swiper-3.4.2.min.css" />
</head>
<body>
    <div class="grow_detail">
        <!--头部-->
        <div class="home_top">
             <div class="row">
                <div class="col-xs-12">
                    <span class="pull-left oprev col-xs-4 glyphicon glyphicon-menu-left"></span>
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
                <?php foreach($output['banner'] as $val):?>
                    <div class="swiper-slide"><img src="<?php echo $val['file_name']?>!product-360" /></div>
                <?php endforeach;?>
            </div>
            <!-- 如果需要分页器 -->
            <div class="swiper-pagination"></div>
        </div>
		<div class="odpro_title overflow">
			<div class="col-xs-12">
				<span class="city">【第<?php echo $output['info']['activity_periods']?>期】</span>
                <?php echo $output['info']['activity_title']; ?>
			</div>
		</div>
        <div class="pro_class overflow">
             <p class="col-xs-12">亲子活动 | 成长 | 挑战活动</p>
             <div class="place col-xs-12 overflow">
             	<div>
             		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/place.png" />
             		<div><?php echo $output['info']['activity_address']?></div>
             	</div>
             	<div>
             		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/time.png" />
             		<div><?php echo date('Y-n-j',$output['info']['activity_begin_time'])?></div>
             	</div>
             </div>
        </div>
        
        <div class="pro_content">
            <!--推荐-->
            <div class="eventdetails text-center container-fluid overflow">
                <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/wap_order_detail.png" class="col-xs-12" />
                <div class="re_nav col-xs-12 overflow" id="or_nav">
                    <div class="col-xs-4"><span>活动足迹 </span></div>
                    <div class="col-xs-4"><span class="active">点评汇总 </span></div>
                    <div class="col-xs-4"><span>推荐活动 </span></div>
                </div>
                <!--活动足迹-->
                <div class="overflow activityContent col-xs-12 text-left">
                    <?php foreach($output['order_list'] as $val):?>
                    <div class="annal overflow" href_url="<?php echo urlBBS('mine','activityPug',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']))?>">
                        <img src="<?php echo $val['activity_index_pic']?>" class="col-xs-4" />
                        <div class="col-xs-8">
                            <div class="overflow">
                                <span class="Content_title"><?php echo $val['activity_title']?></span>
                                <span class="fr">></span>
                            </div>
                            <div class="time">
                                <span><?php echo date('Y-n-j',$val['activity_begin_time'])?></span>
                                <span>植树 | 体验 | 自然</span>
                            </div>
                            <div class="overflow photo_vio">
                                <div class="fl">
                                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/photo.png" />
                                    <span><?php echo $val['count']?></span>
                                </div>
                                <!-- <div class="fl">
                                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/videotape.png" />
                                    <span>2</span>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
                <!--点评汇总-->
                <div class="activity_deta_info overflow col-xs-12 text-left">
                     <div class="reviews">
                        <div class="reviews_title">
                            <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/decorate.png" />
                            <span>领队评语</span>
                        </div>
                        <!-- 学员 -->
                        <?php foreach($output['user_words_list'] as $val):?>
                        <div class="reviews_student overflow">
                            <div class="user_img fl">
                                <img src="<?php echo $val['child_pic'];?>" class="" />
                            </div>
                            <div class="user_txt fl">
                                <div class="user_nt">
                                    <span class="user_name"><?php echo $val['child_name']?></span>
                                    <span class="user_time fr"><?php echo date('Y-n-j H:i',$val['add_time'])?></span>
                                </div>
                                <p class="comment_txt"><span><?php echo $val['words_name'];?></span></p>
                            </div>
                        </div>
                        <?php endforeach;?>
                     </div>           
                </div>
                <!--推荐活动-->
                <div class="overflow col-xs-12 pro_recom">
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
    
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/grow_detail.js"></script>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/swiper-3.4.2.min.js"></script>
</body>
</html>