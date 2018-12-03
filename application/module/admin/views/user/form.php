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
	$username 	= (!empty($this->arrParam['form']['username'])) ? $this->arrParam['form']['username'] : null;
	$email 		= (!empty($this->arrParam['form']['email'])) ? $this->arrParam['form']['email'] : null;
	$fullname 	= (!empty($this->arrParam['form']['fullname'])) ? $this->arrParam['form']['fullname'] : null;
	$avatar 	= (!empty($this->arrParam['form']['avatar'])) ? $this->arrParam['form']['avatar'] : null; 
	$status		= (isset($this->arrParam['form']['status'])) ? $this->arrParam['form']['status'] : null;
	$group_id	= (isset($this->arrParam['form']['group_id'])) ? $this->arrParam['form']['group_id'] : null;
	$ordering	= (!empty($this->arrParam['form']['ordering'])) ? $this->arrParam['form']['ordering'] : null;
	$avatar     = (!empty($this->arrParam['form']['avatar']))  ? $this->arrParam['form']['avatar'] : 'no-avatar.png';
	$id	        = (!empty($this->arrParam['form']['id'])) ? $this->arrParam['form']['id'] : null;
	//Input
	$readOnly   		= !empty($id) ? 'readonly' : null; 
	$inputUserName 		= Helper::cmsInput('text', 'form[username]', 'username', $username, array('class' => 'form-control', 'readOnly' => $readOnly));
	$inputEmail 		= Helper::cmsInput('text', 'form[email]', 'email', $email, array('class' => 'form-control', 'readOnly' => $readOnly));
	$inputFullName		= Helper::cmsInput('text', 'form[fullname]', 'fullname', $fullname, array('class' => 'form-control'));
	$inputPassword		= Helper::cmsInput('password', 'form[password]', 'password', null, array('class' => 'form-control'));
	$selectStatus		= Helper::cmsSelectbox('form[status]', 'form-control', array('default' => '-- Select Status --', '1'=> 'Active', '0'=> 'Inactive'), $status);
	$selectGroup 		= Helper::cmsSelectbox('form[group_id]', 'form-control', $this->slbGroup, $group_id);
	$inputOrdering 	 	= Helper::cmsInput('text', 'form[ordering]', 'ordering', $ordering, array('class' => 'form-control'));
	$inputAvatar		= Helper::cmsInput('file', 'avatar', 'avatar', null, array('class' => 'form-control'));
	$inputHidden		= Helper::cmsInput('hidden', 'form[token]', 'token', time());
	$inputIDHiden 		= '';
	$inputPictureHidden = '';
	$imgAvatarOld		= '';
	$rowAvatarOld 		= '';
	if(!empty($this->arrParam['id'])){
		$inputIDHiden		= Helper::cmsInput('hidden', 'form[id]', 'id', $id);
		$inputPictureHidden	= Helper::cmsInput('hidden', 'form[avatar_hidden]', 'avatar_hidden', $avatar);
		$imgAvatarOld	= '<img src="'.UPLOAD_URL.'avatar'.DS.'150x150-'.$avatar.'" style="width: 150px"/>'; 
		$rowAvatarOld   = Helper::cmsRowForm(null, $imgAvatarOld, 'col-sm-2', 'col-sm-10');
	}
	//RowForm
	$rowUserName	= Helper::cmsRowForm('Username', $inputUserName, 'col-sm-2', 'col-sm-10');
	$rowEmail 		= Helper::cmsRowForm('Email', $inputEmail, 'col-sm-2', 'col-sm-10');
	$rowFullname	= Helper::cmsRowForm('Fullname', $inputFullName, 'col-sm-2', 'col-sm-10');
	$rowPassword 	= Helper::cmsRowForm('Password', $inputPassword, 'col-sm-2', 'col-sm-10');
	$rowStatus 		= Helper::cmsRowForm('Status', $selectStatus, 'col-sm-2', 'col-sm-10');
	$rowGroup		= Helper::cmsRowForm('Group', $selectGroup, 'col-sm-2', 'col-sm-10');
	$rowOrdering	= Helper::cmsRowForm('Ordering', $inputOrdering, 'col-sm-2', 'col-sm-10');
	$rowAvatar		= Helper::cmsRowForm('Avatar', $inputAvatar, 'col-sm-2', 'col-sm-10');
 ?>
<div class="box box-info">
  <div class="box-body">
   <div class="row">
   	 <div class="col-md-6 col-md-offset-3">
      <form class="form-horizontal" id="myForm" action="" method="POST" enctype="multipart/form-data">
        <?php echo $rowUserName.$rowEmail.$rowFullname.$rowPassword.$rowStatus.$rowGroup.$rowOrdering.$rowAvatar.$rowAvatarOld.$inputHidden.$inputIDHiden.$inputPictureHidden; ?>
      </form> 
    </div>
   </div>
  </div>
</div>