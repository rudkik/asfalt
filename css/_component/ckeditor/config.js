/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

    config.filebrowserUploadUrl = '/cabinet/file/loadaddimage';
    config.filebrowserImageBrowseUrl = '/css/_component/elfinder/elfinder.html';

    config.filebrowserBrowseUrl = '/css/_component/elfinder/elfinder.html';

    config.height = 360;
    config.removePlugins = 'elementspath';
    config.entities = false;

    config.extraPlugins = 'youtube';

    config.toolbar =
        [
            { name: 'document',		items : [ 'Source','-', 'Maximize', 'ShowBlocks','-'] },
            { name: 'clipboard',	items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord' ] },
            { name: 'undo',	items : [ 'Undo','Redo' ] },
            { name: 'basicstyles_1',	items : ['Link','UnLink' ] },
            { name: 'addition',	items : ['Image','Table', 'HorizontalRule', 'SpecialChar', 'IFrame', 'Youtube' ] },
            { name: 'div',	items : ['Blockquote','CreateDiv'] },
            { name: 'paragraph_1',	items : [ 'NumberedList','BulletedList'] },
            { name: 'paragraph_2',	items : [  'Outdent','Indent'] },
            { name: 'styles',		items : [ 'RemoveFormat','Styles','Format','Font','FontSize' ] },
            { name: 'basicstyles_2',	items : [ 'Bold','Italic','Underline'] },
            { name: 'basicstyles',	items : ['Strike','Subscript','Superscript'] },
            { name: 'colors',		items : [ 'TextColor','BGColor' ] },
            { name: 'paragraph',	items : ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
        ];

    config.removeDialogTabs = 'image:advanced;link:advanced;link:selectAnchor';
    config.allowedContent = true;
};

CKEDITOR.on( 'dialogDefinition', function( ev ){
    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;
    if ( dialogName == 'link' ){dialogDefinition.removeContents( 'advanced' );dialogDefinition.removeContents( 'target' );}
    if ( dialogName == 'image' ){dialogDefinition.removeContents( 'advanced' );dialogDefinition.removeContents( 'Link' );}
    if ( dialogName == 'flash' ){dialogDefinition.removeContents( 'advanced' );}
});
