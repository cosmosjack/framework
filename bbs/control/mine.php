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
        Tpl::setLayout("common_login_layout");
    }
    //首页
    public function indexOp(){
        Tpl::setLayout("common_layout");
    	$this->checkLogin();
    	//查询最新的用户信息
    	$db_user = Model('bbs_user');
    	$info = $db_user->where('id='.$_SESSION['is_login'])->find();
    	//p($info);
        Tpl::output("info",$info);
        //查询成长记录总数,查参加活动的订单总数
        $db_order = Model('bbs_order');
        $count = $db_order->where('member_id='.$info['id'].' and order_status=3')->count();
        Tpl::output("count",$count);
        Tpl::showpage("mine");
    }
    //成长相册
    public function xiangceOp(){

    }
    //成长记录
    public function jiluOp(){

    }
    //我的收藏
    public function coleccetOp(){

    }
    //优惠券
    public function couponOp(){
        Tpl::showpage("coupon");
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
    			ajaxReturn(array('code'=>'200','msg'=>'请先登录','control'=>'checkLogin','url'=>urlBBS('index','login')));
    		else
    			header("Location: ".urlBBS('index','login'));
    			//showDialog('请先登录',urlBBS('index','login'));
    	}
    }
    
}