<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/3/9
 * Time: 15:52
 * QQ:  997823131 
 */

/*
 * 发短信接口
 * $number  手机号码
 * $type 类型  1 短信验证码  2 活动开始提醒  3 订单支付成功提醒  4 最新活动提醒  5 找回密码提醒  6 绑定微信提醒
 */
function yunpian_sms($number,$type='1',$code){
    $message = "【时刻需】您的验证码是".$code;
    $sms = new Sms();
    $result = $sms->send($number, $message);
    if($result['code'] == 0){
        return true;
    }else{
        return false;
    }
}