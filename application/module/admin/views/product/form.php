<?php include_once MODULE_PATH.$this->arrParam['module'].DS.'views'.DS.'toolbar.php'?>
<?php 
	// MESSAGE
	$message  = Session::get('message');
	Session::delete('message');
	$strMessage = Helper::cmsMessage($message);
	if(!empty($strMessage)) echo $strMessage;
	// ALERT
	if(!empty($this->errors)) echo $this->errors;
	$strListAttr = '';
	foreach($this->listAttr as $key => $value) {
	    $strListAttr .= $key .',';
	}
	$strListAttr = substr($strListAttr, 0, -1);
 ?>
<?php 
	//Value
	$name 	        = (!empty($this->arrParam['form']['name'])) ? $this->arrParam['form']['name'] : null;
	$slug 	        = (!empty($this->arrParam['form']['slug'])) ? $this->arrParam['form']['slug'] : null;
	$keyword	    = (!empty($this->arrParam['form']['keyword'])) ? $this->arrParam['form']['keyword'] : null;
	$discount_price	= (!empty($this->arrParam['form']['discount_price'])) ? $this->arrParam['form']['discount_price'] : null;
	$price 		    = (!empty($this->arrParam['form']['price'])) ? $this->arrParam['form']['price'] : null;
	$description 	= (!empty($this->arrParam['form']['description'])) ? $this->arrParam['form']['description'] : null;
	$content 	    = (!empty($this->arrParam['form']['content'])) ? $this->arrParam['form']['content'] : null;
	$image 	        = (!empty($this->arrParam['form']['image'])) ? $this->arrParam['form']['image'] : 'no-image.jpg';
	$status		    = (isset($this->arrParam['form']['status'])) ? $this->arrParam['form']['status'] : null;
	$category_product_id	= (isset($this->arrParam['form']['category_product_id'])) ? $this->arrParam['form']['category_product_id'] : null;
	$ordering	= (!empty($this->arrParam['form']['ordering'])) ? $this->arrParam['form']['ordering'] : null;
	$id	        = (!empty($this->arrParam['form']['id'])) ? $this->arrParam['form']['id'] : null;
	//Input
	$inputName 		    = Helper::cmsInput('text', 'form[name]', 'name', $name, array('class' => 'form-control'));
	$inputSlug 		    = Helper::cmsInput('text', 'form[slug]', 'slug', $slug, array('class' => 'form-control'));
	$inputKeyword 		= Helper::cmsInput('hidden', 'form[keyword]', 'keyword', $keyword, array('class' => 'form-control')).'<ul id="tagsKeyword"></ul>';
	$inputPrice 		= Helper::cmsInput('number', 'form[price]', 'price', $price, array('class' => 'form-control'));
	$inputDiscountPrice = Helper::cmsInput('number', 'form[discount_price]', 'discount_price', $discount_price, array('class' => 'form-control'));
	$inputDescription 	= Helper::cmsTextarea('form[description]', 'description', $description, array('class' => 'form-control'));
	$inputContent		= Helper::cmsTextarea('form[content]', 'content', $content, array('class' => 'form-control ckeditor'));
	$selectStatus		= Helper::cmsSelectbox('form[status]', 'form-control', array('default' => '-- Select Status --', '1'=> 'Active', '0'=> 'Inactive'), $status);
	$selectCategory 	= Helper::cmsSelectbox('form[category_product_id]', 'form-control', $this->slbCategory, $category_product_id);
	$inputOrdering 	 	= Helper::cmsInput('text', 'form[ordering]', 'ordering', $ordering, array('class' => 'form-control'));
	$inputImage		    = Helper::cmsInput('file', 'image', 'image', null, array('class' => 'form-control'));
	$inputHidden		= Helper::cmsInput('hidden', 'form[token]', 'token', time());

	$selectAttr 	    = Helper::cmsSelectbox('form[attr][name][]', 'form-control', $this->listAttr, null);
	$inputAttr 	 	    = Helper::cmsInput('text', 'form[attr][value][]', '', '', array('class' => 'form-control'));
	$buttonAdd	        = Helper::cmsButton('', '', 'fa fa-plus', 'no', array('type' => 'add-attr'));
	$buttonRemove	    = Helper::cmsButton('', '', 'fa fa-trash', 'no', array('type' => 'remove-attr'));
	$divAttribute       = Helper::cmsRowAttributeForm($selectAttr, $inputAttr, $buttonRemove, $buttonAdd, 'col-sm-6', 'col-sm-5', 'col-sm-1');
	$inputIDHiden 		= '';
	$inputPictureHidden = '';
	$imgAvatarOld		= '';
	$rowAvatarOld 		= '';
	if(!empty($this->arrParam['id'])){
		$inputIDHiden		= Helper::cmsInput('hidden', 'form[id]', 'id', $id);
		$inputPictureHidden	= Helper::cmsInput('hidden', 'form[image_hidden]', 'image_hidden', $image);
		$imgAvatarOld	= '<img src="'.UPLOAD_URL.'product'.DS.'150x150-'.$image.'" style="width: 150px"/>'; 
		$rowAvatarOld   = Helper::cmsRowForm(null, $imgAvatarOld, 'col-sm-2', 'col-sm-10');
	}
	//RowForm
	$rowName   	    = Helper::cmsRowForm('Name', $inputName, 'col-sm-2', 'col-sm-10');
	$rowSlug   	    = Helper::cmsRowForm('Slug', $inputSlug, 'col-sm-2', 'col-sm-10');
	$rowKeyword   	= Helper::cmsRowForm('Keyword', $inputKeyword, 'col-sm-2', 'col-sm-10');
	$rowPrice 		= Helper::cmsRowForm('Price', $inputPrice, 'col-sm-2', 'col-sm-10');
	$rowDiscountPrice = Helper::cmsRowForm('Discount Price', $inputDiscountPrice, 'col-sm-2', 'col-sm-10');
	$rowDescription	= Helper::cmsRowForm('Description', $inputDescription, 'col-sm-2', 'col-sm-10');
	$rowContent 	= Helper::cmsRowForm('Content', $inputContent, 'col-sm-2', 'col-sm-10');
	$rowStatus 		= Helper::cmsRowForm('Status', $selectStatus, 'col-sm-2', 'col-sm-10');
	$rowCategory	= Helper::cmsRowForm('Category Product', $selectCategory, 'col-sm-2', 'col-sm-10');
	$rowOrdering	= Helper::cmsRowForm('Ordering', $inputOrdering, 'col-sm-2', 'col-sm-10');
	$rowImage		= Helper::cmsRowForm('Image', $inputImage, 'col-sm-2', 'col-sm-10');
	$rowAttribute   = Helper::cmsRowForm('Attributes', $divAttribute, 'col-sm-2', 'col-sm-10');
	//LINK AJAX KEYWORD
	$linkAjaxKeyword = URL::createLink('admin', 'product', 'ajaxKeyword');
 ?>
<div class="box box-info">
  <div class="box-body">
   <div class="row">
   	 <div class="col-md-12">
      <form class="form-horizontal" id="myForm" action="" method="POST" enctype="multipart/form-data">
        <?php echo $rowCategory.$rowName.$rowSlug.$rowPrice.$rowDiscountPrice.$rowImage.$rowAvatarOld.$rowKeyword.$rowAttribute.$rowDescription.$rowContent.$rowStatus.$rowOrdering.$inputHidden.$inputIDHiden.$inputPictureHidden; ?>
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
    	height: '300px',
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
		//ATTRUBUTES
		$('.btn-add-attr').click(function(){
			var attributes = '<div class="row row-attribute" style="margin-bottom: 10px">'+
	    			          '<div class="col-sm-6">'+
	    			            '<select name="form[attr][name][]" class="form-control"  ><option value = "1">Bộ nhớ</option><option value = "2">RAM</option></select>'+
	    			          '</div>'+
	    			          '<div class="col-sm-5">'+
	    			            '<input type="text" name="form[attr][value][]" id="" value="" class="form-control">'+
	    			          '</div>'+
	                          '<div class="col-sm-1">'+
	                          '<button type="button" class="btn btn-danger btn-remove-attr">'+
	                          		'<i class="fa fa-trash"></i></button></i>'+
	                          '</button>'+
	                          '</div></div>';
			$('.list-attribute').append(attributes);
		});

		$('.list-attribute').on('click', '.btn-remove-attr', function(){
			$(this).parent().parent().remove();
		});
	});
</script>