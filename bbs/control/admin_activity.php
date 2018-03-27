<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/3/26
 * Time: 11:14
 * QQ:  997823131 
 */
class admin_activityControl extends BaseAdminControl{
    public function __construct(){
        parent::__construct();
    }

    //后台活动添加功能
    public function activity_add(){
        p($_POST);
        p($_FILES);
    }
}