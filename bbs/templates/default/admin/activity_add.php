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
    <link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/plugins/iCheck/custom.css" rel="stylesheet">
<script type="text/javascript" charset="utf-8" src="<?php echo BBS_RESOURCE_SITE_URL;?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo BBS_RESOURCE_SITE_URL;?>/ueditor/ueditor.all.min.js"> </script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="<?php echo BBS_RESOURCE_SITE_URL;?>/ueditor/lang/zh-cn/zh-cn.js"></script>

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
                    <form method="get" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动标题</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动简单介绍</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"> <span class="help-block m-b-none">填写简单的活动介绍</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动封面图</label>

                            <div class="col-sm-10">
                                <label>
                                    <input type="file" multiple="multiple" id="input_img" style="display: none;" name="cover_img[]" value="" onchange="javascript:setImagePreview('input_img','preview','localImage','375px','222px');">
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
                            <label class="col-sm-2 control-label">活动介绍图</label>

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

                        <div class="form-group">
                            <label class="col-sm-2 control-label">活动介绍轮播图</label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="提示信息" class="form-control">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">禁用</label>

                            <div class="col-sm-10">
                                <input type="text" disabled="" placeholder="已被禁用" class="form-control">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">静态控制</label>

                            <div class="col-sm-10">
                                <p class="form-control-static">i@zi-han.net</p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">详细介绍</label>

                            <div class="col-sm-10">
                                <div>
                                    <script id="editor" type="text/plain" style="width:1080px;height:500px;"></script>
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

<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/content.min.js?v=1.0.0"></script>
<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/plugins/iCheck/icheck.min.js"></script>
<script>
    $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
</script>

<script type="text/javascript">
    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');

</script>

</body>

</html>