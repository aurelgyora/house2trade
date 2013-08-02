/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

(function($){
	
	$("#edit-profile").click(function(){
		$("#form-edit-property-info").defaultValidationErrorStatus();
		$("#div-view-account-broker").addClass('hidden');
		$("#div-edit-account-broker").removeClass('hidden');
	});
	$("#save-profile").click(function(event){
		event.preventDefault();
		var err = false;
		var user_password = $("#login-password").val();
		var user_confirm_password = $("#confirm-password").val();
		$(".valid-required").each(function(i,element){if($(element).emptyValue()){$(element).tooltip('show');err = true;}});
		if(!mt.matches_parameters(user_password,user_confirm_password)){$("#confirm-password").attr('data-original-title','Passwords do not match').tooltip('show');return false;}
		if(!err && !mt.minLength(user_password,6)){$("#login-password").attr('data-original-title','length of least 6 characters').tooltip('show');err = true;}
		if(!err){
				var postdata = mt.formSerialize($(".FieldSend"));
				if($("#subcribe").is(":checked")){postdata = postdata+'&subcribe=1';}else{postdata = postdata+'&subcribe=0';}
				$.ajax({
					url: mt.baseURL+"save-profile",data:{'postdata':postdata},type:'POST',dataType:'json',
					beforeSend: function(){
						$("#form-edit-property-info").defaultValidationErrorStatus();
					},
					success: function(data,textStatus,xhr){
						$("div.form-request").html(data.message);
						if(data.status){
							mt.setJsonRequest(data.new_data,'html');
							$("#login-password").val('');
							$("#confirm-password").val('');
							$("#div-view-account-broker").removeClass('hidden');
							$("#div-edit-account-broker").addClass('hidden');
							$("html,body").animate({scrollTop:0},400);
						}
					},
					error: function(xhr,textStatus,errorThrown){
						alert('Error!');
					}
				});
			}
	})
	//----------------------------------------------------------------------------------
	$("a.edit-desired-property").click(function(){
		$("html,body").animate({scrollTop:0},400);
		$(this).parents("form").defaultValidationErrorStatus();
		$("div.div-manage-property").hide().addClass('hidden');
		$("#div-edit-desired-property").hide().removeClass('hidden').fadeIn('slow');
	})
	$("a.btn-edit-main-property").click(function(){
		$("html,body").animate({scrollTop:0},400);
		$(this).parents("form").defaultValidationErrorStatus();
		$("div.div-manage-property").hide().addClass('hidden');
		$("#div-property-information").hide().removeClass('hidden').fadeIn('slow');
	})
	$("a.add-property-images").click(function(){
		$("html,body").animate({scrollTop:0},400);
		$(this).parents("form").defaultValidationErrorStatus();
		$("div.div-manage-property").hide().addClass('hidden');
		$("#div-insert-photo-properties").hide().removeClass('hidden').fadeIn('slow');
	})
	$("a.remove-property-images").click(function(){
		$("html,body").animate({scrollTop:0},400);
		$(this).parents("form").defaultValidationErrorStatus();
		$("div.div-manage-property").hide().addClass('hidden');
		$("#div-remove-photo-properties").hide().removeClass('hidden').fadeIn('slow');
	})
	$("a.show-desired-property-form").click(function(){
		$(this).remove();
		$("div.div-desired-property-form").removeClass('hidden');
	})
	//----------------------------------------------------------------------------------
	$("button.btn-save-main-property").click(function(event){
		event.preventDefault();
		var _form = $("form.form-edit-main-property");
		if(mt.validation($(_form))){
			var postdata = mt.formSerialize($(_form).find('.FieldSend'));
			$.ajax({
				url: mt.baseURL+'save-main-property',data: {'postdata':postdata},type:'POST',dataType:'json',
				beforeSend: function(){
					$(_form).defaultValidationErrorStatus();
					$(".wait-request").removeClass('hidden');
				},
				success: function(data,textStatus,xhr){
					$(_form).defaultValidationErrorStatus();
					if(data.status){
						$("div.form-request").html(data.message);
					}
				},
				error: function(xhr,textStatus,errorThrown){
					$(_form).defaultValidationErrorStatus();
					alert('Error!');
				}
			});
		}else{
			$("html,body").animate({scrollTop:0},400);
		}
	})
	$("button.btn-save-disared-property").click(function(event){
		event.preventDefault();
		var _form = $("form.form-edit-desired-property");
		var _target = $(this).attr('data-target');
		if(mt.validation($(_form))){
			var postdata = mt.formSerialize($(_form).find('.FieldSend'));
			$.ajax({
				url: mt.baseURL+'save-disared-property',data: {'postdata':postdata},type:'POST',dataType:'json',
				beforeSend: function(){
					$(_form).defaultValidationErrorStatus();
					$(".wait-request").removeClass('hidden');
				},
				success: function(data,textStatus,xhr){
					$(_form).defaultValidationErrorStatus();
					if(data.status){
						$("div.form-request").html(data.message);
					}
					if(_target == 'refresh'){
						mt.redirect(mt.currentURL);
					}
				},
				error: function(xhr,textStatus,errorThrown){
					$(_form).defaultValidationErrorStatus();
					alert('Error!');
				}
			});
		}else{
			$("html,body").animate({scrollTop:0},400);
		}
	})
	$("button.btn-delete-property-images").click(function(event){
		event.preventDefault();
		var _form = $("form.form-remove-property-images");
		var postdata = mt.formSerialize($(_form).find("input:checkbox:checked"));
		if(postdata == ''){
			$("#block-message").html("Not selected images");
			return false;
		}
		$.ajax({
			url: mt.baseURL+"delete-property-images",data:{'postdata':postdata},type:'POST',dataType:'json',
			beforeSend: function(){
				$(_form).defaultValidationErrorStatus();
			},
			success: function(data,textStatus,xhr){
				if(data.status == false){
					$("div.form-request").html(data.message);
				}else{
					$(_form).find("input:checkbox:checked").parents('div.property-image-item').remove();
					$("div.form-request").html('Images deleted');
					$("html,body").animate({scrollTop:0},400);
				}
			},
			error: function(xhr,textStatus,errorThrown){
				alert('Error!');
			}
		});
	})
	//----------------------------------------------------------------------------------
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
	$("button.change-property-status").click(function(event){
		if($(this).hasClass("active")){return false;}
		var element = this;
		var property = $(element).parents('div.btn-group').attr('data-property-id');
		var status = $(element).attr('data-property-status');
		$.post(mt.baseURL+"change-property-status",{'property':property,'status':status},
			function(data){
				if(data.status){$(element).siblings("button.change-property-status").removeClass('btn-success btn-info');$(element).addClass('btn-info');}
			},
		"json");
		
	})
	$("button.btn-change-down-payment").click(function(event){
		if($("#down-payment-value").emptyValue()){return false;}
		var element = this;
		var matchID = $(element).attr('data-match');
		var DPValue = $("#down-payment-value").val();
		$.post(mt.baseURL+"change-down-payment-value",{'match':matchID,'value':DPValue},
			function(data){
				if(data.status){
					$("#my-down-payment-value").html(DPValue);
					$(element).addClass('btn-success');
				}
			},
		"json");
		
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
		$("#form-request").empty();
		$("#metod-block-message").empty();
		$("html,body").animate({scrollTop:0},400);
	});
	$("#set-properties-auto-data").click(function(){
		$(".valid-required").tooltip('destroy');
		$("#div-account-properties").hide().addClass('hidden');
		$("#div-choise-metod").hide().removeClass('hidden').fadeIn('slow');
		$("#form-request").empty();
		$("#metod-block-message").empty();
		$("html,body").animate({scrollTop:0},400);
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
	$("button.btn-property-add-potential-by").click(function(){addPotentialBy(this);});
	$("button.btn-property-remove-potential-by").click(function(){
		if(confirm('Confirm remove from potential by?') == false) return false;
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
	$("a.btn-delete-company").click(function(){if(confirm("Delete company?") == false) return false;});
	$("a.show-modal-confirm").click(function(){
		$("button.btn-comfirm-add-potential-by").attr('data-target',$(this).attr('data-propery-target')).attr('data-src',$(this).attr('data-propery-id')).off('click').one('click',function(){setDownPayment(this);});
	});
	$("button.btn-approved-match").click(function(){changeStatusesMatch($(this).attr('data-match-id'),1);})
	$("button.btn-break-match").click(function(){changeStatusesMatch($(this).attr('data-match-id'),2);});
	function changeStatusesMatch(matchID,status){
		
		$.post(mt.baseURL+"change-match-statuses",{'match':matchID,'status':status},
			function(data){
				if(data.status){
					$("div.div-match-operation").addClass('hidden');
					$("#form-request").html(data.message);
				}
			}
		,"json");
	}
	function setDownPayment(_this){
		$("#addToPotentialBy > .modal-body > p:last").removeClass('hidden').siblings('p').addClass('hidden').siblings('#hidden-block').removeClass('hidden').find('input').val('');
		$(_this).html('Continue').removeClass('btn-primary').addClass('btn-success').off('click').one('click',function(){addPotentialBy(this);});
	}
	function addPotentialBy(_this){
		var parameter = $(_this).attr('data-src');
		$(_this).off('click').one('click',function(){setDownPayment(_this);})
		var downPayment = parseInt($("#down-payment").val().trim());
		$.post(mt.baseURL+"add-to-potential-by",{'parameter':parameter,'down_payment':downPayment},
			function(data){
				var target = $(_this).attr('data-target');
				if(target === 'remove'){
					$("a.show-modal-confirm[data-propery-id="+parameter+"]").parents('div.media').html(data.message);
				}else{
					$("a.show-modal-confirm[data-propery-id="+parameter+"]").replaceWith('<h3>Added to potential by</h3>');
				}
				$("#addToPotentialBy").modal('hide');
			}
		,"json");
		
	}
	$("#addToPotentialBy").on('hidden',function(){
		$("#addToPotentialBy > .modal-body > p:last").addClass('hidden').siblings('p').removeClass('hidden').siblings('#hidden-block').addClass('hidden').find('input').val('');
		$("button.btn-comfirm-add-potential-by").html('Yes').removeClass('btn-success').addClass('btn-primary');
	})
})(window.jQuery);