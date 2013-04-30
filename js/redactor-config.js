/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */
var config = {
	skin:'office2003',
	resize_enabled: false,
	height: '350px',
	toolbar:[
		['Source','-','Preview','-','Templates'],
		['Cut','Copy','Paste','PasteText'],
		['Undo','Redo','-','SelectAll','RemoveFormat'],'/',
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		['NumberedList','BulletedList','-','Outdent','Indent'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Link','Unlink'],['Image','HorizontalRule','SpecialChar'],'/',
		['TextColor','Format','FontSize'],
		['Table','HorizontalRule','SpecialChar','-'],
		['Maximize', 'ShowBlocks']
	]
};
$(function(){
	$("textarea.redactor").ckeditor(config);
	var editor = $("textarea.redactor").ckeditorGet();
	CKFinder.setupCKEditor(editor,mt.baseURL+"ckfinder");
});