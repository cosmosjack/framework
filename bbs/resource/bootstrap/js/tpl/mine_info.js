$(function(){    
    var mine_info = {
        //跳转页面
        Url_click:function(o){
            $(document).on('click',o,function(){
                //console.log($(this).attr('href_url'));
                Href($(this).attr('href_url'));
            })
        },
        event:function(){
            this.Url_click('.alter');
            this.Url_click('.management');
        }
    };
    mine_info.event();
})