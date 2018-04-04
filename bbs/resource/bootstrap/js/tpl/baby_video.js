$(function(){
	var page = 1;
	var flag = false;
	var baby_video = {
		click:function(){
           $(document).on('click','.click',function(){
              	console.log($(this).index())
              	//Href(url);//url路径暂时未写
           })
		},
		//分页加载数据
		loadPage:function(){
			if(flag)
			 	return false;
		    $.ajax({  
                url:SITEURL+"/index.php?act=order&op=listPage&pageSize=8&curpage="+page,  //请求路径，接口地址
                type:"get",  //请求的方式
                //            async:false,//同步  
                data:{},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                	//console.log(data);
                	var html = '';
                	if(data.code == '200'){
                		if(page == 1)
                			html += '<div class="overflow">';
                		for(var i=0; i<data.list.length; i++){        
				        	html += '<div class="col-xs-6 text-center click">';
			                html += '    <div class="video">';
			    			html += '	    <img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/timg(4).jpg" class="img-responsive center-block" />';
			                html += '        <p class="duration">06:23</p>';
			                html += '    </div>';
			    			html += '	<span>【夏令营】这里是辩题这里是...</span>';
			    			html += '</div>';
                		}
                		if(page == 1){
                			html += '</div>';
                			$('.type_content').append(html);
                		}else{
                			$('.type_content .overflow').append(html);
                		}
                	}else{
                		if(page == 1){
                			html += '<div class="no_data container-fluid">';
					        html += '    <div class="row">';
					        html += '         <img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/null.png" class="col-xs-6 col-xs-offset-3" />';
					        html += '         <p class="col-xs-12 text-center">还没有活动内容</p>';
					        html += '    </div>';
					        html += '</div>';
					        $('.type_content').append(html);
                		}else{
                			$('.type_content .overflow').append('<div id="noMore" style="text-align: center;">已加载到底部</div>');
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
			 	baby_video.loadPage();
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
		//设置头部栏目的宽度
		titleWidth:function(){
            len = $('.title_ul>li').length;
            var oUl_w = 0;
            for(var i=0;i<len;i++){
            	$('.title_ul>li:eq('+ i +')').width();
            	oUl_w +=$('.title_ul>li:eq('+ i +')').width();
            }
           $('.title_ul').css('width',oUl_w + len*20);
           $(document).on('click','.title_ul>li',function(){
           	       $(this).addClass('active');
           	       $(this).siblings('li').removeClass('active');
           	       page = 1;
           	       flag = false;
           	       $('.type_content').html('');
           	       baby_video.loadPage();
           })
		},
		event:function(){
			this.loadPage();
			this.Scroll();
			this.click();
			this.titleWidth();
		}
	};
    baby_video.event();

})