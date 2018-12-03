/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {


    // config.filebrowserBrowseUrl = 'http://haocms.laptrinhaz.com/ckfinder/ckfinder.html';
    //
    // config.filebrowserImageBrowseUrl = 'http://haocms.laptrinhaz.com/public/themes/sbackend/js/plugins/ckfinder/ckfinder.html?type=Images';
    //
    // config.filebrowserFlashBrowseUrl = 'http://haocms.laptrinhaz.com/public/themes/sbackend/js/plugins/ckfinder/ckfinder.html?type=Flash';
    //
    // config.filebrowserUploadUrl = 'http://haocms.laptrinhaz.com/public/themes/sbackend/js/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    //
    // config.filebrowserImageUploadUrl = 'http://haocms.laptrinhaz.com/public/themes/sbackend/js/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    //
    // config.filebrowserFlashUploadUrl = 'http://haocms.laptrinhaz.com/public/themes/sbackend/js/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

	config.filebrowserBrowseUrl = '../cms/public/template/admin/main/js/plugins/ckfinder/ckfinder.html';
	 
	config.filebrowserImageBrowseUrl = '../cms/public/template/admin/main/js/plugins/ckfinder/ckfinder.html?type=Images';
	 
	config.filebrowserFlashBrowseUrl = '../cms/public/template/admin/main/js/plugins/ckfinder/ckfinder.html?type=Flash';
	 
	config.filebrowserUploadUrl = '../cms/public/template/admin/main/js/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	 
	config.filebrowserImageUploadUrl = '../cms/public/template/admin/main/js/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	 
	config.filebrowserFlashUploadUrl = '../cms/public/template/admin/main/js/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
//	
//    config.filebrowserBrowseUrl = '../cms/public/template/admin/main/js/plugins/kcfinder/browse.php?opener=ckeditor&type=files';
//    config.filebrowserImageBrowseUrl = '../../cms/public/template/admin/main/js/plugins/kcfinder/browse.php?opener=ckeditor&type=images';
//    config.filebrowserFlashBrowseUrl = '../../cms/public/template/admin/main/js/plugins/kcfinder/browse.php?opener=ckeditor&type=flash';
//    config.filebrowserUploadUrl = '../../cms/public/template/admin/main/js/plugins/kcfinder/upload.php?opener=ckeditor&type=files';
//    config.filebrowserImageUploadUrl = '../../cms/public/template/admin/main/js/plugins/kcfinder/upload.php?opener=ckeditor&type=images';
//    config.filebrowserFlashUploadUrl = '../../cms/public/template/admin/main/js/plugins/kcfinder/upload.php?opener=ckeditor&type=flash';

     config.removePlugins = 'save,newpage,preview,print,templates,find,replace,selectall,spellchecker,forms,language,about';


     // Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};
