<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--支付页面-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
    <title>好少年</title>
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/defray.css" />
<body>
    <div class="defray">
        <!--头部-->
        <div class="reg_top oveflow">
            <button type="button" class="btn oprev">
              <span class="glyphicon glyphicon-chevron-left"></span>
            </button>
            <span class="col-xs-12 text-center">活动报名</span>
        </div>
        <!--内容-->
        <div class="de_content container-fluid">
            <div class="overflow">
                <div class="col-xs-12 teacher">
                     <img src="<?php echo $output['info']['activity_index_pic']?>!product-60" class="col-xs-4" />
                     <div class="col-xs-8">
                        <p class="col-xs-12"><?php echo $output['info']['activity_title']?></p>
                        <div class="teacher_age col-xs-12">
                            <p><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/child_boy.png" class="teacher_img" /><?php echo date('m月d日',$output['info']['activity_begin_time'])?>~<?php echo date('m月d日',$output['info']['activity_end_time'])?></p>
                            <p><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/place.png" class="teacher_img col-xs-2" /><span class="col-xs-10"><?php echo $output['info']['address']?></span></p>
                        </div>
                     </div>
                </div>
                <div class="col-xs-12 pad_none">
                    <!-- <?php if(!empty($output['periods'])):?>
                    <span class="col-xs-12 pad_none">其他场次：</span>
                    <div class="title overflow col-xs-12">
                       <ul class="title_ul text-center">
                        <?php foreach($output['periods'] as $val):?>
                            <li class="session" data-id="<?php echo $val['id']?>">
                                <div>
                                    <p><?php echo date('m月d',$val['activity_begin_time'])?>~<?php echo date('m月d',$val['activity_end_time'])?></p>
                                        <p>报名中</p>
                                </div>
                            </li>
                        <?php endforeach;?>
                       </ul> 
                    </div>
                    <?php endif;?> -->
                    <span class="col-xs-12 pad_none">选择套餐：</span>
                    <div class="col-xs-12 package pad_none">
                        <div class="col-xs-6">
                            <span>儿童票：</span><span class="de_price">&yen;<span><?php echo $output['info']['activity_price']?></span></span>
                        </div>
                        <div class="col-xs-6 text-right">
                            <!-- <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/down.png"  class="less" /> -->
                            <span class="de_num">0</span>
                            <!-- <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/up.png" class="push" /> -->
                        </div>
                    </div>
                    <!-- <div class="col-xs-12 de_coupon">
                        <span>我的优惠券：</span>
                        <span class="pull-right">-0.00 ></span>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="de_user container-fluid overflow">
            <div class="col-xs-12">
                <span class="col-xs-4">联系电话：</span>
                <input type="text" name="" class="col-xs-8" id="de_phone" placeholder="" value="<?php echo $_SESSION['userInfo']['member_phone']?>" />
            </div>
            <!-- <div class="col-xs-12">
                <span class="col-xs-4">电子邮箱：</span>
                <input type="text" name="" class="col-xs-8" id="de_mail" placeholder="请输入电子邮箱" />
            </div> -->
            <div class="col-xs-12">
               <div class="overflow" id="tutelage">
                   <span class="col-xs-4">监护人：</span>
                   <span class="col-xs-8 text-right">请选择 ></span>
               </div>
                
            </div>
            <div class="col-xs-12">
               <div class="overflow" id="student">
                   <span class="col-xs-4">学员：</span>
                   <span class="col-xs-8 text-right">请选择 ></span>
               </div>
            </div>
            <div class="col-xs-12">
                <span class="col-xs-4">备      注：</span>
                <textarea class="col-xs-8" id="remark"></textarea>
            </div>
        </div>
        <div class="defray_manner container-fluid overflow">
            <div class="col-xs-12">
                <span class="radio de_radio"></span>
                <span class="contract">我已阅读并接受<span>《国家旅游局团队境内旅游合同》</span></span>
            </div>
            <div class="de_wx col-xs-12">
                <span>支付方式：</span>
                <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/weixin.png" class="pull-right" />
            </div>
        </div>
        <input type="hidden" id="periods" value="<?php echo $output['info']['activity_periods']?>?>">
        <input type="hidden" id="no" value="<?php echo $output['info']['activity_no']?>">
        <input type="hidden" id="minAge" value="<?php echo $output['info']['min_age']?>">
        <input type="hidden" id="maxAge" value="<?php echo $output['info']['max_age']?>">
    </div>
    <div class="de_btn overflow text-center">
        <div class="col-xs-6 total">总计：<span>0.00</span>元</div>
        <?php if($output['info']['total_number']-$output['info']['already_num'] == 0):?>
            <div class="col-xs-6" style="background:#ccc">已满额</div>
        <?php elseif($output['info']['activity_begin_time']-3600*12 < time()):?>
            <div class="col-xs-6" style="background:#ccc">报名已截止</div>
        <?php elseif($output['info']['activity_end_time'] < time()):?>
            <div class="col-xs-6" style="background:#ccc">活动已结束</div>
        <?php else:?>
            <div class="col-xs-6 go_debtn">去付款</div>
        <?php endif;?>
    </div>
    <!--支付成功弹框-->
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog modal-sm row" role="document">
        <div class="modal-content col-xs-12 de_point text-center">
              
        </div>
      </div>
    </div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/defray.js"></script>
</body>
</html>