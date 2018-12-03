<?php 
	$aliasName  = array(
       'controller' => array(
           'index' 		          => 'Dashboard',
           'group' 		          => 'Manager Group',
           'user' 		          => 'Manager User',
           'category'             => 'Manager Category',
           'book' 		          => 'Manager Book',
           'cart' 		          => 'Manager Cart',
           'config' 	          => 'Manager Config',
           'article' 	          => 'Manager Article',
           'categoryArticle' 	  => 'Manager Category Article',
           'product' 	          => 'Manager Product',
           'categoryProduct' 	  => 'Manage Category Product',
           'author'               => 'Manager Author',
           'tag'                  => 'Manager Tag',
           'order' 	              => 'Manage Order',
           'keywordProduct' 	  => 'Manage Keyword Product',
           'attribute' 	          => 'Manage Attribute',
       ),
       
       'action' => array(
           'index' => 'List',
           'info'  => 'Info',
           'form'  => 'Form',
           'delete'=> 'Delete',
           'email' => 'Email',
           'image' => 'Image',
           'profile'=> 'Profile',
       )
   );
	/* HEADER */
   $parrentHeader = $aliasName['controller'][$this->arrParam['controller']];
   $childHeader   = @$aliasName['action'][$this->arrParam['action']];
   $xhtmlHeader   = sprintf('<h1>%s <small>%s</small></h1>', $parrentHeader, $childHeader);
   /* BEADCUMB */
   $breadCrumb = '';
   $linkHome   = URL::createLink('admin', 'index', 'index');
   if($this->arrParam['controller'] != 'index'){
       if($this->arrParam['action'] == 'index'){
           $breadCrumb = sprintf('<li class="active">%s</li><li class="active">%s</li>', $parrentHeader, $childHeader);
       }else{
           $breadCrumb = sprintf('<li class="active"><a href="%s">%s</a></li><li class="active">%s</li>', 
                             $linkHome,
                             $parrentHeader, 
                             $childHeader);
       }
   }
 ?>
 <?php echo $xhtmlHeader?>
<ol class="breadcrumb">
	<li><a href="<?php echo $linkHome; ?>" ><i class="fa fa-dashboard"></i> Home</a></li>
	<?php echo $breadCrumb?>
</ol>