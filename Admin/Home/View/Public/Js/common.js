$(function () {
	$('.add').hover(function () {
		$(this).addClass('add_cur');
	}, function () {
		$(this).removeClass('add_cur');
	});

	$('.lock').click(function () {
		var isLock = confirm($(this).html() + '?');
		if (isLock) {
			return true;
		}
		return false;
	});

	$('.del').click(function () {
		var isDel = confirm('确认删除?');
		if (isDel) {
			return true;
		}
		return false;
	});
});