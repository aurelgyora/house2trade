/* Author: Grapheme Group
 * http://grapheme.ru/
 */

$(function(){
	$("select.chosen-property").chosen({search_contains: true});
	$("button.btn-set-chosen-property").click(function(){
		var propertyID = $("select.chosen-property").val();
		if(propertyID > 0){
			mt.redirect(mt.baseURL+'administrator/properties?property='+propertyID);
		}else{
			mt.redirect(mt.baseURL+'administrator/properties');
		}
	})
});