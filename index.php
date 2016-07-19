<?php
define('APPID','');
define('APPSECRET','');
define('TOKEN','');

require './wechat.class.php';
$wechat = new WeChat(APPID,APPSECRET,TOKEN);
$wechat->responseMsg();