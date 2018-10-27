$(function(){
  var submitflag = false;
  var Gender = '男';
  var defray = {

    //索引当前选中的监护人
    IndexTu:null,
    
    //索引当前选中的学员
    IndexSt:[],
    
    u_img : null,//监护人头像
    
    st_img : null,//学员头像
    //设置选择场次栏目的宽度
    TitleWidth:function(){
            len = $('.title_ul>li').length;
            var w = $('.title_ul>li').innerWidth() * len;
           $('.title_ul').css('width',w + (len * 12.5));
           $('.defray').on('click','.title_ul>li',function(){
                   $(this).addClass('active');
                   $('#period').val($(this).attr('data-id'));
                   $(this).siblings('li').removeClass('active');
           })
    },
    //添加减少数量
    Pl_click:function(obj){
      $(obj).click(function(){
        var Sum = Number($('.de_price>span').html());
                 if($(this)[0].className == 'less'){
                  if($('.de_num').html() > 0){
                      $('.de_num').html(Number($('.de_num').html()) - 1);
                      $('.total>span').html(Number($('.total>span').html()) - Sum);
                    }else{
                            $('.de_num').html(0);
                            $('.total>span').html('0.00');
                    }
                 }else{
                  $('.de_num').html(Number($('.de_num').html()) + 1);
                  $('.total>span').html(Number($('.total>span').html()) + Sum);
                 }
        
      })
    },
    //勾选协议按钮
    De_radio:function(o){
      $(o).click(function(){
        var obj = $('.de_radio');
        if(obj.hasClass('dearadio')){
          obj.removeClass('dearadio');
          obj.find('span').css('background','none');
          return false;
        }else{
          obj.addClass('dearadio');
          obj.find('span').css('background','#e25428');
          return false;
        }
      })
    },
    //协议跳转
    Protocol:function(){
      $('.contract>span').click(function(){
          Href($(this).attr('href_url'))
          return false;
      })
    },
    //监护人选择
    De_id:function(){
       var formData = new FormData();
       var self = this;
       var tut_sum = 5;//监护人的个数
       var curr_tut = {
        name:null,//被选中的监护人姓名
        img_url:null,//被选中的监护人头像
        id:null,//被选中的监护人id
        phone:null,//被选中的监护人手机号
        sex:null,//被选中的监护人性别
        relation:null,//被选中的监护人与学员的关系
       }
        $('#tutelage').click(function(){
            var html = $('<div class="col-xs-12 de_Radio_select"><h4>选择监护人</h4><div class="de_select" id="Guardian"><div class="text-center de_push" id="push_gds"><span>新增监护人</span></div></div><div class="overflow selbtn"><button class="ra_det" id="ra_det">确定</button><button class="ra_can aHide">取消</button></div></div>')
             $('.de_point').children().remove();
             $('.de_point').append(html);
             if($('#newest').length != 0){
              curr_tut.img_url = $('#newest').find('img').attr('src');
              curr_tut.name = $('#newest').find('span').html();
              curr_tut.id = $('#newest').find('img').attr('data-id');
              curr_tut.phone = $('#newest').find('img').attr('data-phone');
              curr_tut.sex = $('#newest').find('img').attr('data-sex');
              curr_tut.relation = $('#newest').find('img').attr('data-relation');
              console.log(curr_tut)
            }
             //请求后台监护人数据
             $.ajax({  
                url:SITEURL+'/index.php?act=set&op=manageInfo',  //请求路径，接口地址
                type:"post",  //请求的方式
                async:false,//同步  
                data:{},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                  if(data.code == '200'){
                    for(var i=0; i<data.list.length; i++){
                      if(data.list[i].headimgurl == '' || data.list[i].headimgurl == null){
                        var img = BBS_RESOURCE_SITE_URL+'/bootstrap/img/logo.png';
                      }else{
                        var img = data.list[i].headimgurl;
                      }
                      var seleHtml = $('<div class="overflow text-left"><img data-id="'+data.list[i].id+'" data-phone="'+data.list[i].parents_phone+'" data-sex="'+data.list[i].parents_sex+'" data-relation="'+data.list[i].relation+'" src="'+img+'" class="avtImg" /><span>'+data.list[i].parents_name+'</span><span class="fr de_rai"><span></span></span></div>')
                      $('.de_select').prepend(seleHtml);
                    }
                  }else{
                    var html = $('<h4 class="col-xs-12">'+data.msg+'</h4><button class="col-xs-6 col-xs-offset-3 btn_prompt aHide">确定</button>')
                    $('.de_point').html(html);
                    HrefDelay(data.url);
                  }
                }
            });
            // for(var i=0;i<tut_sum;i++){
            //   var seleHtml = $('<div class="overflow text-left"><img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/children.jpg" class="avtImg" /><span>武则天'+ i +'</span><span class="fr de_rai"><span></span></span></div>')
            //   $('.de_select').prepend(seleHtml);
            // }
            if(self.IndexTu != null){
                $('.de_rai:eq('+ self.IndexTu +')').find('span').css('background','#e25428');
            }
            $('.modal').modal('show');
         })
         //选择监护人事件
          $('.modal').on('click','#Guardian>div',function(){
            var obj = $(this).find('.de_rai');
            $(this).siblings('div').find('.de_rai').find('span').css('background','none');
            $(this).siblings('div').css('background',"#FFF");
            $(this).css('background',"#EEE");
            obj.find('span').css('background','#e25428');
            curr_tut.img_url = $(this).find('img').attr('src');
            curr_tut.name =  $(this).find('span').html();
            curr_tut.id = $(this).find('img').attr('data-id');
            curr_tut.phone = $(this).find('img').attr('data-phone');
            curr_tut.sex = $(this).find('img').attr('data-sex');
            curr_tut.relation = $(this).find('img').attr('data-relation');
            self.IndexTu = $(this).index();
          })
         //确定按钮
         $('.modal').on('click','#ra_det',function(){
            if(curr_tut.name != null){
                var html = $('<div class="overflow de_tut" id="newest"><img data-phone="'+curr_tut.phone+'" data-sex="'+curr_tut.sex+'" data-id="'+curr_tut.id+'" data-relation="'+curr_tut.relation+'" src="'+ curr_tut.img_url +'" /><span>'+ curr_tut.name +'</span><span class="fr del_guardian" index="0">x</span></div>');
              $('#tutelage').parent('div').append(html);

              if($('#tutelage').parent('div').find('.de_tut').length > 1){
                   $('#tutelage').parent('div').find('.de_tut:eq(0)').remove();
              }
              $('.modal').modal('hide');
              return false;
            }else{
              $('.modal').modal('hide');
              return false;
            }
         })
         //新增监护人
         $('.modal').on('click','#push_gds',function(){

            var arrClass= ['u_name','u_relation','u_phone'];
            var arrTxt = ['姓名:','关系','手机号:'];
            var arrPl = ['请输入姓名','请输入与学员的关系','请输入手机号码'];
            var html = $(' <div class="col-xs-12 overflow student_inf"><div class="pull-left"><img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/logo.png" /><span>监护人信息</span></div></div><form enctype="multipart/form-data" method="post" id="submitForm"><div class="de_student col-xs-12 text-left"><div class="overflow"><div class="col-xs-12 student_inf_txt padding_none"><div class="overflow userImg" id="upImg"><span class="col-xs-4 padding_none text-center">相片:</span><div class="file-box pull-right" ><input type="file" name="photo" class="file-btn" id="up_img" accept="image/*"/><span>></span></div></div></div></div></div></form><div class="overflow selbtn"><button class="ra_det" id="push_det">确定</button><button class="ra_can aHide">取消</button></div></div>');
            $('.de_Radio_select').css('display','none');
            $('.de_point').append(html);
            for(var i=0;i<arrTxt.length;i++){
              var ohtml = $('<div class="col-xs-12 student_inf_txt padding_none text-center"><div class="overflow"><span class="col-xs-4 padding_none">'+ arrTxt[i] +'</span><input type="text" name="'+ arrClass[i] +'" class="col-xs-8 bder_none '+ arrClass[i] +'"  placeholder="'+ arrPl[i] +'"  /></div></div>');
              $('.de_student').append(ohtml);
            };
            var ohtml = $('<input type="hidden" name="u_idtype" id="idtype" value="" />');
            $('.de_student').append(ohtml);
         })
         //添加确定按钮
         $('.modal').on('click','#push_det',function(){

            var u_name = $('.u_name').val();//姓名
            var u_relation = $('.u_relation').val();//关系
            var u_phone = $('.u_phone').val();//手机号
            //var Regu_idnum = /^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|[xX])$/;//身份证验证
            var Regu_idnum = /^[0-9A-Za-z]{6,24}$/;//数字或者字母的组合
            var Regu_born = /^(18|19|20)\d{2}(1[0-2]|0?[1-9])(0?[1-9]|[1-2][0-9]|3[0-1])$/;//出生年月验证
            var Regu_phone = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;
            $('.bder_none').css('border','none');
            if(u_name == ''){
                $('.u_name').css('border','1px solid #f74f4f');
            }else if (u_relation == '') {
                $('.u_relation').css('border','1px solid #f74f4f');
            }else if (u_phone == '') {
                $('.u_phone').css('border','1px solid #f74f4f');
            }else if (!Regu_phone.test(u_phone)) {
                $('.u_phone').css('border','1px solid #f74f4f');
            }else{
                
                //防止重复提交
                if(submitflag)
                  return false;
                submitflag = true;
                // var formData = new FormData(document.getElementById("submitForm"));
                formData.append('u_name',u_name);
                formData.append('u_relation',u_relation); 
                formData.append('u_phone',u_phone);
                //发送请求
                $.ajax({
                  type:"POST", 
                  processData:false,
                  contentType:false,   
                  async: false,  
                  url:SITEURL+"/index.php?act=set&op=addManage",  //请求路径，接口地址
                  data:formData, 
                  success: function(data){
                      //重置form,避免重复上传  
                      formData = new FormData();
                      //console.log(data);
                      if(data.code == '200'){
                        if(data.headimgurl == '' || data.headimgurl == null){
                          var headimgurl = BBS_RESOURCE_SITE_URL+'/bootstrap/img/logo.png';
                        }else{
                          var headimgurl = data.headimgurl;
                        }
                        var html = $('<div class="overflow de_tut" id="newest"><img src="'+ headimgurl +'" data-id="'+data.id+'" data-phone="'+u_phone+'" data-sex="3" data-relation="'+u_relation+'" /><span>'+ u_name +'</span><span class="fr del_guardian" index="0">x</span></div>');
                        $('#tutelage').parent('div').append(html);
                        self.IndexTu = 0;
                        if($('#tutelage').parent('div').find('.de_tut').length > 1){
                           $('#tutelage').parent('div').find('.de_tut:eq(0)').remove();
                        }
                        $('.modal').modal('hide');
                      }else{
                        alert(data.msg);
                      }
                      submitflag = false;
                  },
                  error:function(e){
                      //重置form,避免重复上传  
                      formData = new FormData();
                      alert('网络出错');
                      submitflag = false;
                  }
              });  
              
            }
         })
        //上传图片
         $('.modal').on('change','#up_img',function(){
            var file = this.files[0];
            if (window.FileReader) {    
                    var reader = new FileReader();    
                    reader.readAsDataURL(file);    
                    formData.append('photo',file);
                    //监听文件读取结束后事件    
                  reader.onloadend = function (e) {
                    self.u_img = e.target.result;
                    var Img = $('<img src="'+ e.target.result +'" />');
                    $('#upImg').find('img').remove();
                    $('#upImg').append(Img);
                  };    
            } 
         })
    },
    //学员选择
    De_st:function(){
      var formData = new FormData();
      var self = this;
      var st_sum = 10; //学员的总数
      var arr_st = {
        name:[],//被选中的学员名字
        img:[],//被选中的学员头像
        id:[],//被选中的学员id
      };//所有选中的学员
      var onOff = [];
      for(var i=0;i<st_sum;i++){
        onOff.push(false);
      }
      //选择学员
      $('#student').click(function(){
        $('.de_point').children().remove();
        if($(this).parent('div').find('.de_tut').length == 10){
          var html = $('<h4 class="col-xs-12">学员最多只能选择10位</h4><button class="col-xs-6 col-xs-offset-3 btn_prompt aHide">确定</button>');
          $('.de_point').append(html);
          $('.modal').modal('show');
        }else{
          var html = $('<div class="col-xs-12 de_Radio_select"><h4>选择学员</h4><div class="de_select" id="Students"><div class="text-center de_push"><span id="push_st">新增学员</span></div></div><div class="overflow selbtn"><button class="ra_det" id="deSt_det">确定</button><button class="ra_can aHide">取消</button></div></div>')
            $('.de_point').append(html);
            var periods = $('#periods').val();//活动期数
            var no = $('#no').val();//活动唯一标志
            //请求后台学员数据
            $.ajax({  
                url:SITEURL+'/index.php?act=set&op=studentInfo',  //请求路径，接口地址
                type:"post",  //请求的方式
                async:false,//同步  
                data:{activity_no:no,activity_periods:periods},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                  if(data.code == '200'){
                    for(var i=0; i<data.list.length; i++){
                      if(data.list[i].headimgurl == '' || data.list[i].headimgurl == null){
                        var img = BBS_RESOURCE_SITE_URL+'/bootstrap/img/children.jpg';
                      }else{
                        var img = data.list[i].headimgurl;
                      }
                      var seleHtml = $('<div class="overflow text-left"><img data-age="'+data.list[i].child_age+'" data-id="'+data.list[i].id+'" src="'+img+'" data-phone="'+data.list[i].child_phone+'" data-sex="'+data.list[i].child_sex+'" data-height="'+data.list[i].child_height+'" data-size="'+data.list[i].child_size+'" data-remark="'+data.list[i].child_remark+'"  class="st_Img" /><span class="st_name">'+data.list[i].child_name+'</span><span class="fr de_strai"><span id="'+ data.list[i].id +'"></span></span></div>')
                      $('.de_select').prepend(seleHtml);
                    }
                  }else{
                    var html = $('<h4 class="col-xs-12">'+data.msg+'</h4><button class="col-xs-6 col-xs-offset-3 btn_prompt aHide">确定</button>')
                    $('.de_point').html(html);
                    HrefDelay(data.url);
                  }
                }
            });
            //默认选中以前勾选的
            for(var i=0;i<self.IndexSt.length;i++){
               $('#'+ self.IndexSt[i] +'').css('background','#e25428');
               $('#'+ self.IndexSt[i] +'').parent('span').addClass('de_straiClass');
            }
            $('.modal').modal('show');
        }
      });
      //赋值选中的学员
      $('.modal').on('click','#Students>div',function(){
        //console.log(self.IndexTu);
        if($(this).hasClass('de_straiClass')){
          $(this).find('.de_strai>span').css('background','none');
          $(this).removeClass('de_straiClass');
          onOff[$(this).index()] = false;
        }else{
          onOff[$(this).index()] = true;
          $(this).find('.de_strai>span').css('background','#e25428');
          $(this).addClass('de_straiClass');
        }
      })
      //确定按钮
      $('.modal').on('click','#deSt_det',function(){
        for(var i=0;i<onOff.length;i++){
          var obj = $('.de_strai').parent('div:eq('+ i +')');
          //判断年龄
          var id = obj.find('img').attr('data-id');
          if(onOff[i] && self.IndexSt.indexOf(id) == -1){
              var age = parseInt(obj.find('img').attr('data-age'));
              var st_name = obj.find('.st_name').html();
              var st_img = obj.find('img').attr('src');
              var phone = obj.find('img').attr('data-phone');
              var sex = obj.find('img').attr('data-sex');
              var height = obj.find('img').attr('data-height');
              var size = obj.find('img').attr('data-size');
              var remark = obj.find('img').attr('data-remark');
              // console.log(remark);
              if(remark == '' || remark == 'null'){
                alert('请在身份信息管理中填写学员身体情况');
                Href(SITEURL+'/index.php?act=set&op=addStudent&id='+id);
                return false;
              }
              var html = $('<div class="overflow de_tut"><img data-age="'+age+'" data-id="'+id+'" data-phone="'+phone+'" data-sex="'+sex+'" data-height="'+height+'" data-size="'+size+'" src="'+ st_img +'" /><span>'+ st_name +'</span><span class="fr del_student" index="1">x</span></div>');
              $('#student').parent('div').append(html);
              //改变票数和价格
              $('.de_num').html(parseInt($('.de_num').html())+1);
              var total = parseFloat($('.de_price>span').html())*$('.de_num').html();
              $('.total>span').html(total.toFixed(2));
              self.IndexSt.push(id);
          }
        }
        for(var i=0;i<st_sum;i++){
          onOff[i] = false;
        }
        $('.modal').modal('hide');
      })
      //新增学员
       $('.modal').on('click','#push_st',function(){
            var arrClass= ['u_name','u_id','u_idnum','u_born','u_gender','u_phone','u_height','u_weight','u_clothes','u_exhort'];
            var arrTxt = ['姓名:','证件类型','证件号码:','出生日期:','性别:','手机号:','身高:','体型:','衣服尺码:','学员身体情况:'];
            var arrPl = ['请输入姓名','','请输入证件号码','格式为：20150201','请输入性别','请输入手机号码','单位为：cm','','',''];
            var html = $(' <div class="col-xs-12 overflow student_inf"><div class="pull-left"><img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/child.png" /><span>学员信息</span></div></div><form enctype="multipart/form-data" method="post" id="submitForm"><div class="de_student col-xs-12 text-left"><div class="overflow"><div class="col-xs-12 student_inf_txt padding_none"><div class="overflow userImg" id="stImg"><span class="col-xs-4 padding_none text-center">相片:</span><div class="file-box pull-right" ><input type="file" name="photo" class="file-btn" id="st_img" accept="image/*" /><span>></span></div></div></div></div></div></form><div class="overflow selbtn"><button class="ra_det" id="st_push"><a href="#a0">确定</a></button><button class="ra_can aHide">取消</button></div></div>');
            $('.de_Radio_select').css('display','none');
            $('.de_point').append(html);
            for(var i=0;i<arrTxt.length;i++){
              if(i == 1){
                 var ohtml = $('<div class="col-xs-12 student_inf_txt padding_none text-center" id="a'+ i +'"><div class="overflow"><span class="col-xs-4 padding_none">'+ arrTxt[i] +'</span><div class="col-xs-8 padding_none de_size_margin"><span class="col-xs-6 padding_none"><span class="fl de_strai_idtype" data-id="1"><span></span></span>身份证</span><span class="col-xs-6 padding_none"><span class="fl de_strai_idtype" data-id="2"><span></span></span>港澳居民身份证</span><span class="col-xs-6 padding_none"><span class="fl de_strai_idtype" data-id="3"><span></span></span>护照</span></div></div></div>');
                 $('.de_student').append(ohtml);
              }else if(i == 3){
                 var ohtml = $('<div class="col-xs-12 overflow student_inf_txt" id="a'+ i +'"><div class="overflow" ><span class="col-xs-4 text-center padding_none">出生日期:</span><input type="text" name="'+ arrClass[i] +'" class="col-xs-8 bder_none '+ arrClass[i] +'" placeholder="'+ arrPl[i] +'" /></div></div>');
                 $('.de_student').append(ohtml);
              }else if(i == 4){
                 var ohtml = $('<div class="col-xs-12 student_inf_txt padding_none text-center" id="a'+ i +'"><div class="overflow"><span class="col-xs-4 padding_none">'+ arrTxt[i] +'</span><div class="col-xs-8 padding_none de_size_margin"><span class="col-xs-4 gender_sele_click padding_none"><span class="fl de_strai_gender"><span class="gender_active"></span></span>男</span><span class="col-xs-4 gender_sele_click padding_none"><span class="fl de_strai_gender"><span></span></span>女</span></div></div></div>');
                 $('.de_student').append(ohtml);
              }else if(i == 7){
                 var ohtml = $('<div class="col-xs-12 student_inf_txt padding_none text-center" id="a'+ i +'"><div class="overflow"><span class="col-xs-4 padding_none">'+ arrTxt[i] +'</span><div class="col-xs-8 padding_none de_size_margin"><span class="col-xs-4 padding_none"><span class="fl de_strai_weight"><span></span></span>偏瘦</span><span class="col-xs-4 padding_none"><span class="fl de_strai_weight"><span></span></span>中等</span><span class="col-xs-4 padding_none"><span class="fl de_strai_weight"><span></span></span>偏胖</span></div></div></div>');
                 $('.de_student').append(ohtml);
              }else if(i == 8){
                 var ohtml = $('<div class="col-xs-12 student_inf_txt padding_none text-center" id="a'+ i +'"><div class="overflow"><span class="col-xs-4 padding_none">'+ arrTxt[i] +'</span><div class="col-xs-8 padding_none de_size_margin"><span class="col-xs-10 padding_none"><span class="fl de_strai_size"><span></span></span>S(110-130cm)</span><span class="col-xs-10 padding_none"><span class="fl de_strai_size"><span></span></span>M(131-150cm)</span><span class="col-xs-10 padding_none"><span class="fl de_strai_size"><span></span></span>L(151-160cm)</span><span class="col-xs-10 padding_none"><span class="fl de_strai_size"><span></span></span>XL(161-175cm)</span><span class="col-xs-10 padding_none"><span class="fl de_strai_size"><span></span></span>XXL(175-185cm)</span></div></div></div>');
                 $('.de_student').append(ohtml);
              }else if(i == arrTxt.length - 1){
                 var ohtml = $('<div class="col-xs-12 student_inf_txt padding_none text-center" id="a'+ i +'"><div class="overflow"><span class="col-xs-4 padding_none">'+ arrTxt[i] +'</span><textarea class="'+ arrClass[i] +' col-xs-8 padding_none" name="u_exhort"></textarea></div></div>');
                 $('.de_student').append(ohtml);
              }else{
                 var ohtml = $('<div class="col-xs-12 student_inf_txt padding_none text-center" id="a'+ i +'"><div class="overflow"><span class="col-xs-4 padding_none">'+ arrTxt[i] +'</span><input type="text" name="'+ arrClass[i] +'" class="col-xs-8 bder_none '+ arrClass[i] +'" placeholder="'+ arrPl[i] +'" /></div></div>');
                 $('.de_student').append(ohtml);
              }
            };
            var ohtml = $('<input type="hidden" name="u_clothes" id="size" value="" /><input type="hidden" name="u_weight" id="weight" value="" /><input type="hidden" name="u_idtype" id="idtype" value="" />');
            $('.de_student').append(ohtml);
        })
      //新增的确定按钮
      $('.modal').on('click','#st_push',function(){
            // console.log('#st_push');
            var u_name = $('.u_name').val();//姓名
            var u_idnum = $('.u_idnum').val();//证件号码
            var u_gender = Gender;//性别
            var u_born = $('.u_born').val();//出生年月
            var u_phone = $('.u_phone').val();//手机号
            var u_height = $('.u_height').val();//身高
            var u_weight = $('#weight').val();//体重
            var u_clothes = $('#size').val();//衣服尺码
            var u_exhort = $('.u_exhort').val();//特别叮嘱
            var Regu_height = /^[1-9]\d{1,2}$/;//身高验证
            var Regu_weight = /^\d{2}$/;//体重验证
            var Regu_born = /^(19|20)\d{2}(1[0-2]|0?[1-9])(0?[1-9]|[1-2][0-9]|3[0-1])$/;//出生年月验证
            //var Regu_idnum = /^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|[xX])$/;//身份证验证
            var Regu_phone = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;
            $('.bder_none').css('border','none');
            if(u_name == ''){
                $('.u_name').css('border','1px solid #f74f4f');
            }else if (u_idnum == ''){
                $('.u_idnum').css('border','1px solid #f74f4f');
            }else if (u_born == '') {
                $('.u_born').css('border','1px solid #f74f4f');
            }else if (!Regu_born.test(u_born)) {
                $('.u_born').css('border','1px solid #f74f4f');
                $('.u_born').val('');
                $('.u_born').prop('placeholder','格式为：20150201');
            }else if (u_phone == '') {
                $('.u_phone').css('border','1px solid #f74f4f');
            }else if (!Regu_phone.test(u_phone)) {
                $('.u_phone').css('border','1px solid #f74f4f');
            }else if (u_height == '') {
                $('.u_height').css('border','1px solid #f74f4f');
            }else if (!Regu_height.test(u_height)) {
                $('.u_height').css('border','1px solid #f74f4f');
                $('.u_height').val('');
                $('.u_height').prop('placeholder','格式如为：110');
            }else if (u_weight == '') {
                $('.u_weight').css('border','1px solid #f74f4f');
            }else if (u_exhort == '') {
                $('.u_exhort').css('border','1px solid #f74f4f');
            }else{
                //防止重复提交
                if(submitflag)
                  return false;
                formData.append('u_name',u_name);
                formData.append('u_idtype',$('#idtype').val());
                formData.append('u_idnum',u_idnum);
                formData.append('u_born',u_born);
                formData.append('u_gender',u_gender);
                formData.append('u_phone',u_phone);
                formData.append('u_height',u_height);
                formData.append('u_weight',u_weight);
                formData.append('u_clothes',u_clothes);
                formData.append('u_exhort',u_exhort);

                submitflag = true;
                //发送请求
                $.ajax({
                  type:"POST", 
                  processData:false,
                  contentType:false,   
                  async: false,  
                  url:SITEURL+"/index.php?act=set&op=addStudent",  //请求路径，接口地址
                  data:formData, 
                  success: function(data){
                      submitflag = false;
                      //重置form,避免重复上传  
                      formData = new FormData();
                      if(data.code == '200'){
                        var date = new Date();
                        var year = date.getFullYear();
                        var age = year-u_born.substr(0,4);
                        u_gender = (u_gender=='男')?1:2;
                        $('.modal').modal('hide');
                        if(data.headimgurl == '' || data.headimgurl == null){
                          var headimgurl = BBS_RESOURCE_SITE_URL+'/bootstrap/img/children.jpg';
                        }else{
                          var headimgurl = data.headimgurl;
                        }
                        var html = $('<div class="overflow de_tut"><img src="'+ headimgurl +'" data-age="'+age+'" data-id="'+data.id+'" data-phone="'+u_phone+'" data-sex="'+u_gender+'" data-height="'+u_height+'" data-size="'+u_clothes+'" /><span>'+ u_name +'</span><span class="fr del_student" index="1">x</span></div>');
                        $('#student').parent('div').append(html);
                        self.IndexSt.push(''+ data.id +'');
                        //self.IndexSt.push();
                        console.log(self.IndexSt);
                        //改变票数和价格
                        $('.de_num').html(parseInt($('.de_num').html())+1);
                        var total = parseFloat($('.de_price>span').html())*$('.de_num').html();
                        $('.total>span').html(total.toFixed(2));
                        //$('.total>span').html(parseFloat($('.de_price>span').html()*$('.de_num').html()));
                      }else{
                        //$('.u_phone').css('border','1px solid #f74f4f');
                        alert(data.msg);
                      }
                      
                  },
                  error:function(e){
                      //重置form,避免重复上传  
                      formData = new FormData();
                      alert('网络出错');
                      submitflag = false;
                  }
              });  
              
            }
          
      })
      //上传图片
      $('.modal').on('change','#st_img',function(){
          var file = this.files[0];
          if (window.FileReader) {    
                var reader = new FileReader();    
                reader.readAsDataURL(file);  
                formData.append('photo',file);  //将图片加入到表单
                //监听文件读取结束后事件    
                reader.onloadend = function (e) {
                  self.u_img = e.target.result;
                  var Img = $('<img src="'+ e.target.result +'" />');
                  $('#stImg').find('img').remove();
                  $('#stImg').append(Img);
                };    
          } 
      })
      //衣服尺码选择
      $('.modal').on('click','.de_strai_size',function(){
          $('.de_strai_size').find('span').css('background','none')
          $(this).find('span').css('background','#e25428');
          $('#size').val($(this).parent().text());
      })
      //体重选择
      $('.modal').on('click','.de_strai_weight',function(){
          $('.de_strai_weight').find('span').css('background','none')
          $(this).find('span').css('background','#e25428');
          $('#weight').val($(this).parent().text());
      })
      //证件类型选择
      $('.modal').on('click','.de_strai_idtype',function(){
          $('.de_strai_idtype').find('span').css('background','none');
          $(this).find('span').css('background','#e25428');
          $('#idtype').val($(this).attr('data-id'));
      })
      //性别选择
      $('.modal').on('click','.gender_sele_click',function(){
          $('.gender_active').removeClass('gender_active');
          $(this).find('span').find('span').addClass('gender_active');
          Gender = $(this).index() + 1;
          if($(this).index() == 0){
            Gender = '男';
          }else{
            Gender = '女';
          }
      })
    },
    //支付成功后的弹框
    Bullet:function(){
      //分享功能的html
      var html = $('<img src="'+BBS_RESOURCE_SITE_URL+'/bootstrap/img/paysuccess.png" /><h4>支付成功</h4><p class="prompt">分享我的活动报名即刻获取优惠券！</p><div class="overflow"><div class="bdsharebuttonbox col-xs-12 text-center overflow"><div class="col-xs-3 overflow"><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><p class="col-xs-12">微信</p></div><div class="col-xs-3 overflow"><a href="#" class="bds_tsina col-xs-12" data-cmd="tsina" title="分享到新浪微博"></a><p class="col-xs-12">新浪</p></div><div class="col-xs-3 overflow"><a href="#" class="bds_sqq col-xs-12" data-cmd="sqq" title="分享到QQ好友"></a><p class="col-xs-12">QQ</p></div><div class="col-xs-3 overflow"><a href="#" class="bds_more col-xs-12" data-cmd="more"></a><p class="col-xs-12">其他</p></div></div>')
      var ohtml = $('<h4 class="col-xs-12"></h4><button class="col-xs-6 col-xs-offset-3 btn_prompt aHide">确定</button>')
          $('.go_debtn').click(function(){
            $('.de_point').children().remove();
            //判断是否同意协议
            if(!$('.de_radio').hasClass('dearadio')){
              $('.de_point').append(ohtml);
              $('.de_point>h4').html('请同意协议');
              $('.modal').modal('show');
              return false;
            }
            var periods = $('#periods').val();//活动期数
            var no = $('#no').val();//活动唯一标志
            //var period = $('#period').val();//选择的场次
            //var activityId = $('#activityId').val();//当前场次
            var de_phone = $('#de_phone').val();//手机
            var remark = $('#remark').val();//备注
            //var de_email = $('#de_mail').val();//邮箱
            var phone_reg = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;
            //var email_reg = /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/;
            //var price = $('.total>span').html();
            if(de_phone == ''){
              $('.de_point').append(ohtml);
              $('.de_point>h4').html('请输入手机号码');
              $('.modal').modal('show');
            }else if(!phone_reg.test(de_phone)){
              $('.de_point').append(ohtml);
              $('.de_point>h4').html('手机格式不正确');
              $('.modal').modal('show');
            }else if ($('#tutelage').parent('div').find('.de_tut').length == 0) {
              $('.de_point').append(ohtml);
              $('.de_point>h4').html('添加监护人');
              $('.modal').modal('show');
            }else if ($('#student').parent('div').find('.de_tut').length == 0) {
              $('.de_point').append(ohtml);
              $('.de_point>h4').html('添加学员');
              $('.modal').modal('show');
            }else{
              //防止重复提交
              if(submitflag)
                return false;
              submitflag = true;
              //选择的监护人
              var parents = new Array();
              $('#tutelage').parent().find('.de_tut').each(function(){
                var s = {};
                s.id = $(this).find('img').attr('data-id');
                s.img = $(this).find('img').attr('src');
                s.name = $(this).find('span').html();
                s.phone = $(this).find('img').attr('data-phone');
                s.sex = $(this).find('img').attr('data-sex');
                s.relation = $(this).find('img').attr('data-relation');
                parents.push(s);
              });
              //选择的学员
              var students = new Array();
              $('#student').parent().find('.de_tut').each(function(){
                var s = {};
                s.id = $(this).find('img').attr('data-id');
                s.img = $(this).find('img').attr('src');
                s.name = $(this).find('span').html();
                s.phone = $(this).find('img').attr('data-phone');
                s.sex = $(this).find('img').attr('data-sex');
                s.height = $(this).find('img').attr('data-height');
                s.age = $(this).find('img').attr('data-age');
                s.size = $(this).find('img').attr('data-size');
                students.push(s);
              });
              //students = JSON.stringify(students);
              //console.log(students);
              //发送请求
              $.ajax({  
                url:SITEURL+"/index.php?act=activity&op=ajaxDefray",  //请求路径，接口地址
                type:"post",  //请求的方式
                async:false,//同步  
                data:{activity_no:no,activity_periods:periods,de_phone:de_phone,
                parents:parents,students:students,remark:remark},//传出的数据  
                dataType:"json",//返回的数据类型，常用：html/text/json  
                success:function(data){  //请求成功后的回调函数
                    // console.log(typeof data);
                    // $('.modal').modal('hide');//关闭弹框
                    if(data.code == '200'){
                      submitflag = false;
                      Href(data.url);
                      // $('.de_point').append(html);
                      // $('.modal').modal('show');
                      // window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{}};
                      // with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
                    }else{
                      submitflag = false;
                      $('.de_point').append(ohtml);
                      $('.de_point>h4').html(data.msg);
                      $('.modal').modal('show');
                    }
                    
                }
              })
              
            
            }
          })
    },
    //删除已选的监护人和学员
    Del:function(o){
      var self = this;
      $('.defray').on('click',o,function(){
          self.IndexSt.splice($(this).parent('div').index()-1,1);
          $(this).parent('div').remove();
          
          if($(this).attr('index') == 0){
            self.IndexTu = null;
          }else{
            console.log(self.IndexSt); 
          }
          //改变票数和价格
          if(o == '.del_student' && parseInt($('.de_num').html()) > 0){
            $('.de_num').html(parseInt($('.de_num').html())-1);
            // $('.total>span').html(parseFloat($('.de_price>span').html()*$('.de_num').html()));
            var total = parseFloat($('.de_price>span').html())*$('.de_num').html();
            $('.total>span').html(total.toFixed(2));
          }
      })
    },
    //添加学员时锚点定位
    AnchorPoint:function(){
      var len = 9;
      for(var i=0;i<=9;i++){
          $('.modal').on('click','#a'+i,function(){
          $('#st_push').find('a').attr('href','#' + $(this).attr('id'));
        })
      }
    },
    //函数的调用
    event:function(){
              this.TitleWidth();
              this.Pl_click('.push');
              this.De_radio('.de_radio');
              this.De_radio('.contract');
              this.Protocol();
              this.De_id();
              this.Bullet();
              this.De_st();
              this.Del('.del_guardian');
              this.Del('.del_student');
              this.AnchorPoint();
    }
  };
  defray.event();
})