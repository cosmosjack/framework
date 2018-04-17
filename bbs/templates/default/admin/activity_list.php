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
<!-- 甜窗 start -->
<link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<!-- 甜窗 end -->

<!-- 选择器插件 start -->
<link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/plugins/chosen/chosen.css" rel="stylesheet">
<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/plugins/chosen/chosen.jquery.js"></script>
<!-- 选择器插件 end -->

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

    /* 展示当前的小组  start */
    function show_team(activity_no,periods){
        // 获取 选择的活动的组 情况
        $.ajax({
            url:"<?php echo BBS_SITE_URL.DS.'index.php?act=admin_activity&op=calc_group';?>",
            type:"GET",
            data:{"activity_no":activity_no,"periods":periods},//活动的no
            success:function(msg){
                console.log(msg);
                if(msg.code == 200){
                    //清除当前有的 数据
                    $("#group_info").empty();
                    var d = msg.data;
                    for(var i=0;i<d.length;i++){
                        var teacher_name = d[i]['teacher_name'] ? d[i]['teacher_name'] : "暂无领队";
                        var teacher_phone = d[i]['teacher_phone'] ? d[i]['teacher_phone'] : "暂无电话";
                        $("#group_info").append('<div class="stand_ul row"><ul class="col-sm-12"> <li class="col-sm-2"><a href="javascript:void(0);">'+d[i]['group_id']+'号小组</a></li> <li class="col-sm-2"><a href="javascript:void(0);">'+d[i]['total_num']+'人</a></li> <li class="col-sm-3"><a href="javascript:void(0);">'+teacher_name+'</a></li> <li class="col-sm-3"><a href="javascript:void(0);">'+teacher_phone+'</a></li> <li class="col-sm-2"><button onclick="show_team_detail('+d[i]['group_id']+',\''+d[i]['activity_no']+'\','+d[i]['activity_periods']+');" class="btn btn-sm btn-primary">分配</button></li> </ul> </div>');
                    }
                    // 自动分组 添加上相应的 活动ID
                    $("#auto_group_btn").attr("index",activity_no);
                    $("#auto_group_btn").attr("periods",periods);

                    $("#hands_add_btn").attr("index",activity_no);
                    $("#hands_add_btn").attr("periods",periods);
                    $("#myModal2").modal("show");

                }else{
                    swal({title:"小组信息",text:msg.msg,type:"error"});
                    return false;
                }

            },
            error:function(){
                swal({title:"小组信息",text:"网络请求出错",type:"error"});
                console.log("http error");
            }
        });

    }
    /* 展示当前的小组  end */

    /* 展示详细的小组情况 start */
    function show_team_detail(group_id,activity_no,activity_periods){
        console.log('group_id:'+group_id+"activity_no:"+activity_no+"activity_periods"+activity_periods);
        $.ajax({
            url:"<?php echo BBS_SITE_URL.DS."index.php?act=admin_activity&op=get_team_detail";?>",
            type:"GET",
            data:{"group_id":group_id,"activity_no":activity_no,"activity_periods":activity_periods},
            success:function(msg){
                console.log(msg);
                if(msg.code == 200){
                    $("#group_detail").empty();
                    var d = msg.data;
                    for(var i = 0;i< d.length;i++){
                        $("#group_detail").append('<div class="stand_ul row"><ul class="col-sm-12"> <li class="col-sm-3"><a href="javascript:void(0);">'+d[i]['child_name']+'</a></li> <li class="col-sm-3"><a href="javascript:void(0);">'+d[i]['child_phone']+'</a></li> <li class="col-sm-3"><a href="javascript:void(0);">'+d[i]['parents_name']+'</a></li> <li class="col-sm-3"><a href="javascript:void(0);">'+d[i]['parents_phone']+'</a></li> </ul></div>');
                    }
                    //改变 model3 里边的 activity_no
                    $("input[name='activity_no']").val(activity_no);
                    $("input[name='periods']").val(activity_periods);
                    $("input[name='group_id']").val(group_id);
                    $("#myModal3").modal("show");
                }else{
                    swal({title:group_id+"号小组信息",text:msg.msg,type:"error"});

                }

            },
            error:function(){
                swal({title:group_id+"号小组信息",text:"网络请求出错",type:"error"});

                console.log("http error");
            }
        });

    }
    /* 展示详细的小组情况 end */
    // 更换老师
    function change_teacher(){
       /* var group_id =  $("input[name='group_id']").val();
        var activity_id = $("input[name='activity_no']").val();*/

        $.ajax({
            url:"<?php echo BBS_SITE_URL.DS.'index.php?act=admin_activity&op=get_teacher_list';?>",
            type:"GET",
            data:{},
            success:function(msg){
                if(msg.code == 200){

                    $("#model4_btn").attr("state",'teacher');
                    // 改变 modal4 里边的 值
                    $("#select_change").empty();
                    var d = msg.data;
                    for(var i = 0;i< d.length;i++){
                        var teacher_name = d[i]['nick_name'] ? d[i]['nick_name'] : d[i]['member_name'];
                        $("#select_change").append('<option value="'+d[i]['id']+'" hassubinfo="true">'+teacher_name+'</option>');
                    }

                    $("#select_change").chosen("destroy");
                    $("#select_change").chosen();

                    $("#myModal4").modal("show");
                }else{
                    swal({title:"更换领队",text:msg.msg,type:"error"});
                }
                console.log(msg);
            },
            error:function(){
                swal({title:"更换领队",text:"网络请求出错",type:"error"});
                console.log("http error");
            }
        });

    }

    // 自动分组
    function auto_group(e){
        console.log($(e).attr('index')); //activity_id
    }

    /* 添加小组成员 start */
    function add_child(){
        //先 获取可以添加的成员
        var group_id =  $("input[name='group_id']").val();//小组ID
        var activity_no = $("input[name='activity_no']").val();//活动ID
        $.ajax({
            url:"<?php echo BBS_SITE_URL.DS.'index.php?act=admin_activity&op=get_other_child';?>",
            type:"GET",
            data:{"group_id":group_id,"activity_no":activity_no},
            success:function(msg){
                console.log(msg);
                if(msg.code == 200){
                    $("#model4_btn").attr("state",'add_child');
                    // 改变 modal4 里边的 值
                    $("#select_duo").empty();
                    var d = msg.data;
                    for(var i = 0;i< d.length;i++){
                        $("#select_duo").append('<option value="'+d[i]['id']+'" hassubinfo="true">'+d[i]['child_name']+'</option>');
                    }
                    // 创建 chosen 对象
                    $("#select_duo").chosen("destroy");
                    $("#select_duo").chosen({allow_single_deselect:!0});
                    $("#myModal5").modal("show");
                }else{
                    swal({title:"添加小组成员",text:msg.msg,type:"error"});
                }

            },
            error:function(){
                swal({title:"添加小组成员",text:"网络请求出错",type:"error"});

                console.log("http error");
            }
        });



    }
    /* 添加小组成员 end */

    // 手动添加分组
    function hands_add_group(e){
        console.log($(e).attr('index'));
        var id = $(e).attr('index'); //activity_id
        // 手动添加时 需要查出 当前 哪些小组是大于 1个人的  然后把这些小组 的  信息数组列出来  且只能选择一个人 然后在到 小组详情里添加成员
        $.ajax({
            url:"<?php echo BBS_SITE_URL.DS."index.php?act=admin_activity&op=list_group_info";?>",
            type:"GET",
            data:{"id":id},
            success:function(msg){
                console.log(msg);
                if(msg.code == 200){
                    // 改变 model4_btn  的state 状态为 添加小组
                    $("#model4_btn").attr("state","add_group");

                    // 改变 modal4 里边的 值
                    $("#select_change").empty();
                    var d = msg.data;
                    for(var i=0;i< d.length;i++){
                        $("#select_change").append('<option value="'+d[i]['id']+'" hassubinfo="true">'+d[i]['child_name']+'</option>');
                    }
                    // 创建 chosen 对象
                    $("#select_change").chosen("destroy");
                    $("#select_change").chosen({});
                    $("#myModal4").modal("show");
                }else{
                    swal({title:"小组信息",text:msg.msg,type:"error"});
                    return false;
                }

            },
            error:function(){
                swal({title:"小组信息",text:"网络请求出错",type:"error"});
                console.log("http error");
            }
        });

    }

    /* 修改活动小组的信息 start */
    // 这里是 修改老师 和学生的信息
    function mod_activity(e){

        var mod_state = $("#model4_btn").attr("state");
        console.log(mod_state);
        var chosen_val = $("#select_change").val(); // 选择的学生 或老师
//        return false;
        if(mod_state == 'teacher'){

            var group_id =  $("input[name='group_id']").val();//小组ID
            var activity_no = $("input[name='activity_no']").val();//活动no
            var periods = $("input[name='periods']").val();//活动 periods
            // 根据选择
            $.ajax({
                url:"<?php echo BBS_SITE_URL.DS.'index.php?act=admin_activity&op=change_teacher';?>",
                type:"GET",
                data:{"group_id":group_id,"activity_no":activity_no,"teacher_id":chosen_val,"periods":periods},
                success:function(msg){
                    console.log(msg);
                    if(msg.code == 200){

                        $("#myModal2").modal("hide");
                        $("#myModal4").modal("hide");

                        swal({title:"更改领队",text:"领队已更换,请刷新查看",type:"success"});

                    }else{
                        swal({title:"更改领队",text:msg.msg,type:"error"});
                        return false;
                    }
                },
                error:function(){
                    swal({title:"更改领队",text:"网络请求出错",type:"error"});
                    console.log("http error");
                }
            });

        }else if(mod_state == 'add_child'){
            // 将其他小组的成员添加到 这个小组里边
            var group_id =  $("input[name='group_id']").val();//小组ID
            var activity_no = $("input[name='activity_no']").val();//活动no
            var periods = $("input[name='periods']").val();//活动期数
            var child_arr = $("#select_duo").val();
            console.log(child_arr); //选择的其他学员
            $.ajax({
                url:"<?php echo BBS_SITE_URL.DS.'index.php?act=admin_activity&op=mod_child_group';?>",
                type:"GET",
                data:{"group_id":group_id,"child_arr":child_arr,"activity_no":activity_no},
                success:function(msg){
                    console.log(msg);
                    if(msg.code == 200){
                        $("#myModal5").modal("hide");
                        $("#myModal3").modal("hide");
                        $("#myModal2").modal("hide");
                        swal({title:"添加成员",text:"成员已添加,请刷新查看",type:"success"});

                    }else{
                        swal({title:"添加小组成员",text:msg.msg,type:"error"});
                        return false;
                    }
                },
                error:function(){
                    swal({title:"添加成员",text:"网络请求出错",type:"error"});
                    console.log("http error");
                }
            });
            // 直接将其他apply_id  改变为 group_id

//            console.log("group_id"+group_id+"activity_id"+activity_id+"child_arr"+child_arr);

        }else if(mod_state == 'add_group'){
            // 手动添加一个新的小组  根据选择的 apply_id  来添加一个新的小组  查出当前小组的最大数
            var apply_id  = $("#select_change").val();
            $.ajax({
                url:"<?php echo BBS_SITE_URL.DS.'index.php?act=admin_activity&op=add_new_group';?>",
                type:"GET",
                data:{"apply_id":apply_id},
                success:function(msg){
                    console.log(msg);
                    if(msg.code == 200){
                        $("#myModal4").modal("hide");
                        $("#myModal2").modal("hide");
                        swal({title:"小组添加",text:"小组已添加,请刷新查看",type:"success"});

                    }else{
                        swal({title:"添加小组",text:msg.msg,type:"error"});
                        return false;
                    }
                },
                error:function(){
                    swal({title:"添加小组",text:"网络请求出错",type:"error"});
                    console.log("http error");
                }

            });
        }
    }
    /* 修改活动小组的信息 end */

    /* 添加期数 start */
    function add_periods(activity_no,periods){
        location.href = "<?php echo BBS_SITE_URL.DS.'index.php?act=admin_activity&op=add_new_periods&activity_no=';?>"+activity_no+"&periods="+periods;
    }
    /* 添加期数 end */

    /* 展示其他期数列表 start */
    function show_periods(activity_no){
        location.href = "<?php echo BBS_SITE_URL.DS.'index.php?act=admin&op=activity_list&is_periods=true&activity_no=';?>"+activity_no;
    }
    /* 展示其他期数列表 end */

    /* 修改活动的内容 start */
    function change_activity(activity_no,periods){
        location.href = "<?php echo BBS_SITE_URL.DS.'index.php?act=admin_activity&op=mod_activity&activity_no=';?>"+activity_no+"&periods="+periods;
    }
    /* 修改活动的内容 end */
</script>

<div class="wrapper wrapper-content animated fadeInUp">
    <div class="row">
        <div class="col-sm-12">

            <div class="ibox">
                <div class="ibox-title">
                    <h5><? if($output['is_periods']){echo '活动期数列表';}else{echo "活动列表";};?></h5>
                    <div class="ibox-tools">
                        <?php if($output['is_periods']){?>
                            <a href="<?php echo BBS_SITE_URL.DS.'index.php?act=admin&op=activity_list';?>" class="btn btn-success btn-xs">返回活动列表</a>
                        <?}?>
                        <a href="<?php echo BBS_SITE_URL.DS.'index.php?act=admin&op=activity_add';?>" class="btn btn-primary btn-xs">发布新活动</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-1">
                            <button type="button" id="loading-example-btn" class="btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
                        </div>
                        <div class="col-md-11">
                            <div class="input-group">
                                <input type="text" placeholder="请输入活动名称" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary"> 搜索</button> </span>
                            </div>
                        </div>
                    </div>

                    <div class="project-list">

                        <table class="table table-hover">
                            <tbody>
                            <?php foreach($output['data_bbs_activity'] as $key=>$val){?>
                                <tr>
                                    <td class="project-status">
                                        <span class="label  <?php if($val['state'] == '进行中'){echo "label-primary";}elseif($val['state'] == '已结束'){echo "label-default";}elseif($val['state'] == '未开始'){echo "label-danger";}?>"><?php echo $val['state'];?></span>
                                    </td>
                                    <td class="project-title">
                                        <a href="project_detail.html"><?php echo $val['activity_title'];?></a>
                                        <br/>
                                        <small>发布于 <?php echo date("Y-m-d H:i:s",$val['activity_add_time']);?> </small>
                                    </td>

                                    <td class="project-time">
                                        <span class="text-success"><?php echo date("Y-m-d",$val['activity_begin_time']);?>早 <small style="color: #8b0000;margin-left: 5px;margin-right: 5px;">至</small>  <?php echo date("Y-m-d",$val['activity_end_time']);?>晚 </span>
                                    </td>

                                    <td class="project-completion">
                                        <small>当前进度： <?php echo $val['percent'];?>% </small><small style="margin-left: 10px;" class="text-success">总人数:<?php echo $val['total_number'];?></small>
                                        <div class="progress progress-mini">
                                            <div style="width: <?php echo $val['percent'];?>%;" class="progress-bar"></div>
                                        </div>

                                    </td>

                                    <td class="project-people">
                                        <?php /*if(!empty($val['teacher_arr'])){*/?><!--
                                            <?php /*foreach($val['teacher_arr'] as $k=>$v){*/?>
                                                <a onclick="show_team('<?php /*echo $val['activity_no'];*/?>','<?php /*echo $val['activity_periods'];*/?>');" ><img alt="image" class="img-circle" src="<?php /*echo $v['headimgurl'];*/?>"></a>
                                                <a href=""><img alt="image" class="img-circle" src="<?php /*echo BBS_RESOURCE_SITE_URL.DS."bootstrap".DS;*/?>img/a3.jpg"></a>
                                            <?php /*}*/?>
                                        <?php /*}else{*/?>
                                            <a onclick="show_team('<?php /*echo $val['activity_no'];*/?>','<?php /*echo $val['activity_periods'];*/?>');" ><span class="text-danger">没有领队老师</span></a>
                                        --><?php /*}*/?>
                                        <a onclick="show_team('<?php echo $val['activity_no'];?>','<?php echo $val['activity_periods'];?>');" ><span class="text-danger">查看队伍</span></a>
                                        <span class="text-success">第<?php echo $val['activity_periods'];?>期</span>
                                    </td>
                                    <td class="project-actions">

                                        <a href="#" onclick="add_periods('<?php echo $val['activity_no'];?>','<?php echo $val['activity_periods'];?>');" class="btn btn-primary btn-sm"><i class="fa fa-folder"></i> 加期 </a>
                                        <a href="#" onclick="show_periods('<?php echo $val['activity_no'];?>','<?php echo $val['activity_periods'];?>');" class="btn btn-danger btn-sm"><i class="fa fa-folder"></i> 期数 </a>
                                        <?php if($val['state'] == '未开始'){ ?>
                                            <a href="#" onclick="change_activity('<?php echo $val['activity_no'];?>','<?php echo $val['activity_periods'];?>');" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
                                        <?php }?>
                                    </td>
                                </tr>
                            <?php }?>


                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12 pagination ">
                        <?php echo $output['fpage'];?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal inmodal" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">活动分组</h4>
                <small class="font-bold">当前活动的小组安排</small>
            </div>
            <div class="modal-body" >
                <div class="stand_ul row">
                    <ul class="col-sm-12">
                        <li class="col-sm-2"><a class="stand_title" href="javascript:void(0);">小组ID</a></li>
                        <li class="col-sm-2"><a class="stand_title" href="javascript:void(0);">当前人数</a></li>
                        <li class="col-sm-3"><a class="stand_title" href="javascript:void(0);">领队老师</a></li>
                        <li class="col-sm-3"><a class="stand_title" href="javascript:void(0);">老师电话</a></li>
                        <li class="col-sm-2"><a class="stand_title" href="javascript:void(0);">操作</a></li>
                    </ul>
                </div>

                <div id="group_info">

                </div>

                <!--<div class="stand_ul row">
                    <ul class="col-sm-12">
                        <li class="col-sm-2"><a href="javascript:void(0);">2号小组</a></li>
                        <li class="col-sm-2"><a href="javascript:void(0);">5人</a></li>
                        <li class="col-sm-3"><a href="javascript:void(0);">张三丰</a></li>
                        <li class="col-sm-3"><a href="javascript:void(0);">18825466506</a></li>
                        <li class="col-sm-2"><button onclick="show_team_detail();" class="btn btn-sm btn-primary">分配</button></li>
                    </ul>
                </div>-->


            </div>
            <div class="modal-footer">
<!--                <button type="button" class="btn btn-success pull-left" onclick="auto_group(this);" id="auto_group_btn" index="0" periods="0">自动分组</button>-->
                <button type="button" class="btn btn-danger pull-left" onclick="hands_add_group(this)" id="hands_add_btn" index="0" periods="0">新增小组</button>
                <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">确认</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="myModal3" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">1号小组详情</h4>
                <small class="font-bold">某某活动1号小组参赛人员详情</small>
            </div>
            <div class="modal-body">
                <div class="stand_ul row">
                    <ul class="col-sm-12">
                        <li class="col-sm-3"><a class="stand_title" href="javascript:void(0);">参赛儿童</a></li>
                        <li class="col-sm-3"><a class="stand_title" href="javascript:void(0);">儿童电话</a></li>
                        <li class="col-sm-3"><a class="stand_title" href="javascript:void(0);">监护人</a></li>
                        <li class="col-sm-3"><a class="stand_title" href="javascript:void(0);">监护人电话</a></li>
                    </ul>
                </div>

                <div id="group_detail">

                </div>

                <!--<div class="stand_ul row">
                    <ul class="col-sm-12">
                        <li class="col-sm-3"><a href="javascript:void(0);">小鹏</a></li>
                        <li class="col-sm-3"><a href="javascript:void(0);">13838838438</a></li>
                        <li class="col-sm-3"><a href="javascript:void(0);">大鹏</a></li>
                        <li class="col-sm-3"><a href="javascript:void(0);">18825466506</a></li>
                    </ul>
                </div>
                <div class="stand_ul row">
                    <ul class="col-sm-12">
                        <li class="col-sm-3"><a href="javascript:void(0);">小李</a></li>
                        <li class="col-sm-3"><a href="javascript:void(0);">15535566458</a></li>
                        <li class="col-sm-3"><a href="javascript:void(0);">老李</a></li>
                        <li class="col-sm-3"><a href="javascript:void(0);">18825466506</a></li>
                    </ul>
                </div>-->
            </div>
            <div class="modal-footer">
                <button type="button" onclick="add_child();" class="btn btn-danger pull-left">添加成员</button>
                <input type="hidden" name="activity_no" value="0" />
                <input type="hidden" name="periods" value="0" />
                <input type="hidden" name="group_id" value="0" />
                <button type="button" class="btn btn-success pull-left" onclick="change_teacher();" >更换领队</button>
                <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
<!--                <button type="button" class="btn btn-primary">保存s</button>-->
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight row">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">领队更改</h4>
                <small class="font-bold">更改某某活动1号小组领队老师</small>
            </div>

            <div class="row">

                <div class="col-sm-12">

                    <div class="ibox float-e-margins">

                        <div class="ibox-content">

                            <div class="form-group">
<!--                                <label class="font-noraml">领队老师</label>-->
                                <div class="input-group" style="margin-left: 250px">
                                    <select id="select_change" data-placeholder="选择领队..." class="chosen-select" style="width:350px !important;" tabindex="2">
                                        <option value="">请选择老师</option>
                                        <option value="110000" hassubinfo="true">赵子龙</option>
                                        <option value="120000" hassubinfo="true">张飞</option>
                                        <option value="130000" hassubinfo="true">吴用</option>
                                        <option value="140000" hassubinfo="true">诸葛亮</option>
                                        <option value="150000" hassubinfo="true">猪八戒</option>
                                        <option value="210000" hassubinfo="true">蝎子精</option>
                                        <option value="220000" hassubinfo="true">德玛</option>
                                        <option value="230000" hassubinfo="true">妖姬</option>
                                        <option value="310000" hassubinfo="true">章鱼怪</option>
                                        <option value="320000" hassubinfo="true">艾克</option>
                                        <option value="330000" hassubinfo="true">科比</option>
                                        <option value="340000" hassubinfo="true">勒布朗</option>
                                        <option value="350000" hassubinfo="true">霍金</option>
                                        <option value="360000" hassubinfo="true">江西省</option>
                                        <option value="370000" hassubinfo="true">山东省</option>
                                        <option value="410000" hassubinfo="true">河南省</option>
                                        <option value="420000" hassubinfo="true">湖北省</option>
                                        <option value="430000" hassubinfo="true">湖南省</option>
                                        <option value="440000" hassubinfo="true">广东省</option>
                                        <option value="450000" hassubinfo="true">广西壮族自治区</option>
                                        <option value="460000" hassubinfo="true">海南省</option>
                                        <option value="500000" hassubinfo="true">重庆</option>
                                        <option value="510000" hassubinfo="true">四川省</option>
                                        <option value="520000" hassubinfo="true">贵州省</option>
                                        <option value="530000" hassubinfo="true">云南省</option>
                                        <option value="540000" hassubinfo="true">西藏自治区</option>
                                        <option value="610000" hassubinfo="true">陕西省</option>
                                        <option value="620000" hassubinfo="true">甘肃省</option>
                                        <option value="630000" hassubinfo="true">青海省</option>
                                        <option value="640000" hassubinfo="true">宁夏回族自治区</option>
                                        <option value="650000" hassubinfo="true">新疆维吾尔自治区</option>
                                        <option value="710000" hassubinfo="true">台湾省</option>
                                        <option value="810000" hassubinfo="true">香港特别行政区</option>
                                        <option value="820000" hassubinfo="true">澳门特别行政区</option>
                                        <option value="990000" hassubinfo="true">海外</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                <button type="button" state="teacher" id="model4_btn" onclick="mod_activity(this);" class="btn btn-primary">确认</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="myModal5" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight row">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">成员添加</h4>
                <small class="font-bold">添加小组的成员</small>
            </div>

            <div class="row">

                <div class="col-sm-12">

                    <div class="ibox float-e-margins">

                        <div class="ibox-content">

                            <div class="form-group">
                                <!--                                <label class="font-noraml">领队老师</label>-->
                                <div class="input-group" style="margin-left: 250px">
                                    <select id="select_duo" data-placeholder="选择领队..." class="chosen-select" multiple style="width:350px !important;" tabindex="1">
                                        <option value="">请选择老师</option>
                                        <option value="110000" hassubinfo="true">赵子龙</option>
                                        <option value="120000" hassubinfo="true">张飞</option>
                                        <option value="130000" hassubinfo="true">吴用</option>
                                        <option value="140000" hassubinfo="true">诸葛亮</option>
                                        <option value="150000" hassubinfo="true">猪八戒</option>
                                        <option value="210000" hassubinfo="true">蝎子精</option>
                                        <option value="220000" hassubinfo="true">德玛</option>
                                        <option value="230000" hassubinfo="true">妖姬</option>
                                        <option value="310000" hassubinfo="true">章鱼怪</option>
                                        <option value="320000" hassubinfo="true">艾克</option>
                                        <option value="330000" hassubinfo="true">科比</option>
                                        <option value="340000" hassubinfo="true">勒布朗</option>
                                        <option value="350000" hassubinfo="true">霍金</option>
                                        <option value="360000" hassubinfo="true">江西省</option>
                                        <option value="370000" hassubinfo="true">山东省</option>
                                        <option value="410000" hassubinfo="true">河南省</option>
                                        <option value="420000" hassubinfo="true">湖北省</option>
                                        <option value="430000" hassubinfo="true">湖南省</option>
                                        <option value="440000" hassubinfo="true">广东省</option>
                                        <option value="450000" hassubinfo="true">广西壮族自治区</option>
                                        <option value="460000" hassubinfo="true">海南省</option>
                                        <option value="500000" hassubinfo="true">重庆</option>
                                        <option value="510000" hassubinfo="true">四川省</option>
                                        <option value="520000" hassubinfo="true">贵州省</option>
                                        <option value="530000" hassubinfo="true">云南省</option>
                                        <option value="540000" hassubinfo="true">西藏自治区</option>
                                        <option value="610000" hassubinfo="true">陕西省</option>
                                        <option value="620000" hassubinfo="true">甘肃省</option>
                                        <option value="630000" hassubinfo="true">青海省</option>
                                        <option value="640000" hassubinfo="true">宁夏回族自治区</option>
                                        <option value="650000" hassubinfo="true">新疆维吾尔自治区</option>
                                        <option value="710000" hassubinfo="true">台湾省</option>
                                        <option value="810000" hassubinfo="true">香港特别行政区</option>
                                        <option value="820000" hassubinfo="true">澳门特别行政区</option>
                                        <option value="990000" hassubinfo="true">海外</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                <button type="button" state="teacher"  onclick="mod_activity(this);" class="btn btn-primary">确认</button>
            </div>
        </div>
    </div>
</div>


<script>
//    var config={
//        ".chosen-select":{},
////        ".chosen-select-deselect":{allow_single_deselect:!0},
////        ".chosen-select-no-single":{disable_search_threshold:10},
////        ".chosen-select-no-results":{no_results_text:"Oops, nothing found!"},
////        ".chosen-select-width":{width:"95%"}
//    };
//    for(var selector in config)$(selector).chosen(config[selector]);
var select_chose = $("#select_change").chosen();
var select_chose = $("#select_duo").chosen();

//console.log(select_chose);

</script>


