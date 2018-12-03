<?php include_once MODULE_PATH.$this->arrParam['module'].DS.'views'.DS.'toolbar.php'?>
<?php 
	// MESSAGE
	$message  = Session::get('message');
	Session::delete('message');
	$strMessage = Helper::cmsMessage($message);
	if(!empty($strMessage)) echo $strMessage;
 ?>
<?php 
	$xhtmlList = '';
	foreach ($this->Items as $item) {
		$id   		= $item['id'];
		$image		= !empty($item['image']) ? $item['image'] : 'no-image.jpg';
		$name 	    = $item['name'];
		$price 	    = $item['price'];
		$discount_price = $item['discount_price'];
		$categoryProductName	= $item['category_name'];
		$status   	= Helper::cmsStatus($item['status'], URL::createLink('admin', $this->arrParam['controller'], 'ajaxStatus', array('id' => $id, 'status' => $item['status'])), $id);
		$ordering 	= Helper::cmsInput('text', 'ordering['.$id.']', 'ordering-'.$id, $item['ordering'], array('class'=> 'form-control', 'style' => 'width: 50px; text-align:center'));
		$created  	= Helper::formatDate('d-m-Y', $item['created_at']);
		$created_by = $item['created_by'];
		$modified  	= Helper::formatDate('d-m-Y', $item['modified_at']);
		$modified_by= $item['modified_by'];
		$linkEdit	= URL::createLink('admin', 'product', 'form', array('id' => $id));
		$xhtmlList .= '<tr>
							<td><input type="checkbox" name="cid[]" value="'.$id.'"></td>
                            <td><a href="'.$linkEdit.'">'.$name.'</a></td>
                            <td>'.Helper::formatNumber($price).'</td>
							<td>'.Helper::formatNumber($discount_price).'</td>
                            <td><img src="'.UPLOAD_URL.'product'.DS.'150x150-'.$image.'" class="image-product"/></td></td>
                            <td>'.$categoryProductName.'</td>
							<td>'.$ordering.'</td>
							<td>'.$status.'</td>
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
						<th><input type="checkbox" name="check-all" id="check-all"></th>
						<th>Name</th>
						<th>Price</th>
						<th>Discount Price</th>
						<th>Image</th>
						<th>Category Name</th>
						<th>Ordering</th>
						<th>Status</th>
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
	$(function() {
		$("#example").dataTable(
			{
	        	 aaSorting: [[1, 'asc']], //Field sort default: name ASC		
	 		});
	});
</script>