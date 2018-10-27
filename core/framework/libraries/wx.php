<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/9/6
 * Time: 19:15
 * QQ:  997823131 
 */
defined('InCosmos') or exit('Access Invalid!');

Class Wx{
    private $appid = 'wxa286179f364df0be';
    private $secret = '09d3bbe599337a1c943401b83dbbacac';

    public function init(){

        $url_this =  $this->GetCurUrl();
        $accessToken = $this->get_AccessToken();
        $js_ticket = $this->get_jsticket($accessToken);

        $time = time();
        $data['noncestr'] = $this->create_str(8);
        $data['jsapi_ticket'] = $js_ticket;
        $data['timestamp'] = $time;
        $data['url'] = $url_this;

        $signature = $this->get_signature($data);
        $data['signature'] = $signature;
        return $data;
    }

    private function get_AccessToken(){

        $wx_access_token = $_SESSION['wx_access_token'] ? $_SESSION['wx_access_token'] :'';
        if(!$wx_access_token || $wx_access_token ==''){
            $appid = $this->appid;  // 正常时从数据库取数据
            $appsecret = $this->secret; // 正常时从数据库取数据
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
            return $wx_access_token;

        }else{
            $url_jsapi_ticket =  'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$wx_access_token.'&type=jsapi';

            $userinfo_ch = curl_init();
            curl_setopt($userinfo_ch, CURLOPT_URL, $url_jsapi_ticket);
            curl_setopt($userinfo_ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($userinfo_ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($userinfo_ch, CURLOPT_RETURNTRANSFER, 1);
            $userinfo_out = curl_exec($userinfo_ch);
            curl_close($userinfo_ch);

            $json_data = json_decode($userinfo_out,true);
            if(isset($json_data['errcode']) && $json_data['errmsg'] != '0'){
                $appid = $this->appid;  // 正常时从数据库取数据
                $appsecret = $this->secret; // 正常时从数据库取数据
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
                return $wx_access_token;
            }else{
                return $wx_access_token;
            }
        }

    }

    // 获取 jsticket
    private function get_jsticket($accesstoken){
        $url_jsapi_ticket =  'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$accesstoken.'&type=jsapi';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_jsapi_ticket);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $userinfo_out = curl_exec($ch);
        curl_close($ch);

        $json_data = json_decode($userinfo_out,true);
        return $json_data['ticket'];
    }
    // 获取 sign
    private function get_signature($data){
        $data_key = array();
        foreach($data as $k=>$v){
            $data_key[] = $k;
        }

        sort($data_key);

        $sign_str = '';
        foreach($data_key as $key=>$val){
            $sign_str .= $val."=".$data[$val]."&";
        }

        $sign_str = substr($sign_str,0,strlen($sign_str)-1);
        $signature = sha1( $sign_str );

        return $signature;
    }

    private function create_str( $length = 8 ) {
//        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ( $i = 0; $i < $length; $i++ )
        {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
            $str .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $str;
    }

    private function GetCurUrl(){
        if(isset($_SERVER['REQUEST_URI'])){
            $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        }else{
            if(isset($_SERVER['argv'])){
                $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['argv'][0];
            }else{
                $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
            }
        }
        return $url;//注意这里给编码了
    }
}