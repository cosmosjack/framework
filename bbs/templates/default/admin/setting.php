<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/5/18
 * Time: 14:57
 * QQ:  997823131 
 */
defined('InCosmos') or exit('Access Invalid!');?>
<style>
    .label{
        font-size: 16px;
    }
</style>
<body class="gray-bg">

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>首页BANNER广告图片修改</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <ul class="thumbnails" style="width: 700px;margin-left: auto;margin-right: auto;">
                        <?php foreach($output['data_adv'] as $key=>$val){?>
                        <li class="list-group-item">
                            <a href="<?php echo $val['url'];?> " class="thumbnail">
                                <img src="<?php echo $val['pic'];?>"  alt="700x400" style="width: 1440px;height: 390px;">
                            </a>
                                <span class="label label-primary">
                                    <i onclick="edit_adv('<?php echo $val['adv_id'];?>','<?php echo $val['title'];?>','<?php echo $val['title'];?>','<?php echo $val['url'];?>');" class="fa fa-edit"></i>
                                </span>
                                <span style="margin-left: 5px;" class="label label-danger">
                                    <i class="fa fa-trash-o"></i>
                                </span>
                            <span style="margin-left: 20px;">请上传700X400像素的图片</span>
                        </li>
                        <?php }?>
                    </ul>
                    <p align="center">
                        <button  class="label label-success" >保存</button>
                    </p>

                </div>
            </div>
        </div>
    </div>
    <!-- <div class="row">
         <div class="col-sm-12">
             <div class="ibox float-e-margins">
                 <div class="ibox-title">
                     <h5>其他栏目顶部广告</h5>
                     <div class="ibox-tools">
                         <a class="collapse-link">
                             <i class="fa fa-chevron-up"></i>
                         </a>
                     </div>
                 </div>
                 <div class="ibox-content">
                     <li class="list-group-item">
                         <a href="#" class="thumbnail">
                             <img src=""  alt="1440x390" style="width: 1440px;height: 390px;">
                         </a>
                             <span class="label label-primary">
                                 <i class="fa fa-edit"></i>
                             </span>
                             <span style="margin-left: 5px;" class="label label-danger">
                                 <i class="fa fa-trash-o"></i>
                             </span>
                     </li>

                 </div>
             </div>
         </div>
     </div>-->



</div>
</body>
<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <form enctype="multipart/form-data" class="form-horizontal m-t" target="_self" method="post" action="<?php echo BBS_SITE_URL.DS.'index.php?act=admin&op=setting'?>">

        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
                    </button>
                    <i class="fa fa-laptop modal-icon"></i>
                    <h4 class="modal-title">首页广告管理</h4>
                    <small id="store_list_small" class="font-bold">管理首页的广告</small>
                </div>
                <div class="modal-body">
                    <p style="text-align: center;font-size: 14px"><strong>企业后台</strong></p>
                    <p style="color: #dd4444">为了防止,首页出现混乱，请按照尺寸上传。</p>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">广告名称：</label>
                        <div class="col-sm-8">
                            <input name="ad_name" class="form-control" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">广告介绍：</label>
                        <div class="col-sm-8">
                            <input name="ad_desc" class="form-control" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">选择图片：</label>
                        <div class="col-sm-8">
                            <input name="ad_pic" class="form-control" type="file">
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 请上传对应像素的图片</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">图片链接：</label>
                        <div class="col-sm-8">
                            <input name="ad_link" class="form-control" type="text">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="sub" value="ok">

                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <input type="hidden" name="adv_id">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </div>

    </form>
</div>


<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/plugins/validate/jquery.validate.min.js"></script>
<script>
    function edit_adv(adv_id,img_name,img_desc,img_url){

        console.log(adv_id);
        console.log(img_name);
        console.log(img_desc);
        console.log(img_url);

        $("input[name='adv_id']").val(adv_id);
        $("input[name='ad_name']").val(img_name);
        $("input[name='ad_desc']").val(img_desc);
        $("input[name='ad_link']").val(img_url);
        $('#myModal').modal('show');
    }
</script>