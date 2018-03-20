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
        $result =  yunpian_sms("18825466506",'','3368');
        p($result);

        
        Tpl::output("test",array('ddd','bbb'));
        Tpl::showpage("index");
    }
    //短信发送
    public function sendMessageOp(){
    	$data = array();
    		array('code'=>200,'msg'=>'cg','control'=>'sendMessage','data'=>$data);
    	if(empty($_POST['phone']))		
    		ajaxReturn(array('code'=>'0','msg'=>'手机号不能为空','control'=>'sendMessage'));
    	//验证手机格式
    	$reg = '/^1[3|4|5|8][0-9]\d{8}$/';
    	if(!preg_match($reg,$_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号格式不正确','control'=>'sendMessage'));
    	//60秒内只能发送一次短信
    	$db_tmp = M('tmp');
    	$info = $db_tmp->where(array('remote_addr'=>array('eq'=>$_server['REMOTE_ADDR'])))->find();
    	if($info && (time()-$info['time'] >60))
    		ajaxReturn(array('code'=>'0','msg'=>'60秒内只能发送一次短信','control'=>'sendMessage'));
     	//手机号验证
     	$code = rand(4);
     	if(yunpian_sms($_POST['phone'],1,$code)){
     		$data['remote_addr'] = $_server['REMOTE_ADDR'];
	     	$data['code'] = $code;
	     	$data['time'] = time();
	     	$result = $db_tmp->add($data);
	     	if($result)
	     		ajaxReturn(array('code'=>'200','msg'=>'短信发送成功','control'=>'sendMessage'));
	     	else
	     		ajaxReturn(array('code'=>'0','msg'=>'短信存储失败','control'=>'sendMessage'));
     	}else{
     		ajaxReturn(array('code'=>'0','msg'=>'短信发送失败','control'=>'sendMessage'));
     	}
    }
    //注册
    public function registerOp(){
    	//账号用 hsn_手机号
    	if(empty($_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号不能为空','control'=>'register'));
    	//验证手机格式
    	$reg = '/^1[3|4|5|8][0-9]\d{8}$/';
    	if(!preg_match($reg,$_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号格式不正确','control'=>'register'));
    	if(empty($_POST['password']))
    		ajaxReturn(array('code'=>'0','msg'=>'密码不能为空','control'=>'register'));
    	//验证验证码
    	$db_tmp = M('tmp');
    	$info = $db_tmp->where(array('remote_addr'=>array('eq'=>$_server['REMOTE_ADDR'])))->find();
    	if($_POST['code']!=$info['code'])
    		ajaxReturn(array('code'=>'0','msg'=>'验证码不正确','control'=>'register'));
    	$db_user = M('user');
    	if($db_user->where('phone='.$_POST['phone'])->find()){
    		ajaxReturn(array('code'=>'0','msg'=>'手机号已经注册','control'=>'register'));
    	}
    	$data['member_name'] = 'hsn_'.$_POST['phone'];
    	$data['member_phone'] = $_POST['phone'];
    	$data['member_passwd'] = encrypt($_POST['password']);
    	$data['last_login_ip'] = getIp();
    	$data['add_time'] = time();
    	$result = $db_user->add($_POST);
    	if($result){
    		$result = $db_tmp->where('REMOTE_ADDR='.$_server['REMOTE_ADDR'])->delete();
    		if(!$result)
    			ajaxReturn(array('code'=>'0','msg'=>'临时表删除失败','control'=>'register'));
    		else
    			ajaxReturn(array('code'=>'200','msg'=>'注册成功','control'=>'register'));
    	}else{
    		ajaxReturn(array('code'=>'0','msg'=>'注册失败','control'=>'register'));
    	}
    }
    //登录
    public function loginOp(){
    	//账号用 hsn_手机号
    	if(empty($_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号不能为空','control'=>'login'));
    	//验证手机格式
    	$reg = '/^1[3|4|5|8][0-9]\d{8}$/';
    	if(!preg_match($reg,$_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号格式不正确','control'=>'login'));
    	if(empty($_POST['password']))
    		ajaxReturn(array('code'=>'0','msg'=>'密码不能为空','control'=>'login'));
    	//验证验证码
    	$db_tmp = M('tmp');
    	$info = $db_tmp->where(array('remote_addr'=>array('eq'=>$_server['REMOTE_ADDR'])))->find();
    	if($_POST['code']!=$info['code'])
    		ajaxReturn(array('code'=>'0','msg'=>'验证码不正确','control'=>'login'));
    	$map = array();
    	$map['member_phone'] = $_POST['phone'];
    	$map['password'] = encrypt($_POST['password']);
    	$info = M('user')->where($map)->find();
    	if(!$info){
    		ajaxReturn(array('code'=>'0','msg'=>'账号或密码错误','control'=>'login'));
    	}else{
    		//登录成功
    		$data['last_login_ip'] = getIp();
    		$data['login_times'] = $data['login_times']+1;
    		if(M('user')->where('id='.$info['id'])->save($data))
    			ajaxReturn(array('code'=>'200','msg'=>'登录成功','control'=>'login'));
    		else
    			ajaxReturn(array('code'=>'0','msg'=>'登录次数修改失败','control'=>'login'));
    	}
    }
}