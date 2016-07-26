<?php
define('APPID','');
define('APPSECRET','');
define('TOKEN','');
define('TULINGKEY','');

require './wechat.class.php';
$wechat = new WeChat(APPID,APPSECRET,TOKEN,TULINGKEY);
$wechat->responseMsg();