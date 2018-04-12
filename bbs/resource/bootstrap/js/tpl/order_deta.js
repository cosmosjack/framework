$(function(){
	var submitflag = false;
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
		//分享功能
		Share:function(){
			$('#share_icon').click(function(){
				$('.point').children().remove();
				window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{}};
			 	with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
				var html = $('<div class="bdsharebuttonbox col-xs-12 text-center overflow"><div class="col-xs-3 overflow"><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><p class="col-xs-12">微信</p></div><div class="col-xs-3 overflow"><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><p class="col-xs-12">QQ空间</p></div><div class="col-xs-3 overflow"><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><p class="col-xs-12">新浪</p></div><div class="col-xs-3 overflow"><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a><p class="col-xs-12">QQ</p></div><div class="col-xs-3 overflow"><a href="#" class="bds_more" data-cmd="more"></a><p class="col-xs-12">其他</p></div></div>');
				$('.point').append(html);
				$('.modal').modal('show');
			})
			this.Collection('#collect_icon')
		},
		//收藏按钮
		Collection:function(o){
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
		event:function(){
			this.Scroll();
			this.fn();
			this.Cancel();
			this.Share();
			this.Collection('.num_periods>img');
		}
	}
	//函数调用
	order_deta.event();
	
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