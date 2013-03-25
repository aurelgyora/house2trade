/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */
 
var mt = mt || {};
mt.baseURL = 'http://house2trade/';
mt.currentURL = window.location.href;
mt.currentElement = 0;
mt.isValidEmailAddress = function(emailAddress){
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
};
mt.isValidPhone = function(phoneNumber){
	var pattern = new RegExp(/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i);
	return pattern.test(phoneNumber);
};
mt.formSerialize = function(objects){
	var data = '';
	$(objects).each(function(i,element){
		if(data === ''){data = $(element).attr('name')+"="+$(element).val();
		}else{data = data+"&"+$(element).attr('name')+"="+$(element).val();}
	});
	return data;
};
mt.matches_parameters = function(parameter1,parameter2){
	var param1 = new String(parameter1);
	var param2 = new String(parameter2);
	if(param1.toString() == param2.toString()){return true;}
	return false;
};
mt.exist_email = function(emailInput){
	var user_email = $(emailInput).val();
	$(emailInput).tooltip('destroy');
	if(user_email != ''){
		if(!mt.isValidEmailAddress(user_email)){$(emailInput).attr('data-original-title','Not valid email address').tooltip('show');}
		else{
			$.post(mt.baseURL+"valid/exist-email",{'parametr':user_email,'type':'email'},
				function(data){if(!data.status){$(emailInput).attr('data-original-title','Email already exist').tooltip('show');}},"json");
		}
	}
};
mt.redirect = function(path){window.location=path;}
mt.minLength = function(string,Len){if(string != ''){if(string.length < Len){return false}}return true}
mt.FieldsIsNotNumeric = function(formObject){
	var result = {};var num = 0;
	$(formObject).nextAll("input.digital").each(function(i,element){if(!$.isNumeric($(element).val())){result[num] = $(element).attr('id');num++;}});
	$(formObject).nextAll("input.numeric-float").each(function(i,element){if(!$.isNumeric($(element).val())){result[num] = $(element).attr('id');num++;}});
	if($.isEmptyObject(result)){return false;}else{return result;}
}
$(function(){
	$.fn.exists = function(){return $(this).length;}
	$.fn.emptyValue = function(){if($(this).val() == ''){return true;}else{return false;}}
	$(".none").click(function(event){event.preventDefault();});
	$(":input.unique-email").blur(function(){mt.exist_email(this);});
	$("a.link-operation-account").click(function(){mt.currentElement = $(this).attr("data-src");});
	$("#btn-modal-confirm-user").click(function(){
		if(mt.currentElement){
			var url = $("a.link-operation-account[data-src='"+mt.currentElement+"']").attr('data-url');
			$.post(url,{'parameter':mt.currentElement},function(data){
				if(data.status){mt.redirect(data.redirect);}
			},"json");
		}
	});
	$("#search-properties").submit(function(){
		var error = true;$("#form-request").html('');
		$(this).find("input[type='text'],select").each(function(i,element){if(!$(element).emptyValue()){error = false;}});
		if(!error){
			var postdata = mt.formSerialize($("#search-properties :input"));
			$.post(mt.baseURL+"search-properties",{'postdata':postdata},function(data){if(data.status){mt.redirect(data.redirect);}else{$("#form-request").html(data.message)}},"json");
		}else{
			$("#form-request").html('Not specified your search terms!');
			return false;
		}
		return false;
	});
	$("#a-search-property").click(function(){
		$(this).remove();
		$("#div-search-property").removeClass('hidden');
	});
	$("button.btn-property-add-favorite").click(function(){
		var parameter = $(this).attr('data-src');
		var _this = this;
		$.post(mt.baseURL+"add-to-favorite",{'parameter':parameter},function(data){
			$(_this).off('click').html(data.message);
			$(_this).siblings("button.btn-property-add-potential-by").show();
		},"json");
	});
	$("button.btn-property-remove-favorite").click(function(){
		var parameter = $(this).attr('data-src');
		var _this = this;
		$.post(mt.baseURL+"remove-to-favorite",{'parameter':parameter},
			function(data){
				$(_this).off('click').html(data.message);
				$(_this).siblings("button.btn-property-add-potential-by").remove();
			}
		,"json");
	});
	$("button.btn-property-add-potential-by").click(function(){
		var parameter = $(this).attr('data-src');
		var _this = this;
		$.post(mt.baseURL+"add-to-potential-by",{'parameter':parameter},
			function(data){
				$(_this).off('click').html(data.message);
			}
		,"json");
	});
	$("button.btn-property-remove-potential-by").click(function(){
		var parameter = $(this).attr('data-src');
		var _this = this;
		$.post(mt.baseURL+"remove-to-potential-by",{'parameter':parameter},
			function(data){
				$(_this).off('click').html(data.message);
			}
		,"json");
	});
});