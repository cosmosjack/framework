$(function(){
    var  page = 1;
    var  flag = false;
	var my_content = {
        

        //设置封面
        MyCover:function(){
        	var imgSrc = $('.my_cover');//封面图片
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
        },
        //进入相册
        MyClick:function(){
           $(document).on('click','.my_content>div',function(){
           	   Href($(this).attr('href_url'));
           })
        },
        //加载相册
        loadList:function(){
            if(flag)
                return false;
            console.log(page);
            $.ajax({  
                url:SITEURL+"/index.php?act=mine&op=album&curpage="+page,  //请求路径，接口地址
                type:"get",  //请求的方式
                async:false,//同步  
                data:{},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                    var html = '';
                    if(data.code == '200'){
                        for(var i=0; i<data.list.length; i++) {
                            //var url = "Href('"+data.list[i].url+"')";
                            // console.log(url);
                            html += '<div class="col-xs-6" href_url="'+data.list[i].url+'">';
                            html += '    <div class="album_txt overflow">';
                            html += '       <img src="'+data.list[i].img+'" class="col-xs-12 my_cover" />';
                            html += '       <div class="overflow">';
                            html += '            <span class="album_name col-xs-9">'+data.list[i].time+'</span>';
                            html += '            <span class="album_num col-xs-3 text-right">'+data.list[i].count+'</span>';
                            html += '       </div>';
                            html += '    </div>';
                            html += '    <p class="col-xs-12 my_txt">'+data.list[i].activity_title+'</p>';
                            html += '</div>';
                        }
                        $('.my_content').append(html);
                    }else{
                        if(page == 1){
                            html += '<div class="no_data container-fluid">';
                            html += '    <div class="row">';
                            html += '         <img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/null.png" class="col-xs-6 col-xs-offset-3" />';
                            html += '         <p class="col-xs-12 text-center">还没有上传图片</p>';
                            html += '    </div>';
                            html += '</div>';
                            $('.my_album').append(html);
                        }else{
                            $('.my_album').append('<div id="noMore" style="text-align: center;">已加载到底部</div>');
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

                //console.log(1)
                my_content.loadList();
             }
            });
        },
		event:function(){
            this.loadList();
            this.Scroll();
		    this.MyCover();
            this.MyClick();
		}
	};
	my_content.event();
})