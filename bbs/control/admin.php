<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/3/22
 * Time: 10:18
 * QQ:  997823131 
 */
class adminControl extends BaseAdminControl{
    public function __construct(){
        parent::__construct();
    }
//    后台主页界面
    public function indexOp(){

        Tpl::showpage("index");

    }

    /*
     *  网站信息
     */

    public function web_infoOp(){
        Tpl::showpage("web_info");
    }

//    活动列表
    public function activity_listOp(){
        Tpl::showpage("activity_list");
    }
//    活动添加
    public function activity_addOp(){
        Tpl::showpage("activity_add");
    }
//  资讯列表
    public function news_listOp(){
        Tpl::showpage("news_list");
    }
//    资讯添加
    public function news_addOp(){
        Tpl::showpage("news_add");
    }

//    会员列表
    public function user_listOp(){
        Tpl::showpage("user_list");
    }

//    订单列表
    public function order_listOp(){
        Tpl::showpage("order_list");
    }


}
