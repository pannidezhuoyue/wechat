<?php
define('APPID','wxdca846fffd4d6ada');
define('APPSECRET','223e781aae6cd5e864c61cbf9f0e02d4');
define('TOKEN','');
define('TULINGKEY','eb720a8970964f3f855d863d24406576');

require './wechat.class.php';
$wechat = new WeChat(APPID,APPSECRET,TOKEN,TULINGKEY);
$wechat->responseMsg();