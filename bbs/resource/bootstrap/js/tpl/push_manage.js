$(function(){
    var data_form = new FormData();
	var push_student = {
        
        //性别选择
        gender:function(){
        	var gindex = 2;
            $('.u_gender').click(function(){
            	console.log(1)
            	var ged_html = $('<div class="col-xs-12 ged"><button class="btn ln btn-default col-xs-4 col-xs-offset-1">男</button><button class="btn ln btn-default col-xs-4 col-xs-offset-2">女</button><button class="btn btn-primary col-xs-8 col-xs-offset-2 btn_ged">确定</button></div>');
            	//$('.point').children().remove();
            	$('.point').html(ged_html);
        		$('.modal').modal('show');
            });
            $('.push_student').on('click','.ln',function(){
                 gindex = $(this).index();
        	})
            $('.push_student').on('click','.btn_ged',function(){
            	if(gindex <= 1){
                  $('.u_gender').val($('.ged>button:eq('+  gindex +')')[0].innerHTML);
                  $('.u_gender').attr('data-id',gindex+1);
                  console.log($('.ged>button:eq('+  gindex +')')[0].innerHTML)
            	}
                  $('.modal').modal('hide');
        	})
        },

        //关闭提示框
        down_click:function(){
        	$('.push_student').on('click','.down',function(){
        		$('.modal').modal('hide');
        	})
        },

        //完成按钮
        btn_click:function(){
        	var html = $('<h4>提示</h4><h5 class="point_txt"></h5><button class="btn btn-primary down col-xs-10 col-xs-offset-1">确定</button>');
        	$('.btn>button').click(function(){
        		//$('.point').children().remove();
        		$('.point').html(html);
        		var u_name = $('.u_name').val();//姓名
        		// var u_idnum = $('.u_idnum').val();//证件号码
          //       var u_idtype = $('#u_paperwork').val();//证件类型
        		// var u_born = $('.u_born').val();//出生年月
        		// var u_gender = $('.u_gender').val();//性别
                var u_relation = $('.u_relation').val();//关系 
                var u_phone = $('.u_phone').val();//手机号
                var phone_reg = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;
        		// var u_height = $('.u_height').val();//身高
        		// var u_weight = $('.u_weight').val();//体重
        		// var u_clothes = $('.u_clothes').val();//衣服尺码
        		// var u_exhort = $('.u_exhort').val();//特别叮嘱
        		//var Regu_idnum = /^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|[xX])$/;
                var Regu_idnum = /^[0-9A-Za-z]{6,24}$/;//数字或者字母的组合
                var id = $('#flag').val();
                if(u_name == ''){
                    $('.point_txt').html('姓名不能为空');
                    $('.modal').modal('show');
        		}else if(u_relation == ''){
                    $('.point_txt').html('请填写与学员的关系');
                    $('.modal').modal('show');
                }else if(u_phone == ''){
                    $('.point_txt').html('请输入手机号码');
                    $('.modal').modal('show');
                }else if(!phone_reg.test(u_phone)){
                    $('.point_txt').html('手机格式不正确');
                    $('.modal').modal('show');
                }else{
        			// var data_form = new FormData(document.getElementById("submitForm"));
                    data_form.append('id',$('#flag').val()); 
                    data_form.append('u_name',u_name);
                    data_form.append('u_relation',u_relation); 
                    data_form.append('u_phone',u_phone);  
                    //console.log(data_form);return false;
                    $.ajax({
                        type:"POST", 
                        processData:false,
                        contentType:false,     
                        url:SITEURL+"/index.php?act=set&op=addManage",  //请求路径，接口地址
                        data:data_form, 
                        success: function(data){
                            //重置form,避免重复上传  
                            data_form = new FormData();
                            $('.point_txt').html(data.msg);
                            $('.modal').modal('show');
                            if(data.code == '200')
                                HrefOprev();//返回上一级
                        },
                        error:function(e){
                            //重置form,避免重复上传  
                            data_form = new FormData();
                            $('.point_txt').html('错误');
                            $('.modal').modal('show');
                        }
                    });   
        		}
        	})
        },

        //生日选择
        birthday:function(){
        	//生日插件函数实例
			var currYear = (new Date()).getFullYear();	
						var opt={};
						opt.date = {preset : 'date'};
						opt.datetime = {preset : 'datetime'};
						opt.time = {preset : 'time'};
						opt.default = {
							theme: 'android-ics light', //皮肤样式
					        display: 'modal', //显示方式 
					        mode: 'scroller', //日期选择模式
							dateFormat: 'yyyy-mm-dd',
							lang: 'zh',
							showNow: true,
							nowText: "今天",
					        startYear: currYear - 30, //开始年份
					        endYear: currYear + 10 //结束年份
					};

				  	$("#appDate").mobiscroll($.extend(opt['date'], opt['default']));
				  	var optDateTime = $.extend(opt['datetime'], opt['default']);
				  	var optTime = $.extend(opt['time'], opt['default']);
				    $("#appDateTime").mobiscroll(optDateTime).datetime(optDateTime);
				    $("#appTime").mobiscroll(optTime).time(optTime);
			//返回结果
		    $("#birthday").mobiscroll().date({  
		            theme: "android-ics",  
		            lang: "zh",  
		            display: 'bottom',  
		            dateFormat: 'yy-mm-dd', //返回结果格式化为年月格式  
		            // wheels:[], 设置此属性可以只显示年月，此处演示，就用下面的onBeforeShow方法,另外也可以用treelist去实现  
		            //onBeforeShow: function (inst) { inst.settings.wheels[0].length>2?inst.settings.wheels[0].pop():null; }, //弹掉“日”滚轮  
		            headerText: function (valueText) { //自定义弹出框头部格式  
		                array = valueText.split('-');  
		                return array[0] + "年" + array[1] + "月" + array[2] + "日";  
		            }
		        });
		},
		//说明弹框
        explain:function(){
            $('.explain').click(function(){
                var e_html = $('<div class="col-xs-12 explain_txt text-left"><p class="col-xs-12">1.为什么要儿童证件及身高体重信息？</p><span class="col-xs-12">答：一为儿童购买旅游保险；二为儿童选择合适尺码的衣服。</span><p class="col-xs-12">2.为什么要监护人的证件信息？</p><span class="col-xs-12">答：因为要签订电子旅游合同，儿童是未成年人，必须由监护人签订，需要签订人(即监护人)的有效证件号码。</span><button class="aHide">确定<tton></div>');
                //$('.point').children().remove();
                $('.point').html(e_html);
                $('.modal').modal('show');
            })
        },
        //上传图片
        up_img:function(){
           $("#up_img").change(function(){   
             var file = this.files[0];
               if (window.FileReader) {  
                    var rFilter = /^(image\/bmp|image\/gif|image\/jpeg|image\/png|image\/tiff)$/i; //控制格式
                    var iMaxFilesize = 1024*1024*5; //控制大小2M  
                    var html = $('<h4>提示</h4><h5 class="point_txt"></h5><button class="btn btn-primary down col-xs-10 col-xs-offset-1">确定</button>');
                    $('.point').html(html);
                    if (!rFilter.test(file.type)) {
                        //alert("文件格式必须为图片");
                        $('.point_txt').html('文件格式必须为图片');
                        $('.modal').modal('show');
                        return;
                    }
                    if (file.size > iMaxFilesize) {
                        // alert("图片大小不能超过2M");
                        $('.point_txt').html('图片大小不能超过5M');
                        $('.modal').modal('show');
                        return;
                    }
                    var reader = new FileReader();    
                    reader.readAsDataURL(file);    
                    //监听文件读取结束后事件    
                    reader.onloadend = function (e) {
                        // console.log(e.target.result)
                        $('.userImg').find('div').find('img').attr("src",e.target.result);
                    };   
                    data_form.append('photo',file); 
                } 
            });
        },
         //证件选择
        Paperwork:function(){
            $('#u_paperwork').click(function(){
                var arr = ['身份证','港澳居民身份证','护照'];
                var arrid = ['1','2','3'];
                var oindex = 0;
            
                $('.point').children().remove();
                for(var i=0;i<arr.length;i++){
                    var obj_val = $('<div class="col-xs-6 ra text-left"><span class="radio" data-id="'+arrid[i]+'"><span></span></span><span>'+ arr[i] +'</span></div>');
                    $('.point').append(obj_val);
                }
                var btn_html = $('<div class="overflow col-xs-12"><button class="up down btn btn-default col-xs-5">取消</button><button class="btn btn-primary col-xs-5 col-xs-offset-2" id="paperwork_btn">确定</button></div>');
                $('.point').append(btn_html);
                $('.modal').modal('show');
                
            })
            //确定按钮
            $('.push_student').on('click','#paperwork_btn',function(){
                 $('#u_paperwork').val($('.radio:eq('+ oindex +')').siblings('span').html());
                 $('.modal').modal('hide');
                 $('#u_idtype').val($('.radio:eq('+ oindex +')').attr('data-id'));
            })
            //选中按钮
            $('.push_student').on('click','.radio',function(){
                 oindex = $(this).parent('div').index();
                $(this).find('span').addClass('radio_active');
                $(this).parent('div').siblings('div').find('.radio').find('span').removeClass('radio_active');
            })
        },
		//函数调用
		event:function(){
            this.btn_click();
            this.down_click();
            this.birthday();
            this.gender();
            this.explain();
            this.up_img();
            this.Paperwork();
		}
	};
	push_student.event();
})