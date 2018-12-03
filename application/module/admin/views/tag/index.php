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
		$name 		= $item['name'];
		$status   	= Helper::cmsStatus($item['status'], URL::createLink('admin', $this->arrParam['controller'], 'ajaxStatus', array('id' => $id, 'status' => $item['status'])), $id);
		$created  	= Helper::formatDate('d-m-Y', $item['created']);
		$created_by = $item['created_by'];
		$modified  	= Helper::formatDate('d-m-Y', $item['modified']);
		$modified_by= $item['modified_by'];
		$linkEdit	= URL::createLink('admin', 'tag', 'form', array('id' => $id));
		$xhtmlList .= '<tr>
							<td><input type="checkbox" name="cid[]" value="'.$id.'"></td>
							<td><a href="'.$linkEdit.'">'.$name.'</a></td>
							<td>'.$created.'</td>
							<td>'.$created_by.'</td>
							<td>'.$modified.'</td>
							<td>'.$modified_by.'</td>
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
						<th>Created</th>
						<th>Created by</th>
						<th>Modified</th>
						<th>Modified by</th>
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
	        	 aaSorting: [[1, 'asc']] 			//Field sort default: name ASC
	 		});
	});
</script>