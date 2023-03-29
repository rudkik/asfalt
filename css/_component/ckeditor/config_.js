/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
config.extraPlugins = 'iframe';

config.toolbar =
 [
 	{ name: 'document',		items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-' ] },
 	{ name: 'clipboard',	items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
 	{ name: 'editing',		items : [ 'Find','Replace','-','SelectAll','-','SpellChecker'] },
	{ name: 'paragraph',	items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
 	'/',
 	{ name: 'basicstyles',	items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
 	{ name: 'insert',		items : ['Table','HorizontalRule','SpecialChar'] },
 	{ name: 'styles',		items : [ 'Styles','Format','Font','FontSize' ] },
 	{ name: 'colors',		items : [ 'TextColor','BGColor' ] },
 	{ name: 'tools',		items : [ 'Maximize', 'ShowBlocks','-' ] }
];
};
