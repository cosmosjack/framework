$(function(){
	var set = {
		//跳转页面函数
		load:function(){
			$('.content>.content_child').click(function(){
				Href($(this).attr('href_url'));
			})
		},
		//退出按钮
		out_btn:function(){
			$('.out_btn').click(function(){
				var url = $('#signOut').val();
				// console.log(url);
				$('.Hide_url').attr('href_url',url);
				$('#point_txt').html('是否退出登录');
				$('.modal').modal('show');
			})
		},
		//确定按钮
		Hide_url:function(){
			$('.Hide_url').click(function(){
		     	var url = $(this).attr('href_url');
				Href(url);
		     })
		},
		//取消按钮
		Hide_u:function(){
			$('.aHide').click(function(){
		     	$('.modal').modal('hide');
		     })
		},
		//微信绑定
		WxBinding:function(){
			$('#wx_binding').click(function(){
				var url = $('#wx_bind').val();
				console.log(url);
				$('.Hide_url').attr('href_url',url);
				// console.log(10);
				$('#point_txt').html('是否绑定微信');
				$('.modal').modal('show');
			})
		},
		//所有函数的调用
		event:function(){
			this.load();
			this.out_btn();
			this.Hide_url();
			this.Hide_u();
			this.WxBinding();
		}
	};
	set.event();
})