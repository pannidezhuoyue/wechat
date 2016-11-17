data = {
    'question_1': '',
    'question_2': '',
    'question_3': '',
    'question_4': '',
    'question_5': '',
    'question_6': '',
    'question_7': {
        'option_7_1': '',
        'option_7_2': '',
        'option_7_3': '',
    },
    'question_8': {
        'option_8_1': ''
    },
    'question_9': {
        'option_9_1': ''
    },
    'question_10': {
        'option_10_1': ''
    }
};
rightData = {
    'question_1': 'option_1_1',
    'question_2': 'option_2_1',
    'question_3': 'option_3_1',
    'question_4': 'option_4_1',
    'question_5': 'option_5_1,option_5_2',
    'question_6': 'option_6_1,option_6_2',
    'question_7': {
        'option_7_1': '123',
        'option_7_2': '123',
        'option_7_3': '123',
    },
    'question_8': {
        'option_8_1': '456'
    }
};
point = [
    10,
    10,
    10,
    10,
    10,
    10,
    10,
    10
];
window.onload = function() {
    //cooike回复考生答案
    var answer = $.getCookie("exam_1");
    if (answer != '') {
        recoverAnswer(answer);
    }
    $('#nowNum').html('1');
    var mySwiper = new Swiper('.swiper-container', {
        'direction': 'horizontal',
        'autoHeight': true,
        'speed' : 100,
        nTouchStart: function(swiper) {
            $('.swiper-wrapper').height('auto');
            $('.swiper-wrapper').css('min-height', '100vh');
        },
        onSlideChangeEnd: function(swiper) {
            $('#nowNum').html(swiper.activeIndex + 1);
        }
    });
    countdown = 3600;
    countdownSubmit();
    $('#submit').click(function() {
        $.MsgBox.Confirm('提示','您确认交卷?',submitPaper)
    });
    //自动保存答案
    $(':input').change(function() {
        getAnswer();
    });
    $('.textarea').change(function() {
        getAnswer();
    })
}
function countdownSubmit() {
    var temp = [parseInt(countdown / 86400), new Date(countdown % 86400 * 1000)];
    $('#timer').html((temp[0] ? temp[0] + L.getText('天 ') : '') + ('0' + temp[1].getUTCHours()).slice( - 2) + ':' + ('0' + temp[1].getUTCMinutes()).slice( - 2) + ':' + ('0' + temp[1].getUTCSeconds()).slice( - 2));
    if (countdown <= 1) {
        $.MsgBox.Alert('提示','考试时间结束');
    } else {
        setTime = window.setTimeout(function() {
            countdown -= 1;
            countdownSubmit();
        },
        1000);
    }
};
//获取所有用户答案
function getAnswer(nead) {
    data.question_1 = typeof($('input[name=question_1]:checked').val()) != 'undefined' ? $('input[name=question_1]:checked').val() : '';
    data.question_2 = typeof($('input[name=question_2]:checked').val()) != 'undefined' ? $('input[name=question_2]:checked').val() : '';
    data.question_3 = typeof($('input[name=question_3]:checked').val()) != 'undefined' ? $('input[name=question_3]:checked').val() : '';
    data.question_4 = typeof($('input[name=question_4]:checked').val()) != 'undefined' ? $('input[name=question_4]:checked').val() : '';
    data.question_5 = '';
    $('input[name=question_5]:checked').each(function(i) {
        if (0 == i) {
            data.question_5 = $(this).val();
        } else {
            data.question_5 += ("," + $(this).val());
        }
    });
    data.question_6 = '';
    $('input[name=question_6]:checked').each(function(i) {
        if (0 == i) {
            data.question_6 = $(this).val();
        } else {
            data.question_6 += ("," + $(this).val());
        }
    });
    $.each(data.question_7,
    function(index, value) {
        data.question_7[index] = $('#' + index).val();
    });
    $.each(data.question_8,
    function(index, value) {
        data.question_8[index] = $('#' + index).val();
    });
    $.each(data.question_9,
    function(index, value) {
        data.question_9[index] = $('#' + index).val();
    });
    $.each(data.question_10,
    function(index, value) {
        data.question_10[index] = $('#' + index).val();
    });
    $.setCookie("exam_1", JSON.stringify(data), 10);
    if (nead) {
        return data;
    }
}
//恢复答案
function recoverAnswer(temp) {
    var temp = $.getCookie("exam_1");
    var answer = jQuery.parseJSON(unescape(temp));
    $.each(answer,
    function(index, value) {
        if (typeof(value) == 'string') {
            var temp = value.split(',');
            $.each(temp,
            function(i, v) {
                $('#' + v).attr('checked', 'checked');
            })
        } else {
            $.each(value,
            function(i, v) {
                $('#' + i).val(v);
            })
        }
    });
}
//交卷算分
function submitPaper(){
    var answer = getAnswer(true);
    var score = 0;
    var pointIndex = 0;
    $.each(answer,function(index,value){
        if(typeof(rightData[index]) != 'undefinded' && cmp(value,rightData[index])){
            score += point[pointIndex];
        }
        pointIndex++;
    });
    $.setCookie("exam_1", '', 10);
    $.MsgBox.Alert('消息','您客观题得分为:'+score+'分.');
}
(function($) {
    if (!$.setCookie) {
        $.extend({
            setCookie: function(c_name, value, exdays) {
                try {
                    if (!c_name) return false;
                    var exdate = new Date();
                    exdate.setDate(exdate.getDate() + exdays);
                    var c_value = escape(value) + ((exdays == null) ? "": "; expires=" + exdate.toUTCString());
                    document.cookie = c_name + "=" + c_value;
                } catch(err) {
                    return '';
                };
                return '';
            }
        });
    };
    if (!$.getCookie) {
        $.extend({
            getCookie: function(c_name) {
                try {
                    var i, x, y, ARRcookies = document.cookie.split(";");
                    for (i = 0; i < ARRcookies.length; i++) {
                        x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
                        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
                        x = x.replace(/^\s+|\s+$/g, "");
                        if (x == c_name) return (y);
                    };
                } catch(err) {
                    return '';
                };
                return '';
            }
        });
    };

    $.MsgBox = {
        Alert: function(title, msg) {
            GenerateHtml("alert", title, msg);
            btnOk(); //alert只是弹出消息，因此没必要用到回调函数callback
            btnNo();
        },
        Confirm: function(title, msg, callback) {
            GenerateHtml("confirm", title, msg);
            btnOk(callback);
            btnNo();
        }
    }

    //生成Html
    var GenerateHtml = function(type, title, msg) {

        var _html = "";

        _html += '<div id="mb_box"></div><div id="mb_con"><span id="mb_tit">' + title + '</span>';
        _html += '<a id="mb_ico">x</a><div id="mb_msg">' + msg + '</div><div id="mb_btnbox">';

        if (type == "alert") {
            _html += '<input id="mb_btn_ok" type="button" value="确定" />';
        }
        if (type == "confirm") {
            _html += '<input id="mb_btn_ok" type="button" value="确定" />';
            _html += '<input id="mb_btn_no" type="button" value="取消" />';
        }
        _html += '</div></div>';

        //必须先将_html添加到body，再设置Css样式
        $("body").append(_html);
        GenerateCss();
    }

    //生成Css
    var GenerateCss = function() {

        $("#mb_box").css({
            width: '100%',
            height: '100%',
            zIndex: '99999',
            position: 'fixed',
            filter: 'Alpha(opacity=60)',
            backgroundColor: 'black',
            top: '0',
            left: '0',
            opacity: '0.6'
        });

        $("#mb_con").css({
            zIndex: '999999',
            width: '80vw',
            position: 'fixed',
            backgroundColor: 'White',
            borderRadius: '15px'
        });

        $("#mb_tit").css({
            display: 'block',
            fontSize: '5vw',
            color: '#444',
            'text-align' : 'center',
            'min-height' : '7vh',
            'line-height' : '7vh',
            backgroundColor: '#DDD',
            borderRadius: '15px 15px 0 0',
            borderBottom: '3px solid #009BFE',
            fontWeight: 'bold'
        });

        $("#mb_msg").css({
            padding: '20px',
            lineHeight: '5vw',
            fontSize: '5vw'
        });

        $("#mb_ico").css({
            display: 'none',
            position: 'absolute',
            right: '10px',
            top: '9px',
            border: '1px solid Gray',
            width: '18px',
            height: '18px',
            textAlign: 'center',
            lineHeight: '16px',
            cursor: 'pointer',
            borderRadius: '12px',
            fontFamily: '微软雅黑'
        });

        $("#mb_btnbox").css({
            margin: '15px 0 10px 0',
            textAlign: 'center'
        });
        $("#mb_btn_ok,#mb_btn_no").css({
            width: '85px',
            height: '30px',
            color: 'white',
            border: 'none'
        });
        $("#mb_btn_ok").css({
            backgroundColor: '#05D112'
        });
        $("#mb_btn_no").css({
            backgroundColor: 'gray',
            marginLeft: '20px'
        });

        //右上角关闭按钮hover样式
        $("#mb_ico").hover(function() {
            $(this).css({
                backgroundColor: 'Red',
                color: 'White'
            });
        },
        function() {
            $(this).css({
                backgroundColor: '#DDD',
                color: 'black'
            });
        });

        var _widht = document.documentElement.clientWidth; //屏幕宽
        var _height = document.documentElement.clientHeight; //屏幕高
        var boxWidth = $("#mb_con").width();
        var boxHeight = $("#mb_con").height();

        //让提示框居中
        $("#mb_con").css({
            top: (_height - boxHeight) / 2 + "px",
            left: (_widht - boxWidth) / 2 + "px"
        });
    }

    //确定按钮事件
    var btnOk = function(callback) {
        $("#mb_btn_ok").click(function() {
            $("#mb_box,#mb_con").remove();
            if (typeof(callback) == 'function') {
                callback();
            }
        });
    }

    //取消按钮事件
    var btnNo = function() {
        $("#mb_btn_no,#mb_ico").click(function() {
            $("#mb_box,#mb_con").remove();
        });
    }

})(jQuery);

function cmp(x,y){
    // If both x and y are null or undefined and exactly the same 
    if (x === y) {
        return true;
    }

    // If they are not strictly equal, they both need to be Objects 
    if (! (x instanceof Object) || !(y instanceof Object)) {
        return false;
    }

    //They must have the exact same prototype chain,the closest we can do is
    //test the constructor. 
    if (x.constructor !== y.constructor) {
        return false;
    }

    for (var p in x) {
        //Inherited properties were tested using x.constructor === y.constructor
        if (x.hasOwnProperty(p)) {
            // Allows comparing x[ p ] and y[ p ] when set to undefined 
            if (!y.hasOwnProperty(p)) {
                return false;
            }

            // If they have the same strict value or identity then they are equal 
            if (x[p] === y[p]) {
                continue;
            }

            // Numbers, Strings, Functions, Booleans must be strictly equal 
            if (typeof(x[p]) !== "object") {
                return false;
            }

            // Objects and Arrays must be tested recursively 
            if (!Object.equals(x[p], y[p])) {
                return false;
            }
        }
    }

    for (p in y) {
        // allows x[ p ] to be set to undefined 
        if (y.hasOwnProperty(p) && !x.hasOwnProperty(p)) {
            return false;
        }
    }
    return true;
};