$(function(){
	var growth_record = {
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
			 	console.log(1)
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
		TitleWidth:function(){
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
           })
		},
		//跳转详情页面
		Jump:function(){
			$(document).on('click','.gr_content>div',function(){
				Href('../grow_detail/grow_detail.html');
			})
		},
		event:function(){
			this.TitleWidth();
			this.Scroll();
			this.Jump();
		}
	};
	growth_record.event();
})