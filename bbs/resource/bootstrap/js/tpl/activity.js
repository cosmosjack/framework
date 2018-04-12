$(function(){
	var page = 1;
	var flag = false;
	var activity = {
		//分页加载数据
		loadPage:function(){
			if(flag)
			 	return false;
			var keyword = $('#keyword').val();
		    $.ajax({  
                url:SITEURL+"/index.php?act=activity&op=listPage&curpage="+page,  //请求路径，接口地址
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
	                		html += '<div class="index_pro">';
	        	 			html += '	<div class="overflow index_pro_Img" href_url="'+data.list[i].url1+'">';
	        	 			html += '		<img src="'+data.list[i].activity_index_pic+'" class="col-xs-10 col-xs-offset-1 pro_img" />';
				            html += '		'+data.list[i].top+'';
				        	html += '       <div class="num_periods"><img src="'+ BBS_RESOURCE_SITE_URL+'/bootstrap/img/collect_n.png" />';
			        		html += '       </div>';
				        	html += '		<div class="mask">';
				        	html += '			<span class="pull-left">'+data.list[i].address+' '+data.list[i].age+'岁</span>';
				        	html += '			<span class="pull-left text-right">'+data.list[i].activity_tag+'</span>';
				        	html += '		</div>';
				        	html += '	</div>';
				        	html += '	<div class="overflow pro_tit">';
				        	html += '		<div class="col-xs-10 col-xs-offset-1">';
				        	html += '			<p class="pull-left act_title">';
				        	html += '				<span class="city">【'+data.list[i].city+'】</span>'+data.list[i].activity_title+'';
				        	html += 	'			</p>';
				        	html += '			<p class="people pull-right text-right act_title">已参与';
				        	html += '				<span class="past">'+data.list[i].already_num+'</span>/<span class="sum">'+data.list[i].total_number+'</span>';
				        	html += '			</p>';
				        	html += '		</div>';
				        	html += '	</div>';
				        	html += '	<div class="overflow time_price">';
				        	html += '		<div class="col-xs-10 col-xs-offset-1">';
				        	html += '			<div class="pull-left">';
				        	html += '				<p>'+data.list[i].activity_time+'</p>';
				            html += '				<p class="price">&yen;'+data.list[i].activity_price+'</p>';
				        	html += '			</div>';
				        	html += '			<div class="row pull-left text-right">'+data.list[i].footer+'</div>';
				        	html += '		</div>';
				        	html += '	</div>';
				        	html += '</div>';
                		}
                		if(page == 1){
                			html += '</div>';
                			$('.activity').append(html);
                		}else{
                			$('.content').append(html);
                		}
                	}else{
                		if(page == 1){
                			html += '<div class="no_data container-fluid">';
					        html += '    <div class="row">';
					        html += '         <img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/null.png" class="col-xs-6 col-xs-offset-3" />';
					        html += '         <p class="col-xs-12 text-center">还没有活动内容</p>';
					        html += '    </div>';
					        html += '</div>';
					        $('.activity').append(html);
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
			 if(pageHeight - viewportHeight - scrollHeight <=0){
			 		activity.loadPage();
			 	}
			});
		},
        //点击导航跳转页面
        click_slip:function(){
        	$('.nav_index>div').click(function(){
        		  Href($(this).attr('href_url'));
			})
        },
        //跳转页面
        click_Href:function(e){
        	$(document).on('click',e,function(){
		    	Href($(this).attr('href_url'));
		    })
        },
        //点击搜索
        search:function(){
        	$(document).on('click','.glyphicon-search',function(){
        		page = 1;
        		flag = false;
        		$('.content').remove();
        		$('.no_data').remove();
        		activity.loadPage();
        	})
        },
        Collection:function(){
        	//收藏按钮
			$(document).on('click','.num_periods>img',function(){
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
				this.loadPage();
				this.Scroll();
				this.click_slip();
				this.click_Href('.pro_btn');
				this.search();
				this.Collection();
			}
	}
	//函数调用
	activity.event();
})