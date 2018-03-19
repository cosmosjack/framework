<?php
defined('InCosmos') or exit('Access Invalid!');

require_once(dirname(__FILE__) . DS . 'lib/HttpClient.class.php');
require_once(dirname(__FILE__) . DS . 'config.inc.php');

$GLOBALS['sms_options'] = $options;

/**
* 模板接口发短信
* apikey 为云片分配的apikey
* tpl_id 为模板id
* tpl_value 为模板值
* mobile 为接收短信的手机号
*/
function tpl_send_sms($tpl_id, $tpl_value, $mobile){
	$path = "/v1/sms/tpl_send.json";
	return Send::sendSms($path, $GLOBALS['sms_options']['apikey'], $mobile, $tpl_id, $tpl_value);
}

/**
* 普通接口发短信
* apikey 为云片分配的apikey
* text 为短信内容
* mobile 为接收短信的手机号
*/
function send_sms($content, $mobile){
	$path = "/v1/sms/send.json";
   // return false;
	//return Send::sendSms($path, $GLOBALS['sms_options']['apikey'], str_replace(C('site_name'), $GLOBALS['sms_options']['signature'], $content), $mobile);
    return Send::sendMsg($GLOBALS['sms_options']['apikey'],$mobile,$content);
}

class Send {

	const HOST = 'https://sms.yunpian.com/v2/sms/single_send.json';

	final private static function __replyResult($jsonStr) {
		//header("Content-type: text/html; charset=utf-8");
		$result = json_decode($jsonStr);
		if ($result->code == 0) {
			$data['state'] = 'true';
			return ture;
		} else {
			$data['state'] = 'false';
			$data['msg'] = $result->msg;
			return false;
		}
	}

	final public static function sendSms($path, $apikey, $encoded_text, $mobile, $tpl_id = '', $encoded_tpl_value = '') {
		/*$client = new HttpClient(self::HOST);
		$client->setDebug(false);
		if (!$client->post($path, array (
				'apikey' 		=> $apikey,
				'text' 			=> $encoded_text,
				'mobile' 		=> $mobile,
				'tpl_id' 		=> $tpl_id,
				'tpl_value' 	=> $encoded_tpl_value
		))) {
			return '-10000';
		} else {
           // return 222;
			return self::__replyResult($client->getContent());
		}*/

        $ch = curl_init();
// 必要参数
        $apikey = $apikey; //修改为您的apikey(https://www.yunpian.com)登录官网后获取
        $mobile = $mobile; //请用手机号代替
        $text="【云片网】您的验证码是1234";
        // 发送短信
        $data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
        curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $json_data = curl_exec($ch);
//解析返回结果（json格式字符串）
        $array = json_decode($json_data,true);
        return $array;
	}
    final public static function sendMsg($apikey,$mobile,$body) {

        $ch = curl_init();
// 必要参数
        $apikey = $apikey; //修改为您的apikey(https://www.yunpian.com)登录官网后获取
        $mobile = $mobile; //请用手机号代替
        $text= $body ? $body : "【时刻需】您的验证码是6666";
        // 发送短信
        $data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
        $url = "https://sms.yunpian.com/v2/sms/single_send.json";
        $result = doCurl($url,$data);

        $array = json_decode($result,true);
        return $array;
    }

    private function get_curl($url, $cookie = 0, $post = 0, $referer = 0, $header = 0, $ua = 0, $nobaody = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $klsf[] = "Accept:*/*";
        $klsf[] = "Accept-Encoding:gzip,deflate,sdch";
        $klsf[] = "Accept-Language:zh-CN,zh;q=0.8";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $klsf);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if ($header) {
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
        }

        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        if ($referer) {
            if ($referer == 1) {
                curl_setopt($ch, CURLOPT_REFERER, "http://m.qzone.com/infocenter?g_f=");
            } else {
                curl_setopt($ch, CURLOPT_REFERER, $referer);
            }
        }
        if ($ua) {
            curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        } else {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.0.4; es-mx; HTC_One_X Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0');
        }
        if ($nobaody) {
            curl_setopt($ch, CURLOPT_NOBODY, 1);//主要头部
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);//跟随重定向
        }
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;

    }



}

?>