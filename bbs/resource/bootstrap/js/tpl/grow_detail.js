$(function(){
	
	var collect_detail = {

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
		//查看用户信息
			
		//分享功能,收藏功能
		collect_icon:function(){
              window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{}};
			  with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
              // 分享
			  $(document).on('click','.share_icon',function(){
			  	 $('.modal').modal('show');
			  })
			  this.Collection('.collect_icon');
		},
		Collection:function(o){
			//收藏按钮
			$(document).on('click',o,function(){
				if($(this).hasClass('RemoveClass')){
					$(this).attr('src',BBS_RESOURCE_SITE_URL + '/bootstrap/img/collect_n.png');
					$(this).removeClass('RemoveClass');
				}else{
		            $(this).attr('src',BBS_RESOURCE_SITE_URL + '/bootstrap/img/collect_s_red.png');
					$(this).addClass('RemoveClass');
				}
				return false;
			}) 
		},
		//发表评论
		Comment:function(){
			$('.grade>img').click(function(){
				 var Imgindex = $(this).index();
				 if($(this).hasClass('Imgindex')){
                    for(var i=Imgindex;i<5;i++){
				 		$('.grade>img:eq('+ i +')').attr('src','../../img/collect_no.png');
				 		$('.grade>img:eq('+ i +')').removeClass('Imgindex');
				 	} 
				 }else{
				 	for(var i=0;i<Imgindex;i++){
				 		$('.grade>img:eq('+ i +')').attr('src','../../img/collect_s.png');
				 		$('.grade>img:eq('+ i +')').addClass('Imgindex');
				 	}
				 }
			})
			$('.Input_box>button').click(function(){
				//如果没勾选星星，默认是一颗
					console.log($('.Input_box>textarea').val());
					/*$.ajax({  
		                url:"",  //请求路径，接口地址
		                type:"post",  //请求的方式
		//            async:false,//同步  
		                data:{"phone":phone},//传出的数据  
		                dataType:"json",//返回的数据类型，常用：html/text/json  
		                success:function(data){  //请求成功后的回调函数
		                    console.log(typeof data);
		                    Href();
		                }  
		            })  */
			})
		},
		//页面跳转
		Annal:function(o){
			$(document).on('click',o,function(){
				Href('../activity_pug/activity_pug.html');
			})
		},
		event:function(){
			this.Scroll();
			this.fn();
			this.collect_icon();
			this.Comment();
			this.Annal('.annal');
			this.Collection('.num_periods>img');
			this.Annal('.main>img');
			this.Annal('.past_img>img');
			this.Annal('.name>span');
		}
	}
	//函数调用
	collect_detail.event();
	
	//轮播图
	var mySwiper = new Swiper ('.swiper-container', {
			    direction: 'horizontal',
			    loop: true,//是否自动切换
			    autoplay:5000,//每隔5秒自动切换
			    autoplayDisableOnInteraction : false,//手滑都过后依然可以自动切换
			  })      
})