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
        Tpl::setLayout("common_login_layout");
    }

    public function indexOp(){
        echo 'this is bbs index';
        $db_goods = Model('goods');
        $data_goods = $db_goods->select();
//        p($data_goods);
        //$result =  yunpian_sms("18825466506",'','3368');
        //p($result);

        
        Tpl::output("test",array('ddd','bbb'));
        Tpl::showpage("index");
    }
    //检查登录
    public function checkLogin(){
    	if(!empty($_SESSION['is_login'])){
    		if(isAjax())
    			ajaxReturn(array('code'=>'200','msg'=>'已经登录','control'=>'checkLogin','url'=>urlBBS()));
    		else
    			header("Location: ".urlBBS());
    			//showDialog('请先登录',urlBBS('index','login'));
    	}
    }
    //短信发送
    public function sendMessageOp(){
    	if(!isAjax())
    		ajaxReturn(array('code'=>'0','msg'=>'使用ajax提交','control'=>'sendMessage'));
    	// $data = array();
    	// array('code'=>200,'msg'=>'cg','control'=>'sendMessage','data'=>$data);
    	if(empty($_POST['phone']))		
    		ajaxReturn(array('code'=>'0','msg'=>'手机号不能为空','control'=>'sendMessage'));
    	//验证手机格式
    	if(!isPhone($_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号格式不正确','control'=>'sendMessage'));
    	//注册时验证手机是否已经注册,短信登录时验证是否注册,密码找回时验证是否注册
    	$result = Model('bbs_user')->where('member_phone='.$_POST['phone'])->find();
    	//$result1 = Model('bbs_user')->where(array('member_phone'=>array('eq',$_POST['phone'])))->find();
    	if($_POST['action'] == 'register'){
    		if($result)
    			ajaxReturn(array('code'=>'0','msg'=>'手机号已经注册','control'=>'sendMessage'));
    	}else if($_POST['action'] == 'login'){
    		if(!$result)
    			ajaxReturn(array('code'=>'0','msg'=>'手机号未注册','control'=>'sendMessage'));
    	}else if($_POST['action'] == 'findpw'){
    		if(!$result)
    			ajaxReturn(array('code'=>'0','msg'=>'手机号未注册','control'=>'sendMessage'));
    	}
    	//var_dump($result);exit();
    	//60秒内只能发送一次短信
    	$db_tmp = Model('bbs_tmp');
    	$map['remote_addr'] = array('eq',$_SERVER['REMOTE_ADDR']); 
    	$info = $db_tmp->where($map)->order('send_time desc')->find();
    	if($info && (time()-$info['send_time'] < 60))
    		ajaxReturn(array('code'=>'0','msg'=>'60秒内只能发送一次短信','control'=>'sendMessage'));
     	//手机号验证
     	$type = !empty($_POST['type'])?$_POST['type']:1;
     	$code = random(4,1);
     	$type = !empty($_POST['type'])?$_POST['type']:1;
     	if(yunpian_sms($_POST['phone'],$type,$code)){
     		$data['phone'] = $_POST['phone'];
     		$data['remote_addr'] = $_SERVER['REMOTE_ADDR'];
	     	$data['code'] = $code;
	     	$data['send_time'] = time();
	     	$result = $db_tmp->insert($data);
	     	if($result)
	     		ajaxReturn(array('code'=>'200','msg'=>'短信发送成功,2分钟内有效','control'=>'sendMessage'));
	     	else
	     		ajaxReturn(array('code'=>'0','msg'=>'短信存储失败','control'=>'sendMessage'));
     	}else{
     		ajaxReturn(array('code'=>'0','msg'=>'短信发送失败','control'=>'sendMessage','code'=>$code));
     	}
    }
    //注册
    public function registerOp(){
    	$this->checkLogin();
    	if(!isAjax()){
    		Tpl::showpage("register");
    		exit();
    	}
    	if(empty($_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号不能为空','control'=>'register'));
    	//验证手机格式
    	if(!isPhone($_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号格式不正确','control'=>'register'));
    	if(empty($_POST['password']))
    		ajaxReturn(array('code'=>'0','msg'=>'密码不能为空','control'=>'register'));
    	if(empty($_POST['code']))
    		ajaxReturn(array('code'=>'0','msg'=>'验证码不能为空','control'=>'register'));
    	$db_user = Model('bbs_user');
    	$db_tmp = Model('bbs_tmp');
    	if($db_user->where(array('member_phone'=>array('eq',$_POST['phone'])))->find()){
    		//$db_tmp->where(array('remote_addr'=>array('eq',$_SERVER['REMOTE_ADDR'])))->delete();
    		ajaxReturn(array('code'=>'0','msg'=>'手机号已经注册','control'=>'register'));
    	}
    	//验证短信验证码
    	$map = array();
    	$map['phone'] = array('eq',$_POST['phone']);
    	$map['remote_addr'] = array('eq',$_SERVER['REMOTE_ADDR']);
    	$map['code'] = array('eq',$_POST['code']);
    	$info = $db_tmp->where($map)->order('send_time desc')->find();
    	if(!$info)
    		ajaxReturn(array('code'=>'0','msg'=>'验证码不正确','control'=>'register'));
    	if(time()-$info['send_time'] > 120)
    		ajaxReturn(array('code'=>'0','msg'=>'验证码失效','control'=>'register'));
    	$data['member_name'] = 'hsn_'.$_POST['phone'];//账号用 hsn_手机号
    	$data['member_phone'] = $_POST['phone'];
    	$data['member_passwd'] = encrypt($_POST['password']);
    	$data['last_login_ip'] = getIp();
    	$data['headimgurl'] = BBS_SITE_URL.'/resource/bootstrap/img/logo.png';
    	$data['add_time'] = time();
    	$result = $db_user->insert($data);
    	if($result){
    		$db_tmp->where(array('id'=>array('eq',$info['id'])))->delete();
    		ajaxReturn(array('code'=>'200','msg'=>'注册成功','control'=>'register','url'=>urlBBS('index','login')));
    	}else{
    		ajaxReturn(array('code'=>'0','msg'=>'注册失败','control'=>'register'));
    	}
    }
    //手机号密码登录
    public function loginOp(){
    	$this->checkLogin();
    	if(!isAjax()){
    		Tpl::showpage("login");
    		exit();
    	}
    	if(empty($_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号不能为空','control'=>'login'));
    	//验证手机格式
    	if(!isPhone($_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号格式不正确','control'=>'login'));
    	if(empty($_POST['password']))
    		ajaxReturn(array('code'=>'0','msg'=>'密码不能为空','control'=>'login'));
    	$db_user = Model('bbs_user');
    	$map = array();
    	$map['member_phone'] = array('eq',$_POST['phone']);
    	//$map['member_passwd'] = array('eq',encrypt($_POST['password']));
    	$info = $db_user->where($map)->find();
    	if($info){
    		if(decrypt($info['member_passwd']) != $_POST['password'])
    			ajaxReturn(array('code'=>'0','msg'=>'密码错误','control'=>'login'));
    		//登录成功
    		$data['last_login_ip'] = getIp();
    		$data['login_times'] = $info['login_times']+1;
    		$db_user->where(array('id'=>array('eq',$info['id'])))->update($data);
    		//存用户信息
    		$this->saveUserInfo($info);
    		ajaxReturn(array('code'=>'200','msg'=>'登录成功','control'=>'login','url'=>urlBBS('index','index')));
    	}else{
    		ajaxReturn(array('code'=>'0','msg'=>'手机号未注册','control'=>'login'));
    	}
    }
    //手机验证码登录
    public function login_smsOp(){
    	$this->checkLogin();
    	if(!isAjax()){
    		Tpl::showpage("login_sms");
    		exit();
    	}
    	if(empty($_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号不能为空','control'=>'login_code'));
    	//验证手机格式
    	if(!isPhone($_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号格式不正确','control'=>'login_code'));
    	//验证短信验证码
    	$db_tmp = Model('bbs_tmp');
    	$map = array();
    	$map['phone'] = array('eq',$_POST['phone']);
    	$map['remote_addr'] = array('eq',$_SERVER['REMOTE_ADDR']);
    	$map['code'] = array('eq',$_POST['code']);
    	$info = $db_tmp->where($map)->order('send_time desc')->find();
    	if(!$info)
    		ajaxReturn(array('code'=>'0','msg'=>'验证码不正确','control'=>'login_code'));
    	if(time()-$info['send_time'] > 120)
    		ajaxReturn(array('code'=>'0','msg'=>'验证码失效','control'=>'login_code'));
    	$db_user = Model('bbs_user');
    	$data = $db_user->where(array('member_phone'=>array('eq',$_POST['phone'])))->find();
    	if($data){
    		//登录成功
    		//删除短信发送临时表
    		$db_tmp->where(array('id'=>array('eq',$info['id'])))->delete();
    		//修改登录数据
    		$update['last_login_ip'] = getIp();
    		$update['login_times'] = $data['login_times']+1;
    		$db_user->where(array('id'=>array('eq',$data['id'])))->update($update);
    		//存用户信息
    		$this->saveUserInfo($data);
    		ajaxReturn(array('code'=>'200','msg'=>'登录成功','control'=>'login_code','url'=>urlBBS('index','index')));
    	}else{
    		ajaxReturn(array('code'=>'0','msg'=>'手机号未注册','control'=>'login_code'));
    	}
    }
    //微信登录
    public function login_wxOp(){
    	$this->checkLogin();
    	if(!$_GET['code']){
    		//第一步，请求code
    		$appid = '';
    		$redirect_uri = BBS_SITE_URL.url('index','login_wx');
    		$state = '';
    		$url = "https://open.weixin.qq.com/connect/qrconnect?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_login&state=$state#wechat_redirect";
    		header("Location: ".$url);
    	}else{
    		//第二步：通过code获取access_token
    		$appid = '';
    		$secret = '';
    		$code = $_GET['code'];
    		$get_access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
    		$data = $this->getJson($get_access_token_url);
    		$access_token = $data['access_token'];
    		$openid = $data['openid'];
    		//第三步：通过access_token调用接口,查用户信息
    		$get_userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
    		$info = $this->getJson($get_userinfo_url);
    		//p($info);
    		//查看微信号是否绑定
    		$data = Model('bbs_user')->where('wx_openid='.$info['openid'])->find();
    		if($data){
    			//保存用户信息
    			$this->saveUserInfo($data);
    			header("Location: ".urlBBS());
    		}else{
    			$_SESSION['userInfo_wx'] = $info;
    			header("Location: ".urlBBS('index','bind_wx'));
    		}
    	}
    } 
    //微信登录后绑定手机页面
    public function bind_wxOp(){
    	$this->checkLogin();
    	if(!isAjax()){
    		Tpl::showpage("bind_wx");
    		exit();
    	}
    	if(empty($_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号不能为空','control'=>'bind_wx'));
    	//验证手机格式
    	if(!isPhone($_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号格式不正确','control'=>'bind_wx'));
    	// if(empty($_POST['password']))
    	// 	ajaxReturn(array('code'=>'0','msg'=>'密码不能为空','control'=>'bind_wx'));
    	$db_user = Model('bbs_user');
    	$db_tmp = Model('bbs_tmp');
    	$userinfo = $db_user->where(array('member_phone'=>array('eq',$_POST['phone'])))->find();
    	if($userinfo){
    		//$db_tmp->where(array('remote_addr'=>array('eq',$_SERVER['REMOTE_ADDR'])))->delete();
    		ajaxReturn(array('code'=>'0','msg'=>'手机号已经绑定','control'=>'bind_wx'));
    	}
    	///验证短信验证码
    	$map = array();
    	$map['phone'] = array('eq',$_POST['phone']);
    	$map['remote_addr'] = array('eq',$_SERVER['REMOTE_ADDR']);
    	$map['code'] = array('eq',$_POST['code']);
    	$info = $db_tmp->where($map)->order('send_time desc')->find();
    	if(!$info)
    		ajaxReturn(array('code'=>'0','msg'=>'验证码不正确','control'=>'bind_wx'));
    	if(time()-$info['send_time'] > 120)
    		ajaxReturn(array('code'=>'0','msg'=>'验证码失效','control'=>'bind_wx'));
    	$password = random(6,0);
    	$data['member_name'] = 'hsn_'.$_POST['phone'];//账号用 hsn_手机号
    	$data['member_phone'] = $_POST['phone'];
    	$data['member_passwd'] = encrypt($password);
    	$data['last_login_ip'] = getIp();
    	$data['add_time'] = time();

    	$data['nick_name'] = $_SESSION['userInfo_wx']['nickname'];
    	$data['member_sex'] = $_SESSION['userInfo_wx']['sex'];
    	$data['province'] = $_SESSION['userInfo_wx']['province'];
    	$data['city'] = $_SESSION['userInfo_wx']['city'];
    	$data['headimgurl'] = $_SESSION['userInfo_wx']['headimgurl']?$_SESSION['userInfo_wx']['headimgurl']:BBS_SITE_URL.'/resource/bootstrap/img/logo.png';
    	$data['wx_openid'] = $_SESSION['userInfo_wx']['openid'];
    	$result = $db_user->insert($data);
    	if($result){
    		//删掉临时表的验证码
    		$db_tmp->where(array('id'=>array('eq',$info['id'])))->delete();
    		//保存用户信息
    		$this->saveUserInfo($db_user->where('id='.$result)->find());
    		//发短信通知
    		if(yunpian_sms($_POST['phone'],6,$password))
    			ajaxReturn(array('code'=>'200','msg'=>'绑定成功','control'=>'bind_wx','url'=>urlBBS('index','index')));
    		else
    			ajaxReturn(array('code'=>'200','msg'=>'绑定成功,但短信发送失败','control'=>'bind_wx','url'=>urlBBS('index','index')));
    	}else{
    		ajaxReturn(array('code'=>'0','msg'=>'绑定失败','control'=>'bind_wx'));
    	}
    }
    //密码找回
    public function findpwOp(){
    	$this->checkLogin();
    	if(!isAjax()){
    		Tpl::showpage("findpw");
    		exit();
    	}
    	if(empty($_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号不能为空','control'=>'findpw'));
    	//验证手机格式
    	if(!isPhone($_POST['phone']))
    		ajaxReturn(array('code'=>'0','msg'=>'手机号格式不正确','control'=>'findpw'));
    	if(empty($_POST['password']))
    		ajaxReturn(array('code'=>'0','msg'=>'密码不能为空','control'=>'findpw'));
    	//验证手机是否注册
    	$db_user = Model('bbs_user');
    	$map = array();
    	$map['member_phone'] = array('eq',$_POST['phone']);
    	$info = $db_user->where($map)->find();
    	if(!$info)
    		ajaxReturn(array('code'=>'0','msg'=>'手机号未注册','control'=>'findpw'));
		//验证短信验证码
    	$db_tmp = Model('bbs_tmp');
    	$map = array();
    	$map['phone'] = array('eq',$_POST['phone']);
    	$map['remote_addr'] = array('eq',$_SERVER['REMOTE_ADDR']);
    	$map['code'] = array('eq',$_POST['code']);
    	$data = $db_tmp->where($map)->order('send_time desc')->find();
    	if(!$data)
    		ajaxReturn(array('code'=>'0','msg'=>'验证码不正确','control'=>'findpw'));
		if(time()-$data['send_time'] > 120)
			ajaxReturn(array('code'=>'0','msg'=>'验证码失效','control'=>'findpw'));
		//重置密码
		$update['member_passwd'] = encrypt($_POST['password']);
		$result = $db_user->where(array('id'=>array('eq',$info['id'])))->update($update);
		if($result){
			$db_tmp->where(array('id'=>array('eq',$data['id'])))->delete();
			ajaxReturn(array('code'=>'200','msg'=>'重置成功','control'=>'findpw','url'=>urlBBS('index','login')));
		}else{
			ajaxReturn(array('code'=>'0','msg'=>'重置失败','control'=>'findpw'));
		}
    	

    }
    function getJson($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }
    //存用户信息
    function saveUserInfo($info){
    	$_SESSION['is_login'] = $info['id'];//用户登录标志
    	unset($info['member_passwd']);
    	$_SESSION['userInfo'] = $info;
     	//$_SESSION['user_id'] = $info['id'];//用户id
		// $_SESSION['member_name'] = $info['member_name'];//用户名
		// $_SESSION['nick_name'] = $info['nick_name'];//昵称
		// $_SESSION['member_sex'] = $info['member_sex'];//性别1.男 2.女 3.保密
		// $_SESSION['member_age'] = $info['member_age'];//年龄

		// $_SESSION['province'] = $info['province'];//省
		// $_SESSION['city'] = $info['city'];//市
		// $_SESSION['area'] = $info['area'];//区
		// $_SESSION['address'] = $info['address'];//详细地址
		// $_SESSION['login_times'] = $info['login_times']+1;//登录次数
		// $_SESSION['integral'] = $info['integral'];//积分
		// $_SESSION['is_wx'] = $info['is_wx'];//是否绑定微信 0.未绑定 1.已绑定
		// $_SESSION['member_phone'] = $info['member_phone'];//手机号
		// $_SESSION['member_sign'] = $info['member_sign'];//签名
		// $_SESSION['is_teacher'] = $info['is_teacher'];//是否是老师 0.不是 1.是
		// $_SESSION['wx_openid'] = $info['wx_openid'];//微信id
		// $_SESSION['headimgurl'] = $info['wx_openid'];//头像
    }

    public function testOp(){
    	p($_SESSION);
    	p(decrypt($_GET['passwd']));
    	p(encrypt($_GET['password']));
    	p(time());
    	p(random(6,0));
    }
}