<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/3/22
 * Time: 11:22
 * QQ:  997823131 
 */
defined('InCosmos') or exit('Access Invalid!');?>
<!-- 日期选择start -->
<link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
<link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<!-- 日期选择 end -->

<!-- 甜窗 start -->
<link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<!-- 甜窗 end -->

<script type="text/javascript" charset="utf-8" src="<?php echo BBS_RESOURCE_SITE_URL;?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo BBS_RESOURCE_SITE_URL;?>/ueditor/ueditor.all.min.js"> </script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="<?php echo BBS_RESOURCE_SITE_URL;?>/ueditor/lang/zh-cn/zh-cn.js"></script>
<!-- 插件 -->
<!-- 日期选择 start -->
<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- 日期选择 end -->

<!-- 甜窗 start -->
<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/plugins/sweetalert/sweetalert.min.js"></script>
<!-- 甜窗 end -->

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>活动添加 <small>完善活动的信息</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="form_basic.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="form_basic.html#">选项1</a>
                            </li>
                            <li><a href="form_basic.html#">选项2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="post" enctype="multipart/form-data" action="<?php echo BBS_SITE_URL.DS."index.php";?>" class="form-horizontal">
                        <input type="hidden" name="act" value="admin_activity" />
                        <input type="hidden" name="op" value="activity_add" />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动标题</label>
                            <div class="col-sm-6">
                                <input type="text" name="activity_title" class="form-control" value="<?php echo $output['form_data']['activity_title'];?>">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动简单介绍</label>
                            <div class="col-sm-8">
                                <input type="text" name="activity_ptitle" class="form-control" value="<?php echo $output['form_data']['activity_ptitle'];?>"> <span class="help-block m-b-none text-danger">填写简单的活动介绍</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动封面图</label>

                            <div class="col-sm-10">
                                <label>
                                    <input type="file" multiple="multiple" id="input_img" style="display: none;" name="cover_img" value="" onchange="javascript:setImagePreview('input_img','preview','localImage','375px','222px');">
                                    <a style="text-align: center">
                                        <div id="localImage">
                                            <img id="preview" src="<?php echo BBS_RESOURCE_SITE_URL.DS."bootstrap".DS;?>img/vcs.jpg" style="margin:0 auto .1rem;display: block; width: 375px; height: 222px;">
                                        </div>
                                        <h4>选择封面图 <span style="color: red;">尺寸为 750x445像素</span></h4>
                                        <div style="clear: both;"></div>
                                    </a>
                                </label>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动介绍轮播图</label>

                            <div class="col-sm-10">

                                <label>
                                    <input type="file" multiple="multiple" id="detail_img1" style="display: none;" name="detail_img[]" value="" onchange="javascript:setImagePreview('detail_img1','preview1','localImage1','320px','190px');">
                                    <a style="text-align: center">
                                        <div id="localImage1">
                                            <img id="preview1" src="<?php echo BBS_RESOURCE_SITE_URL.DS."bootstrap".DS;?>img/banner1.jpg" style="margin:0 auto .1rem;display: block; width: 320px; height: 190px;">
                                        </div>
                                        <h4>活动介绍图 <span style="color: red;">尺寸为 320*190像素</span></h4>
                                        <div style="clear: both;"></div>
                                    </a>
                                </label>

                                <label>
                                    <input type="file" multiple="multiple" id="detail_img2" style="display: none;" name="detail_img[]" value="" onchange="javascript:setImagePreview('detail_img2','preview2','localImage2','320px','190px');">
                                    <a style="text-align: center">
                                        <div id="localImage2">
                                            <img id="preview2" src="<?php echo BBS_RESOURCE_SITE_URL.DS."bootstrap".DS;?>img/banner1.jpg" style="margin:0 auto .1rem;display: block; width: 320px; height: 190px;">
                                        </div>
                                        <h4>活动介绍图 <span style="color: red;">尺寸为 320*190像素</span></h4>
                                        <div style="clear: both;"></div>
                                    </a>
                                </label>

                                <label>
                                    <input type="file" multiple="multiple" id="detail_img3" style="display: none;" name="detail_img[]" value="" onchange="javascript:setImagePreview('detail_img3','preview3','localImage3','320px','190px');">
                                    <a style="text-align: center">
                                        <div id="localImage3">
                                            <img id="preview3" src="<?php echo BBS_RESOURCE_SITE_URL.DS."bootstrap".DS;?>img/banner1.jpg" style="margin:0 auto .1rem;display: block; width: 320px; height: 190px;">
                                        </div>
                                        <h4>活动介绍图 <span style="color: red;">尺寸为 320*190像素</span></h4>
                                        <div style="clear: both;"></div>
                                    </a>
                                </label>

                                <label>
                                    <input type="file" multiple="multiple" id="detail_img4" style="display: none;" name="detail_img[]" value="" onchange="javascript:setImagePreview('detail_img4','preview4','localImage4','320px','190px');">
                                    <a style="text-align: center">
                                        <div id="localImage4">
                                            <img id="preview4" src="<?php echo BBS_RESOURCE_SITE_URL.DS."bootstrap".DS;?>img/banner1.jpg" style="margin:0 auto .1rem;display: block; width: 320px; height: 190px;">
                                        </div>
                                        <h4>活动介绍图 <span style="color: red;">尺寸为 320*190像素</span></h4>
                                        <div style="clear: both;"></div>
                                    </a>
                                </label>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动年龄限制</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" name="min_age" class="input-sm form-control" value="<?php echo $output['form_data']['min_age'];?>"  />
                                    <span class="input-group-addon " style="color: #337ab7;">岁 <span style="color: red;font-weight: bold;">到</span></span>
                                    <input type="text" name="max_age" class="input-sm form-control" value="<?php echo $output['form_data']['max_age'];?>" />
                                    <span class="input-group-addon" style="color: #337ab7;">岁</span>
                                </div>
                            </div>

                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动时间选择</label>
                            <div class="col-sm-5">

                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control" name="start_time" value="<?php echo $output['form_data']['start_time'] ? $output['form_data']['start_time'] : date('Y-m-d',time());?>" />
                                    <span class="input-group-addon">到</span>
                                    <input type="text" class="input-sm form-control" name="end_time" value="<?php echo $output['form_data']['end_time'] ? $output['form_data']['end_time'] :  date('Y-m-d',time());?>" />
                                </div>

                            </div>

                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">区域选择</label>
                            <div class="col-sm-10">
                                <select name="province" onchange="province_change('province');" id="province" class="col-lg-3 control-label">
                                    <option selected value="19">广东</option>
                                    <option >福建</option>
                                    <option>湖北</option>
                                </select>
                                <select name="city" onchange="province_change('select_city');" id="select_city" class="col-lg-3 control-label">
                                    <option selected value="299">惠州</option>
                                    <option >广州</option>
                                    <option>深圳</option>
                                </select>
                                <select name="position" id="select_position" class="control-label col-lg-3">
                                    <option>淡水</option>
                                    <option selected value="1333">惠城</option>
                                    <option>惠东</option>
                                </select>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动详细地址</label>
                            <div class="col-sm-8">
                                <input type="text"  class="form-control" value="<?php echo $output['form_data']['address'];?>" name="address"> <span class="help-block m-b-none text-danger">填写详细的活动地址</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动统一出发地点</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $output['form_data']['start_from'];?>" name="start_from" > <span class="help-block m-b-none text-danger">去往活动前的集合地点</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">交通工具</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="transportation" id="">
                                    <option value="1">步行</option>
                                    <option value="1">自行车</option>
                                    <option value="1">自驾</option>
                                    <option value="1">大巴车</option>
                                    <option value="1">火车</option>
                                    <option value="1">飞机</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动报名人数</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="<?php echo $output['form_data']['total_number'];?>"  name="total_number"> <span class="help-block m-b-none text-danger">限制报名的人数</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动小组数量</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="<?php echo $output['form_data']['group_number'];?>" name="group_number"> <span class="help-block m-b-none text-danger">默认为一个小组</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">点击量</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="activity_click" value="<?php echo $output['form_data']['activity_click'];?>" > <span class="help-block m-b-none text-danger">用来提高活动活跃度</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动价格</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="activity_price" value="<?php echo $output['form_data']['activity_price'];?>"> <span class="help-block m-b-none text-danger">单张票的价格</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                活动详细介绍
                                <hr style="color: green"/>
                            <span class="text-danger">请按照手机端样式排版</span>
                            </label>

                            <div class="col-sm-10">
                                <div>
                                    <textarea id="editor" name="activity_body" type="text/plain" style="width:1080px;height:500px;">
                                    <?php echo $output['form_data']['activity_body'];?>
                                    </textarea>
                                </div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">保存内容</button>
                                <button class="btn btn-white" type="submit">取消</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>


    $("#datepicker").datepicker({
        todayBtn: "linked",
        keyboardNavigation: !1,
        forceParse: !1,
        calendarWeeks: !0,
        autoclose: !0
    })

    function province_change(name){ // name = province select_city
        var pid = $("#"+name+" option:selected").val();
//            alert(pid);
        $.ajax({
            url:ApiUrl+"/index.php?act=member_flea_list&op=get_area&area_id="+pid,
            type:"GET",
            data:{},
            success:function(msg){
                if(name == 'province'){
                    $("#select_city").children().remove();
                    if(<?php if(isset($output['form_data']['city'])){echo 1;}else{echo 0;}?> >= 1){
//                        console.log(true);
                        for(var i=0;i<msg['data'].length;i++){
                            if( msg['data'][i]['flea_area_id'] == <?php echo $output['form_data']['city']?$output['form_data']['city']:1;?>){
                                $("#select_city").append("<option selected class='select_city_op' value='"+msg['data'][i]['flea_area_id']+"'>"+msg['data'][i]['flea_area_name']+"</option>");
                                $("#select_position").children().remove();
                                $.ajax({
                                    url:ApiUrl+"/index.php?act=member_flea_list&op=get_area&area_id="+msg['data'][i]['flea_area_id'],
                                    type:"GET",
                                    data:{},
                                    success:function(data){
                                        for(var j=0;j<data['data'].length;j++){
                                            $("#select_position").append("<option value='"+data['data'][j]['flea_area_id']+"'>"+data['data'][j]['flea_area_name']+"</option>");
                                        }
                                    }
                                });
                            }else{
                                $("#select_city").append("<option class='select_city_op' value='"+msg['data'][i]['flea_area_id']+"'>"+msg['data'][i]['flea_area_name']+"</option>");
                            }
                        }
                    }else{
//                        console.log(false);
                        for(var i=0;i<msg['data'].length;i++){
                            if( i==1){
                                $("#select_city").append("<option selected class='select_city_op' value='"+msg['data'][i]['flea_area_id']+"'>"+msg['data'][i]['flea_area_name']+"</option>");
                                $("#select_position").children().remove();
                                $.ajax({
                                    url:ApiUrl+"/index.php?act=member_flea_list&op=get_area&area_id="+msg['data'][i]['flea_area_id'],
                                    type:"GET",
                                    data:{},
                                    success:function(data){
                                        for(var j=0;j<data['data'].length;j++){
                                            $("#select_position").append("<option value='"+data['data'][j]['flea_area_id']+"'>"+data['data'][j]['flea_area_name']+"</option>");
                                        }
                                    }
                                });
                            }else{
                                $("#select_city").append("<option class='select_city_op' value='"+msg['data'][i]['flea_area_id']+"'>"+msg['data'][i]['flea_area_name']+"</option>");
                            }
                        }
                    }


                }else if(name == 'select_city'){
                    $("#select_position").children().remove();
                    for(var i=0;i<msg['data'].length;i++){
                        $("#select_position").append("<option class='select_position_op' value='"+msg['data'][i]['flea_area_id']+"'>"+msg['data'][i]['flea_area_name']+"</option>");
                    }
                }
            },
            error:function(){
                alert('请求失败');
            }
        });
    }

    $(function(){
        /* 获取是否有错误信息 start */
        var is_error = <?php if(isset($output['error_message']) && !empty($output['error_message'])){echo 1;}else{ echo 0;};?>;

        if(is_error){
            swal({title:"<?php echo $output['error_message']['title'];?>",text:"<?php echo $output['error_message']['desc'];?>",type:"error"});
        }
        /* 获取是否有错误信息 end */

        /* 获取默认省份 start */
        var default_province = <?php if(isset($output['form_data']['province']) && !empty($output['form_data']['province'])){echo $output['form_data']['province'];}else{ echo 19;};?>;
//        console.log(default_province);
        $.ajax({
            url:ApiUrl+"/index.php?act=member_flea_list&op=get_area",
            type:"GET",
            data:{},
            success:function(msg){
                $("#province").children().remove();
                for(var i=0;i<msg['data'].length;i++){
                    if(msg['data'][i]['flea_area_id'] == default_province){
                        $("#province").append("<option selected class='province_op' value='"+msg['data'][i]['flea_area_id']+"'>"+msg['data'][i]['flea_area_name']+"</option>");
                        province_change('province');
                    }else{
                        $("#province").append("<option class='province_op' value='"+msg['data'][i]['flea_area_id']+"'>"+msg['data'][i]['flea_area_name']+"</option>");
                    }
                }
            },
            error:function(){
                alert('请求失败');
            }
        });
        /* 获取默认省份 end */
    });
</script>

<script type="text/javascript">
    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');

</script>

</body>

</html>