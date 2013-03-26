/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

(function($){
	$("#login-button").click(function(event) {
		var err = false;
		event.preventDefault();
		$(".valid-required").tooltip("destroy");
		$("#block-message").html('');
		$(".valid-required").each(function(i, element) {
			if ($(element).emptyValue()) {
				$(element).tooltip('show');
				err = true;
			}
		});
		if (!err && !mt.isValidEmailAddress($("#login-email").val())) {
			$("#login-email").attr('data-original-title', 'Incorrect Email Address').tooltip('show');
			err = true;
		}
		if (!err) {
			var postdata = mt.formSerialize($(".FieldSend"));
			$.post(mt.baseURL + "login-in", {
				'postdata' : postdata
			}, function(data) {
				if (data.status) {
					$(".valid-required").tooltip("destroy");
					mt.redirect(data.redirect);
				} else {
					$("#block-message").html(data.message);
				}
			}, "json");
		}
	});
	$("#user-terms-of-service").click(function() {
		if ($(this).is(":checked")) {
			$("#register-button").removeAttr('disabled').css('background', '#FFCC1D');
		} else {
			$("#register-button").attr('disabled', 'disabled').css('background', '#C7C7C7');
		}
		$(".valid-required").tooltip("hide");
		$("#block-message").html('');
	})
	$("#user-subcribe").click(function() {
		if ($(this).is(":checked")) {
			$(this).val(1);
		} else {
			$(this).val(0);
		}
	})
	$("#register-button").click(function(event) {
		event.preventDefault();
		if ($("#user-terms-of-service").is(":checked")) {
			var err = false;
			var user_email = $("#login-email").val();
			var user_phone = $("#login-phone").val();
			$(".valid-required").tooltip("destroy");
			$("#block-message").html('');
			$(".valid-required:visible").each(function(i, element) {
				if ($(element).emptyValue()) {
					$(element).tooltip('show');
					err = true;
				}
			});
			if(!err && !mt.isValidEmailAddress(user_email)){
				$("#login-email").attr('data-original-title', 'Incorrect Email Address').tooltip('show');
				err = true;
			}
			if(!err && !mt.isValidPhone(user_phone)){
				$("#login-phone").attr('data-original-title', 'Incorrect phone number').tooltip('show');
				err = true;
			}
			if(!err){
				var postdata = mt.formSerialize($(".FieldSend"));
				$.post(mt.baseURL + "signup-account", {
					'postdata' : postdata
				}, function(data) {
					$(".valid-required").tooltip("destroy");
					if (data.email) {
						$("#login-email").attr('data-original-title', 'Email already exist').tooltip('show');
					}
					if (data.error) {
						$("#block-message").html('Signup is impossible');
					}
					if (data.status) {
						$("#register-button").remove();
						$("#register-cancel").remove();
						$(".FieldSend").val('');
						$("#block-message").html(data.message);
					}
				}, "json");
			}
		}
	});
	$("#forgot-button").click(function(event) {
		event.preventDefault();
		var err = false;
		var user_email = $("#login-email").val();
		$("#login-email").tooltip("destroy");
		$("#block-message").html('');
		if ($("#login-email").emptyValue()) {
			$("#login-email").tooltip('show');
			err = true;
		}
		if (!err && !mt.isValidEmailAddress(user_email)) {
			$("#login-email").attr('data-original-title', 'Incorrect Email Address').tooltip('show');
			err = true;
		}
		if (!err) {
			var postdata = mt.formSerialize($(".FieldSend"));
			$.post(mt.baseURL + "send-forgot-password", {
				'postdata' : postdata
			}, function(data) {
				$("#login-email").tooltip("destroy");
				if (data.email) {
					$("#login-email").attr('data-original-title', 'Email is not found').tooltip('show');
				}
				if (data.status) {
					$("#forgot-button").remove();
					$(".FieldSend").val('');
					$("#block-message").html(data.message);
				}
			}, "json");
		}
	});
	$(".valid-required").change(function() {
		$(this).tooltip("destroy");
	});
	$(".rd-seller").click(function() {
		$("#seller").val($(this).val())
	});
	$("#account-broker-setup").click(function() {
		if (!$(this).hasClass('active')) {
			$("#login-company").addClass('valid-required');
			$("p[data-class='broker']").show().find("input").addClass("FieldSend");
			$("p[data-class='homeowner']").hide().find("input").removeClass("FieldSend");
		}
	});
	$("#account-homeowner-setup").click(function() {
		if (!$(this).hasClass('active')) {
			$("#login-company").removeClass('valid-required');
			$("p[data-class='homeowner']").show().find("input:not(:radio)").addClass("FieldSend");
			$("p[data-class='broker']").hide().find("input").removeClass("FieldSend");
		}
	});
	$(".change-signup-class").click(function() {
		$("#signup-class").val($(this).attr('data-class'))
	});
	$("#register-cancel").click(function(){mt.redirect('/');});
})(window.jQuery);