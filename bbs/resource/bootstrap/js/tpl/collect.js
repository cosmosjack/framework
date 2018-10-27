$(function(){
	var page = 1;
	var flag = false;
	var collect = {
		//分页加载数据
		loadList:function(){
			if(flag)
				return false;
		    $.ajax({  
	            url:SITEURL+"/index.php?act=mine&op=collect&curpage="+page,  //请求路径，接口地址
	            type:"get",  //请求的方式
	            async:false,//同步  
	            data:{},//传出的数据  
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
					        html += '         <p class="col-xs-12 text-center">还没有收藏</p>';
					        html += '    </div>';
					        html += '</div>';
					        $('.collect').append(html);
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
				 	collect.loadList();
				}
			});
		},
		//跳转页面live_deta
		Url_click:function(o){
              	$(document).on('click',o,function(){
              	   	Href($(this).attr('href_url'));
              	})
		},
		event:function(){
			this.loadList();
			this.Scroll();
			this.Url_click('.pro_btn');
			this.Url_click('.index_pro_Img');
		}
	}
	collect.event();
})