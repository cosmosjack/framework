<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--往期活动详情-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>好少年-往期活动详情</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/past_detail.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/swiper-3.4.2.min.css" />
</head>
<body>
    <div class="past_detail">
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
                <?php foreach($output['banner'] as $val):?>
                  <div class="swiper-slide"><img src="<?php echo $val['file_name'];?>!product-360" /></div>
                <?php endforeach;?>
                <!-- <div class="swiper-slide"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/banner0.jpg" /></div>
                <div class="swiper-slide"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/banner1.jpg" /></div>
                <div class="swiper-slide"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/banner2.jpg" /></div> -->
            </div>
            <!-- 如果需要分页器 -->
            <div class="swiper-pagination"></div>
        </div>
        <div class="odpro_title overflow">
            <div class="col-xs-12">
                <span class="city">【<?php echo getAreaName($output['info']['activity_city'])?>】</span><?php echo $output['info']['activity_title']?>
            </div>
        </div>
        <div class="pro_class overflow">
             <p class="col-xs-12">亲子活动 | 成长 | 挑战活动</p>
             <div class="place col-xs-12 overflow">
                <div>
                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/place.png" />
                    <div><?php echo $output['info']['address']?></div>
                </div>
                <div>
                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/time.png" />
                    <div><?php echo date('Y-m-d',$output['info']['activity_begin_time'])?></div>
                </div>
             </div>
        </div>
        <div class="seo overflow container-fluid">
            <p class="col-xs-12 team_name"></p>
            <?php foreach($output['groupInfo'] as $val):?>
            <?php if($val['total_num'] > 0):?>
            <div class="team col-xs-12 overflow">
                <p class="col-xs-12 name">
                    <span><?php echo $output['group_arr'][$val['group_id']][0]['teacher_name'];?></span>
                    <span class="pull-right" onclick="Href('<?php echo urlBBS('activity','member',array('group_id'=>$val['group_id'],'activity_no'=>$output['info']['activity_no'],'activity_periods'=>$output['info']['activity_periods']))?>')">小组成员 ></span>
                </p>
                <div class="col-xs-12 past_img">
                    <div class="main">
                        <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/logo.png"  />
                    </div>
                    <!--最多展现4个-->
                    <?php foreach($output['group_arr'][$val['group_id']] as $v):?>
                    <img src="<?php echo $v['child_headimgurl']?$v['child_headimgurl']:BBS_RESOURCE_SITE_URL.'/bootstrap/img/children.jpg';?>" alt="<?php echo $v['child_name']?>" />
                    <?php endforeach;?>
                </div>
            </div>
          <?php endif;?>
          <?php endforeach;?>
        </div>
        <div class="pro_content">
            <!--推荐-->
            <div class="eventdetails text-center container-fluid overflow">
                <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/wap_order_detail.png" class="col-xs-12" />
                <div class="re_nav col-xs-12 overflow" id="or_nav">
                    <div class="col-xs-6"><span class="active">活动详情 </span></div>
                    <div class="col-xs-6"><span>活动评估 </span></div>  
                </div>
                <div class="overflow activityContent col-xs-12 text-left">
                    <?php echo $output['info']['activity_desc']?>
                </div>
                <!--活动信息-->
                <div class="activity_deta_info overflow col-xs-12 text-left">
                    <div class="grade text-center">
                        <span>点评:</span>
                        <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_no.png" />
                        <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_no.png" />
                        <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_no.png" />
                        <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_no.png" />
                        <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_no.png" />
                    </div>
                    <div class="col-xs-12 Input_box">
                       <textarea class="col-xs-9"></textarea>
                       <button class="col-xs-2 pull-right"><p>发表</p>评论</button>
                    </div>
                    <input type="hidden" id="past_id" value="<?php echo $output['info']['id'];?>"> 
                    <!--评论-->
                    <div id="comment"></div>
                    
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
    
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/past_detail.js"></script>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/swiper-3.4.2.min.js"></script>
</body>
</html>