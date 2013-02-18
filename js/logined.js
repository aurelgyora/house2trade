/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

(function($){
	if($.cookie('operation') != null){
		$.cookie('operation',null,{path:"/"});
		$.cookie('backpath',null,{path:"/"});
		$.jGrowl('<img src="'+mt.baseURL+'img/check.png" alt="" /> <span class="text-info">Operation successful</span>',{life:2000});
	}
	$(".set-operation").click(function(event){$.cookie('backpath',mt.currentURL,{path:"/"});});
	$("#saveItem").click(function(event){$.cookie('operation',true,{path:"/"});});
	$("#cancel").click(function(event){event.preventDefault();$.cookie('operation',null);mt.redirect($.cookie('backpath'))});
	$("#register-properties").click(function(event){
		event.preventDefault();
		var err = false;
		var user_email = $("#login-email").val();var user_password = $("#login-password").val();
		$(".valid-required").tooltip("destroy");$("#block-message").html('');
		$(".valid-required").each(function(i,element){if($(element).emptyValue()){$(element).tooltip('show');err = true;}});
		if(!err && !mt.isValidEmailAddress(user_email)){$("#login-email").attr('data-original-title','Incorrect Email Address').tooltip('show');err = true;}
		if(!err){
			var postdata = mt.formSerialize($(".FieldSend"));
			$.post(mt.baseURL+"signup-properties",{'postdata':postdata},
				function(data){
					$(".valid-required").tooltip("destroy");
					$("#block-message").html(data.message);
					if(data.status){$("#register-properties").remove();$(".FieldSend").val('');}
				},"json");
		}
	})
	$("#save-profile").click(function(event){
		event.preventDefault();
		var err = false;
		var user_password = $("#login-password").val();
		var user_confirm_password = $("#comfirm-password").val();
		$(".valid-required").tooltip("destroy");$("#block-message").html('');
		$(".valid-required").each(function(i,element){if($(element).emptyValue()){$(element).tooltip('show');err = true;}});
		if(!mt.matches_parameters(user_password,user_confirm_password)){$("#comfirm-password").attr('data-original-title','Passwords do not match').tooltip('show');return false;}
		if(!err && !mt.minLength(user_password,6)){$("#login-password").attr('data-original-title','length of least 6 characters').tooltip('show');err = true;}
		if(!err){
				var postdata = mt.formSerialize($(".FieldSend"));
				$.post(mt.baseURL+"save-profile",{'postdata':postdata},
					function(data){
						$("#block-message").html(data.message);
						if(data.status){$("#login-password").val('');$("#comfirm-password").val('');}
					},"json");
			}
	});
	$(".user-status").click(function(event){
		if($(this).hasClass("active")){return false;}
		var element = this;
		var postdata = $(element).parents('tr').attr('data-account');
		$.post(mt.baseURL+"change-user-status",{'postdata':postdata},
				function(data){
					$(".user-status").removeClass('btn-success').removeClass('btn-danger');
					if(data.status){$(element).addClass('btn-success');}else{$(element).addClass('btn-danger');}
				},"json");
		
	})
	$(".valid-required").change(function(){$(this).tooltip("destroy");});
	$("#set-password").click(function(event){
		event.preventDefault();
		var err = false;
		var user_password = $("#login-password").val();
		var user_confirm_password = $("#comfirm-password").val();
		$(".valid-required").tooltip("destroy");
		$(".valid-required").each(function(i,element){if($(element).emptyValue()){$(element).tooltip('show');err = true;}});
		if(!mt.matches_parameters(user_password,user_confirm_password)){$("#comfirm-password").attr('data-original-title','Passwords do not match').tooltip('show');return false;}
		if(!err && !mt.minLength(user_password,6)){$("#login-password").attr('data-original-title','length of least 6 characters').tooltip('show');err = true;}
		if(!err){
				var postdata = mt.formSerialize($(".FieldSend"));
				$.post(mt.baseURL+"save-profile",{'postdata':postdata},
					function(data){
						$("#block-message").html(data.message);
						if(data.status){mt.redirect(data.redirect)}
					},"json");
			}
	});
	$("#set-properties-data").click(function(event){
		
		event.preventDefault();
		var err = false;
		var mls = $("#mls-parameter").val();
		var zap = $("#zipcode-parameter").val();
		$(".valid-required").tooltip("destroy");$("#block-message").html('');
		$(".valid-required").each(function(i,element){if($(element).emptyValue()){$(element).tooltip('show');err = true;}});
	});
	$("#set-properties-manual-data").click(function(){
		$(".valid-required").tooltip('destroy');
		$("#div-choise-metod").addClass('hidden');
		$("#div-account-properties").hide().removeClass('hidden').fadeIn('slow');
	});
	$("#set-properties-auto-data").click(function(){
		$(".valid-required").tooltip('destroy');
		$("#div-account-properties").hide().addClass('hidden');
		$("#div-choise-metod").hide().removeClass('hidden').fadeIn('slow');
	});
})(window.jQuery);