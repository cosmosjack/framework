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
<style>
    .auto_li{
        margin-left: 60px;
        font-weight: bold;
    }
</style>
<script>
    /* 展示监护人 start */
    function show_parent(id){
        var parent_json = $("input[name='parent_arr"+id+"']").val();
        var parent_obj = JSON.parse(parent_json);
        console.log(parent_obj);
        $("#order_modal_body").empty();
        $("#order_modal_title").text("儿童详细信息");
//        $("#order_modal_body").append('<ul class="list-group" id="child_info"><li style="background-color: #f7b6b6;" class="list-group-item"><span class="auto_li">儿童姓名</span><span class="auto_li">儿童电话</span><span class="auto_li">儿童性别</span><span class="auto_li">儿童年龄</span></li></ul>');
        for(var i=0;i<parent_obj.length;i++){
            $("#order_modal_body").append('<div class="col-sm-4"><div class="contact-box"> <a href="javascript:;"> <div class="col-sm-12"> <div class="text-center"> <img alt="image" class="img-circle m-t-xs img-responsive" src="'+parent_obj[i]['img']+'"> <div class="m-t-xs font-bold">'+parent_obj[i]['name']+'</div><div class="m-t-xs font-bold">'+parent_obj[i]['phone']+'</div> </div> </div> <div class="clearfix"></div> </a> </div> </div>');
        }
        $("#myModal2").modal('show');

        $("#myModal2").modal('show');
    }
    /* 展示监护人 start */
    /* 展示儿童信息 start */
    function show_child(id){
        var child_json = $("input[name='child_arr"+id+"']").val();
        var child_obj = JSON.parse(child_json);
        console.log(child_obj);
        $("#order_modal_body").empty();
        $("#order_modal_title").text("儿童详细信息");
//        $("#order_modal_body").append('<ul class="list-group" id="child_info"><li style="background-color: #f7b6b6;" class="list-group-item"><span class="auto_li">儿童姓名</span><span class="auto_li">儿童电话</span><span class="auto_li">儿童性别</span><span class="auto_li">儿童年龄</span></li></ul>');
        for(var i=0;i<child_obj.length;i++){
            $("#order_modal_body").append('<div class="col-sm-4"><div class="contact-box"> <a href="javascript:;"> <div class="col-sm-12"> <div class="text-center"> <img alt="image" class="img-circle m-t-xs img-responsive" src="'+child_obj[i]['img']+'"> <div class="m-t-xs font-bold">'+child_obj[i]['name']+'</div> <div class="m-t-xs font-bold">'+child_obj[i]['phone']+'</div></div> </div> <div class="clearfix"></div> </a> </div> </div>');
        }
        $("#myModal2").modal('show');

    }
    /* 展示儿童信息 end */

    /* 修改订单价格 start */
    function mod_order(id,price){
        console.log(id);
        console.log(price);
        $("input[name='order_id']").val(id);
        $("input[name='order_amount']").val(price);
        $("#mod_info").attr('action',ApiUrl+'/index.php');
        $("#myModal3").modal('show');
    }
    /* 修改订单价格 end */

    /* 订单搜索 start */
    function order_search(){
        var activity_title = $("input[name='activity_title']").val();
        var order_state = $("select[name='order_state']").val();
        console.log(order_state);
        console.log(activity_title);
        location.href = ApiUrl+'/index.php?act=admin&op=order_list&order_state='+order_state+'&activity_title='+activity_title;
    }
    /* 订单搜索 end */

    /* 订单导出 start */
    function order_excel(){
        var activity_title = $("input[name='activity_title']").val();
        var order_state = $("select[name='order_state']").val();
        console.log(order_state);
        console.log(activity_title);
        location.href = ApiUrl+'/index.php?act=admin_order&op=order_excel&order_state='+order_state+'&activity_title='+activity_title;
    }
    /* 订单导出 end */
</script>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>订单列表</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="table_data_tables.html#">选项1</a>
                            </li>
                            <li><a href="table_data_tables.html#">选项2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <input type="phone" name="activity_title" value="<?php echo $_GET['activity_title'];?>" placeholder="活动标题" class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" id="order_state" name="order_state">
                                <option value="1">未付款</option>
                                <option value="2">付款未参加</option>
                                <option value="3">已参加</option>
                                <option value="4">退款中</option>
                                <option value="5">已退款</option>
                                <option value="6">已取消</option>
                            </select>
                        </div>
                        <label class="col-sm-1 control-label btn btn-primary" onclick="order_search();">搜索</label>
                        <label class="col-sm-1 control-label btn btn-success" onclick="window.location.href = ApiUrl+'/index.php?act=admin&op=order_list';">重置</label>
                        <label class="col-sm-1 control-label btn btn-danger pull-right" onclick="order_excel();">导出</label>
                    </div>

                    <table class="table table-striped table-bordered table-hover " id="editable">
                        <thead>
                        <tr>
                            <th>订单号</th>
                            <th>活动标题</th>
                            <th>活动ID</th>
                            <th>活动期数</th>
                            <th>活动时间</th>
                            <th>购买会员ID</th>
                            <th>会员名称</th>
                            <th>票数</th>
                            <th>儿童详情</th>
                            <th>监护人</th>
                            <th>备注</th>
                            <th>订单金额</th>
                            <th>下单时间</th>
                            <th>订单状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($output['data_bbs_activity'] as $key=>$val){?>
                            <tr class="gradeX">
                                <td><?php echo $val['id'];?></td>
                                <td><?php echo $val['activity_title'];?></td>
                                <td><?php echo $val['activity_no'];?></td>
                                <td class="center"><?php echo $val['activity_periods'];?></td>
                                <td class="center"><?php echo $val['activity_time'];?></td>
                                <td><?php echo $val['member_id'];?></td>
                                <td><?php echo $val['member_name'];?></td>
                                <td><?php echo $val['order_num'];?></td>
                                <td class="center"><?php
                                    $child_arr = unserialize($val['childs_arr']);
                                    echo '<input type="hidden" name="child_arr'.$val['id'].'" value='.json_encode($child_arr).'>';
                                    echo '<label onclick="show_child('.$val['id'].');" class="btn btn-success btn-sm">儿童信息</label>';
                                    ?></td>
                                <td class="center"><?php
                                    $parents_arr = unserialize($val['parents_arr']);
                                    echo '<input type="hidden" name="parent_arr'.$val['id'].'" value='.json_encode($parents_arr).'>';
                                    echo '<label onclick="show_parent('.$val['id'].');" class="btn btn-success btn-sm">监护人</label>';
                                    ?></td>
                                <td class="center"><?php echo $val['remark'];?></td>
                                <td class="center"><?php echo $val['order_amount'];?></td>
                                <td class="center"><?php echo date("Y-m-d H:i:s",$val['order_time']);?></td>
                                <td class="center"><?php
                                    if($val['order_status'] == 1){
                                        echo '<span class="text-danger">未付款</span>';
                                    }elseif($val['order_status'] == 2){
                                        echo '<span class="text-info">付款未参加</span>';
                                    }elseif($val['order_status'] == 3){
                                        echo '<span class="text-success">已参加</span>';
                                    }elseif($val['order_status'] == 4){
                                        echo '<span class="text-warning">退款中</span>';
                                    }elseif($val['order_status'] == 5){
                                        echo '<span class="text-primary">已退款</span>';
                                    }elseif($val['order_status'] == 6){
                                        echo '<span class="text-muted">已取消</span>';
                                    }
                                    ?></td>
                                <td class="center"><?php  if($val['order_status'] ==1){echo "<label onclick='mod_order(".$val['id'].",".$val['order_amount'].");' class='btn btn-sm btn-primary'>修改</label>";}else{ echo '<label class="btn btn-sm btn-success">无</label>';} ?></td>
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

<div class="modal inmodal" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"  >订单详情</h4>
                <small class="font-bold" id="order_modal_title">副标题</small>
            </div>
            <div class="modal-body" >
                <div class="row" id="order_modal_body">
                    <div class="col-sm-4">
                        <div class="contact-box">
                            <a href="profile.html">
                                <div class="col-sm-12">
                                    <div class="text-center">
                                        <img alt="image" class="img-circle m-t-xs img-responsive" src="http://haoshaonian.oss-cn-shenzhen.aliyuncs.com/data/upload/member/child_1_05757373363482318.jpg!product-60">
                                        <div class="m-t-xs font-bold">CTO</div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="contact-box">
                            <a href="profile.html">
                                <div class="col-sm-12">
                                    <div class="text-center">
                                        <img alt="image" class="img-circle m-t-xs img-responsive" src="http://haoshaonian.oss-cn-shenzhen.aliyuncs.com/data/upload/member/child_1_05757373363482318.jpg!product-60">
                                        <div class="m-t-xs font-bold">CTO</div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="contact-box">
                            <a href="profile.html">
                                <div class="col-sm-12">
                                    <div class="text-center">
                                        <img alt="image" class="img-circle m-t-xs img-responsive" src="http://haoshaonian.oss-cn-shenzhen.aliyuncs.com/data/upload/member/child_1_05757373363482318.jpg!product-60">
                                        <div class="m-t-xs font-bold">CTO</div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="contact-box">
                            <a href="profile.html">
                                <div class="col-sm-12">
                                    <div class="text-center">
                                        <img alt="image" class="img-circle m-t-xs img-responsive" src="http://haoshaonian.oss-cn-shenzhen.aliyuncs.com/data/upload/member/child_1_05757373363482318.jpg!product-60">
                                        <div class="m-t-xs font-bold">CTO</div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="contact-box">
                            <a href="profile.html">
                                <div class="col-sm-12">
                                    <div class="text-center">
                                        <img alt="image" class="img-circle m-t-xs img-responsive" src="http://haoshaonian.oss-cn-shenzhen.aliyuncs.com/data/upload/member/child_1_05757373363482318.jpg!product-60">
                                        <div class="m-t-xs font-bold">CTO</div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="myModal3" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">会员信息</h4>
                <small class="font-bold">修改会员的信息</small>
            </div>
            <div class="modal-body">

                <form method="post" id="mod_info" action="" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">订单金额</label>
                        <div class="col-sm-9">
                            <input type="phone" name="order_amount" class="form-control">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>


                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <input type="hidden" name="order_id" value="" />
                            <input type="hidden" name="act" value="admin_order"/>
                            <input type="hidden" name="op" value="mod_order"/>
                            <button class="btn btn-primary" type="submit">确认修改</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
        </div>
    </div>
</div>

</body>
<script>
    $(function(){
        var order_state = "<?php echo $_GET['order_state'];?>"
        if(order_state){
            $("#order_state option[value='"+order_state+"']").attr("selected","selected")
        }
    });

</script>
</html>