<?php 
  $email    = $this->infoItem['email'];
  $fullname = $this->infoItem['fullname'];
  $id       = $this->infoItem['id']; 
  $imgAvatar= !empty($this->infoItem['avatar']) ? $this->infoItem['avatar'] : 'no-avatar.png';

  $linkSave = URL::createLink('admin', 'index', 'profile', array('type' => 'save'));
  $btnSave  = Helper::cmsButton('Save', $linkSave, 'fa fa-save');

  $linkSaveClose  = URL::createLink('admin', 'index', 'profile', array('type' => 'save-close'));
  $btnSaveClose   = Helper::cmsButton('Save & Close', $linkSaveClose, 'fa fa-save');

  $linkCancel = URL::createLink('admin', 'index', 'index');
  $btnCancel  = Helper::cmsButton('Cancel', $linkCancel, 'fa fa-arrow-circle-left');

  // MESSAGE
  $message  = Session::get('message');
  Session::delete('message');
  $strMessage = Helper::cmsMessage($message);
?>

<div class="row">
  <div class="text-center">
    <?php echo $btnSave.$btnSaveClose.$btnCancel ?>
  </div>
   <!-- ALERTT ERROR-->
  <?php 
      if(!empty($this->errors)) echo $this->errors;
      if(!empty($strMessage)) echo $strMessage;
   ?>
  <!-- BUTTON  -->
</div>
<div class="box box-info">
  <div class="box-body">
    <div class="col-md-6 col-md-offset-3">
      <form class="form-horizontal" id="myForm" action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label class="control-label col-sm-2" for="email">Email:</label>
          <div class="col-sm-10">
            <input type="email" name="form[email]" class="form-control" id="email" value="<?php echo $email?>">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="fullname">Fullname</label>
          <div class="col-sm-10">
            <input type="text" name="form[fullname]" class="form-control" id="fullname" value="<?php echo $fullname ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="ID">ID</label>
          <div class="col-sm-10">
            <input type="text" name="form[id]" class="form-control" id="ID" value="<?php echo $id ?>" readonly>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="Avatar">Avatar</label>
          <div class="col-sm-10">
            <input type="file" name="avatar" class="form-control" id="avatar">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="ID"></label>
          <div class="col-sm-10">
            <img src="<?php echo UPLOAD_URL.'avatar'.DS.$imgAvatar?>" alt="" width="150px">
          </div>
        </div>
        <input type="hidden" name="form[avatar_hidden]" value="<?php echo $imgAvatar ?>">
        <input type="hidden" name="form[token]" value="<?php echo time() ?>">
      </form> 
    </div>
  </div>
</div>
