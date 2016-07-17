<?php
defined('APPID','');
defined('APPSECRET','');
defined('TOKEN','');

require './wechat.class.php';
$wechat = new WeChat(APPID,APPSECRET,TOKEN);
$wechat->responseMsg();