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


<!-- Data Tables start -->
<link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

<!--<script src="--><?php //echo BBS_RESOURCE_SITE_URL;?><!--/bootstrap/js/plugins/jeditable/jquery.jeditable.js"></script>-->
<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<!-- Data Tables end -->
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
                    <h5>基本 <small>分类，查找</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="table_data_tables.html#">
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

                    <table id="dataTables-example" class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>会员ID</th>
                            <th>会员名字</th>
                            <th>所属市</th>
                            <th>注册时间</th>
                            <th>电话</th>
                            <th>上次登录IP</th>
                            <th>是否是领队</th>
                            <th>积分</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="gradeX">
                            <td>加载中</td>
                            <td>加载中</td>
                            <td>加载中</td>
                            <td class="center">加载中</td>
                            <td class="center">加载中</td>
                            <td class="center">加载中</td>
                            <td class="center">加载中</td>
                            <td class="center">加载中</td>
                            <td class="center">加载中</td>
                        </tr>
                        <tr class="gradeC">
                            <td>加载中</td>
                            <td>加载中</td>
                            <td>加载中</td>
                            <td class="center">加载中</td>
                            <td class="center">加载中</td>
                            <td class="center">加载中</td>
                            <td class="center">加载中</td>
                            <td class="center">加载中</td>
                            <td class="center">加载中</td>
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
                <ul class="list-group" id="child_info">
                    <li style="background-color: #f7b6b6;" class="list-group-item"><span class="auto_li">儿童姓名</span><span class="auto_li">儿童电话</span><span class="auto_li">儿童性别</span><span class="auto_li">儿童年龄</span></li>

                </ul>
                <ul class="list-group" id="parents_info">
                    <li style="background-color: #f7b6b6;" class="list-group-item"><span class="auto_li">监护人</span><span class="auto_li">监护人电话</span><span class="auto_li">性别</span><span class="auto_li">年龄</span></li>

                </ul>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>


<script>
    /* 展示 监护人 和 儿童的认证 start */
    function show_info(id){
//        var table_data = $('#dataTables-example').DataTable();
//        var data = table_data.row($(e).parent().parent('tr')).data(); // 获取列表
//        var store_id = data['area_id'];
        console.log(id);

        // 模态框出来 前请求获取 认证信息
        $.ajax({
            url:ApiUrl+"/index.php?act=admin_user&op=get_auth_info",
            typt:"GET",
            data:{"id":id},
            success:function(msg){
//                console.log(msg);
                $("#child_info>li:gt(0)").remove();
                $("#parents_info>li:gt(0)").remove();

                for(var i =0 ;i<msg['child'].length;i++){
                    var child_sex = '保密';
                    if(msg.child[i]['child_sex'] == 1){
                        child_sex = '男';
                    }else if(msg.child[i]['child_sex'] == 2){
                        child_sex = '女';
                    }
                    $("#child_info").append('<li class="list-group-item"><span class="auto_li">'+msg.child[i]['child_name']+'</span><span class="auto_li">'+msg.child[i]['child_phone']+'</span><span class="auto_li">'+child_sex+'</span><span class="auto_li">'+msg.child[i]['child_age']+'</span></li>');
                }
                for(var i =0 ;i<msg['parent'].length;i++){
                    var parent_sex = '保密';
                    if(msg.parent[i]['child_sex'] == 1){
                        parent_sex = '男';
                    }else if(msg.parent[i]['child_sex'] == 2){
                        parent_sex = '女';
                    }
                    $("#parents_info").append('<li class="list-group-item"><span class="auto_li">'+msg.parent[i]['parents_name']+'</span><span class="auto_li">'+msg.parent[i]['parents_phone']+'</span><span class="auto_li">'+parent_sex+'</span><span class="auto_li">保密</span></li>');
                }
            },
            error:function(){
                alert("网络请求出错");
                console.log("http error");
            }
        });

        $("#myModal2").modal("show");

    }
    /* 展示 监护人 和 儿童的认证 end */

    /* 时间戳变为 日期 start */
    function date_change(nS) {
        return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
    }
    /* 时间戳变为 日期 end */




$(function(){
    $('#dataTables-example').DataTable(//创建一个Datatable
        {
            ajax : {//通过ajax访问后台获取数据
                "url": ApiUrl + "/index.php?act=admin_user&op=user_list",//后台地址
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
                {"data" : "member_name"},
                {"data" : "area_name"},
                {"data" : null,render:function(data,type,row){
                    return date_change(data.add_time);
                }},
                {"data" : "member_phone"},
                {"data" : "last_login_ip"},
                {"data" : "is_teacher"},
                {"data" : "integral"},
                {"data" : null} ],
            columnDefs : [ {//列渲染，可以添加一些操作等
                targets : 8,//表示是第8列，所以上面第8列没有对应数据列，就是在这里渲染的。
                render : function(data, type, row) {//渲染函数
                    var html = '&nbsp;<label type="button" class="btn btn-default btn-sm" onclick="show_info('+data.id+');"><i style="color: green;" class="fa fa-newspaper-o"></i></label>';//这里加了两个button，一个修改，一个删除
                    return html;//将改html语句返回，就能在表格的第8列显示出来了
                }
            },{
                orderable:false,//禁用排序
                targets:[1,2,4,5,8]   //指定的列
            }
            ],
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
