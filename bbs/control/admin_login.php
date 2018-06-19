<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/4/27
 * Time: 8:41
 * QQ:  997823131 
 */
class admin_loginControl extends BaseAdminControl{
    public function __construct(){
        /* 如果已经登录过 start */
        if($_SESSION['is_login']){
           showMessage("已经登录过",BBS_SITE_URL.DS.'index.php?act=admin');
        }
        /* 如果已经登录过 end */
        Tpl::setLayout("admin_layout");
        Tpl::setDir("admin");
    }
    //登录页面
    public function indexOp(){

        /* 根据时间生成相应的加密码 start */
        $newhash = time();
        //将 newhash 存入 session
        $_SESSION['cosmosHash'] = $newhash;
        $seccode = makeSeccode($newhash);
        Tpl::output('hashValue',$seccode);
        /* 根据时间生成相应的加密码 end */

        Tpl::showpage("admin_login.index");
    }

    //接受登录
    public function loginOp(){
        $result_check = checkSeccode($_SESSION['cosmosHash'],$_POST['hashValue']);
        unset($_SESSION['cosmosHash']);//释放
        if(!$result_check){
            showMessage("重复提交");
            die();
        }
        /* 登录 start */
        $where['admin_name'] = $_POST['admin_name'];
        $where['admin_password'] = md5($_POST['password']);
        $db_admin = new Model("admin");
        $data_admin = $db_admin->where($where)->find();
        if(!$data_admin){
            showMessage("账号或密码错误");
            die();
        }
        /* 登录 end */

        $_SESSION['is_login'] = true;
        $_SESSION['admin_info'] = $data_admin;
        showMessage("登录成功",BBS_SITE_URL.DS."index.php?act=admin");
    }
}