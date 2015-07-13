/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.stylesSet.add( 'default', [
	{ name: 'Custom style', element: 'span', attributes: { 'class': 'custom_style' } }
]);

CKEDITOR.config.contentsCss = '/css/ckeditor.css';

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'links' },
		{ name: 'insert' },
        { name: 'styles' },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'align' ] },
        { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] }
    ];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript,Italic,Bold,Strike,HorizontalRule,Format';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:Link;image:advanced;link:advanced';
	
	config.filebrowserUploadUrl = '/ckupload';
	config.filebrowserImageUploadUrl = '/ckupload?type=image';

    config.language = 'ru';

	config.extraPlugins = 'nbsp';
};
