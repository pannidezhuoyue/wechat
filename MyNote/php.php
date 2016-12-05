<?php 
    //unserialize修改
    $temp = 'a:9:{s:4:"time";i:1405306402;s:4:"name";s:6:"新晨";s:5:"url";s:1:"-";s:4:"word";s:1:"-";s:5:"rpage";s:29:"http://www.baidu.com/test.html";s:5:"cpage";s:1:"-";s:2:"ip";s:15:"117.151.180.150";s:7:"ip_city";s:31:"中国北京市 北京市移动";s:4:"miao";s:1:"5";}';
    $temp1 = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($matches) {
                        return sprintf('s:%s:"%s";', strlen($matches[2]), $matches[2]);
                    }, $temp);
    $temp2 = preg_replace('!s:(\d+):"(.*?)";!se', '"s:".strlen("$2").":\"$2\";"', $temp);