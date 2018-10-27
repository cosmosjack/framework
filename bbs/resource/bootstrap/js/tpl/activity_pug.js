$(function(){
	var activity_pug = {
        
        //跳转页面
		Url_click:function(){
			$('.pug_content').on('click','.pug',function(){
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