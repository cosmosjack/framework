$(function(){
	var page = 1;
	var flag = false;
	var submitflag = false;
	var activity_expired = {
		//分页加载数据
		loadPage:function(){
			if(flag)
			 	return false;
			var keyword = $('#keyword').val();
		    $.ajax({  
                url:SITEURL+"/index.php?act=activity&op=listPageOld&curpage="+page,  //请求路径，接口地址
                type:"post",  //请求的方式
                async:false,//同步  
                data:{keyword:keyword},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                	//console.log(data);
                	var html = '';
                	if(data.code == '200'){
                		if(page == 1)
                			html += '<div class="content">';
                		for(var i=0; i<data.list.length; i++){
                			if(data.list[i].collect == '1')
	            				var collect = 'collect_s_red';
	            			else
	            				var collect = 'collect_n';
				        	html += '<div class="index_pro">';
				        	html += ' 	<div class="overflow index_pro_Img" href_url="'+data.list[i].url1+'">';
				        	html += ' 		<img src="'+data.list[i].activity_index_pic+'!product-360" class="col-xs-10 col-xs-offset-1 pro_img" />';
				            html += '        <div class="Prompt text-left"><span>'+data.list[i].activity_title+'<span></div>';
				            html += '        <img href_url="'+data.list[i].url+'" src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/'+collect+'.png" class="collect" />';
				        	html += ' 		<div class="mask">';
				        	html += ' 			<span class="pull-left">'+data.list[i].address+' '+data.list[i].age+'岁</span>';
				        	html += ' 			<span class="pull-left text-right">亲子活动、成长</span>';
				        	html += ' 		</div>';
				        	html += ' 	</div>';
				        	html += ' 	<div class="overflow pro_tit">';
				        	html += ' 		<div class="col-xs-10 col-xs-offset-1">';
				        	html += ' 			<span class="pull-left">';
				        	html += ' 				<span class="city">【'+data.list[i].city+'】</span>'+data.list[i].activity_time;
				        	html += ' 			</span>';
				        	html += ' 			<div class="pull-right text-right">';
				        	html += ' 				<button class="pro_btn" href_url="'+data.list[i].url1+'">去回顾</button>';
				        	html += ' 			</div>';
				        	html += ' 		</div>';
				        	html += ' 	</div>	';
				        	html += '</div>';
                		}
                		if(page == 1){
                			html += '</div>';
                			$('.activity_expired').append(html);
                		}else{
                			$('.content').append(html);
                		}
                	}else{
                		if(page == 1){
                			html += '<div class="no_data container-fluid">';
					        html += '    <div class="row">';
					        html += '         <img style="pointer-events:none" src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/null.png" class="col-xs-6 col-xs-offset-3" />';
					        html += '         <p class="col-xs-12 text-center">还没有活动内容</p>';
					        html += '    </div>';
					        html += '</div>';
					        $('.activity_expired').append(html);
                		}else{
                			$('.content').append('<div id="noMore" style="text-align: center;">已加载到底部</div>');
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
			 		activity_expired.loadPage();
				}
			});
		},
		//点击收藏
		click_collect:function(){
			var html = $('<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"><div class="modal-dialog modal-sm row" role="document"><div class="modal-content col-xs-10 point col-xs-offset-1"><h4 class="col-xs-12 text-center">已收藏</h4><button class="col-xs-12 aHide">确定</button></div></div></div>');
				$('.activity_expired').append(html);
			$('.content').on('click','.collect',function(){
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
		//点击导航跳转页面
		 click_slip:function(){
        	$('.nav_index>div').click(function(){
        		  Href($(this).attr('href_url'));
			})
        },
        //点击跳转页面
        click_Href:function(e){
        	$('.activity_expired').on('click',e,function(){
        		Href($(this).attr('href_url'));
        	})
        },
        //点击搜索
        search:function(){
        	$('.activity_expired').on('click','.glyphicon-search',function(){
        		page = 1;
        		flag = false;
        		$('.content').remove();
        		$('.no_data').remove();
        		activity_expired.loadPage();
        	})
        },
        event:function(){
        	this.loadPage();
        	this.Scroll();
        	this.click_slip();
        	this.click_collect();
        	this.click_Href('.pro_btn');
        	this.click_Href('.index_pro_Img');
        	this.search();
        }
	};
	//函数调用
	activity_expired.event();
})