$(function(){
    var j=0;
    var formData = new FormData();
	var upload_img = {
        
        up_name:$('#up_select').html(),//被选中的活动名称
        up_id:$('#activityId').val(),//被选中的活动id activity
        flag:false,
        //选择相册
        UpSelect:function(){
        	var self = this;
        	//弹框的html
        	var html = $('<h4 class="col-xs-12 text-center">选择活动</h4><ul></ul><button class="btn btn-success col-xs-4 col-xs-offset-1 my_define">确定</button><button class="btn btn-success col-xs-4 col-xs-offset-2 aHide my_cancel">取消</button>');

        	var up_sum = 4; //相册选项
        	//显示选择相册弹框
        	$('#up_select').click(function(){
        		$('.point').children().remove();
        		$('.point').append(html);
        		//此处是生成相册选项
        		// for(var i=0;i<4;i++){
        		// 	var oLi = $('<li><span>我的第'+ i +'个相册</span><span class="my_ra pull-right"><span></span></span></li>');
        		// 	$('.point>ul').append(oLi);
        		// }
                if(!self.flag){
        		  $('.point>ul').html($('#activity').html());
                  self.flag = true;
                }
                console.log($('#activity').val());
        		$('.modal').modal('show');
        	})
        	//勾选相册
        	$(document).on('click','.my_ra',function(){
        		$(this).find('span').css('background','#f19931');
        		self.up_name = $(this).siblings('span').html();
                self.up_id = $(this).attr('data-id');
        		$(this).parent('li').siblings('li').find('span').find('span').css('background','none');
        	})
            //确定按钮
            $(document).on('click','.my_define',function(){
            	if(self.up_name != null){
                	$('.modal').modal('hide');
                	$('#up_select').html(self.up_name);
                }
            })
        },
        
		//上传图片
        UpImg:function(){
            $(document).on('change','.upPushImg',function(){
                
             	var fl=this.files.length;
                //console.log(fl);
		        for(var i=0;i<fl;i++){  
		            var file=this.files[i];  
		            var reader = new FileReader();
                    var rFilter = /^(image\/bmp|image\/gif|image\/jpeg|image\/png|image\/tiff)$/i; //控制格式
                    var iMaxFilesize = 1024*1024*5; //控制大小2M  
                    var html = $('<h4 class="col-xs-12 text-center">提示</h4><h5 class="text-center point_txt"></h5>');
                    $('.point').html(html);
                    if (!rFilter.test(file.type)) {
                        //alert("文件格式必须为图片");
                        $('.point_txt').html('文件格式必须为图片');
                        $('.modal').modal('show');
                        return false;
                    }
                    if (file.size > iMaxFilesize) {
                        // alert("图片大小不能超过2M");
                        $('.point_txt').html('图片大小不能超过5M');
                        $('.modal').modal('show');
                        return false;
                    }
		            //读取文件完成后执行的方法  
		            reader.onload = function (e) { 		            	
		                var imgstr='<li class="up_li"><img src="'+ e.target.result +'" class="upImg" /><div class="my_sch"></div></li>';
		                $('.push_img').find('ul').append(imgstr);
                        
                        // //aa.find('img').attr("src",e.target.result);
                        // var imgstr = '<div class="uppush_btn"><div class="file-box pull-right" ><input type="file" class="file-btn" class="upPushImg" name="photo[]" multiple /><img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/push_img.png"  /></div></div>';
                        // $('#submitForm').append(imgstr);
		            }  
		            reader.readAsDataURL(file); 
                    formData.append('photo['+j+']',file); 
                    j++;
			    }
                
			})
        },
        //上传按钮
        UpBtn:function(){
        	var self = this;
        	$('#Upload').click(function(){
        		if(self.up_name == ''){
        			var val = $('<h4 class="col-xs-12 text-center">提示</h4><span class="col-xs-12 text-center">请选择活动</span>')
	        		$('.point').children().remove();
	        		$('.point').append(val);
	        		$('.modal').modal('show');
	        	}else if($('.push_img>ul>li').length == 0){
	        		var val = $('<h4 class="col-xs-12 text-center">提示</h4><span class="col-xs-12 text-center">请添加图片</span>')
	        		$('.point').children().remove();
	        		$('.point').append(val);
	        		$('.modal').modal('show');
	        	}else{
	        		var ImgSum = $('.up_li').length - 1;
	        		var w = $('.up_li').width();
	        		function fn(){
	        			var time = setInterval(function(){
		        			$('.up_li:eq('+ ImgSum +')>.my_sch').css('width',$('.up_li:eq('+ ImgSum +')>.my_sch').width() + 20);
		        			if($('.up_li:eq('+ ImgSum +')>.my_sch').width() >= w){
		                         clearInterval(time);
		                         if(ImgSum == 0){
		                         	$('.up_li:eq('+ ImgSum +')').removeClass('up_li');
		                         }else if(ImgSum > 0 ){
	                                $('.up_li:eq('+ ImgSum +')').removeClass('up_li');
	                                ImgSum --;
		                         	fn();
		                         }
		                         
		        			}
	        			},500);
	        		}
                    //防止重复提交
                    if($('#token').val() != 1)
                        return false;
                    $('#token').val(0);
	        		fn();
                    //var data_form = new FormData(document.getElementById("submitForm"));
                    //console.log(data_form);return false;
                    var html = $('<h4 class="col-xs-12 text-center">提示</h4><h5 class="text-center point_txt"></h5>');
                    $('.point').html(html);
                    // $.ajax({
                    //     type:"POST", 
                    //     processData:false,
                    //     contentType:false,   
                    //     async: false,  
                    //     url:SITEURL+"/index.php?act=mine&op=uploadImg",  //请求路径，接口地址
                    //     data:formData, 
                    //     success: function(data){
                    //         $('.point_txt').html(data.msg);
                    //         $('.modal').modal('show');
                    //         // if(data.code == '200')
                    //         //     HrefDelay(data.url);
                    //     },
                    //     error:function(e){
                    //         $('.point_txt').html('错误');
                    //         $('.modal').modal('show');
                    //     }
                    // });  
                    //post方式 
                    var xhr = new XMLHttpRequest();//第一步    
                    xhr.open('POST', SITEURL+"/index.php?act=mine&op=uploads"); //第二步骤    
                    //发送请求   
                    formData.append('activityId',self.up_id); 
                    //console.log(self.up_id);return false;
                    xhr.send(formData);  //第三步骤    
                    //ajax返回    
                    xhr.onreadystatechange = function(){ //第四步    
                　　　　if ( xhr.readyState == 4 && xhr.status == 200 ) {    
                　　　　　　//console.log( xhr.responseText ); 
                            //重置form,避免重复上传  
                            //formData = new FormData(); 
                            var id = formData.get('photo');
                            formData = new FormData(); 
                            formData.append('activityId',id);
                            console.log(xhr.responseText);
                            var data = JSON.parse(xhr.responseText);
                            //console.log(data);
                            $('.point_txt').html(data.msg);
                            $('.modal').modal('show');
                            $('#token').val(1);
                            if(data.code == '200')
                                HrefDelay(SITEURL+"/index.php?act=mine&op=photo&id="+self.up_id);
                　　　　}    
                　　};    
                    //设置超时时间    
                    xhr.timeout = 100000;    
                    xhr.ontimeout = function(event){ 
                        $('#token').val(1);   
                　　　　$('.point_txt').html('请求超时');
                        $('.modal').modal('show');
                　　}   
        	   }
        	})
        },
        event:function(){
            this.UpImg();
            this.UpSelect();
            this.UpBtn()
        }
	};
	upload_img.event();
})