$(function(){
	var nature_teach = {
        
        //切换推荐活动、往期活动
        Cutover:function(){
        	$(document).on('click','.nav_index>div>span',function(){
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
            $(document).on('click',o,function(){
                console.log($(this).index());
                   //Href($(this).attr('href_url'));
            })
        },
        //收藏功能
        Collect:function(o){
            $(document).on('click',o,function(){
                if($(this).hasClass('removeClass')){
                   $(this).attr('src',BBS_RESOURCE_SITE_URL+'/bootstrap/img/collect_n.png');
                   $(this).removeClass('removeClass');
                }else{
                   $(this).attr('src',BBS_RESOURCE_SITE_URL+'/bootstrap/img/collect_s_red.png')
                   $(this).addClass('removeClass');
                }
                return false;
            })
        }, 
		event:function(){
          this.Cutover();
          this.Url_click('.na_pro>.index_pro');
          this.Url_click('.pastpro_btn');
          this.Collect('.collect');
          this.Collect('.num_periods>img');
		}
	};
	nature_teach.event();
})