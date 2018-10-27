$(function(){

    var first = true;//判断是否提交过数据
    var j=0;//照片个数
    var formData = new FormData();
	var upload_img = {
        up_name:$('#title').val(),//被选中的活动名称
        up_no:$('#no').val(),//被选中的活动id
        up_periods:$('#periods').val(),
        up_group:'',
        flag:false,
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
                    console.log(1)
	        	}else if(self.up_group == ''){
                    var val = $('<h4 class="col-xs-12 text-center">提示</h4><span class="col-xs-12 text-center">请选择队伍</span>')
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
	        		
                    //防止重复提交
                    if($('#token').val() != 1)
                        return false;
                    $('#token').val(0);
                    var html = $('<h4 class="col-xs-12 text-center">提示</h4><h5 class="text-center point_txt"></h5>');
                    $('.point').html(html);
                    //添加转圈效果
                    var HTML = $('<div id="MC" style="position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5)"><div id="shclDefault" style="width:100px;height:100px;margin:calc(50% - 50px) auto;"></div></div>')
                    $('body').append(HTML);
                    $('#shclDefault').shCircleLoader();
                    //post方式 
                    var xhr = new XMLHttpRequest();//第一步    
                    xhr.open('POST', SITEURL+"/index.php?act=mine&op=uploads"); //第二步骤   
                    
                    //发送请求  
                    if(first){
                        formData.append('activity_no',self.up_no);
                        formData.append('activity_periods',self.up_periods);
                        formData.append('group_id',self.up_group);
                    } 
                    //console.log(self.up_id);return false;
                    xhr.send(formData);  //第三步骤    
                    //ajax返回
                    xhr.onreadystatechange = function(){ //第四步    
                　　　　if ( xhr.readyState == 4 && xhr.status == 200 ) {    
                　　　　　　//console.log( xhr.responseText ); 
                            //重置form,避免重复上传  
                            formData = new FormData(); 
                            $('#MC').remove();
                            first = false;
                            var data = JSON.parse(xhr.responseText);
                            //console.log(data);
                            $('.point_txt').html(data.msg);
                            $('.modal').modal('show');
                            $('#token').val(1);
                            if(data.code == '200')
                                HrefDelay(SITEURL+"/index.php?act=mine&op=photoLeader&activity_no="+self.up_no+"&activity_periods="+self.up_periods);
                　　　　}    
                　　};    
                    //设置超时时间    
                    xhr.timeout = 100000;    
                    xhr.ontimeout = function(event){ 
                        $('#token').val(1);   
                        //重置form,避免重复上传  
                        formData = new FormData();
                        $('.point_txt').html('请求超时');
                        $('.modal').modal('show');
                　　}   
        	   }
        	})
        },
        //出现队伍弹框
        ClickBullet:function(){
            $('#up_select').click(function(){
                $('.Bullet').fadeIn(300);
            })
        },
        //关闭队伍弹框
        HideBullet:function(o){
            $(o).click(function(){
                $('.Bullet').fadeOut(300);
            })
        },
        //确定选择队伍按钮
        Define:function(){
            $('#Bullet_btn_b').click(function(){
                $('.Bullet').fadeOut(300);//关闭选择队伍弹框
            })
        },
        //选择队伍
        TeamClick:function(){
            var self = this;
            $('.Bullet').on('click','.Bullet_ul>li',function(){
                $('.ul_child').removeClass('ul_active');
                $(this).find('.ul_child').addClass('ul_active');
                self.up_group = $(this).attr('data-id');
                return false;
            })
        },
        event:function(){
            this.UpImg();
            this.UpBtn();
            this.ClickBullet();
            this.TeamClick();
            this.HideBullet('.Bullet');
            this.HideBullet('.Bullet_btn_a');
            this.Define();
        }
	};
	upload_img.event();
})