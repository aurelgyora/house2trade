/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

(function($){
	if($.cookie('operation') != null){
		$.cookie('operation',null,{path:"/"});
		$.cookie('backpath',null,{path:"/"});
		$.jGrowl('<img src="'+mt.baseURL+'img/check.png" alt="" /> <span class="text-info">Operation successful</span>',{life:2000});
	}
	$(".set-operation").click(function(event){$.cookie('backpath',mt.currentURL,{path:"/"});});
	$("#saveItem").click(function(event){$.cookie('operation',true,{path:"/"});});
	$("#cancel").click(function(event){event.preventDefault();$.cookie('operation',null);mt.redirect($.cookie('backpath'))});
})(window.jQuery);