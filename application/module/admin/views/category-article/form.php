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
	$name 		          = (!empty($this->arrParam['form']['name'])) ? $this->arrParam['form']['name'] : null;
	$status				  = (isset($this->arrParam['form']['status'])) ? $this->arrParam['form']['status'] : null;
	$id					  = (!empty($this->arrParam['form']['id'])) ? $this->arrParam['form']['id'] : null;
	$catecode 		      = (!empty($this->arrParam['form']['catecode'])) ? $this->arrParam['form']['catecode'] : null;
	$show_on_fe	          = (isset($this->arrParam['form']['show_on_fe'])) ? $this->arrParam['form']['show_on_fe'] : null;
	$show_on_footer		  = (isset($this->arrParam['form']['show_on_footer'])) ? $this->arrParam['form']['show_on_footer'] : null;
	$position 		      = (!empty($this->arrParam['form']['position'])) ? $this->arrParam['form']['position'] : null;
	$position_footer 	  = (!empty($this->arrParam['form']['position_footer'])) ? $this->arrParam['form']['position_footer'] : null;
	$meta_title 		  = (!empty($this->arrParam['form']['meta_title'])) ? $this->arrParam['form']['meta_title'] : null;
	$meta_description 	  = (!empty($this->arrParam['form']['meta_description'])) ? $this->arrParam['form']['meta_description'] : null;
	//Input
	$inputName 		= Helper::cmsInput('text', 'form[name]', 'name', $name, array('class' => 'form-control'));
	$inputCatecode	= Helper::cmsInput('text', 'form[catecode]', 'catecode', $catecode, array('class' => 'form-control'));
	$selectStatus	= Helper::cmsSelectbox('form[status]', 'form-control', array('default' => '-- Select Status --', '1'=> 'Active', '0'=> 'Inactive'), $status);
	$inputMetaTitle 		= Helper::cmsInput('text', 'form[meta_title]', 'meta_title', $meta_title, array('class' => 'form-control'));
	$inputMetaDescription 	= Helper::cmsTextarea('form[meta_description]', 'meta_description', $meta_description, array('class' => 'form-control'));
	$inputPosition 		        = Helper::cmsInput('number', 'form[position]', 'position', $position, array('class' => 'form-control'));
	$inputPositionFooter 		= Helper::cmsInput('number', 'form[position_footer]', 'position_footer', $position_footer, array('class' => 'form-control'));
	$selectShowOnFE = Helper::cmsSelectbox('form[show_on_fe]', 'form-control', array('1'=> 'Show', '0'=> 'Hide'), $show_on_fe);
	$selectShowOnFooter = Helper::cmsSelectbox('form[show_on_footer]', 'form-control', array('1'=> 'Show', '0'=> 'Hide'), $show_on_footer);
	$inputHidden	= Helper::cmsInput('hidden', 'form[token]', 'token', time());
	//Flag => Edit
	$inputIDHidden	= Helper::cmsInput('hidden', 'form[id]', 'id', $id);
	//RowForm
	$rowName 	= Helper::cmsRowForm('Name', $inputName, 'col-sm-3', 'col-sm-9');
	$rowStatus 	= Helper::cmsRowForm('Status', $selectStatus, 'col-sm-3', 'col-sm-9');
	$rowCatecode= Helper::cmsRowForm('Catecode', $inputCatecode, 'col-sm-3', 'col-sm-9');
	$rowTitle 	= Helper::cmsRowForm('Meta Title', $inputMetaTitle, 'col-sm-3', 'col-sm-9');
	$rowDes 	= Helper::cmsRowForm('Meta Description', $inputMetaDescription, 'col-sm-3', 'col-sm-9');
	$rowShowOnFE= Helper::cmsRowForm('Show on FE', $selectShowOnFE, 'col-sm-3', 'col-sm-9');
	$rowShowOnFooter = Helper::cmsRowForm('Show on (Footer)', $selectShowOnFooter, 'col-sm-3', 'col-sm-9');
	$rowPosition = Helper::cmsRowForm('Position', $inputPosition, 'col-sm-3', 'col-sm-9');
	$rowPositionFooter = Helper::cmsRowForm('Position (Footer)', $inputPositionFooter, 'col-sm-3', 'col-sm-9');
 ?>
<div class="box box-info">
  <div class="box-body">
   <div class="row">
   	 <div class="col-md-6 col-md-offset-3">
      <form class="form-horizontal" id="myForm" action="" method="POST" enctype="multipart/form-data">
        <?php echo $rowName.$rowCatecode.$rowStatus.$rowShowOnFE.$rowShowOnFooter.$rowPosition. $rowPositionFooter. $rowTitle. $rowDes.$inputIDHidden.$inputHidden ?>
      </form> 
    </div>
   </div>
  </div>
</div>