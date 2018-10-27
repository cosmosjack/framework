$(function(){
    var login = {
        //跳转链接
        ClickUrl:function(){
            $('.url').click(function(){
                Href($(this).attr('href_url'));
                return false;
            })
        },
        //登录按钮
        LoginBtn:function(){
            $('#login_btn').click(function(){
                 var phone = $('.phone>input').val();
                 var pwd = $('.pwd>input').val();
                 var phone_reg = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;
                 var url = $(this).attr('href_url');
                 if(phone == ''){
                     $('.point_txt').html('请输入手机号码');
                     $('.modal').modal('show');
                 }else if(!phone_reg.test(phone)){
                    $('.point_txt').html('手机格式不正确');
                    $('.modal').modal('show');
                 }else if(pwd == ''){
                    $('.point_txt').html('请输入密码');
                    $('.modal').modal('show');
                 }else{
                     $.ajax({  
                        url:url,  //请求路径，接口地址
                        type:"post",  //请求的方式
                        //async:false,//同步  
                        data:{"phone":phone,"password":pwd,"login":"login"},//传出的数据  
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
        },
        //所有函数调用
        Event:function(){
            this.ClickUrl();
            this.LoginBtn();
        }
    };
    login.Event();
})