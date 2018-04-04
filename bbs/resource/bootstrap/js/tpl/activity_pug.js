$(function(){
	var activity_pug = {
        
        //跳转页面
		Url_click:function(){
			$(document).on('click','.pug_content>div',function(){
                  console.log($(this).attr('href_url'));
				Href($(this).attr('href_url'));
			})
		},
		event:function(){
            this.Url_click();
		}
	};
	activity_pug.event();
})