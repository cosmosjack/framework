$(function(){
	var coupon = {
        
        //进入页面加载数据
        loadPage:function(){
        	var H = $(document.body).height() - ($('.nav').height() + $('.reg_top').height());
            var objH = parseInt(H/103);
            console.log(objH)
            /*$.ajax({  
		                url:"",  //请求路径，接口地址
		                type:"post",  //请求的方式
		                //            async:false,//同步  
		                data:{"phone":phone},//传出的数据  
		                dataType:"json",//返回的数据类型，常用：html/text/json  
		                success:function(data){  //请求成功后的回调函数
		                    console.log(typeof data);

		                }  
		            })  */
        },
        //勾选使用优惠券
        use_click:function(){
        	$('.coupon').on('click','.use_img',function(){

        		if($(this).hasClass('coupon_use')){
        	     	$(this).attr('src',BBS_RESOURCE_SITE_URL+'/bootstrap/img/coupon_n.png');
        			$(this).removeClass('coupon_use');
        		}else{
        
        			$(this).attr('src',BBS_RESOURCE_SITE_URL+'/bootstrap/img/coupon_s.png');
        	     	$(this).addClass('coupon_use');
        			
        		}
        	})
        },
        Scroll:function(){
        	//滑动到底部事件
			$(document).on("scroll", function () {
			 //真实内容的高度
			 var pageHeight = Math.max(document.body.scrollHeight, document.body.offsetHeight);
			 //视窗的高度
			 var viewportHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight || 0;
			 //隐藏的高度
			 var scrollHeight = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
			 //判断加载视频，文章，回答，医生
			 if(pageHeight - viewportHeight - scrollHeight <=0){
			 	console.log(1)
			     /*$.ajax({  
		                url:"",  //请求路径，接口地址
		                type:"post",  //请求的方式
		                //            async:false,//同步  
		                data:{"phone":phone},//传出的数据  
		                dataType:"json",//返回的数据类型，常用：html/text/json  
		                success:function(data){  //请求成功后的回调函数
		                    console.log(typeof data);

		                }  
		            })  */
			 }
			});
        },
        //当有新的优惠券时出现弹框
        Bullet:function(){
        	$('.modal').modal('show');
        	$('.modal').click(function(){
        		$('.modal').modal('hide');
        	})
        },
        //函数的调用
		event:function(){
           this.use_click();
           this.Scroll();
           this.Bullet();
           this.loadPage();
		}
	};
	coupon.event();
})