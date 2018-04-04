$(function(){
	//页面滚动监听
	$(document).ready(function(){
	$(window).scroll(function(){
	    if($(window).scrollTop()>50){
	        $('.home_top').css('background','#e25428');
	        $('.inp>input').css({'background':'#FFF','color':'#e25428'});
	        $('.inp').css('color','#e25428');
	        $('.inp>span').css('color','#e25428');
	    }
	    if($(window).scrollTop() < 50){
	    	$('.home_top').css({'background':'url("'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/shadow.png") no-repeat 0 0','background-size':' 100% 100%'});
	    	$('.inp>input').css({'background':'none','color':'#FFF'});
            $('.inp>span').css('color','#FFF');
	    }
	   });
	})
	var page = 1;
	var flag = false;
	loadList();
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
		 	console.log(page);
		 	loadList();
		}
	});
	function loadList(){
		if(flag)
			return false;
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
                		html += '<div class="index_pro">';
        	 			html += '	<div class="row index_pro_Img" href_url="'+data.list[i].url1+'">';
        	 			html += '		<img src="'+data.list[i].activity_index_pic+'" class="col-xs-10 col-xs-offset-1 pro_img" />'+data.list[i].top;
			        	html += '		<div class="col-xs-10 col-xs-offset-1 mask">';
			        	html += '			<span class="pull-left">'+data.list[i].address+'</span>';
			        	html += '			<span class="pull-left text-right">'+data.list[i].activity_tag+'</span>';
			        	html += '		</div>';
			        	html += '	</div>';
			        	html += '	<div class="row pro_tit">';
			        	html += '		<div class="col-xs-10 col-xs-offset-1">';
			        	html += '			<span class="pull-left">';
			        	html += '				<span class="city">【惠州】</span>'+data.list[i].activity_title+'';
			        	html += 	'			</span>';
			        	html += '			<span class="people pull-right text-right">已参与';
			        	html += '				<span class="past">'+data.list[i].already_num+'</span>/<span class="sum">'+data.list[i].total_number+'</span>';
			        	html += '			</span>';
			        	html += '		</div>';
			        	html += '	</div>';
			        	html += '	<div class="row time_price">';
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
            		$('.content').append(html);
            	}else{
            		if(page == 1){
            			html += '<div class="no_data container-fluid">';
				        html += '    <div class="row">';
				        html += '         <img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/null.png" class="col-xs-6 col-xs-offset-3" />';
				        html += '         <p class="col-xs-12 text-center">还没有活动内容</p>';
				        html += '    </div>';
				        html += '</div>';
				        $('.home').append(html);
            		}else{
            			$('.content').append('<div id="noMore" style="text-align: center;">已加载到底部</div>');
            		}
            		
            		flag = true;
            	}
            	page++;
            }  
        })
	}
	//轮播图
	var mySwiper = new Swiper ('.swiper-container', {
			    direction: 'horizontal',
			    loop: true,//是否自动切换
			    autoplay:5000,//每隔5秒自动切换
			    // 如果需要分页器
			    pagination: '.swiper-pagination',
			    autoplayDisableOnInteraction : false,//手滑都过后依然可以自动切换
			  });
	//顶部搜索框
	$('.glyphicon-search').click(function(){
		var keyword = $(this).prev().val();
		var url = SITEURL+'/index.php?act=activity&op=index&keyword='+encodeURI(keyword); 
		console.log(url);
	});     
	//页面跳转
	$(document).on('click','.nav>div',function(){
		//console.log($(this).attr('href_url'))
		window.location.href= $(this).attr('href_url');
	})  
	//跳转详情页
	$(document).on('click','.index_pro_Img',function(){
    	Href($(this).attr('href_url'));
    })
    //跳转订票页
    $(document).on('click','.pro_btn',function(){
    	Href($(this).attr('href_url'));
    })
})