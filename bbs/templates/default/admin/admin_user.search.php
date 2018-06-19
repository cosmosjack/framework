<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/5/19
 * Time: 9:26
 * QQ:  997823131 
 */
defined('InCosmos') or exit('Access Invalid!');?>

<!-- 甜窗 start -->
<link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<!-- 甜窗 end -->
<!-- 甜窗 start -->
<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/plugins/sweetalert/sweetalert.min.js"></script>
<!-- 甜窗 end -->

<style>
    /* ul li以横排显示 */

    /* 所有class为stand_ul的div中的ul样式 */
    div.stand_ul ul
    {
        list-style:none; /* 去掉ul前面的符号 */
        margin: 0px; /* 与外界元素的距离为0 */
        padding: 0px; /* 与内部元素的距离为0 */
        /*width: auto; *//* 宽度根据元素内容调整 */
    }
    /* 所有class为stand_ul的div中的ul中的li样式 */
    div.stand_ul ul li
    {
        float:left; /* 向左漂移，将竖排变为横排 */
    }
    /* 所有class为stand_ul的div中的ul中的a样式(包括尚未点击的和点击过的样式) */
    div.stand_ul ul li a, div.stand_ul ul li a:visited
    {
        /*background-color: #465c71; *//* 背景色 */
        /*border: 1px #4e667d solid; *//* 边框 */
        color: #337ab7; /* 文字颜色 */
        display: block; /* 此元素将显示为块级元素，此元素前后会带有换行符 */
        line-height: 1.35em; /* 行高 */
        padding: 4px 20px; /* 内部填充的距离 */
        text-decoration: none; /* 不显示超链接下划线 */
        white-space: nowrap; /* 对于文本内的空白处，不会换行，文本会在在同一行上继续，直到遇到 <br> 标签为止。 */
    }
    /* 所有class为stand_ul的div中的ul中的a样式(鼠标移动到元素中的样式) */
    div.stand_ul ul li a:hover
    {
        background-color: #bfcbd6; /* 背景色 */
        color: #465c71; /* 文字颜色 */
        text-decoration: none; /* 不显示超链接下划线 */
    }
    /* 所有class为stand_ul的div中的ul中的a样式(鼠标点击元素时的样式) */
    div.stand_ul ul li a:active
    {
        background-color: #465c71; /* 背景色 */
        color: #cfdbe6; /* 文字颜色 */
        text-decoration: none; /* 不显示超链接下划线 */
    }
    .stand_title{
        font-family: "arial", "微软雅黑";
        font-weight: bolder;
        color: #2e2e2e !important;
    }

</style>

<script>
    function show_child(){
        var child_name = $("input[name='child_name']").val();
        if(!child_name){
            swal({title:"儿童查询",text:"请输入儿童信息",type:"error"});
            return false;
        }

        /* 展现 模态框 并列出 查询出来的儿童 如果没有则提示 start */
        $.ajax({
            url:ApiUrl+"/index.php?act=admin_user&op=get_child_listByName",
            type:"GET",
            data:{'child_name':child_name},
            success:function(msg){
                console.log(msg);
                if(msg.code == 200){
                    /* 展示modal start */
                    $("#group_detail").empty();
                    for(var i=0;i<msg.data.length;i++){
                        $("#group_detail").append('<div class="stand_ul row"><ul class="col-sm-12"> <li class="col-sm-3"><a href="javascript:void(0);">'+msg.data[i].child_name+'</a></li> <li class="col-sm-3"><a href="javascript:void(0);">'+msg.data[i].child_phone+'</a></li> <li class="col-sm-3"><a href="javascript:void(0);">'+msg.data[i].child_age+'</a></li><li class="col-sm-3"><a href='+ApiUrl+'/index.php?act=admin_user&op=search&child_id='+msg.data[i].id+'>查询</a></li></ul></div>');
                    }

                    $("#myModal3").modal("show");
                    /* 展示modal end */
                }else{
                    swal({title:"儿童查询",text:msg.msg,type:"error"});
                }
            },
            error:function(){
                swal({title:"儿童查询",text:"网络出错,请联系网站管理员",type:"error"});
            }
        });
        /* 展现 模态框 并列出 查询出来的儿童 如果没有则提示 end */
    }

    /* 修改儿童的 代理人 start */
    function mod_staff(id,apply_id){
        // 判断 值是否与原来值 相等
        var old_staff = $("input[name='staff']").val();
        var new_staff = $("input[name='new_staff_"+apply_id+"']").val();
        console.log(new_staff);
        console.log(id);
        if(new_staff && (new_staff != old_staff)){
            $.ajax({
                url:ApiUrl+"/index.php?act=admin_user&op=mod_child_staff",
                type:"GET",
                data:{"id":id,"staff":new_staff},
                success:function(msg){
                    console.log(msg);
                    swal({title:"儿童查询",text:msg.msg,type:"success"});
                },
                error:function(){
                }

            });
        }else{
            swal({title:"代理人修改",text:"无任何修改",type:"error"});
        }
    }
    /* 修改儿童的 代理人 end */
</script>

<body class="gray-bg">
<h2 align="center">儿童搜索功能</h2>
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="row">
        <div class="col-sm-12">

            <div class="ibox">
                <div class="ibox-title">
                    <input type="hidden" name="staff" value="<?php echo $output['data_child']['staff'];?>" />
                    <h5>显示儿童所参加过的活动</h5>
                    <div class="ibox-tools">
<!--                        <a href="projects.html" class="btn btn-primary btn-xs">创建新项目</a>-->
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-1">
                            <button type="button" id="loading-example-btn" class="btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
                        </div>
                        <div class="col-md-11">
                            <div class="input-group">
                                <input type="text" name="child_name" placeholder="请输入儿童名字" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" onclick="show_child();" class="btn btn-sm btn-primary"> 搜索</button> </span>
                            </div>
                        </div>
                    </div>

                    <div class="project-list">

                        <table class="table table-hover">
                            <tbody>
                            <?php foreach ($output['data_apply'] as $key=>$val){?>
                                <tr>
                                    <td class="project-status">
                                            <span class="label label-primary"><?php echo $val['child_name'];?><span>
                                    </td>
                                    <td class="project-title">
                                        <a><?php echo $val['activity_title'];?></a>
                                        <br/>
                                        <small>申请于 <?php echo date("y-m-d H:i:s",$val['apply_time']);?></small>
                                    </td>
                                    <td class="project-completion">
                                        <small>活动期数： <label class="btn btn-sm btn-danger">第<?php echo $val['activity_periods'];?>期</label></small>
                                    </td>
                                    <td>
                                        <span>儿童电话:</span><a><?php echo $val['child_phone'];?></a>
                                    </td>
                                    <td class="project-people">
                                        <a href=""><img alt="image" class="img-circle" src="<?php echo $val['child_headimgurl'];?>"></a>
                                        <a href=""><img alt="image" class="img-circle" src="<?php echo $val['parents_headimgurl'];?>"></a>
                                    </td>
                                    <td>
                                        <span>客服专员:</span> <input type="text" name="new_staff_<?php echo $val['id'];?>" value="<?php echo $output['data_child']['staff'];?>"/>
                                    </td>
                                    <td class="project-actions">

                                        <a onclick="mod_staff(<?php echo $val['child_id'];?>,<?php echo $val['id'];?>)" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 设置 </a>
                                    </td>
                                </tr>
                            <?}?>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12 pagination">
                        <?php echo $output['fpage'];?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="myModal3" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">儿童搜索</h4>
                <small class="font-bold">搜索出来的儿童列表</small>
            </div>
            <div class="modal-body">
                <div class="stand_ul row">
                    <ul class="col-sm-12">
                        <li class="col-sm-3"><a class="stand_title" href="javascript:void(0);">参赛儿童</a></li>
                        <li class="col-sm-3"><a class="stand_title" href="javascript:void(0);">儿童电话</a></li>
                        <li class="col-sm-3"><a class="stand_title" href="javascript:void(0);">儿童年龄</a></li>
                        <li class="col-sm-3"><a class="stand_title" href="javascript:void(0);">操作</a></li>
                    </ul>
                </div>

                <div id="group_detail">

                </div>

                <!--<div class="stand_ul row">
                    <ul class="col-sm-12">
                        <li class="col-sm-3"><a href="javascript:void(0);">小鹏</a></li>
                        <li class="col-sm-3"><a href="javascript:void(0);">13838838438</a></li>
                        <li class="col-sm-3"><a href="javascript:void(0);">大鹏</a></li>
                        <li class="col-sm-3"><a href="javascript:void(0);">查询</a></li>
                    </ul>
                </div>
                <div class="stand_ul row">
                    <ul class="col-sm-12">
                        <li class="col-sm-3"><a href="javascript:void(0);">小李</a></li>
                        <li class="col-sm-3"><a href="javascript:void(0);">15535566458</a></li>
                        <li class="col-sm-3"><a href="javascript:void(0);">老李</a></li>
                        <li class="col-sm-3"><a href="javascript:void(0);">查询</a></li>
                    </ul>
                </div>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                <!--                <button type="button" class="btn btn-primary">保存s</button>-->
            </div>
        </div>
    </div>
</div>

</body>
</html>
