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
		$name 	    = $item['name'];
		$email 	    = $item['name'];
		$phone 	    = $item['phone'];
		$address 	= $item['address'];
		$total 	    = Helper::formatNumber($item['total']);
		$linkView	= URL::createLink('admin', 'order', 'detail', array('id' => $id));
		$buttonView	= Helper::cmsButton('', $linkView, 'fa fa-eye', 'no', array('type' => 'view'));
		$created  	= Helper::formatDate('d-m-Y', $item['created_at']);
		$status   	= Helper::cmsStatus($item['status'], URL::createLink('admin', $this->arrParam['controller'], 'ajaxStatus', array('id' => $id, 'status' => $item['status'])), $id);
		
		$xhtmlList .= '<tr>
							<td><input type="checkbox" name="cid[]" value="'.$id.'"></td>
                            <td style="text-align: left"><span style="color: red;font-weight:bold;font-size:14px">'.$name.'</span><br>'.$phone.'<br>'.$address.'</td>
                            <td>'.$total.'</td>
                            <td>'.$created.'</td>
							<td>'.$status.'</td>
                            <td>'.$buttonView.'</td>
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
						<th style="text-align: left">Info Customer</th>
						<th>Total</th>
						<th>Created</th>
						<th>Status</th>
						<th>View Detail</th>
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