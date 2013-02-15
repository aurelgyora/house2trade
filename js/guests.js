/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

(function($){
	$("#login-button").click(function(event){
		var err = false;
		event.preventDefault();
		$(".valid-required").tooltip("destroy");$("#block-message").html('');
		$(".valid-required").each(function(i,element){if($(element).emptyValue()){$(element).tooltip('show');err = true;}});
		if(!err && !mt.isValidEmailAddress($("#login-email").val())){$("#login-email").attr('data-original-title','Incorrect Email Address').tooltip('show');err = true;}
		if(!err){
			var postdata = mt.formSerialize($(".FieldSend"));
			$.post(mt.baseURL+"login-in",{'postdata':postdata},function(data){if(data.status){$(".valid-required").tooltip("destroy"); mt.redirect(data.redirect);
			}else{$("#block-message").html(data.message);}},"json");
		}
	});
	$("#user-terms-of-service").click(function(){if($(this).is(":checked")){$("#register-button").removeAttr('disabled').css('background','#FFCC1D');}else{$("#register-button").attr('disabled','disabled').css('background','#C7C7C7');}$(".valid-required").tooltip("hide");$("#block-message").html('');})
	$("#user-subcribe").click(function(){if($(this).is(":checked")){$(this).val(1);}else{$(this).val(0);}})
	$("#register-button").click(function(event){
		event.preventDefault();
		if($("#user-terms-of-service").is(":checked")){
			var err = false;
			var user_email = $("#login-email").val();var user_password = $("#login-password").val();var user_confirm_password = $("#login-password-confirm").val();
			$(".valid-required").tooltip("destroy");$("#block-message").html('');
			$(".valid-required").each(function(i,element){if($(element).emptyValue()){$(element).tooltip('show');err = true;}});
			if(!err && !mt.isValidEmailAddress(user_email)){$("#login-email").attr('data-original-title','Incorrect Email Address').tooltip('show');err = true;}
			if(!err && !mt.matches_parameters(user_password,user_confirm_password)){$("#login-password-confirm").attr('data-original-title','Passwords do not match').tooltip('show');err = true;}
			if(!err){
				var postdata = mt.formSerialize($(".FieldSend"));
				$.post(mt.baseURL+"signup-broker",{'postdata':postdata},
					function(data){
						$(".valid-required").tooltip("destroy");
						$("#block-message").html(data.message);
						if(data.status){$("#register-button").remove();$(".FieldSend").val('');}
					},"json");
			}
		}
	});
	$(".valid-required").change(function(){$(this).tooltip("destroy");});
})(window.jQuery);