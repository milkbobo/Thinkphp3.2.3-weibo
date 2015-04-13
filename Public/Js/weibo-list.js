
$(function () {

	/**
	 * 图片点击放大处理
	 */
	$('.mini_img').click(function () {
		$(this).hide().next().show();
	});
	$('.img_info img').click(function () {
		$(this).parents('.img_tool').hide().prev().show();
	});
	$('.packup').click(function () {
		$(this).parent().parent().parent().hide().prev().show();
	});
	$('.turn_mini_img').click(function () {
		$(this).hide().next().show();
	});
	$('.turn_img_info img').click(function () {
		$(this).parents('.turn_img_tool').hide().prev().show();
	});


	/**
	 * 转发框处理
	 */
	 $('.turn').click(function () {
	 	//获取原微内容并添加到转发框
	 	var orgObj = $(this).parents('.wb_tool').prev();
	 	var author = $.trim(orgObj.find('.author').html());
	 	var content = orgObj.find('.content p').html();
	 	var tid = $(this).attr('tid') ? $(this).attr('tid') : 0;
	 	var cons = '';

	 	//多重转发时，转发框内容处理
	 	if (tid) {
	 		author = orgObj.find('.author a').html();
	 		cons = replace_weibo(' // @' + author + ' : ' + content);
	 		author = $.trim(orgObj.find('.turn_name').html());
	 		content = orgObj.find('.turn_cons p').html();
	 	}

	 	$('.turn_main p').html(author + ' : ' + content);
	 	$('.turn-cname').html(author);
	 	$('form[name=turn] textarea').val(cons);

	 	//提取原微博ID
	 	$('form[name=turn] input[name=id]').val($(this).attr('id'));
	 	$('form[name=turn] input[name=tid]').val(tid);

	 	//隐藏表情框
	 	$('#phiz').hide();
	 	//点击转发创建透明背景层
	 	createBg('opacity_bg');
	 	//定位转发框居中
	 	var turnLeft = ($(window).width() - $('#turn').width()) / 2;
	 	var turnTop = $(document).scrollTop() + ($(window).height() - $('#turn').height()) / 2;
	 	$('#turn').css({
	 		'left' : turnLeft,
	 		'top' : turnTop
	 	}).fadeIn().find('textarea').focus(function () {
	 		$(this).css('borderColor', '#FF9B00').keyup(function () {
				var content = $(this).val();
				var lengths = check(content);  //调用check函数取得当前字数
				//最大允许输入140个字
				if (lengths[0] >= 140) {
					$(this).val(content.substring(0, Math.ceil(lengths[1])));
				}
				var num = 140 - Math.ceil(lengths[0]);
				var msg = num < 0 ? 0 : num;
				//当前字数同步到显示提示
				$('#turn_num').html(msg);
			});
	 	}).focus().blur(function () {
	 		$(this).css('borderColor', '#CCCCCC');	//失去焦点时还原边框颜色
	 	});
	 });
	drag($('#turn'), $('.turn_text'));  //拖拽转发框


	/**
	 * 收藏微博
	 */
	$('.keep').click(function () {
		var wid = $(this).attr('wid');
		var keepUp = $(this).next();
		var msg = '';

		$.post(keepUrl, {wid : wid}, function (data) {
			if (data == 1) {
				msg = '收藏成功';
			}

			if (data == -1) {
				msg = '已收藏';
			}

			if (data == 0) {
				msg = '收藏失败';
			}

			keepUp.html(msg).fadeIn();
			setTimeout(function () {
				keepUp.fadeOut();
			}, 3000);

		}, 'json');
		
	});


	/**
	 * 评论框处理
	 */
	//点击评论时异步提取数据
	$('.comment').toggle(function () {
		//异步加载状态DIV
		var commentLoad = $(this).parents('.wb_tool').next();
		var commentList = commentLoad.next();

		//提取当前评论按钮对应微博的ID号
		var wid = $(this).attr('wid');
		//异步提取评论内容
		$.ajax({
			url : getComment,
			data : {wid : wid},
			dataType : 'html',
			type : 'post',
			beforeSend : function () {
				commentLoad.show();
			},
			success : function (data) {
				if (data != 'false') {
					commentList.append(data);
				}
			},
			complete : function () {
				commentLoad.hide();
				commentList.show().find('textarea').val('').focus();
			}
		});
	}, function () {
		$(this).parents('.wb_tool').next().next().hide().find('dl').remove();
		$('#phiz').hide();
	});
	//评论输入框获取焦点时改变边框颜色
	$('.comment_list textarea').focus(function () {
		$(this).css('borderColor', '#FF9B00');
	}).blur(function () {
		$(this).css('borderColor', '#CCCCCC');
	}).keyup(function () {
		var content = $(this).val();
		var lengths = check(content);  //调用check函数取得当前字数
		//最大允许输入140个字
		if (lengths[0] >= 140) {
			$(this).val(content.substring(0, Math.ceil(lengths[1])));
		}
	});
	//回复
	$('.reply a').live('click', function () {
		var reply = $(this).parent().siblings('a').html();
		$(this).parents('.comment_list').find('textarea').val('回复@' + reply + ' ：');
		return false;
	});
	//提交评论
	$('.comment_btn').click(function () {
		var commentList = $(this).parents('.comment_list');
		var _textarea = commentList.find('textarea');
		var content = _textarea.val();

		//评论内容为空时不作处理
		if (content == '') {
			_textarea.focus();
			return false;
		}

		//提取评论数据
		var cons = {
			content : content,
			wid : $(this).attr('wid'),
			uid : $(this).attr('uid'),
			isturn : $(this).prev().find('input:checked').val() ? 1 : 0
		};

		$.post(commentUrl, cons, function (data) {
			if (data != 'false') {
				if (cons.isturn) {
					window.location.reload();
				} else {
					_textarea.val('');
					commentList.find('ul').after(data);
				}
			} else {
				alert('评论失败，请重试...');
			}
		}, 'html');
	});

	/**
	 * 评论异步分类处理
	 */
	$('.comment-page dd').live('click', function () {
		var commentList = $(this).parents('.comment_list');
		var commentLoad = commentList.prev();
		var wid = $(this).attr('wid');
		var page = $(this).attr('page');
		//异步提取评论内容
		$.ajax({
			url : getComment,
			data : {wid : wid, page : page},
			dataType : 'html',
			type : 'post',
			beforeSend : function () {
				commentList.hide().find('dl').remove();
				commentLoad.show();
			},
			success : function (data) {
				if (data != 'false') {
					commentList.append(data);
				}
			},
			complete : function () {
				commentLoad.hide();
				commentList.show().find('textarea').val('').focus();
			}
		});
	});

	/**
	 * 取消收藏
	 */
	$('.cancel-keep').click(function () {
		var isCancel = confirm('确认取消该微博的收藏？');
		var data = {
			kid : $(this).attr('kid'),
			wid : $(this).attr('wid')
		};
		var obj = $(this).parents('.weibo');

		if (isCancel) {
			$.post(cancelKeep, data, function (data) {
				if (data) {
					obj.slideUp('slow', function () {
						obj.remove();
					});
				} else {
					alert('取消失败，请重试...');
				}
			}, 'json');
		}
	});


    /**
     * 表情处理
     * 以原生JS添加点击事件，不走jQuery队列事件机制
     */
  	var phiz = $('.phiz');
  	for (var i = 0; i < phiz.length; i++) {
  		phiz[i].onclick = function () {
  			//定位表情框到对应位置
			$('#phiz').show().css({
				'left' : $(this).offset().left,
				'top' : $(this).offset().top + $(this).height() + 5
    		});
    		//为每个表情图片添加事件
            var phizImg = $("#phiz img");
            var sign = this.getAttribute('sign');
            for (var i = 0; i < phizImg.length; i++){
            	phizImg[i].onclick = function () {
				var content = $('textarea[sign = '+sign+']');
				content.val(content.val() + '[' + $(this).attr('title') + ']');
				$('#phiz').hide();
            	}
            }
  		}
  	}
  	//关闭表情框
	$('.close').hover(function () {
		$(this).css('backgroundPosition', '-100px -200px');
	}, function () {
		$(this).css('backgroundPosition', '-75px -200px');
	}).click(function () {
		$(this).parent().parent().hide();
		$('#phiz').hide();
		if ($('#turn').css('display') == 'none') {
			$('#opacity_bg').remove();
		};
	});

});




/**
 * 统计字数
 * @param  字符串
 * @return 数组[当前字数, 最大字数]
 */
function check (str) {
	var num = [0, 140];
	for (var i=0; i<str.length; i++) {
		//字符串不是中文时
		if (str.charCodeAt(i) >= 0 && str.charCodeAt(i) <= 255){
			num[0] = num[0] + 0.5;//当前字数增加0.5个
			num[1] = num[1] + 0.5;//最大输入字数增加0.5个
		} else {//字符串是中文时
			num[0]++;//当前字数增加1个
		}
	}
	return num;
}

/**
 * 替换微博内容，去除 <a> 链接与表情图片
 */
function replace_weibo (content) {
	content = content.replace(/<img.*?title=['"](.*?)['"].*?\/?>/ig, '[$1]');
	content = content.replace(/<a.*?>(.*?)<\/a>/ig, '$1');
	return content.replace(/<span.*?>\&nbsp;(\/\/)\&nbsp;<\/span>/ig, '$1');
}