$(function(){
    var id = 0;
    var flag;
    var students_id = {

        //删除学员
        Del:function(){
            $(document).on('click','.del',function(){
                id = $(this).attr('data-id');
                flag = $(this).parent('div').parent('div').parent('div');
                console.log(id);
                var e_html = $('<h4 class="col-xs-12 text-center">提示</h4><h5 class="col-xs-12 text-center point_txt">确定删除吗?</h5><button class="btn btn-primary col-xs-4 col-xs-offset-1 Hide_u">取消</button><button class="btn btn-default col-xs-4 col-xs-offset-2 del_btn">确定</button>');
                $('.point').children().remove();
                $('.point').append(e_html);
                $('.modal').modal('show');
                //$(this).parent('div').parent('div').parent('div').remove();
                
            })
        },
        //确定删除按钮
        del_btn:function(){
            $(document).on('click','.del_btn',function(){
                $.ajax({  
                    url:SITEURL+"/index.php?act=set&op=deletInfo",  //请求路径，接口地址
                    type:"post",  //请求的方式
                    //            async:false,//同步  
                    data:{id:id,table:'bbs_parents'},//传出的数据  
                    dataType:"json",//返回的数据类型，常用：html/text/json  
                    success:function(data){  //请求成功后的回调函数
                        $('.point>button').remove();
                        $('.point_txt').html(data.msg);
                        $('.modal').modal('show');
                        if(data.code == '200'){
                            flag.remove();
                            //HrefDelay(data.url);
                        }
                    }  
                }) 
            })
        },
        //取消按钮
        Hide_u:function(){
            $(document).on('click','.Hide_u',function(){
                $('.modal').modal('hide');
            })
        },  
        //设置默认
        Select:function(){
            $(document).on('click','.select_img',function(){
                if($(this).hasClass('Select_true')){
                    //$(this).removeClass('Select_true');
                    //$(this).attr('src',BBS_RESOURCE_SITE_URL+'/bootstrap/img/false_0.png');
                }else{
                    $(this).addClass('Select_true');
                    $(this).attr('src',BBS_RESOURCE_SITE_URL+'/bootstrap/img/true_0.png');
                }
                id = $(this).parent('span').parent('div').attr('data-id');
                $.ajax({  
                    url:SITEURL+"/index.php?act=set&op=default",  //请求路径，接口地址
                    type:"post",  //请求的方式
                    //            async:false,//同步  
                    data:{id:id,table:'bbs_parents'},//传出的数据  
                    dataType:"json",//返回的数据类型，常用：html/text/json  
                    success:function(data){  //请求成功后的回调函数
                        $('.point').html('<h4 class="col-xs-12 text-center">提示</h4><h5 class="col-xs-12 text-center point_txt">'+data.msg+'</h5>');
                        $('.modal').modal('show');
                        if(data.code == '200'){
                            setInterval(function(){
                                window.location.reload();
                            },1000);
                        }
                    }  
                })
            })
        },
        
        //说明弹框
        explain:function(){
            $('.explain').click(function(){
                var e_html = $('<div class="col-xs-12 explain_txt text-left"><p class="col-xs-12">1.为什么要儿童证件及身高体重信息？</p><span class="col-xs-12">答：一为儿童购买旅游保险；二为儿童选择合适尺码的衣服。</span><p class="col-xs-12">2.为什么要监护人的证件信息？</p><span class="col-xs-12">答：因为要签订电子旅游合同，儿童是未成年人，必须由监护人签订，需要签订人(即监护人)的有效证件号码。</span><button class="aHide">确定<tton></div>');
                $('.point').children().remove();
                $('.point').append(e_html);
                $('.modal').modal('show');
            })
        },
        event:function(){
            this.Del();
            this.del_btn();
            this.Hide_u();
            this.Select();
            this.explain();
        }
    }
    students_id.event();
})