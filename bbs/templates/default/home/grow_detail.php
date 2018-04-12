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
    	     			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_n.png" class="pull-right collect_icon" />
    	     		</div>
    	     	</div>
    	     </div>
    	</div>
        <!--轮播图-->
    	<div class="swiper-container">
		    <div class="swiper-wrapper">
		        <div class="swiper-slide"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/banner0.jpg" /></div>
		        <div class="swiper-slide"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/banner1.jpg" /></div>
		        <div class="swiper-slide"><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/banner2.jpg" /></div>
		    </div>
		    <!-- 如果需要分页器 -->
		    <div class="swiper-pagination"></div>
		</div>
		<div class="odpro_title overflow">
			<div class="col-xs-12">
				<span class="city">【惠州】</span>宝贝加油，亲子互动这里是标题这里是标题如果太长就这样换行【惠州】宝贝加油，亲子互动这里是标题这里是标题如果太长就这样换行
			</div>
		</div>
        <div class="pro_class overflow">
             <p class="col-xs-12">亲子活动 | 成长 | 挑战活动</p>
             <div class="place col-xs-12 overflow">
             	<div>
             		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/place.png" />
             		<div>惠州市西湖大门口如果地址过长就换到这一行</div>
             	</div>
             	<div>
             		<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/time.png" />
             		<div>2018-3-12</div>
             	</div>
             </div>
        </div>
        <div class="seo overflow container-fluid">
        	<p class="col-xs-12 team_name"></p>
        	<div class="team col-xs-12 overflow">
        		<p class="col-xs-12 name">
        			<span>战狼队</span>
        			<span class="pull-right">小组成员 ></span>
        		</p>
        		<div class="col-xs-12 past_img">
        		    <div class="main">
        				<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/logo.png"  />
        			</div>
        			<!--最多展现4个-->
        			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/children.jpg" />
        			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/children.jpg" />
        			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/children.jpg" />
        			<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/children.jpg" />
        		</div>
        	</div>
        </div>
        <div class="pro_content">
            <!--推荐-->
            <div class="eventdetails text-center container-fluid overflow">
                <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/wap_order_detail.png" class="col-xs-12" />
                <div class="re_nav col-xs-12 overflow" id="or_nav">
                    <div class="col-xs-4"><span class="active">活动足迹 </span></div>
                    <div class="col-xs-4"><span>点评汇总 </span></div>
                    <div class="col-xs-4"><span>推荐活动 </span></div>
                </div>
                <!--活动足迹-->
                <div class="overflow activityContent col-xs-12 text-left">
                    <div class="annal overflow">
                        <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/img2.jpg" class="col-xs-4" />
                        <div class="col-xs-8">
                            <div class="overflow">
                                <span class="Content_title">3.12大型植树节活动</span>
                                <span class="fr">></span>
                            </div>
                            <div class="time">
                                <span>2018-3-12</span>
                                <span>植树 | 体验 | 自然</span>
                            </div>
                            <div class="overflow photo_vio">
                                <div class="fl">
                                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/photo.png" />
                                    <span>62</span>
                                </div>
                                <div class="fl">
                                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/videotape.png" />
                                    <span>2</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="annal overflow">
                        <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/img2.jpg" class="col-xs-4" />
                        <div class="col-xs-8">
                            <div class="overflow">
                                <span class="Content_title">3.12大型植树节活动</span>
                                <span class="fr">></span>
                            </div>
                            <div class="time">
                                <span>2018-3-12</span>
                                <span>植树 | 体验 | 自然</span>
                            </div>
                            <div class="overflow photo_vio">
                                <div class="fl">
                                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/photo.png" />
                                    <span>62</span>
                                </div>
                                <div class="fl">
                                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/videotape.png" />
                                    <span>2</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--点评汇总-->
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
                   <!--评论-->
                   <div class="reviews col-xs-12 overflow">
                   	    <div class="col-xs-2 text-center">
                   	    	<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/logo.png" class="user_img" />
                   	    </div>
                   	    <div class="col-xs-10 review_txt">
	                   	    <div class="col-xs-12">
	                   	       <div class="col-xs-8">
	                   	       	    <p class="user_name">好少年一号</p>
	                   	    		<span class="user_time">2018-3-12 20:10</span>
	                   	       </div>
	                   	       <div class="col-xs-4 degree text-right">
	                   	       	    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_s_red.png" />
				                   	<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_s_red.png" />
				                   	<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_s_red.png" />
				                   	<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_s_red.png" />
	                   	       </div>
	                   	    </div>
	                   	    <p class="col-xs-12">
	                   	    	这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论
	                   	    </p>
	                   	    <!--回复信息-->
	                   	    <div class="reply col-xs-12 overflow">
	                   	    	 <p class="col-xs-12"><span class="staff">工作人员</span>回复<span class="user">用户</span>:</p>
	                   	    	 <span class="user_time col-xs-12">2018-3-12 20:10</span>
	                   	    	 <p class="col-xs-12">这里是回复</p>
	                   	    </div>
                   	    </div>
                   </div>
                   <div class="reviews col-xs-12 overflow">
                   	    <div class="col-xs-2 text-center">
                   	    	<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/logo.png" class="user_img" />
                   	    </div>
                   	    <div class="col-xs-10 review_txt">
	                   	    <div class="col-xs-12">
	                   	       <div class="col-xs-8">
	                   	       	    <p class="user_name">好少年一号</p>
	                   	    		<span class="user_time">2018-3-12 20:10</span>
	                   	       </div>
	                   	       <div class="col-xs-4 degree text-right">
	                   	       	    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_s_red.png" />
				                   	<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_s_red.png" />
				                   	<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_s_red.png" />
				                   	<img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_s_red.png" />
	                   	       </div>
	                   	    </div>
	                   	    <p class="col-xs-12">
	                   	    	这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论这里是评论
	                   	    </p>
	                   	    <!--回复信息-->
	                   	    <div class="reply col-xs-12 overflow">
	                   	    	 <p class="col-xs-12"><span class="staff">工作人员</span>回复<span class="user">用户</span>:</p>
	                   	    	 <span class="user_time col-xs-12">2018-3-12 20:10</span>
	                   	    	 <p class="col-xs-12">这里是回复</p>
	                   	    </div>
                   	    </div>
                   </div>
                </div>
                <!--推荐活动-->
                <div class="overflow col-xs-12 pro_recom">
                    <div class="index_pro col-xs-12">
                        <div class="overflow index_pro_Img">
                            <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/children.jpg" class="pro_img" />
                            <div class="Prompt text-right"><span>已满额<span></div>
                            <div class="num_periods">
                                <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_n.png" />
                            </div>
                            <div class="mask">
                                <span class="pull-left">惠州市东湖西路5号 6-13岁</span>
                                <span class="pull-left text-right">亲子活动、成长</span>
                            </div>
                        </div>
                        <div class="overflow pro_tit">
                            <div class="col-xs-10 col-xs-offset-1">
                                <span class="pull-left col-xs-8 ProTitle">
                                    <span class="city">【惠州】</span>宝贝加油，亲子互动
                                </span>
                                <span class="people pull-right text-right">
                                    已参与 
                                    <span class="past">20</span>/<span class="sum">20</span>
                                </span>
                            </div>
                        </div>
                        <div class="overflow time_price">
                            <div class="col-xs-10 col-xs-offset-1">
                                <div class="pull-left text-left">
                                    <p>3月15日一天</p>
                                    <p class="price">&yen;360</p>
                                </div>
                                <div class="row pull-left text-right">
                                    <button class="pro_btn">去订票</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="index_pro col-xs-12">
                        <div class="overflow index_pro_Img">
                            <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/img0.jpg" class="pro_img" />
                            <div class="Prompt text-right"><span>已满额<span></div>
                            <div class="num_periods">
                                <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/collect_n.png" />
                            </div>
                            <div class="mask">
                                <span class="pull-left">惠州市东湖西路5号 6-13岁</span>
                                <span class="pull-left text-right">亲子活动、成长</span>
                            </div>
                        </div>
                        <div class="overflow pro_tit">
                            <div class="col-xs-10 col-xs-offset-1">
                                <span class="pull-left col-xs-8 ProTitle">
                                    <span class="city">【惠州】</span>宝贝加油，亲子互动
                                </span>
                                <span class="people pull-right text-right">
                                    已参与 
                                    <span class="past">20</span>/<span class="sum">20</span>
                                </span>
                            </div>
                        </div>
                        <div class="overflow time_price">
                            <div class="col-xs-10 col-xs-offset-1">
                                <div class="pull-left text-left">
                                    <p>3月15日一天</p>
                                    <p class="price">&yen;360</p>
                                </div>
                                <div class="row pull-left text-right">
                                    <button class="pro_btn">去订票</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		  <div class="modal-dialog remodal modal-sm" role="document">
		    <div class="modal-content point overflow">
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
		            <div class="col-xs-3 overflow">
		            	<a href="#" class="bds_more col-xs-12" data-cmd="more"></a>
		            	<p class="col-xs-12">其他</p>
		            </div>
			  </div>
		    </div>
		  </div>
	</div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/grow_detail.js"></script>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/swiper-3.4.2.min.js"></script>
</body>
</html>