$(function(){
  var submitflag = false;
  var defray = {
    //勾选协议按钮
    De_radio:function(){
      $('.de_radio').click(function(){
        if($(this).hasClass('dearadio')){
          $(this).removeClass('dearadio');
          $(this).css('background','none');
        }else{
          $(this).addClass('dearadio');
          $(this).css('background','#e25428');
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
          //防止重复提交
          if(submitflag)
            return false;
          submitflag = true;
          var id = $('#orderId').val();
          //发送请求
          $.ajax({  
            url:SITEURL+"/index.php?act=order&op=payOrder",  //请求路径，接口地址
            type:"post",  //请求的方式
            async:false,//同步  
            data:{id:id},//传出的数据  
            dataType:"json",//返回的数据类型，常用：html/text/json  
            success:function(data){  //请求成功后的回调函数
                // console.log(typeof data);
                // $('.modal').modal('hide');//关闭弹框
                if(data.code == '200'){
                  submitflag = false;
                  $('.de_point').append(html);
                  $('.modal').modal('show');
                  window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{}};
                  with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
                }else{
                  submitflag = false;
                  $('.de_point').append(ohtml);
                  $('.de_point>h4').html(data.msg);
                  $('.modal').modal('show');
                }
                
            }
          })
        })
    },
    //函数的调用
    event:function(){
      this.De_radio();
      this.Bullet();
    }
  };
  defray.event();
})