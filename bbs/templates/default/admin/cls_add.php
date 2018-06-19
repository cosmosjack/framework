<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/5/19
 * Time: 10:12
 * QQ:  997823131 
 */
defined('InCosmos') or exit('Access Invalid!');?>

<!-- 甜窗 start -->
<link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<!-- 甜窗 end -->

<!-- 甜窗 start -->
<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/plugins/sweetalert/sweetalert.min.js"></script>
<!-- 甜窗 end -->
<script>
    $(function(){

        /* 请求获取当前的类别列表 并根据 $_GET['pid'] 来定义默认父级 start */
        $.ajax({
            url:ApiUrl+"/index.php?act=admin_activity&op=cls_ajax",
            type:"GET",
            success:function(msg){
                console.log(msg);
                if(msg.code == 200){
                    $("#bbs_cls_select").empty();
                    var data = msg.data;
                    $("#bbs_cls_select").append("<option value='0' >顶级分类</option>");
                    for(var i=0;i<data.length;i++){
                        $("#bbs_cls_select").append("<option value='"+data[i]['id']+"' >"+data[i]['cls_name']+"</option>");
                    }


                }
            },
            error:function(){
                console.log("http error");
            }
        });
        /* 请求获取当前的类别列表 并根据 $_GET['pid'] 来定义默认父级 end */

    })
</script>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>类别添加 <small>完善活动类别的信息</small></h5>
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
                        <input type="hidden" name="op" value="cls_add" />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">类别名字</label>
                            <div class="col-sm-8">
                                <input type="text"  class="form-control" value="<?php echo $output['form_data']['address'];?>" name="cls_name"> <span class="help-block m-b-none text-danger">活动类别</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">类别说明</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $output['form_data']['start_from'];?>" name="cls_desc" > <span class="help-block m-b-none text-danger">类别介绍</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">父级选择</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="pid" id="bbs_cls_select">
                                    <option value="0">顶级类别</option>
                                    <option value="1">夏冬令营</option>
                                    <option value="2">城市实践</option>
                                    <option value="3">少年独立团</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">类别图片</label>

                            <div class="col-sm-10">
                                <label>
                                    <input type="file" multiple="multiple" id="input_img" style="display: none;" name="cls_img" value="" onchange="javascript:setImagePreview('input_img','preview','localImage','200px','200px');">
                                    <a style="text-align: center">
                                        <div id="localImage">
                                            <img id="preview" src="<?php echo $output['form_data']['activity_index_pic'] ? $output['form_data']['activity_index_pic'] : BBS_RESOURCE_SITE_URL.DS."bootstrap".DS.'img/vcs.jpg';?>" style="margin:0 auto .1rem;display: block; width: 200px; height: 200px;">
                                        </div>
                                        <h4>选择类别图片 <span style="color: red;">尺寸为 200x200像素</span></h4>
                                        <div style="clear: both;"></div>
                                    </a>
                                </label>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <input type="hidden" name="sub" value="ok" />
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

</body>

</html>
