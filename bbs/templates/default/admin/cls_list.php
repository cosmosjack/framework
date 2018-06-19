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
                    <h5>类别管理 <small>类别列表</small></h5>
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
                            <th>类别ID</th>
                            <th>类别名字</th>
                            <th>类别描述</th>
                            <th>类别级别</th>
                            <th>类别父级ID</th>
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
                        </tr>
                        <tr class="gradeC">
                            <td>加载中</td>
                            <td>加载中</td>
                            <td>加载中</td>
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
</div>
<script>

    $(function(){
        $('#dataTables-example').DataTable(//创建一个Datatable
            {
                ajax : {//通过ajax访问后台获取数据
                    "url": ApiUrl + "/index.php?act=admin_activity&op=cls_listAjax",//后台地址
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
                    {"data" : "cls_name"},
                    {"data" : "cls_desc"},
                    {"data" : "level"},
                    {"data" : "pid"},
                    {"data" : null} ],
                columnDefs : [ {//列渲染，可以添加一些操作等
                    targets : 5,//表示是第8列，所以上面第8列没有对应数据列，就是在这里渲染的。
                    render : function(data, type, row) {//渲染函数
                        var html = '&nbsp;<label type="button" class="btn btn-danger btn-sm" onclick=window.location.href="'+ApiUrl+'/index.php?act=admin_activity&op=cls_del&id='+data.id+'">删除</label>';//这里加了两个button，一个修改，一个删除
                        return html;//将改html语句返回，就能在表格的第8列显示出来了
                    }
                },{
                    orderable:false,//禁用排序
                    targets:[1,2,5]   //指定的列
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

    /* 删除方法 start */

    /* 删除方法 end */


</script>

</body>
</html>
