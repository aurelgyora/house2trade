/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

$(function(){
	$("form.admin-search-properties").submit(function(){
		var error = true;
		$(this).find("input[type='text'],select").each(function(i,element){if(!$(element).emptyValue()){error = false;}});
		if(!error){
			var postdata = mt.formSerialize($("form.admin-search-properties :input"));
			$.ajax({
				url: mt.baseURL+"admin-search-properties",type: 'POST',dataType: 'json',
				data:{'postdata':postdata},
				beforeSend: function(){
					$("#form-request").html('');
					$("span.wait-request").removeClass('hidden');
				},
				success: function(response,textStatus,xhr){
					if(response.status){
						mt.redirect(response.redirect);
					}else{
						$("#form-request").html(response.message);
						$("span.wait-request").addClass('hidden');
					}
				},
				error: function(xhr,textStatus,errorThrown){
					$("#form-request").html(textStatus);
					$("span.wait-request").addClass('hidden');
				}
			});
		}else{
			$("#form-request").html('Not specified your search terms!');
		}
		return false;
	});
});