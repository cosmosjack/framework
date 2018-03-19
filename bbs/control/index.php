<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/3/9
 * Time: 15:50
 * QQ:  997823131 
 */
class indexControl extends BaseControl{
    public function __construct(){
        parent::__construct();
    }
    public function indexOp(){
        echo 'this is bbs index';
        $db_goods = Model('goods');
        $data_goods = $db_goods->select();
//        p($data_goods);
        $number = '18675778621';
        $message = "【时刻需】您的验证码是8888";
        $sms = new Sms();
        $result = $sms->send($number, $message);
        p($result);

        Tpl::output("test",array('ddd','bbb'));
        Tpl::showpage("index");
    }
}