<?php
/**
 * Created by PhpStorm.
 * User: 神秘大腿
 * Date: 2017/3/14
 * Time: 16:16
 * QQ:  997823131 
 */
defined('InCosmos') or exit('Access Invalid!');
class app_pay
{
    const DEBUG = 0; // 是否开启 日志模式

    protected $config;

    public function __construct()
    {
        $this->config = (object)array(
            'appId' => 'wxc7a6049820cf0efd',//wx76f323fa386627e7  //wxc7a6049820cf0efd
            'appSecret' => '1a44156b7d2d759090ed3508bd3ff581',//3564b4ba8419790cc0d2f523e0d0a9f9 //1a44156b7d2d759090ed3508bd3ff581
            'partnerId' => '1373214302',// 1351031801 // 1373214302
            'apiKey' => '1a44156b7d2d759090ed350bd3ff5kvr',//1a44156b7d2d759090ed3508bd3ff589 //3564b4ba8419790cc0d2f523e0d0a9f9 //1a44156b7d2d759090ed350bd3ff5kvr

            'notifyUrl' => MOBILE_SITE_URL . '/api/payment/wxpay_jsapi/app_notify.php',
            'finishedUrl' => WAP_SITE_URL . '/tmpl/member/payment_result.html?_=2&attach=_attach_',
            'undoneUrl' => WAP_SITE_URL . '/tmpl/member/payment_result_failed.html?_=2&attach=_attach_',

            'orderSn' => date('YmdHis'),
            'orderInfo' => 'Test app  api',
            'orderFee' => 1,
            'orderAttach' => '_',
        );
    }

    // 可以另外设置参数
    public function setConfig($name, $value)
    {
        $this->config->$name = $value;
    }

//用数组方法设置参数
    public function setConfigs(array $params)
    {
        foreach ($params as $name => $value) {
            $this->config->$name = $value;
        }
    }

    //通知
    public function notify()
    {
        try {
            $data = $this->onNotify(); // 这里是

            $resultXml = $this->arrayToXml(array(
                'return_code' => 'SUCCESS',
            ));

            if (self::DEBUG) {
                @file_put_contents(__DIR__ . '/log.txt', var_export($data, true), FILE_APPEND | LOCK_EX);
            }

        } catch (Exception $ex) {

            $data = null;
            $resultXml = $this->arrayToXml(array(
                'return_code' => 'FAIL',
                'return_msg' => $ex->getMessage(),
            ));

            if (self::DEBUG) {
                @file_put_contents(__DIR__ . '/log_err.txt', $ex . PHP_EOL, FILE_APPEND | LOCK_EX);
            }

        }
        $log_path = BASE_DATA_PATH.DS."log".DS."wxpay".DS."ES".DS.date("Y-m-d",time()).".log";
        if($data){
            foreach($data as $key=>$val){
                $str .= $key."=>".$val;
            }
        }else{
            $str = '失败';
        }
//        @file_put_contents($log_path,$str.PHP_EOL,FILE_APPEND); // 输出返回来的信息
        return array(

            $data,
            $resultXml,
        );
    }
// 验证信息是否是马化腾服务器来的数据
    public function onNotify()
    {
        $d = $this->xmlToArray(file_get_contents('php://input')); // 把POST请求的数据转换为array

        if (empty($d)) {
            throw new Exception(__METHOD__);
        }

        if ($d['return_code'] != 'SUCCESS') {
            throw new Exception($d['return_msg']);
        }

        if ($d['result_code'] != 'SUCCESS') {
            throw new Exception("[{$d['err_code']}]{$d['err_code_des']}");
        }

        if (!$this->verify($d)) {
            throw new Exception("Invalid signature");
        }

        return $d;
    }
    // 再次确定签名是否存在
    public function verify(array $d)
    {
        if (empty($d['sign'])) {
            return false;
        }

        $sign = $d['sign'];
        unset($d['sign']);

        return $sign == $this->sign($d);
    }
    // 获取预支付
    public function get_wx_preId($total_fee, $pay_sn)
    {
        $data = array();
        $data['appid'] = $this->config->appId; //应用APPID
        $data['mch_id'] = $this->config->partnerId;//商户号
        $data['device_info'] = "WEB";//终端编号 可以不用传
        $data['nonce_str'] = md5(uniqid(mt_rand(), true));//随机字符串
        $data['body'] = '钓友天下'; // 应用名字
//        $data['detail'] = '钓友天下'; // 商品详细列表，使用Json格式，传输签名前请务必使用CDATA标签将JSON文本串保护起来 可以不用传
        $data['attach'] = 'r';// 附加数据 可以不用传递
        $data['out_trade_no'] = $pay_sn;//订单号32 个字符内  可控参数
        $data['total_fee'] = intval($total_fee*100); // 金额          可控参数
        $data['spbill_create_ip'] = $_SERVER['REMOTE_ADDR']; //终端IP
        $data['notify_url'] = 'http://www.diaoyoutx.com/mobile/api/payment/wxpay_jsapi/app_notify.php'; // 回调地址
        $data['trade_type'] = 'APP';
        $sign = $this->sign($data);
        $data['sign'] = $sign;
//        echo 'bbb';

        $result = $this->postXml('https://api.mch.weixin.qq.com/pay/unifiedorder', $data);
//        P($result);
        /*if ($result['return_code'] != 'SUCCESS') {
            throw new Exception($result['return_msg']);

        }

        if ($result['result_code'] != 'SUCCESS') {
            throw new Exception("[{$result['err_code']}]{$result['err_code_des']}");

        }*/

        if ($result['result_code'] == 'SUCCESS') {
            /*二次签名 start */
            $second_data['appid'] = $this->config->appId; //应用APPID
            $second_data['partnerid'] = $this->config->partnerId;
            $second_data['prepayid'] = $result['prepay_id'];
            $second_data['noncestr'] = md5(uniqid(mt_rand(), true));//随机字符串
            $second_data['timestamp'] = time();
            $second_data['package'] = "Sign=WXPay";
            $second_data['sign'] = $this->sign($second_data);

            /*二次签名 end */
            ajaxReturn($second_data);
        } else {
            ajaxReturn($result);
        }
//        return $result['prepay_id'];
    }

    // 签名算法
    public function sign(array $data)
    {
        ksort($data);

        $a = array();
        foreach ($data as $k => $v) {
            if ((string)$v === '') {
                continue;
            }
            $a[] = "{$k}={$v}";
        }

        $a = implode('&', $a);
        $a .= '&key=' . $this->config->apiKey;

        return strtoupper(md5($a));
    }

    // xml请求
    public function postXml($url, array $data)
    {
        // pack xml
        $xml = $this->arrayToXml($data);
        $bath_path = BASE_ROOT_PATH . DS . "mobile" . DS . "api" . DS . "payment" . DS . "wxpay" . DS . "cert" . DS;
        // curl post
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSLCERT, $bath_path . "apiclient_cert.pem");
        curl_setopt($ch, CURLOPT_SSLKEY, $bath_path . "apiclient_key.pem");
        curl_setopt($ch, CURLOPT_CAINFO, $bath_path . "rootca.pem");

        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $response = curl_exec($ch);
        if (!$response) {
            throw new Exception('CURL Error: ' . curl_errno($ch));
        }
        curl_close($ch);

        // unpack xml
        return $this->xmlToArray($response);
    }

    // array 转 XML
    public function arrayToXml(array $data)
    {
        $xml = "<xml>";
        foreach ($data as $k => $v) {
            if (is_numeric($v)) {
                $xml .= "<{$k}>{$v}</{$k}>";
            } else {
                $xml .= "<{$k}><![CDATA[{$v}]]></{$k}>";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    public function xmlToArray($xml)
    {
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

}