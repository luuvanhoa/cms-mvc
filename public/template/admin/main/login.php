<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $this->_title;?></title>
	<link rel="stylesheet" href="<?php echo TEMPLATE_URL.$this->_moduleName.DS.'main'.DS ?>css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo TEMPLATE_URL.$this->_moduleName.DS.'main'.DS ?>css/font-awesome.min.css" />
	<link rel="stylesheet" href="<?php echo TEMPLATE_URL.$this->_moduleName.DS.'main'.DS ?>css/AdminLTE.css" />
	<link rel="stylesheet" href="<?php echo TEMPLATE_URL.$this->_moduleName.DS.'main'.DS ?>css/custom.css" />
</head>
<body class="bg-black">
	<?php 
		require_once MODULE_PATH. $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php';
	?>
	<script src="<?php echo TEMPLATE_URL.$this->_moduleName.DS.'main'.DS ?>js/jquery.min.js"></script>
	<script src="<?php echo TEMPLATE_URL.$this->_moduleName.DS.'main'.DS ?>js/bootstrap.min.js"></script>
</body>
</html>
