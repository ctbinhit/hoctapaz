/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	config.extraPlugins += (config.extraPlugins.length == 0 ? '' : ',') + 'pastefromword,clipboard';
	config.extraPlugins += (config.extraPlugins.length == 0 ? '' : ',') + 'codeTag';

	config.extraPlugins += (config.extraPlugins.length == 0 ? '' : ',') + 'chart';

	// QR Creator
	//config.extraPlugins += (config.extraPlugins.length == 0 ? '' : ',') + 'yaqr';

	config.extraPlugins += (config.extraPlugins.length == 0 ? '' : ',') + 'colorbutton';

	// Add WIRIS to the plugin list
    config.extraPlugins += (config.extraPlugins.length == 0 ? '' : ',') + 'ckeditor_wiris';

    config.extraPlugins += (config.extraPlugins.length == 0 ? '' : ',') + 'colordialog';
    config.extraPlugins += (config.extraPlugins.length == 0 ? '' : ',') + 'ckawesome';

    config.extraPlugins += (config.extraPlugins.length == 0 ? '' : ',') + 'widget,lineutils,fontawesome';
    config.contentsCss 	= window.location.origin + '/public/bower_components/font-awesome/css/font-awesome.min.css';

        //config.pasteFromWordRemoveFontStyles = false;
	//config.pasteFromWordRemoveStyles = false;
        config.forcePasteAsPlainText = false;
        config.pasteFromWordRemoveFontStyles = false;
        config.pasteFromWordRemoveStyles = false;
        config.allowedContent = true;
        config.extraAllowedContent = 'p(mso*,Normal)';
        config.pasteFilter = null;

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		'/',
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'others' },
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	//config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;h4;h5;h6;pre';

	// Simplify the dialog windows.
	//config.removeDialogTabs = 'image:advanced;link:advanced';
	config.height = '500px';
};
