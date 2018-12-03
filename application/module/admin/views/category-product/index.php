<?php include_once MODULE_PATH.$this->arrParam['module'].DS.'views'.DS.'toolbar.php'?>
<?php include_once MODULE_PATH.$this->arrParam['module'].DS.'models'.DS.'CategoryProductModel.php'?>
<?php 
	// MESSAGE
    $itemObj= new CategoryProductModel();
	$message  = Session::get('message');
	Session::delete('message');
	$strMessage = Helper::cmsMessage($message);
	if(!empty($strMessage)) echo $strMessage;
?>
<?php 
	$xhtmlList = '';
	foreach ($this->Items as $item) {
		$id   		= $item['id'];
		$childList[$item['parent']][]	= $id;
		$orderingValue	= array_search($id, $childList[$item['parent']]);
		$lft   		= $item['lft'];
		$name 		= Helper::cmsLevelNested($item['level'], $item['name']);
		$catecode	= $item['catecode'];
		$status   	= Helper::cmsStatus($item['status'], URL::createLink('admin', $this->arrParam['controller'], 'ajaxStatus', array('id' => $id, 'status' => $item['status'])), $id);
		$position 	= Helper::cmsInput('text', 'position['.$id.']', 'position-'.$id, $item['position'], array('class'=> 'form-control', 'style' => 'width: 80px; text-align:center'));
		$position_footer 	= Helper::cmsInput('text', 'position_footer['.$id.']', 'position_footer-'.$id, $item['position_footer'], array('class'=> 'form-control', 'style' => 'width: 80px; text-align:center'));
		$ordering 	= Helper::cmsInput('text', 'ordering['.$id.']', 'ordering-'.$id, $orderingValue + 1, array('class'=> 'form-control', 'style' => 'width: 50px; text-align:center'));
		$created  	= Helper::formatDate('d-m-Y', $item['created_at']);
		$created_by = $item['created_by'];
		$modified  	= Helper::formatDate('d-m-Y', $item['modified_at']);
		$modified_by= $item['modified_by'];
		$linkEdit	= URL::createLink('admin', 'categoryProduct', 'form', array('id' => $id));
		$nodeParentInfo = $itemObj->getInfoItem($item['parent']);
		$btnMoveUp		= Helper::showButtonMove($id, 'up', $item['lft'], $nodeParentInfo['lft'] + 1);
		$btnMoveDown	= Helper::showButtonMove($id, 'down', $item['rgt'] + 1, $nodeParentInfo['rgt']);
		$xhtmlList .= '<tr>
							<td><input type="checkbox" name="cid[]" value="'.$id.'"></td>
							<td style="text-align:left;"><a href="'.$linkEdit.'">'.$name.'</a></td>
							<td>'.$btnMoveUp . ' ' . $btnMoveDown.' '. $ordering.'</td>
							<td>'.$catecode.'</td>
							<td>'.$position.'</td>
                            <td>'.$position_footer.'</td>
                            <td>'.$status.'</td>
							<td>'.$lft.'</td>
							<td>'.$id.'</td>
					 </tr>';
	}
 ?>
 <div class="row" id="alert"></div>
<form name="myForm" id="myForm" action="" method="POST">
	<div class="box box-info">
		<div class="box-body">
			<table id="example" class="table table-bordered table-striped text-center">
				<thead>
					<tr>
						<th><input type="checkbox" name="checkAll" id="check-all"></th>
						<th>Name</th>
						<th>Ordering</th>
						<th>Catecode</th>
						<th>Position</th>
						<th>Position (Left)</th>
						<th>Status</th>
						<th>Left</th>
						<th>ID</th>
					</tr>
				</thead>
				<tbody>
					<?php echo $xhtmlList ?>
				</tbody>
			</table>
		</div>
	</div>
</form>
<script type="text/javascript">
    function moveNode(id, type){
    	var location = window.location.href;
    	var res		 = location.replace('action=index', 'action=moveNode');
    	//console.log(res);
        window.location.href = res + '&id=' + id + '&type=' + type;
    }

	$(function() {
		$("#example").dataTable(
			{
	        	 aaSorting: [[8, 'asc']] 			//Field sort default: name ASC
	 		});
	});
</script>