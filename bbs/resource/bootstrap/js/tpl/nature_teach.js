$(function(){
    var page = 1;
    var flag = false;
    var submitflag = false;
	var nature_teach = {
        //分页加载数据
        loadPage:function(){
            if(flag)
                return false;
            var cls_id = $('#cls_id').val();
            var H = $(document.body).height() - ($('.nav').height() + $('.reg_top').height());
            var objH = parseInt(H/90);
            $.ajax({  
                url:SITEURL+"/index.php?act=activity&op=listPageOld&curpage="+page,  //请求路径，接口地址
                type:"POST",  //请求的方式
                async:false,//同步  
                data:{cls_id:cls_id,pageSize:objH,time:1},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                    //console.log(data);
                    var html = '';
                    if(data.code == '200'){
                        for(var i=0; i<data.list.length; i++){
                            html += '<div class="row a_pro" Href_url="'+data.list[i].url2+'">';
                            html += '   <img src="'+data.list[i].activity_index_pic+'!product-240" class="col-xs-3" />';
                            html += '   <div class="col-xs-6 overflow">';
                            html += '       <p class="a_tit">'+data.list[i].activity_title+'</p>';
                            html += '       <p class="a_time">'+data.list[i].activity_time+'</p>';
                            html += '       <p>已报名：<span class="a_join">'+data.list[i].already_num+'</span> / '+data.list[i].total_number+'人</p>';
                            html += '   </div>';
                            html += '   <div class="col-xs-3 a_status text-center">';
                            html += '        <p>状态</p>';
                            html += '        <p class="status">'+data.list[i].footer+'</p>';
                            html += '   </div>';
                            html += '</div>';
                        }
                        $('.a_content').append(html);
                    }else{
                        if(page == 1){
                            html += '<div class="no_data container-fluid">';
                            html += '    <div class="row">';
                            html += '         <img style="pointer-events:none" src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/null.png" class="col-xs-6 col-xs-offset-3" />';
                            html += '         <p class="col-xs-12 text-center">还没有活动内容</p>';
                            html += '    </div>';
                            html += '</div>';
                            $('.a_content').append(html);
                        }else{
                            $('.a_content').append('<div id="noMore" style="text-align: center;">已加载到底部</div>');
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
                    //console.log(page);
                    nature_teach.loadPage();
                }
            });
        },
        //切换推荐活动、往期活动
        Cutover:function(){
        	$('.nature_teach').on('click','.nav_index>div>span',function(){
        		$(this).addClass('active');
                $(this).parent('div').siblings('div').find('span').removeClass('active');
        		if($(this).parent('div').index() == 0){
                    $('.past_pro').css('display','none');
                    $('.na_pro').css('display','block');
        		}else{
        			$('.past_pro').css('display','block');
                    $('.na_pro').css('display','none');
        		}
        	})
        },
        //页面跳转
        Url_click:function(o){
            $('.nature_teach').on('click',o,function(){
                //console.log($(this).index());
                Href($(this).attr('href_url'));
            })
        },
        //收藏功能
        Collect:function(o){
            var html = $('<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"><div class="modal-dialog modal-sm row" role="document"><div class="modal-content col-xs-10 point col-xs-offset-1"><h4 class="col-xs-12 text-center">已收藏</h4><button class="col-xs-12 aHide">确定</button></div></div></div>');
            $('.nature_teach').append(html);
            $('.nature_teach').on('click',o,function(){
                //防止重复提交
                if(submitflag)
                  return false;
                var url = $(this).attr('href_url');
                var obj = $(this);
                submitflag = true;
                //向后台发送请求
                  $.ajax({  
                        url:url,  //请求路径，接口地址
                        type:"post",  //请求的方式
                        async:false,//同步  
                        data:{},//传出的数据  
                        dataType:"json",//返回的数据类型，常用：html/text/json  
                        success:function(data){  //请求成功后的回调函数
                            submitflag = false;
                            $('.point>h4').html(data.msg);
                            $('.modal').modal('show');
                            if(data.code == '200'){
                              if(data.flag == 1){
                                //添加收藏
                                obj.attr('src',BBS_RESOURCE_SITE_URL + '/bootstrap/img/collect_s_red.png');
                              }else if(data.flag == 2){
                                //取消收藏
                                obj.attr('src',BBS_RESOURCE_SITE_URL + '/bootstrap/img/collect_n.png');
                              }else{
                                //没有登录
                                HrefDelay(data.url);
                              }
                            }
                        }  
                    })
                return false;
            })
        }, 
		event:function(){
            this.Cutover();
            this.Url_click('.a_pro');
            // this.Url_click('.pastpro_btn');
            //this.Url_click('.pro_btn');
            this.Collect('.collect');
            this.Collect('.num_periods>img');
            this.loadPage();
		}
	};
	nature_teach.event();
})