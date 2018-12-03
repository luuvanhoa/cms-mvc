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
		$catecode	= $item['catecode'];
		$show_on_fe = $item['show_on_fe'];
		$show_on_footer = $item['show_on_footer'];
		$metaTtile 	= $item['meta_title'];
		$metaDescription = $item['meta_description'];
		$created  	= Helper::formatDate('d-m-Y', $item['created_at']);
		$created_by = $item['created_by'];
		$modified  	= Helper::formatDate('d-m-Y', $item['modified_at']);
		$modified_by= $item['modified_by'];
		$linkEdit	= URL::createLink('admin', 'categoryArticle', 'form', array('id' => $id));
		$xhtmlList .= '<tr>
							<td><input type="checkbox" name="cid[]" value="'.$id.'"></td>
							<td><a href="'.$linkEdit.'">'.$name.'</a></td>
							<td>'.$catecode.'</td>
							<td>'.$show_on_fe.'</td>
							<td>'.$show_on_footer.'</td>
							<td>'.$metaTtile.'</td>
							<td>'.$metaDescription.'</td>
							<td>'.$created.'<br>'.$created_by.'</td>
							<td>'.$modified.'<br>'.$modified_by.'</td>
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
						<th><input type="checkbox" name="checkAll" id="check-all"></th>
						<th>Name</th>
						<th>Catecode</th>
						<th>Show On FE</th>
						<th>Show On Footer</th>
						<th>Meta Title</th>
						<th>Meta Description</th>
						<th>Created</th>
						<th>Modified</th>
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