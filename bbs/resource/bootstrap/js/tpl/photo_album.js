$(function(){
    var  page = 1;
    var  flag = false;
	var  photo_album = {
         
        //放发后展现哪张图片
        ph_index:1,
        //请求回来的图片个数
        ImgNum:0,
        //分页加载
        
        //关闭蒙层
        MaskShow:function(){
        	$('.ph_out').click(function(){
        		$('.ph_mask').fadeOut(500);
        		return false;
        	})
        },
        //返回上一级
        Return:function(){
            $('.ph_oprev').click(function(){
                Href($(this).attr('href_url'));
            })
        },
        //显示蒙层
        MaskHide:function(){
        	var self = this;
        	$('.photo_album').on('click','.ph_content>img',function(){
                console.log('1');
                self.ph_index = $(this).index();
        		$('.ph_mask').fadeIn(500);
        		for(var i=0;i<$('.ph_content>img').length;i++){
        			var Src = $('.ph_content>img:eq('+ i +')').attr('data-id');
        			var html = $('<div class="swiper-slide"><img src="'+ Src +'" /></div>');
        			$('.ph_img').append(html);
        		}
                self.BannerPh();
        	})
        },
        //轮播图
        BannerPh:function(){
        	//轮播图
        	var self = this;
			var mySwiper = new Swiper ('.swiper-container', {
					    direction: 'horizontal',
					    initialSlide:self.ph_index,
					    observer:true,//启动动态检查器
					    observeParents:true,//启动动态检查器
                        //当展示图片滑动到最后一张时触发函数
                        onReachEnd: function(swiper){
                            if(flag)
                                return false;
                            var activity_no = $('#no').val();
                            var activity_periods = $('#periods').val();
                            $.ajax({  
                                url:SITEURL+"/index.php?act=mine&op=photo&curpage="+page,  //请求路径，接口地址
                                type:"post",  //请求的方式
                                async:false,//同步  
                                data:{activity_no:activity_no,activity_periods:activity_periods},//传出的数据  
                                dataType:"json",//返回的数据类型，常用：html/text/json  
                                success:function(data){  //请求成功后的回调函数
                                    var html = '';
                                    if(data.code == '200'){
                                        if(page == 1)
                                            html += '<div class="ph_content overflow">';
                                        for(var i=0; i<data.list.length; i++) {
                                            html += '<img data-id="'+data.list[i].file_name+'!product-360" src="'+data.list[i].file_name+'!product-360" class="ph_content_img" />';
                                            var ImgNum = $('<div class="swiper-slide"><img src="'+ data.list[i].file_name +'!product-360" /></div>');
                                            if(i == data.list.length-1){
                                                console.log(data.list[i].file_name)
                                            }
                                            $('.ph_img').append(ImgNum);
                                        }
                                        if(page == 1){
                                            html += '</div>';
                                            $('.photo_album').append(html);
                                        }else{
                                            $('.ph_content').append(html);
                                        }
                                    }else{
                                        if(page == 1){
                                            html += '<div class="no_data container-fluid">';
                                            html += '    <div class="row">';
                                            html += '         <img style="pointer-events:none" src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/null.png" class="col-xs-6 col-xs-offset-3" />';
                                            html += '         <p class="col-xs-12 text-center">还没有上传图片</p>';
                                            html += '    </div>';
                                            html += '</div>';
                                            $('.photo_album').append(html);
                                        }else{
                                            $('.photo_album').append('<div id="noMore" style="text-align: center;">已加载到底部</div>');
                                        }
                                        flag = true;
                                    }
                                    page++;
                                }  
                            })
                        },
					  })        
        },
        //加载图片
        loadList:function(){
            var self = this;
            if(flag)
                return false;
            var activity_no = $('#no').val();
            var activity_periods = $('#periods').val();
            $.ajax({  
                url:SITEURL+"/index.php?act=mine&op=photo&curpage="+page,  //请求路径，接口地址
                type:"post",  //请求的方式
                async:false,//同步  
                data:{activity_no:activity_no,activity_periods:activity_periods},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                    var html = '';
                    if(data.code == '200'){
                        if(page == 1)
                            html += '<div class="ph_content overflow">';
                        for(var i=0; i<data.list.length; i++) {
                            html += '<img data-id="'+data.list[i].file_name+'!product-360" src="'+data.list[i].file_name+'!product-240" class="ph_content_img" />';
                        }
                        //console.log(data.list.length);
                        self.ImgNum = data.list.length;
                        if(page == 1){
                            html += '</div>';
                            $('.photo_album').append(html);
                        }else{
                            $('.ph_content').append(html);
                        }
                    }else{
                        if(page == 1){
                            html += '<div class="no_data container-fluid">';
                            html += '    <div class="row">';
                            html += '         <img style="pointer-events:none" src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/null.png" class="col-xs-6 col-xs-offset-3 test"  />';
                            html += '         <p class="col-xs-12 text-center" id="test">还没有上传图片</p>';
                            html += '    </div>';
                            html += '</div>';
                            $('.photo_album').append(html);
                        }else{
                            $('.photo_album').append('<div id="noMore" style="text-align: center;">已加载到底部</div>');
                        }
                        flag = true;
                    }
                    page++;
                }  
            })  
            this.MaskHide();
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

                //console.log(1)
                photo_album.loadList();
             }
            });
        },
        //跳转上传页面
        UpBtn:function(){
            $('#UpBtn').click(function(){
                Href(SITEURL+'/index.php?act=mine&op=uploadImg');
            })
        },  
		event:function(){
            this.loadList();
            this.MaskShow();
            
            this.Scroll();
            //this.UpBtn();
            this.Return();
		}
	};
	photo_album.event();
})