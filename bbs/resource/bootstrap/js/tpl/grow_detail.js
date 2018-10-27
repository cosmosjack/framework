$(function(){
	var submitflag = false;
	var collect_detail = {

        //轮播图
        Banner:function(){
        	var mySwiper = new Swiper ('.swiper-container', {
			    direction: 'horizontal',
			    loop: true,//是否自动切换
			    autoplay:5000,//每隔5秒自动切换
			    autoplayDisableOnInteraction : false,//手滑都过后依然可以自动切换
			    pagination: '.swiper-pagination',// 如果需要分页器
			  })
        },
		//页面滚动监听
		Scroll:function(){
			$(document).ready(function(){
			$(window).scroll(function(){
			    if($(window).scrollTop()>50){
			        $('.home_top').css('background','#e25428');
			        $('.od_title').html('成长记录');
			        $('.collect_icon').css('display','none');
			    }
			    if($(window).scrollTop() < 50){
			    	$('.od_title').html('');
			    	$('.home_top').css({'background':'url("'+ BBS_RESOURCE_SITE_URL + '/bootstrap/img/shadow.png") no-repeat 0 0','background-size':' 100% 100%'});
			    	$('.collect_icon').css('display','block');
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
            	}else if (nav_index == 2){
                    $('.activityContent').css('display','none');
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
			  $('.home_top').on('click','.share_icon',function(){
			  	 $('#share_it').fadeIn(300);
			  })
			  $('.grow_detail').on('click','#share_it',function(){
			     $(this).fadeOut(300);
			  })
		},
		//收藏按钮
		Collection:function(o){
			$('.grow_detail').on('click',o,function(){
				//防止重复提交
				if(submitflag)
					return false;
				var url = $(this).attr('href_url');
				var obj = $(this);
				submitflag = true;
				// var html = $('<h4 class="col-xs-12 text-center">已收藏</h4><button class="col-xs-12 aHide">确定</button>');
				// $('.point').html(html);
				//向后台发送请求
		     	$.ajax({  
		            url:url,  //请求路径，接口地址
		            type:"post",  //请求的方式
		            async:false,//同步  
		            data:{},//传出的数据  
		            dataType:"json",//返回的数据类型，常用：html/text/json  
		            success:function(data){  //请求成功后的回调函数
		                submitflag = false;
		                $('.point>h4').html(data.msg);
		                $('.modal').modal('show');
		                if(data.code == '200'){
		                	if(data.flag == 1){
		                		//添加收藏
		                		obj.attr('src',BBS_RESOURCE_SITE_URL + '/bootstrap/img/collect_s_red.png');
		                	}else if(data.flag == 2){
		                		//取消收藏
		                		obj.attr('src',BBS_RESOURCE_SITE_URL + '/bootstrap/img/collect_n.png');
		                	}else{
		                		//没有登录
		                		HrefDelay(data.url);
		                	}
		                }
		            }  
		        })
				return false;
			}) 
		},
		//页面跳转
		Annal:function(o){
			$('.grow_detail').on('click',o,function(){
				Href($(this).attr('href_url'));
			})
		},
		event:function(){
			// this.Banner();
			this.Scroll();
			this.fn();
			// this.collect_icon();
			this.Annal('.annal');
			// this.Collection('.collect_icon');
			this.Collection('.num_periods>img');
			this.Annal('.name>.pull-right');
			this.Annal('.index_pro_Img');
		}
	}
	//函数调用
	collect_detail.event();
})