$(function(){
	var page = 1;
	var flag = false;
	var arrange = {
		//分页加载数据
		loadPage:function(){
			if(flag)
			 	return false;
			 var cls = $('.nav').find('.active').parent().attr('Href_url');
			 console.log(cls);
		    $.ajax({  
                url:SITEURL+"/index.php?act=activity&op=listPage&curpage="+page,  //请求路径，接口地址
                type:"get",  //请求的方式
                //            async:false,//同步  
                data:{},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                	//console.log(data);
                	var html = '';
                	if(data.code == '200'){
                		for(var i=0; i<data.list.length; i++){
				        	html += '<div class="row a_pro">';
				        	html += '	<img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/activitylogo_1.jpg" class="col-xs-3" />';
				        	html += '	<div class="col-xs-6 overflow">';
				        	html += '		<p class="a_tit">城市生存挑战，全新竞速模式！</p>';
				        	html += '		<p class="a_time">3月24日</p>';
				        	html += '		<p>已报名：<span class="a_join">6</span> / 30人</p>';
				        	html += '	</div>';
				        	html += '	<div class="col-xs-3 a_status text-center">';
				        	html += '		 <p>状态</p>';
				        	html += '		 <p class="status">报名中</p>';
				        	html += '	</div>';
				        	html += '</div>';
                		}
                		$('.'+cls).append(html);
                	}else{
                		if(page == 1){
                			html += '<div class="no_data container-fluid">';
					        html += '    <div class="row">';
					        html += '         <img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/null.png" class="col-xs-6 col-xs-offset-3" />';
					        html += '         <p class="col-xs-12 text-center">还没有活动内容</p>';
					        html += '    </div>';
					        html += '</div>';
					        $('.'+cls).append(html);
                		}else{
                			$('.'+cls).append('<div id="noMore" style="text-align: center;">已加载到底部</div>');
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
			 if(pageHeight - viewportHeight - scrollHeight <= 0){

			 	arrange.loadPage();
			     /*$.ajax({  
		                url:"",  //请求路径，接口地址
		                type:"post",  //请求的方式
		                //            async:false,//同步  
		                data:{"phone":phone},//传出的数据  
		                dataType:"json",//返回的数据类型，常用：html/text/json  
		                success:function(data){  //请求成功后的回调函数
		                	self.index = 1;//修改为已解除状态
		                    console.log(typeof data);

		                }  
		            })  */
			 }
			});
		},
		//月份选择
		month_click:function(){
			$(document).on('click','.nav_index>div',function(){
				 $(this).find('span').addClass('active');
				 $(this).siblings('div').find('span').removeClass('active');
                 var oindex = $(this).index();
                 if(oindex == 0){
                 	$('.three').css('display','block');
                 	$('.four').css('display','none');
                 	$('.five').css('display','none');
                 	page = 1;
                 	flag = false;
                 	$('.three').html('');
                 	arrange.loadPage();
                 }else if(oindex == 1){
                    $('.three').css('display','none');
                 	$('.four').css('display','block');
                 	$('.five').css('display','none');
                 	page = 1;
                 	flag = false;
                 	$('.four').html('');
                 	arrange.loadPage();
                 }else if(oindex == 2){
                    $('.three').css('display','none');
                 	$('.four').css('display','none');
                 	$('.five').css('display','block');
                 	page = 1;
                 	flag = false;
                 	$('.five').html('');
                 	arrange.loadPage();
                 }
			})
		},
		//点击进入活动详情
		a_pro_click:function(){
			$(document).on('click','.a_pro',function(){
				console.log("<?php echo urlBBS('activity','activityDetail')?>");
				Href("<?php echo urlBBS('activity','activityDetail')?>");
			})
		},
		event:function(){
			this.loadPage();
			this.Scroll();
			this.month_click();
		}
	};
	arrange.event();
})