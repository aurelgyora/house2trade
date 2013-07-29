/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

$(function(){
	$("select.set-active-property").change(function(){
		var parameter = $(this).val();
		$.ajax({
			url: mt.baseURL+'set-active-property',
			data: {'parameter':parameter},type: 'POST',dataType: 'json',
			beforeSend: function(){},
			success: function(response,textStatus,xhr){
				if(response.status){
					mt.redirect(response.redirect)
				}
			},
			error: function(xhr,textStatus,errorThrown){}
		});
	});
	$("select.select-property").change(function(){
		var parameter = $(this).val();
		$.ajax({
			url: mt.baseURL+'show-detail-property?property_id='+parameter,
			data: {'parameter':parameter},type: 'POST',dataType: 'json',
			beforeSend: function(){},
			success: function(response,textStatus,xhr){
				if(response.status){
					mt.redirect(response.redirect)
				}
			},
			error: function(xhr,textStatus,errorThrown){}
		});
	});
	$("select.show-properties").change(function(){
		var parameter = $(this).val();
		$.ajax({
			url: mt.baseURL+'show-properties-list',
			data: {'parameter':parameter},type: 'POST',dataType: 'json',
			beforeSend: function(){},
			success: function(response,textStatus,xhr){
				if(response.status){
					mt.redirect(response.redirect)
				}
			},
			error: function(xhr,textStatus,errorThrown){}
		});
	});
	$("select.set-current-property").change(function(){
		var parameter = $(this).val();
		$.ajax({
			url: mt.baseURL+'set-current-property',
			data: {'parameter':parameter},type: 'POST',dataType: 'json',
			beforeSend: function(){},
			success: function(response,textStatus,xhr){},
			error: function(xhr,textStatus,errorThrown){}
		});
	});
	$("select.choise-property").change(function(){
		var parameter = $(this).val();
		$.ajax({
			url: mt.baseURL+'set-current-property',
			data: {'parameter':parameter},type: 'POST',dataType: 'json',
			beforeSend: function(){},
			success: function(response,textStatus,xhr){
				if(response.status){
					mt.redirect(mt.currentURL);
				}
			},
			error: function(xhr,textStatus,errorThrown){}
		});
	});
	
});