<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/5/4
 * Time: 16:22
 * QQ:  997823131 
 */
class paymentControl extends BaseControl{
    public function __construct(){
        parent::__construct();
    }

    public function notifyOp(){
        /* 日志记录 start */
        $str = var_export($_GET,TRUE);
        file_put_contents(BASE_DATA_PATH.DS.'log'.DS.'wxpay'.DS.'pay_log.txt',$str.PHP_EOL,FILE_APPEND);
        /* 日志记录 end */
        /* 验证开始 start */
        $wx_api_path = BASE_DATA_PATH.DS."api".DS."payment".DS."wxpay_jsapi".DS;
//        p($wx_api_path);
        include($wx_api_path."wxpay_jsapi.php");
        $wx_pay = new wxpay_jsapi();

        // $result = 是微信返回来的数据 $output 是XML格式的数据'return_code' => 'SUCCESS',
        list($result, $output) = $wx_pay->notify();
        // 验证不正确时 $result = null
        if ($result) {
            $internalSn = $result['out_trade_no'] . '_' . $result['attach']; // 支付号码_v/r
            $externalSn = $result['transaction_id'];            // 微信支付凭证号
//            $updateSuccess = $this->_update_order($internalSn, $externalSn);
            /* 改变活动订单的状态并且把apply表插入 start */
            $db_bbs_order = new Model('bbs_order');
            $where['pay_no'] = $result['out_trade_no'];
            $where['order_status'] = 1;
            $data_bbs_order = $db_bbs_order->where($where)->find();
            if(!$data_bbs_order){
                $str = '订单不存在或状态已经改变，订单号为'.$internalSn."订单时间为".date("Y-m-d H:i:s",time());
                @file_put_contents(BASE_DATA_PATH.DS.'log'.DS.'wxpay'.DS.'pay_log.txt',$str.PHP_EOL,FILE_APPEND);
                die();
            }
            $model_bbs_apply = Model('bbs_apply');
            $model_bbs_apply->afterPay($data_bbs_order['id']);
            /* 改变活动订单的状态 end */
                $updateSuccess = true;
            @file_put_contents(BASE_DATA_PATH.DS.'log'.DS.'wxpay'.DS.'pay_log.txt',$internalSn.'ok'.PHP_EOL,FILE_APPEND);
            if (!$updateSuccess) {
                // @todo
                // 直接退出 等待下次通知
                exit;
            }
        }

        echo $output;
        echo 'ok';

        exit;
        /* 验证开始 end */
    }

}