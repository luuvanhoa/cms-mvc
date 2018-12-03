<?php
    $id	= (!empty($this->arrParam['form']['id'])) ? $this->arrParam['form']['id'] : null;
	$xhtmlList = '';
	foreach ($this->Items as $item) {
		$name 	    = $item['name'];
		$image		= !empty($item['image']) ? $item['image'] : 'no-image.jpg';
		$price 	    = Helper::formatNumber($item['price']);
		$quantity 	= $item['quantity'];
		$total 	    = Helper::formatNumber($item['quantity'] * $item['price']);
		$linkEdit	= URL::createLink('admin', 'product', 'form', array('id' => $item['product_id']));
		
		$xhtmlList .= '<tr>
							<td><input type="checkbox" name="cid[]" value="'.$id.'"></td>
                            <td><a href="'.$linkEdit.'">'.$name.'</a></td>
                            <td><img src="'.UPLOAD_URL.'product'.DS.'150x150-'.$image.'" class="image-product"/></td></td>
                            <td>'.$price.'</td>
                            <td>'.$quantity.'</td>
                            <td>'.$total.'</td>
					 </tr>';
	}
	
	//$rowName 	= Helper::cmsRowForm('Name', $this->infoOrder['name'], 'col-sm-2', 'col-sm-10');
	//$rowTotal 	= Helper::cmsRowForm('Total', $this->infoOrder['total'] , 'col-sm-2', 'col-sm-10');
 ?>
 <div class="box box-info">
  <div class="box-body">
   <div class="row">
   	 <div class="col-md-6 col-md-offset-3">
      <form class="form-horizontal" id="myForm" action="" method="POST" enctype="multipart/form-data">
        	<div class="form-group">
        		<label class="col-md-2">
        			Name
        		</label>
        		
        		<p class="col-md-10">
        			<?php echo $this->infoOrder['name'] . '<br>' . $this->infoOrder['phone'] . '<br>' . $this->infoOrder['address']?>
        		</p>
        	</div>
        	
        	<div class="form-group">
        		<label class="col-md-2">
        			Total
        		</label>
        		
        		<span class="col-md-10">
        			<?php echo Helper::formatNumber($this->infoOrder['total'])?>
        		</span>
        	</div>
      </form> 
    </div>
   </div>
  </div>
</div>
<form name="myForm" id="myForm" action="" method="POST">
	<h3>Order Detail</h3>
	<div class="box box-info">
		<div class="box-body">
			<table id="example" class="table table-bordered table-striped text-center">
				<thead>
					<tr>
						<th><input type="checkbox" name="check-all" id="check-all"></th>
						<th>Name</th>
						<th>Image</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total</th>
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