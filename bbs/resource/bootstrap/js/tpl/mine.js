$(function(){
	// var footer = ['../../img/icon0.png','../../img/icon1.png','../../img/icon2.png','../../img/icon3.png'];
	// var footer_active = ['../../img/icon0-1.png','../../img/icon0-2.png','../../img/icon0-3.png','../../img/icon0-4.png'];
 //     $('.footer>div').click(function(){
 //     	for(let i=0;i<footer.length;i++){
 //     		$('.footer>div:eq('+ i +')').find('img').attr('src',footer[i]);
 //     	}
 //     	$(this).find('img').attr('src',footer_active[$(this).index()]);
 //     })
     var mine = {
          //退出按钮
          OutBtn:function(){
               $('.out').click(function(){
                    $('.point_txt').html('是否退出登录');
                    $('.modal').modal('show');
               })
          },
          //关闭弹框
          HideClick:function(){
               $('.Hide_u').click(function(){
                    $('.modal').modal('hide');
               })
          },
          //所有函数调用
          Event:function(){
               this.OutBtn();
               this.HideClick();
          }
     }
     mine.Event();
     //确认退出登录；跳转到登录页面
     // $('.Hide_url').click(function(){
     // 	var url = $(this).attr('href_url');
     // 	Href(url);
     // })
})