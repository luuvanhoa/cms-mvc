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
		$avatar		= !empty($item['avatar']) ? $item['avatar'] : 'no-avatar.png';
		$name 		= $item['name'];
		$status   	= Helper::cmsStatus($item['status'], URL::createLink('admin', $this->arrParam['controller'], 'ajaxStatus', array('id' => $id, 'status' => $item['status'])), $id);
		$creation_time  	= Helper::formatDate('d-m-Y H:m:s', $item['creation_time']);
		$modified_time  	= Helper::formatDate('d-m-Y H:m:s', $item['modified_time']);
		$linkEdit	= URL::createLink('admin', 'author', 'form', array('id' => $id));
		$xhtmlList .= '<tr>
							<td><input type="checkbox" name="cid[]" value="'.$id.'"></td>
							<td><img src="'.UPLOAD_URL.'author'.DS.'150x150-'.$avatar.'" class="img-circle image-avatar"/></td>
							<td><a href="'.$linkEdit.'">'.$name.'</a></td>
							<td>'.$creation_time.'</td>
							<td>'.$modified_time.'</td>
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
						<th>Avatar</th>
						<th>Name</th>
						<th>Creation_time</th>
						<th>Modified_time</th>
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