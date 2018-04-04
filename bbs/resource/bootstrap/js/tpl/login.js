$(function(){
	$(document).on('click','.url',function(){
		console.log($(this).attr('href_url'));
		Href($(this).attr('href_url'));
		return false;
	})
	//登录按钮
	$('#login_btn').click(function(){
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
         }else if(pwd == ''){
             console.log('请输入密码');
            $('.point_txt').html('请输入密码');
            $('.modal').modal('show');
         }else{
         	console.log(1)
         	 $.ajax({  
                url:url,  //请求路径，接口地址
                type:"post",  //请求的方式
//            async:false,//同步  
                data:{"phone":phone,"password":pwd,"login":"login"},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                    //console.log(typeof data);
                    $('.point_txt').html(data.msg);
                    $('.modal').modal('show');
                    if(data.code == '200')
                        HrefDelay(data.url);
                    //Href();
                }  
            })  
         }
	})
	$('.Hide').click(function(){
		$('.modal').modal('hide');
	})
})