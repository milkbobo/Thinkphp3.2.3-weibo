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


    //创建好友分组
   $('#create_group').click(function () {
   		var groupLeft = ($(window).width() - $('#add-group').width()) / 2;
	 	var groupTop = $(document).scrollTop() + ($(window).height() - $('#add-group').height()) / 2;
   		var gpObj = $('#add-group').show().css({
	 		'left' : groupLeft,
	 		'top' : groupTop
	 	});
   		createBg('group-bg');
   		drag(gpObj, gpObj.find('.group_head'));
   });
   //异步创建分组
   $('.add-group-sub').click(function(){
	   var groupName = $('#gp-name').val();
		if (groupName != '') {
			$.post(addGroup,{name:groupName},function(data){
				if(data.status){
					showTips(data.msg);
					$('.group-cencle').click();
				}else{
					alert(data.msg);
				}
			},'json');
		} 
   });
   //关闭
   $('.group-cencle').click(function () {
   		$('#add-group').hide();
   		$('#group-bg').remove();
   });


    //好友关注
   $('.add-fl').click(function () {
   		var followLeft = ($(window).width() - $('#follow').width()) / 2;
	 	var followTop = $(document).scrollTop() + ($(window).height() - $('#follow').height()) / 2;
   		var flObj = $('#follow').show().css({
	 		'left' : followLeft,
	 		'top' : followTop
	 	});
   		createBg('follow-bg');
   		drag(flObj, flObj.find('.follow_head'));
   		//alert($(this).attr('uid'));
   		$('input[name=follow]').val($(this).attr('uid'));
   });
   //添加关注
//   $('.add-follow-sub').click(function () {
//   		var follow = $('input[name=follow]').val();
//   		var group = $('select[name=gid]').val();
//   		$.post(addFollow, {
//   			'follow' : follow,
//   			'gid' : group
//   		}, function (data) {
//   			if (data.status) {
//   				$('.add-fl[uid=' + follow + ']').removeClass('add-fl').html('√&nbsp;已关注');
//   				$('#follow').hide();
//   				$('#follow-bg').remove();
//   			} else {
//   				alert(data.msg);
//   			}
//   		}, 'json');
//   });
   $('.add-follow-sub').click(function () {
	   var follow = $('input[name=follow]').val();
	   var group =$('select[name=gid]').val();
	   $.post(addFollow,{'follow':follow,'gid':group},function(data){
		   if(data.status){
			   $('.add-fl[uid=' + follow + ']').removeClass('add-fl').html('√&nbsp;已关注');
				$('#follow').hide();
				$('#follow-bg').remove();
		   }else{
			   alert(data.msg);
		   }
	   },'json')

   });
   //关闭关注框
   $('.follow-cencle').click(function () {
   		$('#follow').hide();
   		$('#follow-bg').remove();
   });


	//消息推送回调函数
   /* news({
		"total" : 2,
		"type" : 1
	});*/
	
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

/**
 * 创建全屏透明背景层
 * @param   id
 */
function createBg (id) {
	$('<div id = "' + id + '"></div>').appendTo('body').css({
 		'width' : $(document).width(),
 		'height' : $(document).height(),
 		'position' : 'absolute',
 		'top' : 0,
 		'left' : 0,
 		'z-index' : 2,
 		'opacity' : 0.3,
 		'filter' : 'Alpha(Opacity = 30)',
 		'backgroundColor' : '#000'
 	});
}


/**
* 元素拖拽
* @param  obj		拖拽的对象
* @param  element 	触发拖拽的对象
*/
function drag (obj, element) {
	var DX, DY, moving;
	element.mousedown(function (event) {
		DX = event.pageX - parseInt(obj.css('left'));	//鼠标距离事件源宽度
		DY = event.pageY - parseInt(obj.css('top'));	//鼠标距离事件源高度
		moving = true;	//记录拖拽状态
	});
	$(document).mousemove(function (event) {
		if (!moving) return;
		var OX = event.pageX, OY = event.pageY;	//移动时鼠标当前 X、Y 位置
		var	OW = obj.outerWidth(), OH = obj.outerHeight();	//拖拽对象宽、高
		var DW = $(window).width(), DH = $('body').height();  //页面宽、高
		var left, top;	//计算定位宽、高
		left = OX - DX < 0 ? 0 : OX - DX > DW - OW ? DW - OW : OX - DX;
		top = OY - DY < 0 ? 0 : OY - DY > DH - OH ? DH - OH : OY - DY;
		obj.css({
			'left' : left + 'px',
			'top' : top + 'px'
		});
	}).mouseup(function () {
		moving = false;	//鼠标抬起消取拖拽状态
	});
}

/**操作成功效果**/
function showTips(tips,time,height){
	var windowWidth = $(window).width();height=height?height:$(window).height();
	time = time ? time : 1;
	var tipsDiv = '<div class="tipsClass">' + tips + '</div>';
	$( 'body' ).append( tipsDiv );
	$( 'div.tipsClass' ).css({
		'top' : height/2 + 'px',
		'left' : ( windowWidth / 2 ) - 100 + 'px',
		'position' : 'absolute',
		'padding' : '3px 5px',
		'background': '#670768',
		'font-size' : 14 + 'px',
		'text-align': 'center',
		'width' : '300px',
		'height' : '40px',
		'line-height' : '40px',
		'color' : '#fff',
		'font-weight' : 'bold',
		'opacity' : '0.8'
	}).show();
	setTimeout( function(){
		$( 'div.tipsClass' ).animate({
			top: height/2-50+'px'
		}, "slow").fadeOut();
	}, time * 1000);
}