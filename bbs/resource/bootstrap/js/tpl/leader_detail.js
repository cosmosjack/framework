$(function(){
	var leader_detail = {

		//向后台发送请求,获取姓名，性别，手机，等级等等
		API:function(){
			var user = {
				u_img: $('.u_img'),//用户头像
				u_name: $('.u_name').html(),//用户姓名
				u_gen: $('.u_gen'),//用户性别
				u_gra: $('.u_gra'),//用户等级
				phone: $('.phone')//用户手机号码
			}
         	 /*$.ajax({  
                url:"",  //请求路径，接口地址
                type:"post",  //请求的方式
                //            async:false,//同步  
                data:{"phone":phone},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                    console.log(typeof data);
                }  
            })  */
		},
		//返回上一级
		// UpperLevel:function(){
		// 	$('.leader_detail').on('click','.oprev',function(){
		// 		history.back(-1);
		// 	})
		// },
		event:function(){
            this.API();
            // this.UpperLevel();//返回上一级
		}
	};
	leader_detail.event();
})