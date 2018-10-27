$(function(){
	var page = 1;
	var flag = false;
	var order = {
		//ajax加载数据
		loadPage:function(){
			console.log(page);
			console.log(flag);
	 		if(flag){
	 			return false;
	 		}
	 		var H = $(document.body).height() - ($('.nav').height() + $('.reg_top').height());
            var objH = parseInt(H/103);
			$.ajax({  
                url:SITEURL+"/index.php?act=order&op=listPage&curpage="+page,  //请求路径，接口地址
                type:"post",  //请求的方式
                //            async:false,//同步  
                data:{orderStatus:3,pageSize:objH},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                	var html = '';
                	if(data.code == '200'){
                		if(page == 1)
                			html += '<div class="content container-fluid">';
                		for(var i=0; i<data.list.length; i++){
				        	html += '<div class="order_pro overflow" href_url="'+data.list[i].url+'">';
				        	html += ' 	<div class="col-xs-12 overflow">';
				        	html += ' 		<div class="orpro_img col-xs-4 overflow">';
				        	html += ' 			<img src="'+data.list[i].activity_index_pic+'!product-360" class="col-xs-12" />';
				        	html += ' 		</div>';
				        	html += ' 		<div class="col-xs-5 order_pro_txt">';
				        	html += ' 			<p class="pro_title">'+data.list[i].activity_title+'</p>';
				        	html += '           <div class="po_bottom">';
				        	html += ' 				<p class="pro_class">亲子活动 | 成长</p>';
				        	html += ' 				<p class="pro_Time">'+data.list[i].activity_time+'</p>';
				        	html += '           </div>';
				        	html += ' 		</div>';
				        	html += ' 		<div class="col-xs-3 price_sum">';
				        	html += ' 			<p class="price text-center">&yen;'+data.list[i].order_amount+'</p>';
				        	html += ' 			<div class="text-center">';
				        	html += ' 				<span class="sum">数量：'+data.list[i].order_num+'</span>';
				        	html += ' 			</div>';
				        	html += ' 			<button class="pay">已结束</button>';
				        	html += ' 		</div>';
				        	html += ' 	</div>';
				        	html += '</div>';
                		}
                		if(page == 1){
                			html += '</div>';
                			$('.order_completed').append(html);
                		}else{
                			$('.content').append(html);
                		}
                	}else{
                		if(page == 1){
                			html += '<div class="no_data container-fluid">';
					        html += '    <div class="row">';
					        html += '         <img style="pointer-events:none" src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/null.png" class="col-xs-6 col-xs-offset-3" />';
					        html += '         <p class="col-xs-12 text-center">还没有订单内容</p>';
					        html += '    </div>';
					        html += '</div>';
					        $('.order_completed').append(html);
                		}else{
                			$('.content').append('<div id="noMore" style="text-align: center;">已加载到底部</div>');
                		}
                		$('.content').append(html);
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

			 	console.log('loadPage');
			 	order.loadPage();
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
        //导航点击跳转
        click_nav:function(){
            $('.nav>div').click(function(){
                Href($(this).attr('href_url'));
            })
        },
        //页面跳转
        Jump:function(obj){
        	$('.order_completed').on('click',obj,function(){
        		//console.log($(this).attr('href_url'))
        		Href($(this).attr('href_url'));
        		return false;
        	})
        },
		event:function(){
			this.loadPage();
			this.Scroll();
			this.click_nav();
			this.Jump('.order_pro');
		}
	};
	order.event();
})