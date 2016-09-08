<?php
define('APPID','wxdca846fffd4d6ada');
define('APPSECRET','223e781aae6cd5e864c61cbf9f0e02d4');
define('TOKEN','zhuoyue');
define('TULINGKEY','eb720a8970964f3f855d863d24406576');

require './wechat.class.php';
$wechat = new WeChat(APPID,APPSECRET,TOKEN,TULINGKEY);

header("content-type:text/html;charset=utf-8");
// $menu = ' 
//   {
//      "button":[
//      {	
//           "type":"view",
//           "name":"官网",
//           "url":"http://www.orivon.com/"
//       },
//       {
//            "name":"培训",
//            "sub_button":[
//            {	
//                "type":"view",
//                "name":"搜索",
//                "url":"http://www.soso.com/"
//             },
//             {
//                "type":"view",
//                "name":"视频",
//                "url":"http://v.qq.com/"
//             },
//             {
//                "type":"click",
//                "name":"赞一下我们",
//                "key":"V1001_GOOD"
//             }]
//        },
//        {
//            "name":"考试",
//            "sub_button":[
//            {	
//                "type":"view",
//                "name":"搜索",
//                "url":"http://www.soso.com/"
//             },
//             {
//                "type":"view",
//                "name":"打蛋蛋",
//                "url":"http://m.creatby.com/manage/book/5gp3pa"
//             },
//             {
//                "type":"click",
//                "name":"赞一下我们",
//                "key":"V1001_GOOD"
//             }]
//        }
// ]
//  }

 
// ';
// $menu='{
//     "button": [
//         {
//             "name": "扫码", 
//             "sub_button": [
//                 {
//                     "type": "scancode_waitmsg", 
//                     "name": "扫码带提示", 
//                     "key": "rselfmenu_0_0", 
//                     "sub_button": [ ]
//                 }, 
//                 {
//                     "type": "scancode_push", 
//                     "name": "扫码推事件", 
//                     "key": "rselfmenu_0_1", 
//                     "sub_button": [ ]
//                 }
//             ]
//         }, 
//         {
//             "name": "发图", 
//             "sub_button": [
//                 {
//                     "type": "pic_sysphoto", 
//                     "name": "系统拍照发图", 
//                     "key": "rselfmenu_1_0", 
//                    "sub_button": [ ]
//                  }, 
//                 {
//                     "type": "pic_photo_or_album", 
//                     "name": "拍照或者相册发图", 
//                     "key": "rselfmenu_1_1", 
//                     "sub_button": [ ]
//                 }, 
//                 {
//                     "type": "pic_weixin", 
//                     "name": "微信相册发图", 
//                     "key": "rselfmenu_1_2", 
//                     "sub_button": [ ]
//                 }
//             ]
//         }, 
//         {
//             "name": "发送位置", 
//             "type": "location_select", 
//             "key": "rselfmenu_2_0"
//         }
        
//     ]
// }';
// $menu='{
//      "button":[
    
//       {
//            "name":"培训学习",
//            "sub_button":[
//            {	
//                "type":"view",
//                "name":"我的课程",
//                "url":"http://ots.orivon.com/course.php?a=myCourse"
//             },
//             {
//                "type":"view",
//                "name":"视频",
//                "url":"http://v.qq.com/"
//             },
//             {
//                "type":"view",
//                "name":"我的笔记",
//                "url":"http://ots.orivon.com/course.php?a=myNote"
//             },
//              {
//                "type":"view",
//                "name":"我的学习计划",
//                "url":"http://ots.orivon.com/plan.php?a=myPlan"
//             },
//            {
//                "type":"view",
//                "name":"我的作业",
//                "url":"http://ots.orivon.com/homework.php?a=homeworkList"
//             }]
//        },
//        {
//            "name":"考试测评",
//            "sub_button":[
//            {	
//                "type":"view",
//                "name":"考试",
//                "url":"http://oes.orivon.com/exam.php?a=displayExam&exam_id=23"
//             },
            
//             {	
//                "type":"view",
//                "name":"我的练习",
//                "url":"http://ots.orivon.com/exam.php?a=myExercise"
//             },
//            {	
//                "type":"view",
//                "name":"我的考试",
//                 "url":"http://ots.orivon.com/exam.php?a=myExam"
//             },
//            {	
//                "type":"view",
//                "name":"我的成绩",
//                 "url":"http://ots.orivon.com/user.php?a=myEnteredExam"
//             },
//             {
//                "type":"click",
//                "name":"消息",
//                "key":"news"
//             }]
//        },
//      {	
//           "type":"view",
//           "name":"关于我们",
//           "url":"http://www.orivon.com/"
//       }
// ]
//  }';
$menu = '{
    "button":[
	     {	
	          "type":"view",
	          "name":"关于我们",
	          "url":"http://www.orivon.com/"
	      }
	]
 }';
$wechat->createMenu($menu);