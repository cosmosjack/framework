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
                url:SITEURL+"/index.php?act=order&op=listPage&pageSize="+objH+"&curpage="+page,  //请求路径，接口地址
                type:"get",  //请求的方式
                //            async:false,//同步  
                data:{},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                	var html = '';
                	if(data.code == '200'){
                		if(page == 1)
                			html += '<div class="content container-fluid">';
                		for(var i=0; i<data.list.length; i++){
                			html += '<div class="order_pro overflow">';
				        	html += ' 	<div class="col-xs-12 overflow">';
				        	html += ' 		<div class="orpro_img col-xs-4 overflow" href_url="../product_deta/product_deta.html">';
				        	html += ' 			<img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/img2.jpg" class="col-xs-12" />';
				        	html += ' 		</div>';
				        	html += ' 		<div class="col-xs-5 order_pro_txt" href_url="../product_deta/product_deta.html">';
				        	html += ' 			<p class="pro_title">宝贝加油！亲子互动宝贝加油！亲子互动宝贝加油！亲子互动</p>';
				        	html += ' 			<p class="pro_class">亲子活动 | 成长</p>';
				        	html += ' 			<p class="pro_Time">3月15日一天</p>';
				        	html += ' 		</div>';
				        	html += ' 		<div class="col-xs-3 price_sum">';
				        	html += ' 			<p class="price text-center">&yen;360</p>';
				        	html += ' 			<div class="text-center">';
				        	html += ' 				<img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/down.png" class="down" />';
				        	html += ' 				<span class="sum">1</span>';
				        	html += ' 				<img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/up.png" class="up">';
				        	html += ' 			</div>';
				        	html += ' 			<button class="pay" href_url="../payment/payment.html">付款</button>';
				        	html += ' 		</div>';
				        	html += ' 	</div>';
				        	html += '</div>';
                		}
                		if(page == 1){
                			html += '</div>';
                			$('.order').append(html);
                		}else{
                			$('.content').append(html);
                		}
                	}else{
                		if(page == 1){
                			html += '<div class="no_data container-fluid">';
					        html += '    <div class="row">';
					        html += '         <img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/null.png" class="col-xs-6 col-xs-offset-3" />';
					        html += '         <p class="col-xs-12 text-center">还没有订单内容</p>';
					        html += '    </div>';
					        html += '</div>';
					        $('.order').append(html);
                		}else{
                			//html += '';
                			$('.content').append('<div id="noMore" style="text-align: center;">已加载到底部</div>');
                		}
                		$('.content').append(html);
                		flag = true;
                	}
                	page++;
                }  
            })  
            console.log(page);
			console.log(flag);
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
        //添加减少票数
        down_up:function(){
        	//减少
        	$(document).on('click','.down',function(){
        		var sum = Number($(this).siblings('span').html());
        		if(sum == 0){
                    $(this).siblings('span').html(0);
        		}else{
        			$(this).siblings('span').html(sum - 1);
        		}
        	})
        	//添加
        	$(document).on('click','.up',function(){
        		var sum = Number($(this).siblings('span').html());
        		if(sum >= 100){
                    $(this).siblings('span').html(100);
        		}else{
        			$(this).siblings('span').html(sum + 1);
        		}
        		
        	})
        },
        //导航点击跳转
        click_nav:function(){
            $('.nav>div').click(function(){
                   Href($(this).attr('href_url'));
            })
        },
        //页面跳转
        Jump:function(obj){
        	$(document).on('click',obj,function(){
        		console.log($(this).attr('href_url'))
        		 //Href($(this).attr('href_url'));
        		 return false;
        	})
        },
		event:function(){
			this.loadPage();
			this.Scroll();
			this.down_up();
			this.click_nav();
			this.Jump('.pay');
			this.Jump('.orpro_img');
			this.Jump('.order_pro_txt');
		}
	};
	//console.log(1)
	order.event();
})