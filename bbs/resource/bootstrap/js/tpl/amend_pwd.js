$(function(){
	var amend = {
		Obj:{
			Time:null,//赋值定时器
			Countdown:60,//倒计时时间
            code_state:'1234'//后台请求回来的验证码
		},
		//定时器函数
		time:function(){
			var self = this;
			$('.amend_code>button').prop('disabled',true);
			$('.amend_code>button').css({'background':'#EEE','color':'#FFF','border-color':'#EEE'});
	        self.Obj.Time = setInterval(function(){
	         	if(self.Obj.Countdown == 0){
	         		clearInterval(self.Obj.Time);
	         		$('#Time').html('');
	         		self.Obj.Countdown = 60;
		         	$('.amend_code>button').prop('disabled',false);
		         	$('.amend_code>button').css({'background':'none','color':'#f48c12','border-color':'#f48c12'});
	         	}else{
	         		self.Obj.Countdown -= 1; 
	         	    $('#Time').html(self.Obj.Countdown + 's');
	         	}
	          },1000);
		},
		//获取验证码请求
		login_sms:function(){
			var self = this;
			$('.amend_code>button').click(function(){
					var url = $(this).attr('href_url');
					var phone = $(this).attr('data-id');
		         	//self.time();
		         	//向后台发送请求
		         	 $.ajax({  
		                url:url,  //请求路径，接口地址
		                type:"post",  //请求的方式
		                //            async:false,//同步  
		                data:{phone:phone},//传出的数据  
		                dataType:"json",//返回的数据类型，常用：html/text/json  
		                success:function(data){  //请求成功后的回调函数
		                    //console.log(typeof data);
		                    //self.Obj.code_state = data.code;//后台请求回来的验证码
		                    $('.point_txt').html(data.msg);
             				$('.modal').modal('show');
		                    if(data.code == '200')
		                    	self.time();//倒计时函数
		                }  
		            })  
		      return false;
			})
		},
		//完成按钮
		amend_click:function(){
			var self = this;
			$('.amend_btn').click(function(){
				var pwd = $('.pwd').val();
				var pwd_n = $('.pwd_n').val();
				var code = $('.code').val();
				var pwd_reg = /^[0-9a-zA-Z]{0,25}$/;
				var url = $(this).attr('href_url');
				if(pwd == ''){
					$('.point_txt').html('请设置新密码');
             		$('.modal').modal('show');
				}else if(!pwd_reg.test(pwd) || pwd.length <6 || pwd.length > 18){
                    $('.point_txt').html('密码由数字和英文字母，并长度在6到18个字符');
             		$('.modal').modal('show');
				}else if(pwd_n == ''){
                    $('.point_txt').html('请再次输入密码');
             		$('.modal').modal('show');
				}else if(pwd_n != pwd){
                    $('.point_txt').html('两次密码不一致');
             		$('.modal').modal('show');
				}else if(code == ''){
					$('.point_txt').html('请输入验证码');
             		$('.modal').modal('show');
				}else{
					//向后台发送请求
		         	 $.ajax({  
		                url:url,  //请求路径，接口地址
		                type:"post",  //请求的方式
		                async:false,//同步  
		                data:{password:pwd,code,code},//传出的数据  
		                dataType:"json",//返回的数据类型，常用：html/text/json  
		                success:function(data){  //请求成功后的回调函数
		                    $('.point_txt').html(data.msg);
             				$('.modal').modal('show');
             				if(data.code == '200')
             					Href(data.url)//跳转到home页面或者到设置中心
		                }  
		            })  
					
				}
			})
		},
		//函数调用
		event:function(){
          this.login_sms();
          this.amend_click();
		}
	};
	amend.event();
})