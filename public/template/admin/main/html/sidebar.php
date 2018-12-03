<?php 
$userInfo = Session::get('user')['info'];
$username = $userInfo['username'];

$linkCPanel= URL::createLink('admin', 'index', 'index');
$linkGroup = URL::createLink('admin', 'group', 'index');
$linkUser  = URL::createLink('admin', 'user', 'index');

// Article
$linkArticle  			= URL::createLink('admin', 'article', 'index');
$linkCategoryArticle  	= URL::createLink('admin', 'categoryArticle', 'index');
$linkTag 				= URL::createLink('admin', 'tag', 'index');
$linkAuthor				= URL::createLink('admin', 'author', 'index');
// Product
$linkProduct  			= URL::createLink('admin', 'product', 'index');
$linkCategoryProduct  	= URL::createLink('admin', 'categoryProduct', 'index');
$linkKeywordProduct     = URL::createLink('admin', 'keywordProduct', 'index');
$linkAttribute          = URL::createLink('admin', 'attribute', 'index');
// Order
$linkOrder  			= URL::createLink('admin', 'order', 'index');

$arrMenu = array(
	array('name' => 'Control Panel', 'class'=> 'index-index', 'icon' => 'fa fa-dashboard', 'link' => URL::createLink('admin', 'index', 'index')),
	array('name' => 'Group', 'class'=> 'group-index group-form', 'icon' => 'fa fa-group', 'link' => URL::createLink('admin', 'group', 'index')),
	array('name' => 'User', 'class'=> 'user-index user-form', 'icon' => 'fa fa-user', 'link' => URL::createLink('admin', 'user', 'index')),
	array('name' => 'Article', 'class'=> 'categoryArticle-index article-index categoryArticle-form article-form author-index author-form tag-index tag-form', 'icon' => 'fa fa-newspaper-o', 'link' => '#', 'children' => array(
		array('name' => 'Category Article', 'class'=> 'categoryArticle-index categoryArticle-form', 'icon' => 'fa fa-list', 'link' => $linkCategoryArticle),
		array('name' => 'Article', 'class'=> 'article-index article-form', 'icon' => 'fa fa-file-text-o', 'link' => $linkArticle),
		array('name' => 'Author', 'class'=> 'author-index author-form', 'icon' => 'fa fa-male', 'link' => $linkAuthor),
		array('name' => 'Tag', 'class'=> 'tag-index tag-form', 'icon' => 'fa fa-tag', 'link' => $linkTag),
    )),
    array('name' => 'Product', 'class'=> 'categoryProduct-index product-index categoryProduct-form product-form', 'icon' => 'fa fa-book', 'link' => '#', 'children' => array(
        array('name' => 'Category Product', 'class'=> 'categoryProduct-index categoryProduct-form', 'icon' => 'fa fa-list', 'link' => $linkCategoryProduct),
        array('name' => 'Product', 'class'=> 'product-index product-form', 'icon' => 'fa fa-book', 'link' => $linkProduct),
        array('name' => 'Keyword Product', 'class'=> 'product-index product-form', 'icon' => 'fa fa-tag', 'link' => $linkKeywordProduct),
        array('name' => 'Attribute', 'class'=> 'product-index product-form', 'icon' => 'fa fa-list-alt', 'link' => $linkAttribute),
    )),
    array('name' => 'Order', 'class'=> 'order-index order-form', 'icon' => 'fa fa-shopping-cart', 'link' => $linkOrder),
);
$xhtmlMenu = '';
foreach ($arrMenu as $menu) {
	if(!empty($menu['children'])){
		$xhtmlMenu  .= '<li class="treeview '.$menu['class'].'">
							<a href="'.$menu['link'].'"> 
								<i class="'.$menu['icon'].'"></i> <span>'.$menu['name'].'</span><i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu '.$menu['class'].'">';
							foreach ($menu['children'] as $menuChild) {
								$xhtmlMenu .= '<li class="'.$menuChild['class'].'">
													<a href="'.$menuChild['link'].'" style="margin-left: 10px;">
														<i class="'.$menuChild['icon'].'"></i> '.$menuChild['name'].'
													</a>
												</li>';
							}
		$xhtmlMenu .= '</ul></li>';
	}else{
		$xhtmlMenu .= '<li class="'.$menu['class'].'">
							<a href="'.$menu['link'].'"> 
								<i class="'.$menu['icon'].'"></i><span>'.$menu['name'].'</span>
							</a>
						</li>';
	}
}

?>
<section class="sidebar">
	<div class="user-panel">
		<div class="pull-left image">
			<img src="<?php echo UPLOAD_URL.'avatar'.DS.$imgAvatar;?>" class="img-circle" alt="User Image">
		</div>
		<div class="pull-left info">
			<p><?php echo $username?></p>
			<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
		</div>
	</div>

	<ul class="sidebar-menu">
		<?php echo $xhtmlMenu ?>
	</ul>
</section>
<!-- Active menu -->
<script type="text/javascript">
	$(document).ready(function(){
		var controller = '<?php echo $this->arrParam['controller']?>';
        var action = '<?php echo $this->arrParam['action']?>';
        var classSelect = controller + '-' + action;
        $('li.' + classSelect).addClass('active');
        $('ul.' +classSelect).css('display', 'block');
	});
</script>