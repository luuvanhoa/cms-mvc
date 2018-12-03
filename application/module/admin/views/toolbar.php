<?php
$controller	= $this->arrParam['controller'];

$linkAdd		= URL::createLink('admin', $controller, 'form');
$btnAdd 		= Helper::cmsButton('Add', $linkAdd, 'fa fa-plus-square-o', 'no', array('type' => 'add'));

$linkOrdering	= URL::createLink('admin', $controller, 'ordering');
$btnOrdering 	= Helper::cmsButton('Ordering', $linkOrdering, 'fa fa-refresh', 'yes');

$linkActive		= URL::createLink('admin', $controller, 'status', array('type' => 1));
$btnActive 		= Helper::cmsButton('Active', $linkActive, 'fa fa-check-square-o', 'yes');

$linkInactive	= URL::createLink('admin', $controller, 'status', array('type' => 0));
$btnInactive 	= Helper::cmsButton('Inactive', $linkInactive, 'fa fa-square-o',  'yes');

$linkDelete		= URL::createLink('admin', $controller, 'delete');
$btnDelete 		= Helper::cmsButton('Delete', $linkDelete, 'fa fa-minus-square-o', 'yes', array('type' => 'delete'));

$linkSave		= URL::createLink('admin', $controller, 'form', array('type' => 'save'));
$btnSave 		= Helper::cmsButton('Save', $linkSave, 'fa fa-save');

$linkSaveClose	= URL::createLink('admin', $controller, 'form', array('type' => 'save-close'));
$btnSaveClose 	= Helper::cmsButton('Save & Close', $linkSaveClose, 'fa fa-save');

$linkSaveNew	= URL::createLink('admin', $controller, 'form', array('type' => 'save-new'));
$btnSaveNew 	= Helper::cmsButton('Save & New', $linkSaveNew, 'fa fa-minus-square-o');

$linkCancel		= URL::createLink('admin', $controller, 'index');
$btnCancel 		= Helper::cmsButton('Cancel', $linkCancel, 'fa fa-arrow-circle-left');

$arrControllerNoOrdering = array('group', 'user', 'categoryArticle', 'categoryProduct', 'tag', 'author');
switch ($this->arrParam['action']) {
	case 'index':
		$strButton = $btnAdd.$btnActive.$btnInactive.$btnDelete;
		if(!in_array($controller, $arrControllerNoOrdering)){
			$strButton .= $btnOrdering;
		}
		
		if($this->arrParam['controller'] == 'order') {
		    $strButton = $btnActive.$btnInactive.$btnDelete;
		}
	break;
	case 'form':
		$strButton = $btnSave.$btnSaveClose.$btnSaveNew.$btnCancel;
	break;
}
?>
<div class="row">
	<div class="text-center">
		<?php echo $strButton ?>
	</div>
</div>

