/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

$(function(){
	$("button.btn-broker-register-property").click(function(){
		var step = $(this).attr('data-register-step').trim();
		var _form = $("#form-property-register");
		var _this = this;
		if(mt.validation($(_form))){
			if(step == 1){
				var postdata = mt.formSerialize($(_form).find('.FieldSend'));
				$.ajax({
					url: mt.baseURL+"valid/property-exist",data:{'postdata':postdata},type:'POST',dataType:'json',
					beforeSend: function(){
						$(_form).defaultValidationErrorStatus();
					},
					success: function(data,textStatus,xhr){
						if(data.status == false){
							$("#form-request").html(data.message);
						}else{
							$(_this).attr('data-register-step',2);
							$("div.div-register-property").addClass('hidden');
							$("div.register-property-step-2").removeClass('hidden');
							$("#span-step-number").html(2);
							$("span.decision").remove();
							$("#set-properties-auto-data").remove();
							$(_this).html('Add property');
							$("html,body").animate({scrollTop:0},400);
						}
					},
					error: function(xhr,textStatus,errorThrown){
						alert('Error!');
					}
				});
			}else if(step == 2){
				var postdata = mt.formSerialize($(_form).find('.FieldSend'));
				$.ajax({
					url: mt.baseURL+'signup-property',data: {'postdata':postdata},type:'POST',dataType:'json',
					beforeSend: function(){
						$(_form).defaultValidationErrorStatus();
					},
					success: function(data,textStatus,xhr){
						if(data.status){
							$("#div-choise-metod").remove();
							$("#div-account-properties").remove();
							$("#div-insert-photo-properties").removeClass('hidden');
							$("#photos-block-message").html(data.message);
						}
					},
					error: function(xhr,textStatus,errorThrown){
						alert('Error!');
					}
				});
			}
		}else{
			$("html,body").animate({scrollTop:0},400);
		}
	});
	$("button.btn-save-disared-property").click(function(event){
		event.preventDefault();
		var _form = $("form.form-edit-desired-property");
		if(mt.validation($(_form))){
			var postdata = mt.formSerialize($(_form).find('.FieldSend'));
			$.ajax({
				url: mt.baseURL+'save-disared-property',data: {'postdata':postdata},type:'POST',dataType:'json',
				beforeSend: function(){
					$(_form).defaultValidationErrorStatus();
				},
				success: function(data,textStatus,xhr){
					if(data.status){
						$("div.form-request").html(data.message);
					}
				},
				error: function(xhr,textStatus,errorThrown){
					alert('Error!');
				}
			});
		}else{
			$("html,body").animate({scrollTop:0},400);
		}
	})
	$("button.btn-save-main-property").click(function(event){
		event.preventDefault();
		var _form = $("form.form-edit-main-property");
		if(mt.validation($(_form))){
			var postdata = mt.formSerialize($(_form).find('.FieldSend'));
			$.ajax({
				url: mt.baseURL+'save-property',data: {'postdata':postdata},type:'POST',dataType:'json',
				beforeSend: function(){
					$(_form).defaultValidationErrorStatus();
				},
				success: function(data,textStatus,xhr){
					if(data.status){
						$("div.form-request").html(data.message);
					}
				},
				error: function(xhr,textStatus,errorThrown){
					alert('Error!');
				}
			});
		}else{
			$("html,body").animate({scrollTop:0},400);
		}
	})
	$("a.edit-desired-property").click(function(){
		$("html,body").animate({scrollTop:0},400);
		$(this).parents("form").defaultValidationErrorStatus();
		$("div.div-manage-property").hide().addClass('hidden');
		$("#div-edit-desired-property").hide().removeClass('hidden').fadeIn('slow');
	});
	$("a.btn-edit-main-property").click(function(){
		$("html,body").animate({scrollTop:0},400);
		$(this).parents("form").defaultValidationErrorStatus();
		$("div.div-manage-property").hide().addClass('hidden');
		$("#div-property-information").hide().removeClass('hidden').fadeIn('slow');
	});
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
});