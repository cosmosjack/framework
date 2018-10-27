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
    private $appid = 'wxa286179f364df0be';
    private $secret = '09d3bbe599337a1c943401b83dbbacac';
    public function __construct(){
        parent::__construct();
    }
    public function indexOp(){


        $wx = new Wx();

        $data = $wx->init();

        Tpl::output("data",$data);
        Tpl::showpage("wx_test");
    }



}