$(function(){

	var code_state = '1234';//判断验证码值
	var onOff = false;//赋值判断协议是否同意
    var time = null;//赋值定时器
    var Countdown = 60;//倒计时时间
	$('#pact').click(function(){
        if(onOff){
            $('#re_radio>span').css('background','none');
        }else{
            $('#re_radio>span').css('background','#e25428');
        }
        onOff = !onOff;
        return false;
	})
	$('.href_url').click(function(){
		Href($(this).attr('href_url'));
		return false;
	})

	function Time(){
        $('.code_btn').prop('disabled',true);
        $('.code_btn').css('background','#CCC');
        time = setInterval(function(){
         	if(Countdown == 0){
         		clearInterval(time);
         		$('#Time').html('');
         		Countdown = 60;
                $('.code_btn').css('background;','#e25428')
                $('.code_btn').prop('disabled',false);
         	}else{
         		Countdown -= 1; 
         	    $('#Time').html(Countdown + 's');
         	}
         	
        },1000);
	}
	//获取验证码按钮
	$('.code_btn').click(function(){
		 var phone = $('.phone>input').val();
         var pwd = $('.pwd>input').val();
         var phone_reg = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;
         var url = $(this).attr('href_url');
         if(phone == ''){
             console.log('请输入手机号码');
             $('.point_txt').html('请输入手机号码');
             $('.modal').modal('show');
         }else if(!phone_reg.test(phone)){
         	console.log('手机格式不正确');
         	$('.point_txt').html('手机格式不正确');
            $('.modal').modal('show');
         }else{
         	
         	//向后台发送请求
         	 $.ajax({  
                url:url,  //请求路径，接口地址
                type:"post",  //请求的方式
                async:false,//同步  
                data:{"phone":phone,"action":"register"},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                    //console.log(typeof data);
                    $('.point_txt').html(data.msg);
                    $('.modal').modal('show');
                    if(data.code == '200'){
                        //code_state = data.messageCode;//后台请求回来的验证码
                        Time();//倒计时函数
                    }
                }  
            })  
         }
	})

	//注册按钮
	$('.reg_btn').click(function(){
		 var phone = $('.phone>input').val();
         var pwd = $('.pwd>input').val();
         var code = $('.code>input').val();
         var phone_reg = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;
         var pwd_reg = /^[0-9a-zA-Z]{0,25}$/;
         var url = $(this).attr('href_url');
         if(phone == ''){
             $('.point_txt').html('请输入手机号码');
             $('.modal').modal('show');
         }else if(!phone_reg.test(phone)){
         	$('.point_txt').html('手机格式不正确');
            $('.modal').modal('show');
         }else if(pwd == ''){
         	$('.point_txt').html('密码不能为空');
            $('.modal').modal('show');
         }else if(!pwd_reg.test(pwd)){
         	$('.point_txt').html('密码由数字和英文字母，并长度在6到18个字符');
            $('.modal').modal('show');
         }else if(pwd.length <6 || pwd.length > 18){
         	$('.point_txt').html('密码由数字和英文字母，并长度在6到18个字符');
            $('.modal').modal('show');
         }else if(code == ''){
         	console.log(code,code_state)
         	$('.point_txt').html('验证码不能为空');
            $('.modal').modal('show');
         }else if(onOff != true){
         	$('.point_txt').html('请同意协议');
            $('.modal').modal('show');
         }else{
         	//向后台发送请求
         	$.ajax({  
                url:url,  //请求路径，接口地址
                type:"post",  //请求的方式
                async:false,//同步  
                data:{"phone":phone,'password':pwd,'code':code},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                    //console.log(typeof data);
                    $('.point_txt').html(data.msg);
                    $('.modal').modal('show');
                    if(data.code == '200')
                        HrefDelay(data.url);
                }  
            })  
         }
	})
})