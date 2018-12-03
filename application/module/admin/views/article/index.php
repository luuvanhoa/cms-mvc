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
		$title 		= $item['title'];
		$categorName= $item['categoryName'];
		$thumbnail  = !empty($item['thumbnail_url']) ? $item['thumbnail_url'] : 'no-image.jpg';
		$status   	= Helper::cmsStatus($item['status'], URL::createLink('admin', $this->arrParam['controller'], 'ajaxStatus', array('id' => $id, 'status' => $item['status'])), $id);
		$ordering 	= Helper::cmsInput('text', 'ordering['.$id.']', 'ordering-'.$id, $item['ordering'], array('class'=> 'form-control', 'style' => 'width: 50px; text-align:center'));
		$publish_time  		= Helper::formatDate('d-m-Y', $item['publish_time']);
		$creation_time  	= Helper::formatDate('d-m-Y H:m:s', $item['creation_time']);
		$modified_time  	= Helper::formatDate('d-m-Y H:m:s', @$item['modified_time']);
		$share_url 			= $item['share_url'];
		$linkEdit	= URL::createLink('admin', 'article', 'form', array('id' => $id));
		$classDelete 	= ($item['status'] == 2) ? 'class="delete-item"' : '';
		$xhtmlList .= '<tr '.$classDelete.'>
							<td><input type="checkbox" name="cid[]" value="'.$id.'"></td>
							<td><a href="'.$linkEdit.'">'.$title.'</a></td>
							<td><img src="'.UPLOAD_URL.'thumbnail'.DS.'150x150-'.$thumbnail.'" class="image-avatar"/></td>
							<td>'.$categorName.'</td>
                            <td>'.$publish_time.'</td>
							<td>'.$creation_time.'</td>
							<td>'.$creation_time.'</td>
							<td id="share_url-'.$id.'">'.$share_url.'</td>
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
						<th><input type="checkbox" name="checkAll" id="check-all"></th>
						<th>Title</th>
						<th>Thumbnail</th>
						<th>Category</th>
						<th>PublishTime</th>
						<th>CreateTime</th>
						<th>ModifiedTime</th>
						<th>ShareURL</th>
						<th>Ordering</th>
						<th>Publish</th>
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