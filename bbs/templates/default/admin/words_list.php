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

<!-- Data Tables start -->
<link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

<!--<script src="--><?php //echo BBS_RESOURCE_SITE_URL;?><!--/bootstrap/js/plugins/jeditable/jquery.jeditable.js"></script>-->
<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<!-- Data Tables end -->

<!-- 甜窗 start -->
<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/plugins/sweetalert/sweetalert.min.js"></script>
<!-- 甜窗 end -->
<style>
    .auto_li{
        margin-left: 60px;
        font-weight: bold;
    }
</style>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>词语管理 <small>老师点评的词语库</small></h5>
                    <div class="ibox-tools">
                        <label onclick="window.location.reload();" class="btn btn-sm btn-primary">刷新</label>
                        <label onclick="add_words('add',0);" class="btn btn-sm btn-success">添加</label>
                    </div>
                </div>
                <div class="ibox-content">

                    <table id="dataTables-example" class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th class="col-sm-2">会员ID</th>
                            <th class="col-sm-4">会员名字</th>
                            <th class="col-sm-4">排序</th>
                            <th class="col-sm-2">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="gradeX">
                            <td>加载中</td>
                            <td>加载中</td>
                            <td>加载中</td>
                            <td>加载中</td>
                        </tr>
                        <tr class="gradeC">
                            <td>加载中</td>
                            <td>加载中</td>
                            <td>加载中</td>
                            <td>加载中</td>
                        </tr>

                        </tfoot>
                    </table>

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
                <h4 class="modal-title">认证信息</h4>
                <small class="font-bold">用户的认证信息</small>
            </div>
            <div class="modal-body">
                <form method="post" id="mod_info" action="" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">词语名字</label>
                        <div class="col-sm-9">
                            <input type="phone" name="words_name" class="form-control">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">排序</label>
                        <div class="col-sm-9">
                            <input type="phone" name="sort" class="form-control">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <input type="hidden" name="words_id" value="" />
                            <input type="hidden" name="act" value="admin_words"/>
                            <input type="hidden" name="op" value="add_words"/>
                            <input type="hidden" name="action_type" value="add"/>
                            <button class="btn btn-primary" onclick="mod_words();" type="button">确认添加</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

<script>

    /* 添加单词 start */
    function add_words(action_type,id,name,sort){
        $("input[name='words_id']").val(id);
        $("input[name='words_name']").val(name);
        $("input[name='sort']").val(sort);
        console.log(action_type);
        if(action_type == 'add'){
            $("input[name='action_type']").val("add");
        }else if(action_type == 'mod'){
            $("input[name='action_type']").val("mod");
        }
        $("#mod_info").attr('action',ApiUrl+'/index.php');

        $("#myModal2").modal("show");
    }
    /* 添加单词 end */

    /* 删除 start */
    function del_words(id){
        $.ajax({
            url:ApiUrl+'/index.php?act=admin_words&op=del_words',
            type:"POST",
            data:{"id":id},
            success:function(msg){
                if(msg.code == 200){
                    swal({title:"词语删除",text:msg.msg,type:"success"});
//                    window.location.reload();
                }else{
                    swal({title:"词语删除",text:msg.msg,type:"error"});
                    return false;
                }
            },
            error:function(){
                swal({title:"词语删除",text:"网络出错",type:"error"});
                return false;
            }
        });

    }
    /* 删除 end */

    /* 删除 start */
    function mod_words(){
        var id = $("input[name='words_id']").val();
        var name = $("input[name='words_name']").val();
        var sort = $("input[name='sort']").val();
        var action = $("input[name='action_type']").val();
        if(action == 'add'){
            action = 'add_words';
        }else if(action == 'mod'){
            action = 'mod_words';
        }
        $.ajax({
            url:ApiUrl+'/index.php?act=admin_words&op='+action,
            type:"POST",
            data:{"id":id,"words_name":name,"sort":sort},
            success:function(msg){
                if(msg.code == 200){
                    $("#myModal2").modal('hide');

                    swal({title:"词语管理",text:msg.msg,type:"success"});
                }else{
                    swal({title:"词语管理",text:msg.msg,type:"error"});
                    return false;
                }
            },
            error:function(){
                swal({title:"词语管理",text:"网络出错",type:"error"});
                return false;
            }

        });
    }
    /* 删除 end */


    /* 修改会员的信息 可以修改 是否是领队  修改积分 修改密码 end */

    /* 时间戳变为 日期 start */
    function date_change(nS) {
        return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
    }
    /* 时间戳变为 日期 end */


$(function(){
    $('#dataTables-example').DataTable(//创建一个Datatable
        {
            ajax : {//通过ajax访问后台获取数据
                "url": ApiUrl + "/index.php?act=admin_words&op=words_list",//后台地址
                "type":'GET',
                "dataSrc": function (json) {//获取数据之后处理函数，jason就是返回的数据
                    var dataSet = new Array();
                    dataSet=json.data;
                    return dataSet;//再将数据返回给datatable控件使用
                }
            },
            serverSide: true,//如果是服务器方式，必须要设置为true
            processing: true,//设置为true,就会有表格加载时的提示
            columns : [ {"data" : "id"}, //各列对应的数据列
                {"data" : "words_name"},
                {"data" : "sort"},
                {"data" : null,render:function(data,type,row){
                    return "<label class='btn btn-sm btn-danger' onclick='del_words("+data.id+")'>删除</label><label class='btn btn-sm btn-success' onclick=add_words('mod',"+data.id+",'"+data.words_name+"',"+data.sort+")>修改</label>";
                }} ],
            "language": {//国际化
                "processing":"<p style=\"font-size: 20px;color: #f71925;\">正在玩命加载中。。。。请稍后！</p>",//这里设置就是在加载时给用户的提示
                "lengthMenu": "_MENU_ 条记录每页",
                "zeroRecords": "没有找到记录",
                "info": "第 _PAGE_ 页 ( 总共 _PAGES_ 页 )",
                "infoEmpty": "无记录",
                "infoFiltered": "(从 _MAX_ 条记录过滤)",
                "paginate": {
                    "previous": "上一页",
                    "next": "下一页"
                }
            },
//            "dom": "<'row'<'col-xs-2'l><'#mytool.col-xs-4'><'col-xs-6'f>r>" +"t" +"<'row'<'col-xs-6'i><'col-xs-6'p>>",//给表格改样式
             initComplete : function() {//表格完成时运行函数
//             $("#mytool").append('<button type="button" class="btn btn-warning btn-sm" id="importfilebutton" onclick="jumpimportfilepage();">添加</button>');//这里在表格的上面加了一个添加标签
             }
        });
});



</script>

</body>
</html>
