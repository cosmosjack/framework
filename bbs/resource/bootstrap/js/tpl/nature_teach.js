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
                   Href($(this).attr('href_url'));
            })
        },
		event:function(){
          this.Cutover();
          this.Url_click('.index_pro');
		}
	};
	nature_teach.event();
})