<?php include_once MODULE_PATH.$this->arrParam['module'].DS.'views'.DS.'toolbar.php'?>
<?php 
	// MESSAGE
	$message  = Session::get('message');
	Session::delete('message');
	$strMessage = Helper::cmsMessage($message);
	if(!empty($strMessage)) echo $strMessage;
	// ALERT
	if(!empty($this->errors)) echo $this->errors;
 ?>
<?php 
	//Value
	$name 		= (!empty($this->arrParam['form']['name'])) ? $this->arrParam['form']['name'] : null;
	$status		= (isset($this->arrParam['form']['status'])) ? $this->arrParam['form']['status'] : null;
	$id	= (!empty($this->arrParam['form']['id'])) ? $this->arrParam['form']['id'] : null;
	//Input
	$inputName 		= Helper::cmsInput('text', 'form[name]', 'name', $name, array('class' => 'form-control'));
	$selectStatus	= Helper::cmsSelectbox('form[status]', 'form-control', array('default' => '-- Select Status --', '1'=> 'Active', '0'=> 'Inactive'), $status);
	$inputHidden	= Helper::cmsInput('hidden', 'form[token]', 'token', time());
	//Flag => Edit
	$inputIDHidden	= Helper::cmsInput('hidden', 'form[id]', 'id', $id);
	//RowForm
	$rowName 	= Helper::cmsRowForm('Name', $inputName, 'col-sm-2', 'col-sm-10');
	$rowStatus 	= Helper::cmsRowForm('Status', $selectStatus, 'col-sm-2', 'col-sm-10');
 ?>
<div class="box box-info">
  <div class="box-body">
   <div class="row">
   	 <div class="col-md-6 col-md-offset-3">
      <form class="form-horizontal" id="myForm" action="" method="POST" enctype="multipart/form-data">
        <?php echo $rowName.$rowStatus.$inputIDHidden.$inputHidden ?>
      </form> 
    </div>
   </div>
  </div>
</div>