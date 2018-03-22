<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/3/9
 * Time: 15:49
 * QQ:  997823131 
 */

/*
 *  前端顶部控制器
 */
class BaseControl{
    public function __construct(){
        Tpl::setLayout("common_layout");
        Tpl::setDir('home');
    }
}

/*
 *  后台主控制器
 */
class BaseAdminControl{
    public function __construct(){
        Tpl::setLayout("admin_layout");
        Tpl::setDir("admin");
    }
}
