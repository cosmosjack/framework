<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/6/5
 * Time: 15:06
 * QQ:  997823131 
 */
class wx_testControl extends BaseControl{
    public function __construct(){
        parent::__construct();
    }
    public function indexOp(){
        Tpl::showpage("wx_test");
    }
}