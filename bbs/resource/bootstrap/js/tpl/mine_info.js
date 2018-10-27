$(function(){    
    var mine_info = {
        //跳转页面
        Url_click:function(o){
            $(o).click(function(){
                Href($(this).attr('href_url'));
            })
        },
        event:function(){
            this.Url_click('#alter');
            this.Url_click('#management');
        }
    };
    mine_info.event();
})