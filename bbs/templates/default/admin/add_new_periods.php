<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/4/9
 * Time: 9:13
 * QQ:  997823131 
 */
defined('InCosmos') or exit('Access Invalid!');?>
<!-- 日期选择start -->
<link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
<link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<!-- 日期选择 end -->

<!-- 甜窗 start -->
<link href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<!-- 甜窗 end -->

<!-- 日期选择 start -->
<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- 日期选择 end -->

<!-- 甜窗 start -->
<script src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/plugins/sweetalert/sweetalert.min.js"></script>
<!-- 甜窗 end -->

<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3 class="center"><?php echo $output['data_activity']['activity_title'];?>的第4期活动添加
                    <label class="pull-right btn btn-sm btn-success" onclick="javascript:history.go(-1);">返回列表</label>
                </h3>
            </div>
            <div class="ibox-content">
                <form method="post" action="" class="form-horizontal">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">活动标题</label>

                        <div class="col-sm-10">
                            <input type="text" disabled="" placeholder="已被禁用" value="<?php echo $output['data_activity']['activity_title'];?>" class="form-control">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">活动年龄限制</label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="min_age" class="input-sm form-control" value="<?php echo $output['data_activity']['min_age'];?>"  />
                                <span class="input-group-addon " style="color: #337ab7;">岁 <span style="color: red;font-weight: bold;">到</span></span>
                                <input type="text" name="max_age" class="input-sm form-control" value="<?php echo $output['data_activity']['max_age'];?>" />
                                <span class="input-group-addon" style="color: #337ab7;">岁</span>
                            </div>
                        </div>

                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">活动时间选择</label>
                        <div class="col-sm-5">

                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="input-sm form-control" name="start_time" value="<?php echo $output['data_activity']['activity_begin_time'] ? date("Y-m-d",$output['data_activity']['activity_begin_time']) : date('Y-m-d',time());?>" />
                                <span class="input-group-addon">到</span>
                                <input type="text" class="input-sm form-control" name="end_time" value="<?php echo $output['data_activity']['activity_end_time'] ? date("Y-m-d",$output['data_activity']['activity_end_time']) :  date('Y-m-d',time());?>" />
                            </div>

                        </div>

                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">交通工具</label>
                        <div class="col-sm-2">
                            <select class="form-control" name="transportation" id="">
                                <option value="1">步行</option>
                                <option value="1">自行车</option>
                                <option value="1">自驾</option>
                                <option value="1">大巴车</option>
                                <option value="1">火车</option>
                                <option value="1">飞机</option>
                            </select>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">活动报名人数</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" value="<?php echo $output['data_activity']['total_number'];?>"  name="total_number"> <span class="help-block m-b-none text-danger">限制报名的人数</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">活动小组数量</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" value="<?php echo $output['data_activity']['group_number'];?>" name="group_number"> <span class="help-block m-b-none text-danger">默认为一个小组</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">点击量</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="activity_click" value="<?php echo $output['data_activity']['activity_click'];?>" > <span class="help-block m-b-none text-danger">用来提高活动活跃度</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">活动价格</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="activity_price" value="<?php echo $output['data_activity']['activity_price'];?>"> <span class="help-block m-b-none text-danger">单张票的价格</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>


                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <input type="hidden" name="activity_no" value="<?php echo $output['data_activity']['activity_no'];?>"/>
                            <input type="hidden" name="activity_periods" value="<?php echo $output['data_activity']['activity_periods'];?>"/>
                            <input type="hidden" name="sub" value="ok" />
                            <button class="btn btn-primary" type="submit">确认添加</button>
                            <button class="btn btn-white" type="button">取消</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("#datepicker").datepicker({
        todayBtn: "linked",
        keyboardNavigation: !1,
        forceParse: !1,
        calendarWeeks: !0,
        autoclose: !0
    })
</script>