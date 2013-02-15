/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */
 
var mt = mt || {};
mt.baseURL = 'http://'+window.location.hostname+'/';
mt.currentURL = window.location.href;
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
			$.post(mt.baseURL+"administrator/valid/exist-email",{'parametr':user_email,'type':'email'},
				function(data){if(!data.status){$(emailInput).attr('data-original-title','Email already exist').tooltip('show');}},"json");
		}
	}
};
mt.redirect = function(path){window.location=path;}
mt.ShowCut = function(element,event){
	event.preventDefault();
	$(element).next('cut').fadeIn('slow');$(element).remove();
}
mt.minLength = function(string,Len){if(string != ''){if(string.length < Len){return false}}return true}
$(function(){
	$.fn.exists = function(){return $(this).length;}
	$.fn.emptyValue = function(){if($(this).val() == ''){return true;}else{return false;}}
	$(".digital").keypress(function(e){if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)){return false;}});
	$(".numeric-float").keypress(function(e){if(e.which == 47){return false}; if(e.which!=8 && e.which!=46 && e.which!=0 && (e.which<46 || e.which>57)){return false}});
	$(".none").click(function(event){event.preventDefault();});
	$(".advanced").click(function(event){mt.ShowCut(this,event);});
});