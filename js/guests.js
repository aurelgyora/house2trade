/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

(function($){
	$("#login_button").click(function(event){
		var err = false; var thisElement = this;
		event.preventDefault();
		$(".valid-required").tooltip("destroy");$(thisElement).tooltip("destroy");
		$(".valid-required").each(function(i,element){if($(element).emptyValue()){$(element).tooltip('show');err = true;}});
		if(!err && !mt.isValidEmailAddress($("#login-email").val())){$("#login-email").attr('data-original-title','Incorrect Email Address').tooltip('show');err = true;}
		if(!err){
			var postdata = mt.formSerialize($(".FieldSend"));
			$.post(mt.baseURL+"login-in",{'postdata':postdata},function(data){if(data.status){$(".valid-required").tooltip("destroy"); mt.redirect(data.redirect);
			}else{$(thisElement).attr('data-original-title',data.message).tooltip('show');}},"json");
		}
	});
})(window.jQuery);