/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

(function($){
	$("#register-properties").click(function(event){
		event.preventDefault();
		var err = false; var _this = this;
		$("#form-request").html('');
		var user_email = $("#login-email").val();var user_password = $("#login-password").val();
		$("input.valid-required").tooltip("destroy");$("#block-message").html('');
		$("#form-property-register .valid-required").each(function(i,element){if($(element).emptyValue()){$(element).tooltip('show');err = true;}});
		if(!err && !mt.isValidEmailAddress(user_email)){$("#login-email").attr('data-original-title','Incorrect Email Address').tooltip('show');err = true;}
		var notNumerics = mt.FieldsIsNotNumeric($("#form-property-register"));
		if(notNumerics){for(var element in notNumerics){$("#"+notNumerics[element]).attr('data-original-title','Incorrect numeric value').tooltip('show');err = true;}}
		if(!err){
			var postdata = mt.formSerialize($("#form-property-register .FieldSend"));
			$(_this).addClass('disabled').attr('disabled','disabled').siblings("span.wait-request").removeClass('hidden');
			$.post(mt.baseURL+"signup-property",{'postdata':postdata},
				function(data){
					$(_this).removeClass('disabled').removeAttr('disabled').siblings("span.wait-request").addClass('hidden');
					$("input.valid-required").tooltip("destroy");
					if(data.status){
						$("#div-choise-metod").remove();
						$("#div-account-properties").remove();
						$("#div-insert-photo-properties").hide().removeClass('hidden').fadeIn('slow');
						$(".FieldSend").val('');
						$("#photos-block-message").html(data.message);
					}else{
						$("#form-request").html(data.message);
					}
				},"json");
		}
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
					}else{
						$("#metod-block-message").html(data.messages);
					}
				}
			,"json");
		}
	});
	$("#input-select-property").change(function(){
		var parameter = $(this).val();
		$.post(mt.baseURL+"set-active-property",{'parameter':parameter},function(data){mt.redirect(data.redirect)},"json");
	});
	$("#input-select-current-property").change(function(){
		var parameter = $(this).val();
		$.post(mt.baseURL+"set-current-property",{'parameter':parameter},function(data){mt.redirect(data.redirect)},"json");
	});
	$("#input-select-favorite").change(function(){
		var parameter = $(this).val();
		$.post(mt.baseURL+"set-current-favorite",{'parameter':parameter},function(data){mt.redirect(data.redirect)},"json");
	});
	$("#seller-register-properties").click(function(event){
		event.preventDefault();
		var err = false; var _this = this;
		$("#form-request").html('');
		var notNumerics = mt.FieldsIsNotNumeric($("#form-property-register"));
		if(notNumerics){for(var element in notNumerics){$("#"+notNumerics[element]).attr('data-original-title','Incorrect numeric value').tooltip('show');err = true;}}
		if(!err){
			var postdata = mt.formSerialize($("#form-property-register .FieldSend"));
			$(_this).addClass('disabled').attr('disabled','disabled').siblings("span.wait-request").removeClass('hidden');
			$.post(mt.baseURL+"seller-signup-properties",{'postdata':postdata},
				function(data){
					$(_this).removeClass('disabled').removeAttr('disabled').siblings("span.wait-request").addClass('hidden');
					$("input.valid-required").tooltip("destroy");
					if(data.status){
						$("#div-choise-metod").remove();
						$("#div-account-properties").remove();
						$("#div-insert-photo-properties").hide().removeClass('hidden').fadeIn('slow');
						$(".FieldSend").val('');
						$("#photos-block-message").html(data.message);
					}else{
						$("#form-request").html(data.message);
					}
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
					$("#form-remove-property-images input:checkbox:checked").parents('div.property-image-item').remove();
					$("#photo-delete-message").html('Images deleted');
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
	$("#form-manage-company").submit(function(){
		var err = false;
		$(".valid-required").tooltip("destroy");
		$(".valid-required").each(function(i,element){if($(element).emptyValue()){$(element).tooltip('show');err = true;}});
		if(!err && !mt.isValidEmailAddress($("#company-email").val())){$("#company-email").attr('data-original-title','Incorrect Email Address').tooltip('show');err = true;}
		if(!err && !mt.isValidPhone($("#company-phone").val())){$("#login-email").attr('data-original-title','Incorrect Phone Number').tooltip('show');err = true;}
		if(err){return false;}
	})
	$("button.btn-property-add-favorite").click(function(){
		if($("select.input-select-property").emptyValue()){alert('At first select a property'); return false;}
		var parameter = $(this).attr('data-src');
		var _this = this;
		$.post(mt.baseURL+"add-to-favorite",{'parameter':parameter},function(data){
			if(data.status){$(_this).siblings("button.btn-property-remove-favorite").removeClass('hidden').show();$(_this).hide();
			}else{$(_this).html('Error adding');}
		},"json");
	});
	$("button.btn-property-remove-favorite").click(function(){
		var parameter = $(this).attr('data-src');
		var _this = this;
		$.post(mt.baseURL+"remove-to-favorite",{'parameter':parameter},
			function(data){
				var target = $(_this).attr('data-target');
				if(data.status){
					if(target === 'remove'){$(_this).parents('div.media').remove();
					}else{$(_this).hide();$(_this).siblings("button.btn-property-add-favorite").removeClass('hidden').show();}
				}else{$(_this).html('Error removing');}
			}
		,"json");
	});
	$("button.btn-property-add-potential-by").click(function(){
		var parameter = $(this).attr('data-src');
		var _this = this;
		$.post(mt.baseURL+"add-to-potential-by",{'parameter':parameter},
			function(data){
				var target = $(_this).attr('data-target');
				if(target === 'remove'){
					$(_this).parents('div.media').remove();
				}else{
					$(_this).siblings("button.btn-property-remove-potential-by").removeClass('hidden').show();
					$(_this).hide();
				}
			}
		,"json");
	});
	$("button.btn-property-remove-potential-by").click(function(){
		var parameter = $(this).attr('data-src');
		var _this = this;
		$.post(mt.baseURL+"remove-to-potential-by",{'parameter':parameter},
			function(data){
				var target = $(_this).attr('data-target');
				if(target === 'remove'){
					$(_this).parents('div.media').remove();
				}else{
					$(_this).hide();
					$(_this).siblings("button.btn-property-add-potential-by").show();
				}
			}
		,"json");
	});
	$("a.btn-delete-company").click(function(){if(confirm("Delete company?") == false) return false;})
})(window.jQuery);