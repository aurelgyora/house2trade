/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

$(function(){
	var config = {fx: 'fade',speed: '1000',easing: 'easeInOutExpo',timeout: 0,pager: '',pagerAnchorBuilder: function(idx,slide){return true}}
	$("ul.nav-cycle").each(function(i,element){
		var element_index = parseInt(i+2);
		config['pager'] = '.nav-'+element_index;
		config['pagerAnchorBuilder'] = function(idx,slide){
			return '.nav-'+element_index+' li:eq('+idx+') a';
		}
		if($('div.cycle-blocks-'+element_index).find("div.cycle-clocks-elements").length > 1){
			$('div.cycle-blocks-'+element_index).cycle(config);
		}
	});
});