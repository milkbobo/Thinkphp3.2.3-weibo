
window.onload = function () {

	var verify = $('#getCode').attr('src');
	$('#getCode').click(function () {
		$(this).attr('src', verify + '/' + Math.random());
	})

	//初始化动画显视登录框
	$('#login').fadeIn(800, function () {
		var pd = ($(window).height() - $(this).height()) / 2 - $('#top').height();
		$('#main').animate({
			paddingTop : pd - 32 + 'px'
		}, 600, function () {
			$('input[name=uname]').focus();
		});
	});

	//登录验证
	$('input[name=submit]').hover(function () {
		$(this).addClass('tologin');
	}, function () {
		$(this).removeClass('tologin');
	}).click(function () {
		var uname = $('input[name=uname]');
		var pwd = $('input[name=pwd]');
		var verify = $('input[name=verify]');
		if (uname.val() == '') {
			dialog(uname, '用户名不能为空');
			return false;
		}
		if (pwd.val() == '') {
			dialog(pwd, '密码不能为空');
			return false;
		}
		if (verify.val() == '') {
			dialog(verify, '请填写验证码');
			return false;
		}
	});
}

//jQueryUI Dialog
function dialog (obj, msg) {
	$('#dialog').html(msg).dialog({
		title : 'HDSHOP 提示：',
		modal : true,
		show : 'shake',
		hide : 'explode',
		buttons : [{
			text : 'OK',
			click : function () {
				obj.focus();
				$(this).dialog('close');
			}
		}]
	});
}