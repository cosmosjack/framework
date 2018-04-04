$(function(){
	var member = {
       
       //设置ul的width值
        ul_w:function(){
        	len = $('.title_ul>li').length;
            var oUl_w = 0;
            var pdg = $('.title_ul>li').innerWidth() - $('.title_ul>li').width();
           $('.title_ul').css('width',$('.title_ul>li').width() * len + len * (pdg + 1));
           $(document).on('click','.title_ul>li',function(){
           	       $(this).addClass('active');
           	       $(this).siblings('li').removeClass('active');
           })
        },
        //查看助教信息
        teacher_data:function(obj){
        	$(document).on('click',obj,function(){
        		console.log('此处是跳转到个人信息页面')
                 //Href()路径暂时未定
                 return false;
        	})
        },
		event:function(){
           this.ul_w();
           this.teacher_data('.teacher>img');
           this.teacher_data('.user_img');
		}
	};
	member.event();
})