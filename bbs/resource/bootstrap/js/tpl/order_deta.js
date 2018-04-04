$(function(){
	
	var order_deta = {
		//页面滚动监听
		Scroll:function(){
			$(document).ready(function(){
			$(window).scroll(function(){
			    if($(window).scrollTop()>50){
			        $('.home_top').css('background','#e25428');
			        $('.od_title').html('订单详情');
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
            	if(nav_index == 0){
            		$('.activityContent').css('display','block');
            		$('.activity_deta_info').css('display','none');
            		$('.pro_recom').css('display','none');
            	}else if (nav_index == 1){
                    $('.activityContent').css('display','none');
            		$('.activity_deta_info').css('display','block');
            		$('.pro_recom').css('display','none');
            	}else if(nav_index == 2){
                    $('.activityContent').css('display','none');
            		$('.activity_deta_info').css('display','none');
            		$('.pro_recom').css('display','block');
            	}
            })
		},
		event:function(){
			this.Scroll();
			this.fn();
		}
	}
	//函数调用
	order_deta.event();
	
	//轮播图
	var mySwiper = new Swiper ('.swiper-container', {
			    direction: 'horizontal',
			    loop: true,//是否自动切换
			    //autoplay:5000,//每隔5秒自动切换
			    // 如果需要分页器
			    pagination: '.swiper-pagination',
			    autoplayDisableOnInteraction : false,//手滑都过后依然可以自动切换
			  })      
})