<?php
/**
 *
 *	我的个人中心控制器
 *	Create by :杨奇林
 *  time:201803.21
 *  qq:928944169
 */
class mineControl extends BaseControl{

    public function __construct(){
        parent::__construct();
        $this->checkLogin();
    }
    //首页
    public function indexOp(){
    	$this->checkLogin();
    	//查询最新的用户信息
    	$db_user = Model('bbs_user');
    	$info = $db_user->where('id='.$_SESSION['is_login'])->find();
    	//p($info);
        Tpl::output("info",$info);
        Tpl::showpage("mine");
    }
    //设置
    public function setOp(){
    	echo 'this is bbs setOp';
    }
    //设置个人信息
    public function informationOp(){
    	$this->checkLogin();
    	if(!isAjax()){
    		Tpl::showpage("information");
    		exit();
    	}
    }
    //退出
    public function signOutOp(){
    	//清空session
    	$_SESSION['is_login'] = null;
    	$_SESSION['userInfo'] = null;
    	//showMessage('退出成功',urlBBS('index','login'));
    	header("Location: ".urlBBS('index','login'));
    }
    //检查登录
    public function checkLogin(){
    	if(empty($_SESSION['is_login'])){
    		if(isAjax())
    			ajaxReturn(array('code'=>'0','msg'=>'请先登录','control'=>'checkLogin'));
    		else
    			header("Location: ".urlBBS('index','login'));
    			//showDialog('请先登录',urlBBS('index','login'));
    	}
    }
}