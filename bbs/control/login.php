<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/5/28
 * Time: 15:51
 * QQ:  997823131 
 */
class loginControl extends BaseControl{
    public function __construct(){
        parent::__construct();
    }
    /*
    * 接受微信服务器传送过来的code
    * 生成 openID 并存入session
    * 跳转至 登录界面 user_insert 下的index
    */
    public function indexOp(){
            //P($_GET);
            $state_value = '123';
            $appid = "wxa286179f364df0be";  // 正常时从数据库取数据
            $appsecret = "09d3bbe599337a1c943401b83dbbacac"; // 正常时从数据库取数据
            $return_url = 'http://www.gdhsn.net/bbs/index.php?act=login';
            $get_codeUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxa286179f364df0be&redirect_uri='.$return_url.'&response_type=code&scope=snsapi_base&state='.$state_value.'#wechat_redirect';
            $get_accessUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$appsecret.'&code='.$_GET['code']."&grant_type=authorization_code";


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $get_accessUrl);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $jsoninfo = json_decode($output, true);
            //  ajaxReturn($jsoninfo,'JSONP');
            $_SESSION['openid'] = $jsoninfo['openid'];

        $this->wx_get($_SESSION['openid'],'666');
          p($_SESSION);
    }

    //  获取微信 access_token  和 用户信息
    private function wx_get($openid,$chief){
        //整理 访问微信服务器的地址 start
        // P($_SESSION['wx_access_token']);
        $chief = $chief ? $chief : 'qrscene_666';
        $openid = $openid ? $openid : 'oNlhuxOMiPzAsCM8POazeEFzLLvk';
        $wx_access_token = $_SESSION['wx_access_token'] ? $_SESSION['wx_access_token'] :'';
        $wx_openid = $_SESSION['wx_openid'] ? $_SESSION['wx_openid'] :'';
        //  先判断 access_token 是否存在 不存在则 重新获取  如果存在则 判断 是否可以用 不可以用则重新生成
        if(!$wx_access_token || $wx_access_token ==''){
            $appid = "wxa286179f364df0be";  // 正常时从数据库取数据
            $appsecret = "09d3bbe599337a1c943401b83dbbacac"; // 正常时从数据库取数据
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $jsoninfo = json_decode($output, true);
            $wx_access_token = $jsoninfo["access_token"];
            $_SESSION['wx_access_token'] = $wx_access_token;
        }else{
            $get_userinfo = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$wx_access_token."&openid=".$wx_openid;
            $userinfo_ch = curl_init();
            curl_setopt($userinfo_ch, CURLOPT_URL, $get_userinfo);
            curl_setopt($userinfo_ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($userinfo_ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($userinfo_ch, CURLOPT_RETURNTRANSFER, 1);
            $userinfo_out = curl_exec($userinfo_ch);
            curl_close($userinfo_ch);

            $json_userinfo = json_decode($userinfo_out,true);
            if(isset($json_userinfo['errcode'])){
                $appid = "wxa286179f364df0be";  // 正常时从数据库取数据
                $appsecret = "09d3bbe599337a1c943401b83dbbacac"; // 正常时从数据库取数据
                $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($ch);
                curl_close($ch);
                $jsoninfo = json_decode($output, true);
                $wx_access_token = $jsoninfo["access_token"];
                $_SESSION['wx_access_token'] = $wx_access_token;
            }
        }
        $get_userinfo = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$wx_access_token."&openid=".$openid;
        $user_ch = curl_init();
        curl_setopt($user_ch, CURLOPT_URL, $get_userinfo);
        curl_setopt($user_ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($user_ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($user_ch, CURLOPT_RETURNTRANSFER, 1);
        $user_out = curl_exec($user_ch);
        curl_close($user_ch);

        $json_user = json_decode($user_out,true);

          p($json_user);

        //整理 访问微信服务器的地址 end
        /*  整理获取到用户的数据 start */
//        $insert_user['user_name'] = $json_user['nickname'];
//        $insert_user['user_passwd'] = $json_user['openid'];
//        $insert_user['user_chief'] = $chief;
//        $insert_user['sex'] = $json_user['sex'];
//        $insert_user['phone'] = '';
//        $insert_user['user_pic'] = $json_user['headimgurl'];
//        $insert_user['country'] = $json_user['country'];
//        $insert_user['province'] = $json_user['province'];
//        $insert_user['city'] = $json_user['city'];
//        $insert_user['wx_openid'] = $json_user['openid'];
        /*  整理获取到用户的数据 end */
        //插入数据库
        // P($insert_user);
        // $db_user = D('user');
        // $db_user->insert($insert_user);
        // P($wx_access_token);
//        return(array('wx_access_token'=>$wx_access_token,'insert_user'=>$insert_user));
    }
}