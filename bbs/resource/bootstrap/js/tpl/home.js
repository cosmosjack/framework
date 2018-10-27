$(function(){
	var submitflag = false;
	var page = 1;
	var flag = false;
	var home = {
		//页面滚动监听
		Scroll:function(){
			$(document).ready(function(){
			$(window).scroll(function(){
			    if($(window).scrollTop()>50){
			        $('.home_top').css('background','#e25428');
			        $('.inp>input').css({'background':'#FFF','color':'#e25428'});
			        $('.inp').css('color','#e25428');
			        $('.inp>span').css('color','#e25428');
			        console.log(1)
			    }
			    if($(window).scrollTop() < 50){
			    	$('.home_top').css({'background':'url("'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/shadow.png") no-repeat 0 0','background-size':' 100% 100%'});
			    	$('.inp>input').css({'background':'none','color':'#FFF'});
		            $('.inp>span').css('color','#FFF');
			    }
			   });
			})
		},
		//滑动到底部事件
		SlideFinal:function(){
			var self = this;
			$(document).on("scroll", function () {
			 //真实内容的高度
			 var pageHeight = Math.max(document.body.scrollHeight, document.body.offsetHeight);
			 //视窗的高度
			 var viewportHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight || 0;
			 //隐藏的高度
			 var scrollHeight = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
			 //判断加载视频，文章，回答，医生
			 if(pageHeight - viewportHeight - scrollHeight <=0){
				 	console.log(page);
				 	self.LoadList();
				}
			});
		},
		//页面加载数据
		LoadList:function(){
			if(flag)
				return false;
			var keyword = $('#keyword').val();
		    $.ajax({  
	            url:SITEURL+"/index.php?act=activity&op=listPage&curpage="+page,  //请求路径，接口地址
	            type:"POST",  //请求的方式
	            async:false,//同步  
	            data:{keyword:keyword},//传出的数据  
	            dataType:"json",//返回的数据类型，常用：html/text/json  
	            success:function(data){  //请求成功后的回调函数
	            	//console.log(data);
	            	var html = '';
	            	if(data.code == '200'){
	            		for(var i=0; i<data.list.length; i++){
	            			if(data.list[i].collect == '1')
	            				var collect = 'collect_s_red';
	            			else
	            				var collect = 'collect_n';
	                		html += '<div class="index_pro">';
	        	 			html += '	<div class="overflow index_pro_Img" href_url="'+data.list[i].url+'">';
	        	 			html += '		<img src="'+data.list[i].activity_index_pic+'!product-360" class="pro_img" />'+data.list[i].top;
				        	html += '       <div class="num_periods"><img href_url="'+data.list[i].url1+'" src="'+ BBS_RESOURCE_SITE_URL+'/bootstrap/img/'+collect+'.png" />';
				        	html += '       </div>';
				        	html += '		<div class="mask">';
				        	html += '			<span class="pull-left">'+data.list[i].address+'</span>';
				        	html += '			<span class="pull-left text-right">'+data.list[i].activity_tag+'</span>';
				        	html += '		</div>';
				        	html += '	</div>';
				        	html += '	<div class="overflow pro_tit">';
				        	html += '		<div class="col-xs-10 col-xs-offset-1">';
				        	html += '			<span class="pull-left col-xs-8 ProTitle">';
				        	html += '				<span class="city">【'+data.list[i].city+'】</span>'+data.list[i].activity_title+'';
				        	html += 	'			</span>';
				        	html += '			<span class="people pull-right text-right">已参与';
				        	html += '				<span class="past">'+data.list[i].already_num+'</span>/<span class="sum">'+data.list[i].total_number+'</span>';
				        	html += '			</span>';
				        	html += '		</div>';
				        	html += '	</div>';
				        	html += '	<div class="overflow time_price">';
				        	html += '		<div class="col-xs-10 col-xs-offset-1">';
				        	html += '			<div class="pull-left">';
				        	html += '				<p>'+data.list[i].activity_time+'</p>';
				            html += '				<p class="price">&yen;'+data.list[i].activity_price+'<span class="NumPeriods">第'+data.list[i].activity_periods+'期</span></p>';
				        	html += '			</div>';
				        	html += '			<div class="row pull-left text-right">'+data.list[i].footer+'</div>';
				        	html += '		</div>';
				        	html += '	</div>';
				        	html += '</div>';
	            		}
	            		$('.content').append(html);
	            	}else{
	            		if(page == 1){
	            			html += '<div class="no_data container-fluid">';
					        html += '    <div class="row">';
					        html += '         <img style="pointer-events:none" src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/null.png" class="col-xs-6 col-xs-offset-3" />';
					        html += '         <p class="col-xs-12 text-center">还没有活动内容</p>';
					        html += '    </div>';
					        html += '</div>';
					        $('.home').append(html);
	            		}else{
	            			$('.content').append('<div id="noMore" style="text-align: center;">已加载到底部</div>');
	            		}
	            		
	            		flag = true;
	            	}
	            	page++;
	            }  
	        })
		},
		//轮播图
		Banner:function(){
			var mySwiper = new Swiper ('.swiper-container', {
			    direction: 'horizontal',
			    loop: true,//是否自动切换
			    autoplay:5000,//每隔5秒自动切换
			    // 如果需要分页器
			    pagination: '.swiper-pagination',
			    autoplayDisableOnInteraction : false,//手滑都过后依然可以自动切换
			  });
		},
		//顶部搜索框
		Seo:function(){
			$('.glyphicon-search').click(function(){
				page = 1;
				flag = false;
				$('.content').html('');
        		$('.no_data').remove();
				home.LoadList();
				// var keyword = $(this).prev().val();
				// var url = SITEURL+'/index.php?act=activity&op=index&keyword='+encodeURI(keyword); 
				// console.log(url);
			}); 
		},
		//页面跳转
		UrlClick:function(o){
			$('.home').on('click',o,function(){
				Href($(this).attr('href_url'));
			})
		},
		//收藏按钮
		Collection:function(){
			var html = $('<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"><div class="modal-dialog modal-sm row" role="document"><div class="modal-content col-xs-10 point col-xs-offset-1"><h4 class="col-xs-12 text-center">已收藏</h4><button class="col-xs-12 aHide">确定</button></div></div></div>');
			$('.home').append(html);
            $('.content').on('click','.num_periods>img',function(){
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
		Event:function(){
			this.LoadList();
			this.Scroll();
			this.SlideFinal();
			this.Banner();
			this.Seo();
			this.UrlClick('#nav1');
			this.UrlClick('#nav2');
			this.UrlClick('#nav3');
			this.UrlClick('#nav4');
			this.UrlClick('.pro_btn');
			this.UrlClick('.index_pro_Img');
			this.Collection();
		}
	}
	home.Event();
})