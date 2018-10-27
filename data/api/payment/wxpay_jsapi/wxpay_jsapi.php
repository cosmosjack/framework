<?php

defined('InCosmos') or exit('Access Invalid!');


class wxpay_jsapi
{
    const DEBUG = 0; // 是否开启 日志模式

    protected $config;
//配置参数
    public function __construct()
    {
        $this->config = (object) array(
            'appId' => 'wxa286179f364df0be', //wx76f323fa386627e7  //wxc7a6049820cf0efd
            'appSecret' => '09d3bbe599337a1c943401b83dbbacac',//3564b4ba8419790cc0d2f523e0d0a9f9 //1a44156b7d2d759090ed3508bd3ff581
            'partnerId' => '1329426201',// 1351031801 // 1373214302
            'apiKey' => '3ae9771bac808dd4fe100866ec0c356a',//1a44156b7d2d759090ed3508bd3ff589 //3564b4ba8419790cc0d2f523e0d0a9f9

            'notifyUrl' => BASE_SITE_URL . '/data/api/payment/wxpay_jsapi/notify_url.php',
//            'notifyUrl' => BBS_SITE_URL . DS.'index.php?act=wx&op=notify',
            'finishedUrl' => "http://www.gdhsn.net/bbs/index.php?act=order&op=orderCompleted",
            'undoneUrl' => "http://www.gdhsn.net/bbs/index.php?act=order&op=index",

            'orderSn' => date('YmdHis'),
            'orderInfo' => 'Test wxpay js api',
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

    protected $control; // 声明内部保护变量
// 手机端支付页面
    public function paymentHtml($control = null) {
        $this->control = $control;

        $prepayId = $this->getPrepayId();

        $params = array();
        $params['appId'] = $this->config->appId;
        $params['timeStamp'] = '' . time();
        $params['nonceStr'] = md5(uniqid(mt_rand(), true));
        $params['package'] = 'prepay_id=' . $prepayId;
        $params['signType'] = 'MD5';

        $sign = $this->sign($params);
        $params['paySign'] = $sign;

        // @todo timestamp
        $jsonParams = json_encode($params);
//p($jsonParams);
//        die();
        return <<<EOB
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
<title>微信安全支付</title>
</head>
<body>
正在加载…
<script type="text/javascript">
function jsApiCall() {
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest',
        {$jsonParams},
        function(res) {
            var h;
            if (res && res.err_msg == "get_brand_wcpay_request:ok") {
                // success;
                h = '{$this->config->finishedUrl}';
            } else {
                // fail;
                alert(res && res.err_msg);
                h = '{$this->config->undoneUrl}';
            }
            location.href = h.replace('_attach_', '{$this->config->orderAttach}');
        }
    );
}
window.onload = function() {
    if (typeof WeixinJSBridge == "undefined") {
        if (document.addEventListener) {
            document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
        } else if (document.attachEvent) {
            document.attachEvent('WeixinJSBridgeReady', jsApiCall);
            document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
        }
    } else {
        jsApiCall();
    }
}
</script>
</body>
</html>
EOB;
    }

    protected function getOpenId()
    {
        if ($c = $this->control) {
            $openId = $c->getOpenId();
            if ($openId) {
                return $openId;
            }

            // through multiple requests
            $openId = $this->getOpenIdThroughMultipleRequests();
            $c->setOpenId($openId);

            return $openId;
        }

        return $this->getOpenIdThroughMultipleRequests();
    }

    public function getPrepayId(){

        $openId = $this->getOpenId();
//		P($openId);
//        die;
        $data = array();
        $data['appid'] = $this->config->appId;
        $data['mch_id'] = $this->config->partnerId;
        $data['nonce_str'] = md5(uniqid(mt_rand(), true));
        $data['body'] = $this->config->orderInfo;
        $data['attach'] = $this->config->orderAttach;
        $data['out_trade_no'] = $this->config->orderSn;
        $data['total_fee'] = $this->config->orderFee;
        $data['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'];
        $data['notify_url'] = $this->config->notifyUrl;
        $data['trade_type'] = 'JSAPI'; // h5 "MWEB"  // JSAPI
        $data['openid'] = $openId; // H5 中可以不用传递

        //   {"h5_info": //h5支付固定传"h5_info"{"type": "",  //场景类型"wap_url": "",//WAP网站URL地址"wap_name": ""  //WAP 网站名}}
//        $data['scene_info'] =  array('h5_info'=>array('type'=>'H5','wap_url'=>"http://www.gdhsn.net/bbs/index.php",'wap_name'=>'好少年'));
        $sign = $this->sign($data);
        $data['sign'] = $sign;


        $result = $this->postXml('https://api.mch.weixin.qq.com/pay/unifiedorder', $data);
        /*P($result);
        die;*/
        if ($result['return_code'] != 'SUCCESS') {
            throw new Exception($result['return_msg']);
        }

        if ($result['result_code'] != 'SUCCESS') {
            throw new Exception("[{$result['err_code']}]{$result['err_code_des']}");
        }

        return $result['prepay_id'];
//        P($result['prepay_id']);
    }

    public function getOpenIdThroughMultipleRequests()
    {
        if (empty($_GET['code'])) {
            if (isset($_GET['state']) && $_GET['state'] == 'redirected') {
                throw new Exception('Auth failed');
            }

            $url = sprintf(
                'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=redirected#wechat_redirect',
                $this->config->appId,
                urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])
            );
            header('Location: ' . $url);
            exit;
        }

        $d = json_decode(file_get_contents(sprintf(
            'https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code',
            $this->config->appId,
            $this->config->appSecret,
            $_GET['code']
        )), true);

        if (empty($d)) {
            throw new Exception(__METHOD__);
        }

        if (empty($d['errcode']) && isset($d['openid'])) {
            return $d['openid'];
        }

        throw new Exception(var_export($d, true));
    }

    public function sign(array $data)
    {
        ksort($data);

        $a = array();
        foreach ($data as $k => $v) {
            if ((string) $v === '') {
                continue;
            }
            $a[] = "{$k}={$v}";
        }

        $a = implode('&', $a);
        $a .= '&key=' . $this->config->apiKey;

        return strtoupper(md5($a));
    }

    public function postXml($url, array $data)
    {
        // pack xml
        $xml = $this->arrayToXml($data);

        // curl post
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
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
