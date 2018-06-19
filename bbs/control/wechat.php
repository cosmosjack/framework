<?php



/* 

  实现功能：

  1.扫码关注提示

  2.点击click事件自动回复  

*/

class WechatControl extends BaseControl

{
    public function __construct(){
//        parent::__construct();
        define('TOKEN','cosmos');
    }

    public function indexOp(){

        if (!isset($_GET['echostr'])) {

            $this->responseMsg();

        }else{

            $this->valid();

        }
    }

    public function valid()

    {

        $echoStr = $_GET["echostr"];

        if($this->checkSignature()){

            echo $echoStr;

            exit;

        }

    }



    private function checkSignature()

    {

        $signature = $_GET["signature"];

        $timestamp = $_GET["timestamp"];

        $nonce = $_GET["nonce"];



        $token = TOKEN;

        $tmpArr = array($token, $timestamp, $nonce);

        sort($tmpArr);

        $tmpStr = implode( $tmpArr );

        $tmpStr = sha1( $tmpStr );



        if( $tmpStr == $signature ){

            return true;

        }else{

            return false;

        }

    }



    public function responseMsg()

    {

        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr)){

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

            $RX_TYPE = trim($postObj->MsgType);



            switch ($RX_TYPE)

            {

                case "text":

                    $resultStr = $this->receiveText($postObj);

                    break;

                case "event":

                    $resultStr = $this->receiveEvent($postObj);

                    break;

                default:

                    $resultStr = "";

                    break;

            }

            echo $resultStr;

        }else {

            echo "";

            exit;

        }

    }



    private function receiveText($object)

    {

        $funcFlag = 0;

        $contentStr = "你发送的内容为：".$object->Content;

        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);

        return $resultStr;

    }



    private function receiveEvent($object)

    {

        $contentStr = "";

        switch ($object->Event)

        {
            // 关注事件
            case "subscribe":
                // 返回 access_token  和 用户 信息   param  第一个 openid 第二个 上级代理 ID 不传 默认为零
                $access_token = wx_get($object->FromUserName,$object->EventKey);

                /* 异步传输 start  返回 0 失败 1 成功 2 已经注册过*/
                $insert_url = "http://".$_SERVER['HTTP_HOST'].$GLOBALS["app"]."user_insert/add";
                $insert_ch = curl_init();
                curl_setopt($insert_ch,CURLOPT_URL,$insert_url);
                curl_setopt($insert_ch,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($insert_ch,CURLOPT_POST,1);
                curl_setopt($insert_ch,CURLOPT_POSTFIELDS,$access_token['insert_user']);
                $insert_out = curl_exec($insert_ch);
                curl_close($insert_ch);
                /* 异步传输  end*/

                if($insert_out == 1){
                    $contentStr= '谢谢关注'/*.$object->EventKey*/;
                }elseif($insert_out == 2){
                    $contentStr = '您已经注册过，欢迎回来'/*.$insert_out.$object->EventKey*/;
                }else{
                    $contentStr = '你已经时我们的VIP'/*.$insert_out.$object->EventKey*/;
                }

                break;

            case "unsubscribe":

                break;
            case "SCAN":

                $contentStr = "找工作！赶职网"/*.$object->FromUserName.$object->EventKey*/;

                break;

            case "CLICK":

                switch ($object->EventKey)

                {

                    case "company":

                        $contentStr[] = array("Title" =>"公司简介",

                            "Description" =>"赶职网提供优质服务"/*.$object->FromUserName*/,

                            "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg",

                            "Url" =>"http://z-zfd.wh2013.com/index.php/index/add/userid/".$object->FromUserName);

                        break;

                    default:

                        $access_token = wx_get($object->FromUserName,'');


                        /* 异步传输 start  返回 0 失败 1 成功 2 已经注册过*/
                        $insert_url = "http://".$_SERVER['HTTP_HOST'].$GLOBALS["app"]."user_insert/add";
                        $insert_ch = curl_init();
                        curl_setopt($insert_ch,CURLOPT_URL,$insert_url);
                        curl_setopt($insert_ch,CURLOPT_RETURNTRANSFER,1);
                        curl_setopt($insert_ch,CURLOPT_POST,1);
                        curl_setopt($insert_ch,CURLOPT_POSTFIELDS,$access_token['insert_user']);
                        $insert_out = curl_exec($insert_ch);
                        curl_close($insert_ch);
                        /* 异步传输  end*/
                        if($insert_out == 1){
                            $contentStr[] = array("Title" =>"欢迎点赞666".$access_token['insert_user']['user_name'].$GLOBALS["app"].$insert_out,

                                "Description" =>"您正在使用我的点赞系统2016.12.7",

                                "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg",

                                "Url" =>"http://".$_SERVER['HTTP_HOST'].$GLOBALS["app"]);
                        }else{
                            $contentStr = '您已经成为我们的VIP'.$insert_out;
                        }



                        break;

                }

                break;

            default:

                break;



        }

        if (is_array($contentStr)){

            $resultStr = $this->transmitNews($object, $contentStr);

        }else{

            $resultStr = $this->transmitText($object, $contentStr);

        }

        return $resultStr;

    }



    private function transmitText($object, $content, $funcFlag = 0)

    {

        $textTpl = "<xml>

<ToUserName><![CDATA[%s]]></ToUserName>

<FromUserName><![CDATA[%s]]></FromUserName>

<CreateTime>%s</CreateTime>

<MsgType><![CDATA[text]]></MsgType>

<Content><![CDATA[%s]]></Content>

<FuncFlag>%d</FuncFlag>

</xml>";

        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $funcFlag);

        return $resultStr;

    }



    private function transmitNews($object, $arr_item, $funcFlag = 0)

    {

        //首条标题28字，其他标题39字

        if(!is_array($arr_item))

            return;



        $itemTpl = "    <item>

        <Title><![CDATA[%s]]></Title>

        <Description><![CDATA[%s]]></Description>

        <PicUrl><![CDATA[%s]]></PicUrl>

        <Url><![CDATA[%s]]></Url>

    </item>

";

        $item_str = "";

        foreach ($arr_item as $item)

            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);



        $newsTpl = "<xml>

<ToUserName><![CDATA[%s]]></ToUserName>

<FromUserName><![CDATA[%s]]></FromUserName>

<CreateTime>%s</CreateTime>

<MsgType><![CDATA[news]]></MsgType>

<Content><![CDATA[]]></Content>

<ArticleCount>%s</ArticleCount>

<Articles>

$item_str</Articles>

<FuncFlag>%s</FuncFlag>

</xml>";



        $resultStr = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item), $funcFlag);

        return $resultStr;

    }
     function insert_db($data_insert){
          //  $db_user = D('user');
           // $db_user->insert($data_insert);
         echo 'bbb';
        // $this->display();
//         P($db_user->select());
    }

}

?>