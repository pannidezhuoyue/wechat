<?php
class WeChat{
    private $_appid;
    private $_appsecret;
    private $_token;
    public function __construct($_appid, $_appsecret,$_token){
        $this->_appid = $_appid;
        $this->_appsecret = $_appsecret;
        $this->token = $_token;
    }

    public function _request($curl,$https = true,$method = 'GET',$data = null){
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, $curl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if($https){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if($method == 'POST'){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
        }
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    public function _getAccessToken(){
        $file = './accesstoken';
        if(file_exists($file)){
            $content = file_get_contents($file);
            $content = json_decode($content);
            if(time() - filemtime($file) < $content->expires_in){
                return $content->access_token;;
            }
        }
        $curl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->_appid.'&secret='.$this->_appsecret;
        $content = $this->_request($curl);
        file_put_contents($file, $content);
        $content = json_decode($content);
        return $content->access_token;
    }

    public function _getTicket($sceneid, $type='temp',$expire_seconds = 604800){
        if($type=='temp'){
            $data = '{"expire_seconds": %s, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": %s}}}';
            $data = sprintf($data, $expire_seconds, $sceneid);
        }
        else{
            $data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": %s}}}';
            $data = sprintf($data, $sceneid);
        }
        $curl = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->_getAccessToken();
        $content = $this->_request($curl, true, 'POST', $data);
        $content = json_decode($content);
        return $content->ticket;
    }

    public function _getQRCode($sceneid, $type = 'temp', $expire_seconds = 604800){
        $ticket = $this->_getTicket($sceneid, $type, $expire_seconds);
        $content = $this->_request('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($ticket));
        return $content;
    }

    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postObj = simplexml_load_string($postStr,'simpleXMLElement',LIBXML_NOCDATA);
        switch ($postObj->MsgType) {
            case 'text':
                $this->_doText($postObj);
                break;

            case 'image':
                $this->_doImage($postObj);
                break;

            case 'voice':
                $this->_doVoice($postObj);
                break;

            case 'event':
                $this->_doEvent($postObj);
                break;
            
            default:
                # code...
                break;
        }
    }

    private function _doText($postObj){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $time = time();
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";             
        switch ($keyword) {
            case 'zhangzhuo':
                $contentStr = '叛逆的卓越';
                break;
            
            default:
                $contentStr = "Welcome to wechat world!";
                break;
        }
        $msgType = "text";
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        echo $resultStr;
    }

    private function _doEvent($postObj){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Event);
        $time = time();
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";             
        switch ($keyword) {
            case 'subscribe':           //订阅
                $contentStr = '欢迎订阅';
                break;

            case 'unsubscribe':         //取消订阅
                $contentStr = '';
                break;
            
            default:
                $contentStr = "未定义";
                break;
        }
        $msgType = "text";
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        echo $resultStr;
    }
        
    private function checkSignature()
    {
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
                
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}

// $wechat = new WeChat('wx70e955edcecdf7f8','a4515189b5230578f6faea92ae0e84a5','');
// $wechat->valid();//第一次接入微信平台时使用
// echo $wechat->_getAccessToken();
// header('Content-type:image/jpeg');
// echo $wechat->_getQRCode(1);
// $wechatObj = new WeChat();
// $wechatObj->responseMsg();
?>