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
        $this->checkLogin();
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
    //设置
    public function setUpOp(){
    	$this->checkLogin();
        if(!isAjax()){
            Tpl::showpage("setUp");
            exit();
        }
    }
    //设置个人信息
    public function mineInfoOp(){
    	$this->checkLogin();
    	if(!isAjax()){
    		Tpl::showpage("mineInfo");
    		exit();
    	}
    }
    //解绑手机
    public function unBindOp(){
        $this->checkLogin();
        if(!isAjax()){
            Tpl::showpage("unBind");
            exit();
        }
        if(empty($_POST['phone']))
            ajaxReturn(array('code'=>'0','msg'=>'手机号不能为空','control'=>'unBind'));
        //验证手机格式
        if(!isPhone($_POST['phone']))
            ajaxReturn(array('code'=>'0','msg'=>'手机号格式不正确','control'=>'unBind'));
        //检查手机
        if($_POST['phone'] != $_SESSION['userInfo']['member_phone'])
            ajaxReturn(array('code'=>'0','msg'=>'请输入之前绑定的手机','control'=>'unBind'));
        ///验证短信验证码
        $db_tmp = Model('bbs_tmp');
        $map = array();
        $map['phone'] = array('eq',$_POST['phone']);
        $map['remote_addr'] = array('eq',$_SERVER['REMOTE_ADDR']);
        $map['code'] = array('eq',$_POST['code']);
        $info = $db_tmp->where($map)->order('send_time desc')->find();
        if(!$info)
            ajaxReturn(array('code'=>'0','msg'=>'验证码不正确','control'=>'unBind'));
        if(time()-$info['send_time'] > 120)
            ajaxReturn(array('code'=>'0','msg'=>'验证码失效','control'=>'unBind'));
        $db_tmp->where('id='.$info['id'])->delete();
        ajaxReturn(array('code'=>'200','msg'=>'成功，绑定新的手机号','control'=>'unBind','url'=>urlBBS('mine','bind')));
    }
    //绑定手机
    public function bindOp(){
        $this->checkLogin();
        if(!isAjax()){
            Tpl::showpage("bind");
            exit();
        }
        if(empty($_POST['phone']))
            ajaxReturn(array('code'=>'0','msg'=>'手机号不能为空','control'=>'bind'));
        //验证手机格式
        if(!isPhone($_POST['phone']))
            ajaxReturn(array('code'=>'0','msg'=>'手机号格式不正确','control'=>'bind'));
        $db_user = Model('bbs_user');
        if($db_user->where('member_phone='.$_POST['phone'])->find()){
            //$db_tmp->where(array('remote_addr'=>array('eq',$_SERVER['REMOTE_ADDR'])))->delete();
            ajaxReturn(array('code'=>'0','msg'=>'手机号已经绑定,请重新输入','control'=>'bind'));
        }
        ///验证短信验证码
        $db_tmp = Model('bbs_tmp');
        $map = array();
        $map['phone'] = array('eq',$_POST['phone']);
        $map['remote_addr'] = array('eq',$_SERVER['REMOTE_ADDR']);
        $map['code'] = array('eq',$_POST['code']);
        $info = $db_tmp->where($map)->order('send_time desc')->find();
        if(!$info)
            ajaxReturn(array('code'=>'0','msg'=>'验证码不正确','control'=>'bind'));
        if(time()-$info['send_time'] > 120)
            ajaxReturn(array('code'=>'0','msg'=>'验证码失效','control'=>'bind'));
        $update = array();
        //$update['member_name'] = 'hsn_'.$_POST['phone'];
        $update['member_phone'] = $_POST['phone'];
        $result = $db_user->where('id='.$_SESSION['userInfo']['id'])->update($update);
        if($result){
            //删掉验证码
            $db_tmp->where('id='.$info['id'])->delete();
            //修改session
            //$_SESSION['userInfo']['member_name'] = 'hsn_'.$_POST['phone'];
            $_SESSION['userInfo']['member_phone'] = $_POST['phone'];
            ajaxReturn(array('code'=>'200','msg'=>'绑定成功','control'=>'bind','url'=>urlBBS('mine','index')));
        }else{
            ajaxReturn(array('code'=>'0','msg'=>'绑定失败','control'=>'bind','url'=>urlBBS('mine','index')));
        }
    }
    //修改密码
    public function editPw(){
        echo "editPw";
    }
    //关于我们
    public function aboutUs(){
        echo "aboutUs";
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