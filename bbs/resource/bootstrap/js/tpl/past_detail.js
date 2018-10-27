$(function(){
	var submitflag = false;
	var flag = false;
	var page = 1;
	var past_detail = {
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
			        $('.od_title').html('往期详情');
			        $('.collect_icon').css('display','none');
			    }
			    if($(window).scrollTop() < 50){
			    	$('.od_title').html('');
			    	$('.home_top').css({'background':'url("'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/shadow.png") no-repeat 0 0','background-size':' 100% 100%'});
			        $('.collect_icon').css('display','block');
			    }
			   });
			});
		},
		//切换活动内容，活动评论
		fn:function(){
            $('.re_nav>div').click(function(){
            	var nav_index = $(this).index();
            	$(this).find('span').addClass('active');
            	$(this).siblings('div').find('span').removeClass('active');
            	if(nav_index == 0){
            		$('.activityContent').css('display','block');
            		$('.activity_deta_info').css('display','none');
            	}else if (nav_index == 1){
                    $('.activityContent').css('display','none');
            		$('.activity_deta_info').css('display','block');
            	}
            })

		},
		//查看用户信息
		user_click:function(){
			$(document).on('click','.past_img>img',function(){
				console.log('我是第'+ $(this).index() +'个用户');
			})
			//查看全部用户
			$('.name>span').click(function(){
				console.log('查看全部用户');
				//Href()路径还没有定
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
			  $('.past_detail').on('click','#share_it',function(){
			     $(this).fadeOut(300);
			  })
			  //收藏
			  $('.home_top').on('click','.collect_icon',function(){
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
		//发表评论
		Comment:function(){
			$('.grade>img').click(function(){
				 var Imgindex = $(this).index();
				 if($(this).hasClass('Imgindex')){
                    for(var i=Imgindex;i<5;i++){
				 		$('.grade>img:eq('+ i +')').attr('src',BBS_RESOURCE_SITE_URL+'/bootstrap/img/collect_no.png');
				 		$('.grade>img:eq('+ i +')').removeClass('Imgindex');
				 	} 
				 }else{
				 	for(var i=0;i<Imgindex;i++){
				 		$('.grade>img:eq('+ i +')').attr('src',BBS_RESOURCE_SITE_URL+'/bootstrap/img/collect_s_red.png');
				 		$('.grade>img:eq('+ i +')').addClass('Imgindex');
				 	}
				 }
			})
			$('.Input_box>button').click(function(){
				var grade = $('.grade .Imgindex').length;
				var content = $('.Input_box>textarea').val();
				var id = $('#past_id').val();
				console.log(id,grade,content);
				$.ajax({  
	                url:SITEURL+"/index.php?act=activity&op=comment",  //请求路径，接口地址
	                type:"post",  //请求的方式
	                async:false,//同步  
	                data:{id:id,grade:grade,content:content},//传出的数据  
	                dataType:"json",//返回的数据类型，常用：html/text/json  
	                success:function(data){  //请求成功后的回调函数
	                	$('.point>h4').html(data.msg);
		                $('.modal').modal('show');
		                var html = '';
	                    if(data.code == '200'){
	                    	//window.location.reload();
	                    	html += '<div class="reviews col-xs-12 overflow">';
		                    html += '    <div class="col-xs-2 text-center">';
		                    html += '        <img src="'+data.info.comment_pic+'" class="user_img" />';
		                    html += '    </div>';
		                    html += '    <div class="col-xs-10 review_txt" data-id="'+data.info.id+'">';
		                    html += '        <div class="col-xs-12">';
		                    html += '           <div class="col-xs-8">';
		                    html += '                <p class="user_name" data-id="'+data.info.comment_id+'">'+data.info.comment_name+'</p>';
		                    html += '                <span class="user_time">'+data.info.add_time+'</span>';
		                    html += '           </div>';
		                    html += '           <div class="col-xs-4 degree text-right">';
		                    for(var j=0; j<data.info.grade; j++){
		                    	html += '                <img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/collect_s_red.png" />';
							}
		                    html += '           </div>';
		                    html += '        </div>';
		                    html += '        <p class="col-xs-12">'+data.info.content+'</p>';
		                    html += '    </div>';
		                    html += '</div>';
		                    $('#comment').append(html);
		                    $('.Input_box>textarea').val('');
		                    $('.grade>img').attr('src',BBS_RESOURCE_SITE_URL+'/bootstrap/img/collect_no.png');
		                    past_detail.Reply_fn('.review_txt>p');
	                    }
	                }  
	            })  
			})
		},
		//回复功能
		Reply_fn:function(o){
			var oIndex = 0;//判断当前是否在评论
			//点击评论时出现文本框
			$('.past_detail').on('click',o,function(){
				if($('.ReplyBtn').length == 1){
                     return;
				}
				var oInp = $('<div class="overflow col-xs-12"><div class="col-xs-8 ReDiv"><textarea class="ReplyTxt"></textarea></div><button class="col-xs-2 ReplyBtn">完成</botton></div>');
                $(this).after(oInp);
                $('.ReplyTxt').focus();
			})
			//确定按钮
			$('.past_detail').on('click','.ReplyBtn',function(){
				if($('.ReplyTxt').val().length == 0){
					$(this).parent('div').remove();
					return;
				};
				if(submitflag)
					return false;
				var obj = $(this);
				var id = $(this).parent().parent('.review_txt').attr('data-id');
				var replay_id = $(this).parent().parent('.review_txt').find('.user_name').attr('data-id');
				var replay_name = $(this).parent().parent('.review_txt').find('.user_name').html();
				var content = $('.ReplyTxt').val();
				console.log(id,replay_id,replay_name,content);
				submitflag = true;
				$.ajax({  
	                url:SITEURL+"/index.php?act=activity&op=replay",  //请求路径，接口地址
	                type:"post",  //请求的方式
	                async:false,//同步  
	                data:{id:id,content:content,replay_id:replay_id,replay_name:replay_name},//传出的数据  
	                dataType:"json",//返回的数据类型，常用：html/text/json  
	                success:function(data){  //请求成功后的回调函数
	                	submitflag = false;
		                $('.point>h4').html(data.msg);
		                $('.modal').modal('show');
	                    if(data.code == '200'){
	                    	var html = $('<div class="reply review_txt col-xs-12 overflow" data-id="'+data.info.id+'"><span class="col-xs-12"><span class="user_name" data-id="'+data.info.comment_id+'">'+data.info.comment_name+'</span>回复<span class="user">'+data.info.replay_name+'</span>:</span><span class="user_time col-xs-12">'+data.info.add_time+'</span><p class="col-xs-12">'+ $('.ReplyTxt').val() +'</p></div>');
							obj.parent('div').parent('div').append(html);
							obj.parent('div').remove();
	                    }
	                }  
	            })  
				
			})
			//光标从文本框移出时blur
			$('.past_detail').on('blur','.ReplyTxt',function(){
				if($(this).val().length == 0){
					$(this).parent('div').parent('div').remove();
					return;
				};
			})
			//取消按钮
			$('.past_detail').on('click','.ReplyCancel',function(){
				    $(this).parent('div').parent('div').remove();
					return;
			})

		},
		//分页加载评论数据
		loadPage:function(){
			if(flag)
			 	return false;
			var id = $('#past_id').val();
		    $.ajax({  
                url:SITEURL+"/index.php?act=activity&op=commentList&curpage="+page,  //请求路径，接口地址
                type:"post",  //请求的方式
                async:false,//同步  
                data:{id:id,pageSize:3},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                	//console.log(data.comment_list[0].replay.length);
                	var html = '';
                	if(data.code == '200'){
                		
                		for(var i=0; i<data.comment_list.length; i++){
                			var ff = 'block';

                			html += '<div class="reviews col-xs-12 overflow">';
		                    html += '    <div class="col-xs-2 text-center">';
		                    html += '        <img src="'+data.comment_list[i].comment_pic+'" class="user_img" />';
		                    html += '    </div>';
		                    html += '    <div class="col-xs-10 review_txt" data-id="'+data.comment_list[i].id+'">';
		                    html += '        <div class="col-xs-12">';
		                    html += '           <div class="col-xs-8">';
		                    html += '                <p class="user_name" data-id="'+data.comment_list[i].comment_id+'">'+data.comment_list[i].comment_name+'</p>';
		                    html += '                <span class="user_time">'+data.comment_list[i].add_time+'</span>';
		                    html += '           </div>';
		                    html += '           <div class="col-xs-4 degree text-right">';
		                    for(var j=0; j<data.comment_list[i].grade; j++){
		                    	html += '                <img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/collect_s_red.png" />';
							}
		                    html += '           </div>';
		                    html += '        </div>';
		                    html += '        <p class="col-xs-12">'+data.comment_list[i].content+'</p>';
		                    html += '        <!--回复信息-->';
		                    html += '        <!--当回复信息超过3条时-->';
		                    if(data.comment_list[i].replay.length > 3){
			                    html += '        <div class="col-xs-12 ellipsis">';
			                    html += '            <span>共有'+data.comment_list[i].replay.length+'条回复</span>';
			                    html += '        </div>';
			                    ff = 'none';
		                    }
		                    for(var k=0; k<data.comment_list[i].replay.length; k++){
			                    html += '        <div style="display:'+ff+'" class="reply review_txt col-xs-12 overflow" data-id="'+data.comment_list[i].replay[k].id+'">';
			                    html += '            <span class="col-xs-12">';
			                    html += '                <span class="user_name" data-id="'+data.comment_list[i].replay[k].comment_id+'">'+data.comment_list[i].replay[k].comment_name+'</span>回复';
			                    html += '                <span class="user">'+data.comment_list[i].replay[k].replay_name+'</span>:';
			                    html += '            </span>';
			                    html += '            <span class="user_time col-xs-12">'+past_detail.timestampToTime(parseInt(data.comment_list[i].replay[k].add_time))+'</span>';
			                    html += '            <p class="col-xs-12">'+data.comment_list[i].replay[k].content+'</p>';
			                    html += '        </div>';
		                    }
		                    html += '    </div>';
		                    html += '</div>';
                		}
                		$('#comment').append(html);
                		//显示回复
						$('.ellipsis').on('click',function(){
							console.log(1);
							$(this).parent().find('.reply').css('display','block');
							$(this).remove();
						})
                	}else{
                		if(page == 1){
                			$('#comment').html('暂无评论');
                		}else{
                			$('#comment').after('<div id="noMore" style="text-align: center;">已加载到底部</div>');
                		}
                		flag = true;
                	}
                	page++;
                }  
            })
		},
		//滑动到底部事件
		Scroll:function(){
			$(document).on("scroll", function () {
			 //真实内容的高度
			 var pageHeight = Math.max(document.body.scrollHeight, document.body.offsetHeight);
			 //视窗的高度
			 var viewportHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight || 0;
			 //隐藏的高度
			 var scrollHeight = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
			 //判断加载视频，文章，回答，医生
			 if(pageHeight - viewportHeight - scrollHeight <=0){
			 		past_detail.loadPage();
			 	}
			});
		},
		//时间戳转化日期
		timestampToTime:function(timestamp){
			var date = new Date(timestamp*1000); //时间戳为10位需*1000，时间戳为13位的话不需乘1000
			//console.log(date.getMonth());//月份比当前月少1
			//console.log(date.getDate());
			Y = date.getFullYear() + '-';
			M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '-';
			D = (date.getDate()<10 ? '0'+date.getDate(): date.getDate()) + ' ';
			h = (date.getHours()<10 ? '0'+date.getHours(): date.getHours()) + ':';
			m = (date.getMinutes()<10 ? '0'+date.getMinutes(): date.getMinutes()) + ':';
			s = (date.getSeconds()<10 ? '0'+date.getSeconds(): date.getSeconds());
			return Y + M + D + h + m + s;
		},
		event:function(){
			this.Banner();
			this.Scroll();
			this.fn();
			this.collect_icon();
			this.user_click();
			this.Comment();
			this.Reply_fn('.review_txt>p');
			this.loadPage();
		}
	}
	//函数调用
	past_detail.event();
	
	     
})