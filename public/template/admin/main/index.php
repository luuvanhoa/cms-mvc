<!DOCTYPE html>
<html>
<head>
	<?php echo $this->_metaHTTP;?>
	<?php echo $this->_metaName;?>
    <title><?php echo $this->_title;?></title>
    <?php echo $this->_cssFiles;?>
    <?php echo $this->_jsFiles;?>
</head>
<body class="skin-blue">
	<!-- HEADER START -->
	<header class="header">
		<?php include_once 'html/nav-left.php';?>
		<?php include_once 'html/nav-right.php';?>
	</header>
	<!-- HEADER END -->
	<div class="wrapper row-offcanvas row-offcanvas-left"
		style="min-height: 599px;">
		<!-- SIDEBAR START -->
		<aside class="left-side sidebar-offcanvas" style="min-height: 1772px;">
			<?php include_once 'html/sidebar.php';?>
		</aside>
		<!-- SIDEBAR END -->

		<!-- CONTENT START -->
		<aside class="right-side">
			<section class="content-header">
           		<?php include_once 'html/breadcrumb.php';?>         
			</section>
			<section class="content">
           		<?php require_once MODULE_PATH. $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php'; ?>
			</section>
		</aside>
		<!-- CONTENT END -->
	</div>
</body>
</html>