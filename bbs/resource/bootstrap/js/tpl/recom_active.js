$(function(){
	
	var recom_active = {
		//页面滚动监听
		Scroll:function(){
			$(document).ready(function(){
			$(window).scroll(function(){
			    if($(window).scrollTop()>50){
			        $('.home_top').css('background','#e25428');
			        $('.od_title').html('活动详情');
			    }
			    if($(window).scrollTop() < 50){
			    	$('.od_title').html('');
			    	$('.home_top').css({'background':'url("'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/shadow.png") no-repeat 0 0','background-size':' 100% 100%'});
			    }
			   });
			});
		},
		//切换活动内容，活动信息，推荐活动
		fn:function(){
            $('.re_nav>div').click(function(){
            	var nav_index = $(this).index();
            	$(this).find('span').addClass('active');
            	$(this).siblings('div').find('span').removeClass('active');
            	if (nav_index == 0){
            		$('.activity_deta_info').css('display','block');
            		$('.pro_recom').css('display','none');
            	}else if(nav_index == 1){
            		$('.activity_deta_info').css('display','none');
            		$('.pro_recom').css('display','block');
            	}
            })

		},
		//分享功能,收藏功能
		collect_icon:function(){
              window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{}};
			  with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
              // 分享
			  $(document).on('click','.share_icon',function(){
			  	 $('.modal').modal('show');
			  })
			  //收藏
			  this.Collection('.collect_icon');
		},
		Collection:function(o){
			$(document).on('click',o,function(){
			  	if($(this).hasClass('on')){
			  	  $(this).prop('src',BBS_RESOURCE_SITE_URL+'/bootstrap/img/collect_n.png');
			  	  $(this).removeClass('on');
			  	}else{
			  	  $(this).attr('src',BBS_RESOURCE_SITE_URL+'/bootstrap/img/collect_s_red.png');
			  	  $(this).addClass('on');
			  	}
			  })
		},
		event:function(){
			this.Scroll();
			this.fn();
			this.collect_icon();
			this.Collection('.num_periods>img');
		}
	}
	//函数调用
	recom_active.event();
	
	//轮播图
	var mySwiper = new Swiper ('.swiper-container', {
			    direction: 'horizontal',
			    loop: true,//是否自动切换
			    autoplay:5000,//每隔5秒自动切换
			    // 如果需要分页器
			    pagination: '.swiper-pagination',
			    autoplayDisableOnInteraction : false,//手滑都过后依然可以自动切换
			  })      
})