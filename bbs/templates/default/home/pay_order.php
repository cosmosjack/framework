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
            <span class="col-xs-12 text-center">订单支付</span>
        </div>
        <!--内容-->
        <div class="de_content container-fluid">
            <div class="overflow">
                <div class="col-xs-12 teacher">
                     <img src="<?php echo $output['info']['activity_index_pic']?>!product-60" class="col-xs-4" />
                     <div class="col-xs-8">
                        <p class="col-xs-12"><?php echo $output['info']['activity_title']?></p>
                        <div class="teacher_age col-xs-12">
                            <p><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/child_boy.png" class="teacher_img" /><?php echo $output['info']['activity_time']?></p>
                            <p><img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/place.png" class="teacher_img col-xs-2" /><span class="col-xs-10"><?php echo $output['info']['activity_address']?></span></p>
                        </div>
                     </div>
                </div>
                <div class="col-xs-12 pad_none">
                    <span class="col-xs-12 pad_none">选择套餐：</span>
                    <div class="col-xs-12 package pad_none">
                        <div class="col-xs-6">
                            <span>儿童票：</span><span class="de_price">&yen;<span><?php echo $output['info']['order_amount']/$output['info']['order_num']?></span></span>
                        </div>
                        <div class="col-xs-6 text-right">
                            <span class="de_num"><?php echo $output['info']['order_num']?></span>
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
            <div class="col-xs-12">
                <div class="overflow" id="tutelage">
                   <span class="col-xs-4">监护人：</span>
                </div>
                <?php $parents = unserialize($output['info']['parents_arr']); foreach($parents as $val):?>
                <div class="overflow de_tut">
                    <img src="<?php echo $val['img']?>">
                    <span><?php echo $val['name']?></span>
                </div>
                <?php endforeach;?>
            </div>
            <div class="col-xs-12">
                <div class="overflow" id="student">
                   <span class="col-xs-4">学员：</span>
                </div>
                <?php $childs = unserialize($output['info']['childs_arr']); foreach($childs as $val):?>
                <div class="overflow de_tut">
                    <img src="<?php echo $val['img']?>">
                    <span><?php echo $val['name']?></span>
                </div>
                <?php endforeach;?>
            </div>
            <div class="col-xs-12">
                <span class="col-xs-4">备      注：</span>
                <span class="col-xs-8" id="remark"><?php echo $output['info']['remark']?></span>
            </div>
        </div>
        <div class="defray_manner container-fluid overflow">
            <div class="col-xs-12">
                <span class="radio de_radio"></span>
                <span class="contract">我已阅读并接受<span><a href="<?php echo urlBBS('activity','pact')?>" style="color:#e25428">《活动协议书》</a></span></span>
            </div>
            <div class="de_wx col-xs-12">
                <span>支付方式：</span>
                <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/weixin.png" class="pull-right" />
            </div>
        </div>
        <input type="hidden" id="orderId" value="<?php echo $output['info']['id']?>">
    </div>
    <div class="de_btn overflow text-center">
        <div class="col-xs-6 total">总计：<span><?php echo $output['info']['order_amount'] ?></span>元</div>
        <div class="col-xs-6 go_debtn">去付款</div>
    </div>
    <!--支付成功弹框-->
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog modal-sm row" role="document">
        <div class="modal-content col-xs-12 de_point text-center">
              
        </div>
      </div>
    </div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/pay_order.js"></script>
</body>
</html>