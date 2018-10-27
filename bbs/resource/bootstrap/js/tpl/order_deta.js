$(function(){
	var submitflag = false;
	var order_deta = {
        //轮播图
		Banner:function(){
			var mySwiper = new Swiper ('.swiper-container', {
					    direction: 'horizontal',
					    loop: true,//是否自动切换
					    autoplay:5000,//每隔5秒自动切换
					    // 如果需要分页器
					    pagination: '.swiper-pagination',
					    autoplayDisableOnInteraction : false,//手滑都过后依然可以自动切换
					  })   
		},
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
            		$('.pro_recom').css('display','none');
            	}else if (nav_index == 1){
                    $('.activityContent').css('display','none');
            		$('.pro_recom').css('display','block');
            	}
            })
		},
		//取消订单
		Cancel:function(){
			$('.cancel').click(function(){
				//防止重复提交
				if(submitflag)
					return false;
				var id = $('#orderId').val();
				$('.point').children().remove();
				var html = $('<h4 class="col-xs-12 text-center point_txt">提示</h4><button class="col-xs-6 col-xs-offset-3 aHide" style="color:#FFF;background: #e25428;border: none;border-radius: 10px;padding: 5px;">确定</button>');
				$('.point').append(html);
				$.ajax({  
	                url:SITEURL+'/index.php?act=order&op=ajaxCancelOrder',  //请求路径，接口地址
	                type:"post",  //请求的方式
	                async:false,//同步  
	                data:{id:id},//传出的数据  
	                dataType:"json",//返回的数据类型，常用：html/text/json  
	                success:function(data){  //请求成功后的回调函数
	                    //console.log(typeof data);
	                    $('.point_txt').html(data.msg);
	             		$('.modal').modal('show');
	             		//HrefDelay(data.url);
	                    submitflag = false;
	                },  
	                error:function(e){
	                    $('.point_txt').html('网络错误');
	             		$('.modal').modal('show');
	                    submitflag = false;
	                }
	            })  
			})
		},
		//分享订单
		ShareOrder:function(){
      		// var html = $('<img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/paysuccess.png" /><h4>支付成功</h4><p class="prompt">分享我的活动报名即刻获取优惠券！</p><div class="overflow"><div class="bdsharebuttonbox col-xs-12 text-center overflow"><div class="col-xs-3 overflow"><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><p class="col-xs-12">微信</p></div><div class="col-xs-3 overflow"><a href="#" class="bds_tsina col-xs-12" data-cmd="tsina" title="分享到新浪微博"></a><p class="col-xs-12">新浪</p></div><div class="col-xs-3 overflow"><a href="#" class="bds_sqq col-xs-12" data-cmd="sqq" title="分享到QQ好友"></a><p class="col-xs-12">QQ</p></div><div class="col-xs-3 overflow"><a href="#" class="bds_more col-xs-12" data-cmd="more"></a><p class="col-xs-12">其他</p></div></div>')
      		$('.cancel').click(function(){
      			// $('.point').html(html);
                // $('.modal').modal('show');
                window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{}};
                with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
      			$('.bullet').fadeIn(300);
      		})
		},
		//分享功能
		Share:function(){
		    window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{}};
		    with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
		    function block(o){
                $('.order_deta').on('click',o,function(){
			    	$('.bullet').fadeIn(300);
			    	return false;
			    })
		    }
		    function none(o){
                $('.order_deta').on('click',o,function(){
					$('.bullet').fadeOut(300);
					return false;
				})
		    };
		    block('#share_icon');
		    block('.bdsharebuttonbox');
			none('.bullet');
		},
		//收藏按钮
		Collection1:function(o){
			$('.order_deta').on('click',o,function(){
				//防止重复提交
				if(submitflag)
					return false;
				var url = $(this).attr('href_url');
				var obj = $(this);
				submitflag = true;
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
		event:function(){
			this.Banner();
			this.Scroll();
			this.fn();
			this.ShareOrder();
			this.Share();
			this.Collection1('#collect_icon');
			this.Collection1('.num_periods>img');
		}
	}
	//函数调用
	order_deta.event();
	
	
})