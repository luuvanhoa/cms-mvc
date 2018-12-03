<?php
	
	// ====================== PATHS ===========================
	define ('DS'				, '/');
	define ('ROOT_PATH'			, dirname(__FILE__));						
	define ('LIBRARY_PATH'		, ROOT_PATH . DS . 'libs' . DS);			
	define ('LIBRARY_EXT_PATH'	, LIBRARY_PATH . 'extends' . DS);			
	define ('PUBLIC_PATH'		, ROOT_PATH . DS . 'public' . DS);			
	define ('UPLOAD_PATH'		, PUBLIC_PATH  . 'files' . DS);				
	define ('SCRIPT_PATH'		, PUBLIC_PATH  . 'scripts' . DS);			
	define ('APPLICATION_PATH'	, ROOT_PATH . DS . 'application' . DS);		
	define ('MODULE_PATH'		, APPLICATION_PATH . 'module' . DS);					
	define ('BLOCK_PATH'		, APPLICATION_PATH . 'block' . DS);			
	define ('TEMPLATE_PATH'		, PUBLIC_PATH . 'template' . DS);								
	
	define	('ROOT_URL'			, DS);
	define	('APPLICATION_URL'	, ROOT_URL . 'application' . DS);
	define	('PUBLIC_URL'		, ROOT_URL . 'public' . DS);
	define	('UPLOAD_URL'		, PUBLIC_URL . 'files' . DS);
	define	('TEMPLATE_URL'		, PUBLIC_URL . 'template' . DS);
	
	
	define	('DEFAULT_MODULE'		, 'admin');
	define	('DEFAULT_CONTROLLER'	, 'index');
	define	('DEFAULT_ACTION'		, 'index');

	// ====================== DATABASE ===========================
   	 define ('DB_HOST'			, 'localhost');
   	 define ('DB_USER'			, 'root');
   	 define ('DB_PASS'			, 'mysql');
   	 define ('DB_NAME'			, 'cms-mvc');
   	 define ('DB_TABLE'			, 'group');
	
	// ====================== DATABASE LOCAL ===========================
	/*define ('DB_HOST'			, 'localhost');
	define ('DB_USER'			, 'root');						
	define ('DB_PASS'			, '');						
	define ('DB_NAME'			, 'cms_project');						
	define ('DB_TABLE'			, 'group');*/
	// ====================== DATABASE TABLE===========================
	define ('TBL_GROUP'					, 'group');
	define ('TBL_USER'					, 'user');
	define ('TBL_PRIVELEGE'				, 'privilege');
	define ('TBL_CATEGORY_ARTICLE'		, 'category_article');
	define ('TBL_ARTICLE'				, 'article');
	define ('TBL_CATEGORY_PRODUCT'		, 'category_product');
	define ('TBL_PRODUCT'				, 'product');
	define ('TBL_TAG'					, 'tag');
	define ('TBL_AUTHOR'				, 'author');
	define ('TBL_ORDER'				    , 'order');
	define ('TBL_ORDER_DETAIL'			, 'order_detail');
	define ('TBL_OBJECT_ARTICLE'		, 'object_article');
	define ('TBL_KEYWORD_PRODUCT'		, 'keyword_product');
	define ('TBL_OBJECT_PRODUCT'		, 'object_product');
	define ('TBL_ATTRIBUTES'		    , 'attributes');
	// ====================== CONFIG ===========================
	define ('TIME_LOGIN'		, 3600);
