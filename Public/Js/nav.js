/**
 * 头部导航
 */
$(function () {
	/**
	 * 头部选项移入效果
	 */
	//左侧选项
	$('.top_left li').hover(function () {
		$(this).addClass('cur_bg');
	}, function () {
		$(this).removeClass('cur_bg');
	});
	//用户名
	$('.user').hover(function () {
		$(this).addClass('cur_bg');
	}, function () {
		$(this).removeClass('cur_bg');
	});
	//快速发微博按钮
	$('.top_right li:eq(0)').hover(function () {
		$(this).addClass('cur_bg');
	}, function () {
		$(this).removeClass('cur_bg');
	});
	$('.fast_send').click(function () {
		$('.send_write textarea').focus();
		$('.backToTop').click();
	});


	/**
	 * 头部右侧下拉选项
	 */
	$('.selector').hover(function () {
		var objClass = $('i', this).attr('class');
		$('i', this).removeClass(objClass).addClass(objClass + '-cur');
		$(this).css({  //改变背景色
			'width' : '36px',
			'backgroundColor' : '#FFFFFF',
			'borderLeft' : '1px solid #CCCCCC',
			'borderRight' : '1px solid #CCCCCC'
		}).find('ul').show();
	}, function () {
		var objClass = $('i', this).attr('class');
		$('i', this).removeClass(objClass).addClass(objClass.replace('-cur', ''));
		$(this).css({  //还原背景
			'width' : '38px',
			'background' : 'none',
			'border' : 'none'
		}).find('ul').hide();
	});
	$('.selector li').hover(function () {  //下拉项添加效果
		$(this).css('background', '#DCDCDC');
	}, function () {
		$(this).css('background', 'none');
	});



	/**
	 * 头部搜索框
	 */
	//移入时改变背景
	$('#sech_text').hover(function () {
		$(this).css('backgroundPosition', '-237px -5px');
		$('#sech_sub').css('backgroundPosition', '-443px -5px');
	}, function () {
		if ($(this).val() == '搜索微博、找人') {
			$(this).css('backgroundPosition', '0 -5px');
			$('#sech_sub').css('backgroundPosition', '-206px -5px');
		};
	//获得焦点时清空默认文字
	}).focus(function () {
		if ($(this).val() == '搜索微博、找人') {
			$(this).val('');
		};
	//失去焦点时
	}).blur(function () {
		//添加默认文字
		if ($(this).val() == '') {
			$(this).val('搜索微博、找人')
		};
		//恢复原背景
		$(this).css('backgroundPosition', '0 -5px');
		$('#sech_sub').css('backgroundPosition', '-206px -5px');
	});
	$('#sech_sub').hover(function () {
		$(this).css('backgroundPosition', '-443px -5px');
		$('#sech_text').css('backgroundPosition', '-237px -5px');
	}, function () {
		$(this).css('backgroundPosition', '-206px -5px');
		$('#sech_text').css('backgroundPosition', '0 -5px');
	});


	/**
	 * 中部左侧导行选项移入效果
	 */
	$('.left_nav li').hover(function () {
		$(this).css('background', '#D7ECF4');
	}, function () {
		$(this).css('background', '#EFF8FC');
	});
	$('.group ul li').hover(function () {
		$(this).css('background', '#D7ECF4');
	}, function () {
		$(this).css('background', '#EFF8FC');
	});


	/**
	 * 返回顶部
	 */
	var toTopElement = '<div class="backToTop" title="返回顶部"><i class="icon icon-totop"></i>返回顶部</div>';
	//创建DIV按钮并定位
    var toTop = $(toTopElement).appendTo($("body")).css({
    	'left' : ($('body').width() - ($('body').width() - $('.main').width()) / 2) + 'px',
    	'top' : ($(window).height() - ($(window).height() / 3)) + 80 + 'px'
	//添加点击事件
    }).click(function() {
        $("html, body").animate({scrollTop: 0}, 200);
    });
    //添加窗口滚动事件
    $(window).scroll(function () {
    	var st = $(document).scrollTop();
    	//IE6定位
    	if (window.ActiveXObject&&!window.XMLHttpRequest) {
	    	var ieTop = st + ($(window).height() / 2 + 80);
	    	$('.backToTop').css('top', ieTop + 'px');
    	}
    	//滚动条高度大于100时显示 返回顶部按钮
    	(st > 100) ? $('.backToTop').show() : $('.backToTop').hide();
    });



	//消息推送回调函数
    news({
		"total" : 2,
		"type" : 1
	});
	
});


/********************效果函数********************/

/**
 * 推送的新消息
 * @param  {[type]} json {total:新消息的条数,type:（1：评论，2：私信，3：@我）}
 * @return {[type]}      [description]
 */
var flags = true;
function news (json) {
	switch (json.type) {
		case 1:
			$('#news ul .news_comment').show().find('a').html(json.total + '条新评论');
			break;
		case 2:
			$('#news ul .news_letter').show().find('a').html(json.total + '条新私信');
			break;
		case 3:
			$('#news ul .news_atme').show().find('a').html(json.total + '条@提到我');
			break;
	}
	var obj = $('#news');
	var icon = obj.find('i');
	obj.show().find('li').hover(function () {  //下拉项添加效果
		$(this).css('background', '#DCDCDC');
	}, function () {
		$(this).css('background', 'none');
	}).click(function () {
		clearInterval(newsGlint);
	});
	if (flags) {
		flags = false;
		var newsGlint= setInterval(function () {
			icon.toggleClass("icon-news");
		}, 500);
	}
}