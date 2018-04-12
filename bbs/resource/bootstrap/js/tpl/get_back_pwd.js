$(function(){
	var getBackPwd = {
		Obj:{
			Time:null,//赋值定时器
			Countdown:60,//倒计时时间
            code_state:'1234'//后台请求回来的验证码
		},
		//定时器函数
		time:function(){
			var self = this;
			$('.code_btn').prop('disabled',true);
			$('.code_btn').css('background','#CCC');
	        self.Obj.Time = setInterval(function(){
	         	if(self.Obj.Countdown == 0){
	         		clearInterval(self.Obj.Time);
	         		$('#Time').html('');
	         		self.Obj.Countdown = 60;
	         		$('.code_btn').css('background','#e25428');
		         	$('.code_btn').prop('disabled',false);
	         	}else{
	         		self.Obj.Countdown -= 1; 
	         	    $('#Time').html(self.Obj.Countdown + 's');
	         	}
	          },1000);
		},
		//获取验证码请求
		login_sms:function(){
			var self = this;
			$('.code_btn').click(function(){
				 var phone = $('.phone>input').val();
		         var phone_reg = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;
		         var url = $(this).attr('href_url');
		         if(phone == ''){
		             $('.point_txt').html('请输入手机号码');
		             $('.modal').modal('show');
		         }else if(!phone_reg.test(phone)){
		         	$('.point_txt').html('手机格式不正确');
		            $('.modal').modal('show');
		         }else{
		         	//self.time();
		         	//向后台发送请求
		         	 $.ajax({  
		                url:url,  //请求路径，接口地址
		                type:"post",  //请求的方式
		                async:false,//同步  
		                data:{phone:phone,action:"findpw"},//传出的数据  
		                dataType:"json",//返回的数据类型，常用：html/text/json  
		                success:function(data){  //请求成功后的回调函数
		                    //console.log(typeof data);
		                    $('.point_txt').html(data.msg);
		             		$('.modal').modal('show');
		                    if(data.code == '200'){
		                    	//self.Obj.code_state = data.messageCode;//后台请求回来的验证码
		                    	self.time();//倒计时函数
		                    }
		                }  
		            })  
		         }
			})
		},
		//修改密码按钮请求
		login:function(){
        	var self = this;
        	$('.reg_btn').click(function(){
			 var phone = $('.phone>input').val();
			 var pwd = $('.pwd>input').val();
			 var again_pwd = $('.again_pwd>input').val();
	         var code = $('.code>input').val();
	         var phone_reg = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;
	         var pwd_reg = /^[0-9a-zA-Z]{0,25}$/;
	         var url = $(this).attr('href_url');
	         //console.log(pwd,again_pwd);
	         if(pwd == ''){
	             $('.point_txt').html('请设置密码');
	             $('.modal').modal('show');
	         }else if(!pwd_reg.test(pwd)){
	         	$('.point_txt').html('密码由数字和英文字母，并长度在6到18个字符');
	            $('.modal').modal('show');
	         }else if(pwd.length <6 || pwd.length > 18){
	         	$('.point_txt').html('密码由数字和英文字母，并长度在6到18个字符');
	            $('.modal').modal('show');
	         }else if(again_pwd == ''){
	         	$('.point_txt').html('请再输入密码');
	            $('.modal').modal('show');
	         }else if(pwd != again_pwd){
	         	$('.point_txt').html('两次密码不相同');
	            $('.modal').modal('show');
	         }else if(phone == ''){
	         	$('.point_txt').html('请输入手机号码');
	            $('.modal').modal('show');
	         }else if(!phone_reg.test(phone)){
	         	$('.point_txt').html('手机格式不正确');
	            $('.modal').modal('show');
	         }else if(code == ''){
	         	$('.point_txt').html('验证码不能为空');
	            $('.modal').modal('show');
	         }else{
	         	//向后台发送请求
	         	 $.ajax({  
	                url:url,  //请求路径，接口地址
	                type:"post",  //请求的方式
	                async:false,//同步  
	                data:{phone:phone,password:pwd,code:code},//传出的数据  
	                dataType:"json",//返回的数据类型，常用：html/text/json  
	                success:function(data){  //请求成功后的回调函数
	                	$('.point_txt').html(data.msg);
	            		$('.modal').modal('show');
	                	if(data.code == '200')
	                    	HrefDelay(data.url);//页面跳转
	                }  
	            })
	         }
		})
        },
		event:function(){
           this.login_sms();
           this.login();
		}
	}
	getBackPwd.event();
})