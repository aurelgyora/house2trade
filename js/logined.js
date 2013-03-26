/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

(function($){
	if($.cookie('operation') != null){
		$.cookie('operation',null,{path:"/"});
		$.cookie('backpath',null,{path:"/"});
		$("#form-request").html('<img src="'+mt.baseURL+'img/check.png" alt="" /> <span class="text-info">Operation successful</span>');
	}
	$(".set-operation").click(function(event){$.cookie('backpath',mt.currentURL,{path:"/"});});
	$("#saveItem").click(function(event){$.cookie('operation',true,{path:"/"});});
	$("#cancel").click(function(event){event.preventDefault();$.cookie('operation',null);mt.redirect($.cookie('backpath'))});
	$("#register-properties").click(function(event){
		event.preventDefault();
		var err = false;
		var user_email = $("#login-email").val();var user_password = $("#login-password").val();
		$("input.valid-required").tooltip("destroy");$("#block-message").html('');
		$("#form-property-register .valid-required").each(function(i,element){if($(element).emptyValue()){$(element).tooltip('show');err = true;}});
		if(!err && !mt.isValidEmailAddress(user_email)){$("#login-email").attr('data-original-title','Incorrect Email Address').tooltip('show');err = true;}
		var notNumerics = mt.FieldsIsNotNumeric($("#form-property-register"));
		if(notNumerics){
			for(var element in notNumerics){
				$("#"+notNumerics[element]).attr('data-original-title','Incorrect numeric value').tooltip('show');err = true;
			}
		}
		if(!err){
			var postdata = mt.formSerialize($("#form-property-register .FieldSend"));
			$.post(mt.baseURL+"signup-properties",{'postdata':postdata},
				function(data){
					$("input.valid-required").tooltip("destroy");
					if(data.status){
						$("#div-choise-metod").remove();
						$("#div-account-properties").remove();
						$("#div-insert-photo-properties").hide().removeClass('hidden').fadeIn('slow');
						$(".FieldSend").val('');
						$("#photos-block-message").html(data.message);
					}
					$("#form-request").html(data.message);
				},"json");
		}
	})
	$("#save-property").click(function(event){
		event.preventDefault();
		var err = false;
		var user_password = ''; var user_confirm_password = '';
		if($("#login-password").val()){
			user_password = $("#login-password").val();
			user_confirm_password = $("#confirm-password").val();
		}
		$(".valid-required").tooltip("destroy");$("#block-message").html('');
		$("#form-edit-property-info .valid-required").each(function(i,element){if($(element).emptyValue()){$(element).tooltip('show');err = true;}});
		if(!mt.matches_parameters(user_password,user_confirm_password)){$("#confirm-password").attr('data-original-title','Passwords do not match').tooltip('show');return false;}
		if(!err && !mt.minLength(user_password,6)){$("#login-password").attr('data-original-title','length of least 6 characters').tooltip('show');err = true;}
		var notNumerics = mt.FieldsIsNotNumeric($("#form-edit-property-info"));
		if(notNumerics){
			for(var element in notNumerics){
				$("#"+notNumerics[element]).attr('data-original-title','Incorrect numeric value').tooltip('show');err = true;
			}
		}
		if(!err){
				var postdata = mt.formSerialize($("#form-edit-property-info .FieldSend"));
				$.post(mt.baseURL+"save-property-info",{'postdata':postdata},
					function(data){
						$("#block-message").html(data.message);
						if(data.status){$("#login-password").val('');$("#confirm-password").val('');}
					},"json");
			}
	});
	$(".user-status").click(function(event){
		if($(this).hasClass("active")){return false;}
		var element = this;
		var postdata = $(element).parents('tr').attr('data-account');
		$.post(mt.baseURL+"change-user-status",{'postdata':postdata},
				function(data){
					$(element).removeClass('btn-success').removeClass('btn-danger');
					$(element).siblings(':button').removeClass('btn-success').removeClass('btn-danger');
					if(data.status){$(element).addClass('btn-success');}else{$(element).addClass('btn-danger');}
				},"json");
		
	})
	$("input[role='tooltip']").change(function(){$(this).tooltip("destroy");});
	$("textarea[role='tooltip']").change(function(){$(this).tooltip("destroy");});
	$("#set-password").click(function(event){
		event.preventDefault();
		var err = false;
		var user_password = $("#login-password").val();
		var user_confirm_password = $("#confirm-password").val();
		$("input.valid-required").tooltip("destroy");
		$("input.valid-required").each(function(i,element){if($(element).emptyValue()){$(element).tooltip('show');err = true;}});
		if(!mt.matches_parameters(user_password,user_confirm_password)){$("#confirm-password").attr('data-original-title','Passwords do not match').tooltip('show');return false;}
		if(!err && !mt.minLength(user_password,6)){$("#login-password").attr('data-original-title','length of least 6 characters').tooltip('show');err = true;}
		if(!err){
				var postdata = mt.formSerialize($("input.FieldSend"));
				$.post(mt.baseURL+"save-profile",{'postdata':postdata},
					function(data){
						$("#block-message").html(data.message);
						if(data.status){mt.redirect(data.redirect)}
					},"json");
			}
	});
	$("#set-properties-manual-data").click(function(){
		$(".valid-required").tooltip('destroy');
		$("#div-choise-metod").addClass('hidden');
		$("#div-account-properties").hide().removeClass('hidden').fadeIn('slow');
	});
	$("#set-properties-data").click(function(event){
		event.preventDefault();
		var err = false;
		var _this = this;
		$("input.valid-required").tooltip("destroy");$("#block-message").html('');
		$("#form-metod-property-register .valid-required").each(function(i,element){if($(element).emptyValue()){$(element).tooltip('show');err = true;}});
		if(!err){
			var address = $("#address-parameter").val();
			var zip = $("#zipcode-parameter").val();
			$(_this).addClass('disabled').attr('disabled','disabled');
			$("span.wait-request").removeClass('hidden');
			$.post(mt.baseURL+"get-property-zillow-api",{'address':address,'zip':zip},
				function(data){
					$("span.wait-request").addClass('hidden');
					$(_this).removeClass('disabled').removeAttr('disabled');
					if(data.status){
						mt.setJsonRequest(data.result,'val');
						$("#property-type :contains('"+data.result['property-type']+"')").attr("selected","selected");
						$("#set-properties-manual-data").click()
					}
				}
			,"json");
		}
	});
	$("#save-profile").click(function(event){
		event.preventDefault();
		var err = false;
		var user_password = $("#login-password").val();
		var user_confirm_password = $("#confirm-password").val();
		$(".valid-required").tooltip("destroy");$("#block-message").html('');
		$(".valid-required").each(function(i,element){if($(element).emptyValue()){$(element).tooltip('show');err = true;}});
		if(!mt.matches_parameters(user_password,user_confirm_password)){$("#confirm-password").attr('data-original-title','Passwords do not match').tooltip('show');return false;}
		if(!err && !mt.minLength(user_password,6)){$("#login-password").attr('data-original-title','length of least 6 characters').tooltip('show');err = true;}
		if(!err){
				var postdata = mt.formSerialize($(".FieldSend"));
				if($("#subcribe").is(":checked")){postdata = postdata+'&subcribe=1';}else{postdata = postdata+'&subcribe=0';}
				$.post(mt.baseURL+"save-profile",{'postdata':postdata},
					function(data){
						$("#block-message").html(data.message);
						if(data.status){
							mt.setJsonRequest(data.new_data,'html');
							$("#login-password").val('');
							$("#confirm-password").val('');
							$("#div-view-account-broker").removeClass('hidden');
							$("#div-edit-account-broker").addClass('hidden');
						}
					},"json");
			}
	});
	$("#edit-profile").click(function(){
		$("#div-view-account-broker").addClass('hidden');
		$("#div-edit-account-broker").removeClass('hidden');
	});
	$("#delete-property-images").click(function(event){
		event.preventDefault();
		var postdata = mt.formSerialize($("#form-remove-property-images input:checkbox:checked"));
		if(postdata == ''){
			$("#block-message").html("Not selected images");
			return false;
		}
		$.post(mt.baseURL+"delete-property-images",{'postdata':postdata},
			function(data){
				$("#block-message").html(data.message);
				if(data.status){
					$("#form-remove-property-images input:checkbox:checked").parents('div.property-image-item').html('<p class="text-info">Deleted</p>');
				}
			},"json");
	});
	$("#set-properties-auto-data").click(function(){
		$(".valid-required").tooltip('destroy');
		$("#div-account-properties").hide().addClass('hidden');
		$("#div-choise-metod").hide().removeClass('hidden').fadeIn('slow');
	});
	$("a.add-property-images").click(function(){
		$(".valid-required").tooltip('destroy');
		$("#div-property-information").hide().addClass('hidden');
		$("#div-remove-photo-properties").hide().addClass('hidden');
		$("#div-insert-photo-properties").hide().removeClass('hidden').fadeIn('slow');
	});
	$("#remove-property-images").click(function(){
		$(".valid-required").tooltip('destroy');
		$("#div-property-information").hide().addClass('hidden');
		$("#div-insert-photo-properties").hide().addClass('hidden');
		$("#div-remove-photo-properties").hide().removeClass('hidden').fadeIn('slow');
	});
	$("#input-select-owner").change(function(){
		var parameter = $(this).val();
		$.post(mt.baseURL+"set-current-owner",{'parameter':parameter},function(data){mt.redirect(data.redirect)},"json");
	});
})(window.jQuery);