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
	$title 	                  = (!empty($this->arrParam['form']['title'])) ? $this->arrParam['form']['title'] : null;
	$description              = (!empty($this->arrParam['form']['description'])) ? $this->arrParam['form']['description'] : null;
	$content                  = (!empty($this->arrParam['form']['content'])) ? $this->arrParam['form']['content'] : null;
	 
	$status		              = (isset($this->arrParam['form']['status'])) ? $this->arrParam['form']['status'] : null;
	$category_orginal      	  = (isset($this->arrParam['form']['category_orginal'])) ? $this->arrParam['form']['category_orginal'] : null;
	$ordering	              = (!empty($this->arrParam['form']['ordering'])) ? $this->arrParam['form']['ordering'] : null;
	$id	                      = (!empty($this->arrParam['form']['id'])) ? $this->arrParam['form']['id'] : null;
	$keyword	              = (!empty($this->arrParam['form']['keyword'])) ? $this->arrParam['form']['keyword'] : null;
	$publish_time	          = (!empty($this->arrParam['form']['publish_time'])) ? $this->arrParam['form']['publish_time'] : null;
	$author	         		  = (!empty($this->arrParam['form']['author'])) ? $this->arrParam['form']['author'] : null;
	$authorValue			  = !empty($author) ? array_values($author) : null;
	$thumbnail_url 			  = (!empty($this->arrParam['form']['thumbnail_url'])) ? $this->arrParam['form']['thumbnail_url'] : 'no-image.jpg';
	//Input
	$inputTitle 		= Helper::cmsInput('text', 'form[title]', 'title', $title, array('class' => 'form-control'));
	$inputDescription 	= Helper::cmsTextarea('form[description]', 'description', $description, array('class' => 'form-control'));
	$inputContent		= Helper::cmsTextarea('form[content]', 'content', $content, array('class' => 'form-control ckeditor'), array('style' => 'width:595px'));
	$inputThumbnail		= Helper::cmsInput('file', 'thumbnail', 'thumbnail', null, array('class' => 'form-control'));
	$inputKeyword 		= Helper::cmsInput('hidden', 'form[keyword]', 'keyword', $keyword, array('class' => 'form-control')).'<ul id="tagsKeyword"></ul>';
	$inputDatePublish	= Helper::cmsInput('text', 'form[publish_time]', 'publish_time', $publish_time, array('class' => 'form-control'));
	$selectAuthor		= Helper::cmsSelectbox('form[author][]', 'js-multiple-author form-control', $this->listAuthor, 'default', null, null, 'multiple');
	
	$selectCategory 	= Helper::cmsSelectbox('form[category_orginal]', 'form-control', $this->slbCategory, $category_orginal);
	$inputOrdering 	 	= Helper::cmsInput('text', 'form[ordering]', 'ordering', $ordering, array('class' => 'form-control'));
	
	$inputHidden		= Helper::cmsInput('hidden', 'form[token]', 'token', time());
	$inputIDHiden 		= '';
	$inputPictureHidden = '';
	$imgThumbnailOld	= '';
	$rowThumnailOld 	= '';
	$selectStatus 		= '';
	if(!empty($this->arrParam['id'])){
		$inputIDHiden		= Helper::cmsInput('hidden', 'form[id]', 'id', $id);
		$inputPictureHidden	= Helper::cmsInput('hidden', 'form[thumbnail_hidden]', 'thumbnail_hidden', $thumbnail_url);
		$imgThumbnailOld	= '<img src="'.UPLOAD_URL.'thumbnail'.DS.'150x150-'.$thumbnail_url.'" style="width: 150px"/>'; 
		$rowThumnailOld   	= Helper::cmsRowForm(null, $imgThumbnailOld, 'col-sm-2', 'col-sm-10');
		$selectStatus		= Helper::cmsSelectbox('form[status]', 'form-control', array('1'=> 'Publish','0'=> 'Save', '2' => 'Delete'), $status);
	}

	//RowForm
	$rowTitle	    = Helper::cmsRowForm('Title', $inputTitle, 'col-sm-1', 'col-sm-11');
	$rowDescription = Helper::cmsRowForm('Description', $inputDescription, 'col-sm-1', 'col-sm-11');
	$rowContent	    = Helper::cmsRowFormContent('Content', $inputContent, 'col-sm-1', 'col-sm-11', array('Thumbnail' => $inputThumbnail.$rowThumnailOld, 'Category' => $selectCategory, 'Keyword' => $inputKeyword, 'Author' => $selectAuthor, 'Publish' => $inputDatePublish, 'Status' => $selectStatus, 'Ordering' => $inputOrdering));

	//LINK AJAX KEYWORD
	$linkAjaxKeyword = URL::createLink('admin', 'article', 'ajaxKeyword');
 ?>
<div class="box box-info">
  <div class="box-body">
   <div class="row">
   	 <div class="col-md-12">
      <form class="form-horizontal" id="myForm" action="" method="POST" enctype="multipart/form-data">
        <?php echo $rowTitle.$rowDescription.$rowContent.$inputHidden.$inputIDHiden; ?>
      </form> 
    </div>
   </div>
  </div>
</div>
<script>
	//CKEDITOR
	CKEDITOR.replace( 'content', {
		toolbarGroups: [
			{"name":"basicstyles","groups":["basicstyles", "cleanup"]},
			{"name":"paragraph","groups":["list","indent","blocks","align","bidi","paragraph"]},
			{"name":"insert","groups":["insert"]},
			{"name":"styles","groups":["styles"]},
			{"name":"colors","groups":["colors"]},
		],
		removeButtons: 'Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,BidiLtr,BidiRtl,Language,Styles,Font,Smiley,CreateDiv,Checkbox,Scayt,NewPage,About,CreatePlaceholder,Flash,Smiley,Iframe,HorizontalRule,SpecialChar,PageBreak',
		height: '600px',
	} );

	$(document).ready(function() {
		//KEYWORD
		var sampleTags = <?php echo json_encode($this->listKeyWord) ?>;
		$('#tagsKeyword').tagit({
			availableTags: sampleTags,
			singleField: true,
			removeConfirmation: true,
			allowSpaces: true,
			singleFieldNode: $('#keyword'),
		});
		//AUTHOR
		$(document).ready(function() {
		    $('.js-multiple-author').select2();
		    $('.js-multiple-author').val(<?php echo json_encode($authorValue) ?>).change();
		});

	    //DATEPICKER
	    $('#publish_time').datepicker({
	    	format: 'yyyy-mm-dd'
	    });
	});
</script>