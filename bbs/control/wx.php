<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/4/25
 * Time: 10:22
 * QQ:  997823131 
 */
class wxControl extends BaseControl{
    public function __construct(){
        parent::__construct();
    }
    /* 支付测试 */
    public function indexOp(){
        $wx_api_path = BASE_DATA_PATH.DS."api".DS."payment".DS."wxpay_jsapi".DS;
//        p($wx_api_path);
        include($wx_api_path."wxpay_jsapi.php");
        $wx_pay = new wxpay_jsapi();
        echo($wx_pay->paymentHtml());
    }
    public function notifyOp(){
        $str = var_export($_POST,TRUE);
        file_put_contents(BASE_DATA_PATH.DS.'log'.DS.'wxpay'.DS.'pay_log.txt',$str,FILE_APPEND);
        echo 'ok';
    }
}