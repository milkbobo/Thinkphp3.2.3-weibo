
/**
 * 页面加载完成时运行
 */
$(function () {
    //初始化窗口
	window_resize();
	$(window).resize(function () {
		window_resize();
	});

    //初始化时动画显视菜单
    $('#top .t_title').show(600, function () {
        $('#top .menu').show(1000, function () {
            navMoveIn($('.nav'));$('.nav').click();
        });
    });

    //头部菜单
    var topLi = $('#top .menu li');
    topLi.click(function () {
        var index = $(this).index();
        $(this).siblings().removeClass('cur next first_cur last_cur');
        if (index == 0) {
            $(this).addClass('first_cur');
        } else if (index == topLi.length - 1) {
            $(this).addClass('last_cur');
        } else {
            $(this).addClass('cur');
        }
        $(this).next().addClass('next');
    });

	//左侧菜单动画效果
    $(".nav").prepend('<div class="nav_ub"></div><div class="nav_db"></div>');  //动画层
    var moveOn = false;     //移入开关
    var clickOn = false;    //点击开关
    $(".nav").hover(function () {
        moveOn = true;
        navMoveIn($(this));
    }, function () {
        moveOn = false;
        if ($(this).next().css('display') == 'none' || !clickOn) {
            clickOn = true;
            navMoveOut($(this));
        }
    }).toggle(function () {
        clickOn = true;
        $(this).next().slideDown('200');
        $(this).find('.pos').removeClass('down').addClass('up');
    }, function () {
        clickOn = false;
        $(this).next().slideUp('200');
        $(this).find('.pos').removeClass('up').addClass('down');
        if (!moveOn) {
            navMoveOut($(this));
        }
    });

    //去除a链接点击时出现的虚线框
    $('a').focus(function () {
        return $(this).blur();
    });

    //退出登录时确认框
    $('#login_out').click(function () {
        var isOut = confirm('退出登录？');
        if (isOut) {
            return true;
        }
        return false;
    });
});

/**
 *  窗口定位
 */
function window_resize () {
	$('#left').height($(window).height() - 101);
	$('#right').width($(window).width() - 201).height($(window).height() - 100);
}

/**
 * 左侧菜单移入
 */
function navMoveIn (obj) {
    obj.children(".nav_ub").stop().animate({
        top : -26
    }, 300).next().stop().animate({
        bottom : -14
    }, 300).next().children().stop().animate({
        left : 50
    }, 250).css({
        color : '#1E90FF'
    });
}

/**
 * 左侧菜单移出
 */
function navMoveOut (obj) {
    obj.children(".nav_ub").stop().animate({
        top : 0
    }, 300).next().stop().animate({
        bottom : 0
    }, 300).next().children().stop().animate({
        left : 20
    }, 250).css({
        color : '#3A66B0'
    });
}

