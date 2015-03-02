$(function () {
	//jQuery Validate 表单验证
	
	/**
	 * 添加验证方法
	 * 以字母开头，5-17 字母、数字、下划线"_"
	 */
	jQuery.validator.addMethod("user", function(value, element) {   
	    var tel = /^[a-zA-Z][\w]{4,16}$/;
	    return this.optional(element) || (tel.test(value));
	}, " ");

	$('form[name=login]').validate({
		errorElement : 'span',
		success : function (label) {
			label.addClass('success');
		},
		rules : {
			account : {
				required : true,
				user : true
			},
			pwd : {
				required : true,
				user : true
			}
		},
		messages : {
			account : {
				required : ' ',
			},
			pwd : {
				required : ' '
			}
		}
	});
});