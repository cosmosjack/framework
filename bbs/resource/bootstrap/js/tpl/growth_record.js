$(function(){
	var page = 1;
	var flag = false;
	var type = 0;
	var growth_record = {
		//分页加载数据
		loadPage:function(){
			if(flag)
			 	return false;
		    $.ajax({  
                url:SITEURL+"/index.php?act=mine&op=growRecord&curpage="+page,  //请求路径，接口地址
                type:"post",  //请求的方式
                async:false,//同步  
                data:{type:type,pageSize:6},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                	//console.log(data);
                	var html = '';
                	if(data.code == '200'){
                		for(var i=0; i<data.list.length; i++){
			                html += '<div class="col-xs-12" Href_url="'+data.list[i].url+'">';
			        	    html += '	<div class="overflow gr_pro">';
				        	html += '   	<img src="'+data.list[i].activity_index_pic+'!product-360" class="col-xs-4 gr_img" />';
				        	html += '		<div class="col-xs-8 gr_txt">';
				        	html += '			<p class="gr_title">';
				        	html += '		 		<span>'+data.list[i].activity_title+'</span><span class="glyphicon glyphicon-menu-right pull-right"></span>';
				        	html += '			</p>';
				        	html += '		 	<p class="vice_title">'+data.list[i].activity_ptitle+'</p>';
				        	html += '		 	<p class="time_class"><span>'+data.list[i].time+'</span><span>植树 | 体验 | 自然</span></p>';
				        	html += '		</div>';
			        	    html += '	</div>';
			        		html += '</div>';
                		}
                		
                	}else{
                		if(page == 1){
				            html += '<div class="no_data container-fluid">';
					        html += '    <div class="row">';
					        html += '         <img style="pointer-events:none" src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/null.png" class="col-xs-6 col-xs-offset-3" />';
					        html += '         <p class="col-xs-12 text-center">您还没有参加过活动</p>';
					        html += '    </div>';
					        html += '</div>';

                		}else{
                			html += '<div id="noMore" style="text-align: center;">已加载到底部</div>';
                		}
                		flag = true;
                	}
                	$('.gr_content').append(html);
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
			 	growth_record.loadPage();
			 }
			});
		},
		//设置头部栏目的宽度
		TitleWidth:function(){
            len = $('.title_ul>li').length;
            var oUl_w = 0;
            for(var i=0;i<len;i++){
            	$('.title_ul>li:eq('+ i +')').width();
            	oUl_w +=$('.title_ul>li:eq('+ i +')').width();
            }
           $('.title_ul').css('width',oUl_w + len*20);
           $('.growth_record').on('click','.title_ul>li',function(){
           	       $(this).addClass('active');
           	       $(this).siblings('li').removeClass('active');
           	       type = $(this).attr('data-id');
           	       page = 1;
           	       flag = false;
           	       $('.gr_content').html('');
           	       growth_record.loadPage();
           })
		},
		//跳转详情页面
		Jump:function(){
			$('.growth_record').on('click','.gr_content>div',function(){
				Href($(this).attr('Href_url'));
			})
		},
		event:function(){
			this.TitleWidth();
			this.Scroll();
			this.Jump();
			this.loadPage();
		}
	};
	growth_record.event();
})