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
<!-- 甜窗 start -->
<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/plugins/sweetalert/sweetalert.min.js"></script>
<!-- 甜窗 end -->
<style>
    .auto_li{
        margin-left: 60px;
        font-weight: bold;
    }
</style>
<script>
</script>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>儿童列表</h5>
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
                    <table class="table table-striped table-bordered table-hover " id="editable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>儿童姓名</th>
                            <th>儿童电话</th>
                            <th>年龄</th>
                            <th>尺寸</th>
                            <th>会员</th>
                            <th>业务员</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($output['data_bbs_activity'] as $key=>$val){?>
                            <tr class="gradeX">
                                <td><?php echo $val['id'];?></td>
                                <td><?php echo $val['child_name'];?></td>
                                <td><?php echo $val['child_phone'];?></td>
                                <td class="center"><?php echo $val['child_age'];?></td>
                                <td class="center"><?php echo $val['child_size'];?></td>
                                <td><?php echo $val['member_name'];?></td>
                                <td><input class="form-control" type="text" name="child_staff_<?php echo $val['id']; ?>" value="<?php echo $val['staff'];?>"/></td>
                                <td><label class="btn btn-sm btn-primary" onclick="mod_staff('<?php echo $val['id']; ?>')">修改</label></td>

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

</body>
<script>
    function mod_staff(id){
        var staff = $("input[name='child_staff_"+id+"']").val();
        if(!staff){
            swal({title:"儿童修改",text:"请填写业务员",type:"error"});
            return false;
        }

        $.ajax({
            url:ApiUrl+"/index.php?act=admin_user&op=mod_child_staff",
            type:"GET",
            data:{"id":id,"staff":staff},
            success:function(msg){
                if(msg.code == 200){
                    swal({title:"儿童修改",text:"修改成功",type:"success"});
                }else{
                    swal({title:"儿童修改",text:"修改失败",type:"error"});
                }
            },
            error:function(){
                swal({title:"儿童修改",text:"网络错误",type:"error"});

            }
        })
    }

</script>
</html>