<?php
class Helper{
	
	// Create Button
	public static function cmsButton($name, $link, $icon, $showItem = 'no', $option = null){
		if($option['type'] == 'add'){
			$xhtml = '<a data-show-item="'.$showItem.'"  class="btn btn-app" href="#" onclick="javascript:addNew(\''.$link.'\')">';
		}else if($option['type'] =='delete'){
			$xhtml = '<a data-show-item="'.$showItem.'"  class="btn btn-app" href="#" onclick="javascript:if(confirm(\'Are you sure you want to delete?\')){submitForm(\''.$link.'\')}">';
		}
		else if($option['type'] == 'view'){
		    $xhtml = '<a data-show-item="'.$showItem.'"  class="btn btn-success" href="'.$link.'">';
		}
		else if($option['type'] == 'add-attr'){
		    $xhtml = '<button type="button" class="btn btn-success btn-add-attr">Add</button>';
		    return $xhtml;
		}
		else if($option['type'] == 'remove-attr'){
		    $xhtml = '<button type="button" class="btn btn-danger btn-remove-attr"><i class="'.$icon.'"></i></button>';
		    return $xhtml;
		}
		else {
		    $xhtml = '<a data-show-item="'.$showItem.'"  class="btn btn-app" href="#" onclick="javascript:submitForm(\''.$link.'\')">';
		}
		$xhtml .= '<i class="'.$icon.'"></i>'.$name.'</a>';
		return $xhtml;
	}
	
	// Create Icon Status
	public static function cmsStatus($statusValue, $link, $id){
		$xhtml = '<i class="fa fa-lg fa-trash-o"></i>';
		if($statusValue == 0 || $statusValue == 1){
			$icon  = ($statusValue == 0) ? 'fa-square-o': 'fa-check-square-o';
			$xhtml = '<i id="status-'.$id.'" class="fa fa-lg '.$icon.'" onclick="javascript:ajaxStatus(\''.$link.'\')"></i>';
		}
		return $xhtml;
	}

	// Create Icon GroupACP
	public static function cmsGroupACP($statusValue, $link, $id){
		$icon  = ($statusValue == 0) ? 'fa-square-o': 'fa-check-square-o';
		$xhtml = '<i id="groupACP-'.$id.'" class="fa fa-lg '.$icon.'" onclick="javascript:ajaxGroupACP(\''.$link.'\')"></i>';
		return $xhtml;
	}
	
	// Create Message Sucess
	public static function cmsMessage($message){
		$xhtml = '';
		if(!empty($message)){
			$class = ($message['class'] == 'success') ? 'success' : 'danger';
			$xhtml .= '<div class="alert alert-'.$class.' alert-dismissable text-center">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                '.$message['content'].'
                        </div>';
		}
		return $xhtml;
	}
	
	// Create Selectbox
	public static function cmsSelectbox($name, $class, $arrValue, $keySelect = 'default', $style = null, $id = null, $multiple = null){
		$id = (!empty($id)) ? " id='$id' " : '';
		$style = (!empty($style)) ? " style='$style' " : '';
		$multiple = (!empty($multiple)) ? " multiple='$multiple' " : '';
		$xhtml = '<select name="'.$name.'" class="'.$class.'" '.$id.$style.$multiple.' >';
		foreach($arrValue as $key => $value){
			if($key == $keySelect && is_numeric($keySelect)){
				$xhtml .= '<option selected="selected" value = "'.$key.'">'.$value.'</option>';
			}else{
				$xhtml .= '<option value = "'.$key.'">'.$value.'</option>';
			}
		}
		$xhtml .= '</select>';
		return $xhtml;
	}

	// Create Input
	public static function cmsInput($type, $name, $id, $value, $option = null){
		$strClass	=	(empty($option['class'])) ? '' : 'class="'.$option['class'].'"';
		$strStyle	=	(empty($option['style'])) ? '' : 'style="'.$option['style'].'"';
		$strReadOnly=	(empty($option['readOnly'])) ? '' : $option['readOnly'];
		$xhtml = '<input type="'.$type.'" name="'.$name.'" id="'.$id.'" value="'.$value.'" '.$strClass.$strStyle.$strReadOnly.'>';
		
		return $xhtml;
	}
	
	// Create Textarea
	public static function cmsTextarea($name, $id, $value, $option = null){
	    $strClass	=	(empty($option['class'])) ? '' : "class='".$option['class']."'";
	    $strStyle	=	(empty($option['style'])) ? '' : "style='".$option['style']."'";
	    $xhtml = "<textarea name='$name' id='$id' $strClass $strStyle>$value</textarea>";
	    
	    return $xhtml;
	}
		
	// Create Row - ADMIN
	public static function cmsRowForm($label, $input, $classLabel, $classInput){
		$xhtml = '  <div class="form-group">
			          <label class="control-label '.$classLabel.'" for="'.$label.'">'.$label.'</label>
			          <div class="'.$classInput.'">
			            '.$input.'
			          </div>
			        </div>';
		return $xhtml;
	}
	
	// Create Row - Attribute
	public static function cmsRowAttributeForm($select, $input,$buttonRemove, $buttonAdd, $classSelect, $classInput, $classButton){
	 	$xhtml = '  <div class="list-attribute">
	                        <div class="row row-attribute" style="margin-bottom: 10px">
	    			          <div class="'.$classSelect.'">
	    			            '.$select.'
	    			          </div>
	    			          <div class="'.$classInput.'">
	    			            '.$input.'
	    			          </div>
	                          <div class="'.$classButton.'">
	                            '.$buttonRemove.'
	                          </div>
	    			        </div>
                    	</div><div class="row" style="margin-left: 0">'.$buttonAdd.'</div>';
	    return $xhtml;
	}

	// Create RowContent - ADMIN
	public static function cmsRowFormContent($label, $input, $classLabel, $classInput, $attributes = array()){
		$xhtml = '  <div class="form-group">
			          <label class="control-label '.$classLabel.'" for="'.$label.'">'.$label.'</label>
			          <div class="'.$classInput.'">
			           		<div class="content-textarea">'.$input.'</div>
			           		<div class="content-attributes">
			           			<ul class="list-group">';
			           				foreach ($attributes as $key => $value) {
			           					if(!empty($value)){
			           						$xhtml .= '<li class="list-group-item item-title">'.$key.'</li>
  												   <li class="list-group-item item-attributes">'.$value.'</li>';
			           					}
			           				}
		$xhtml .='				</ul>
			           		</div>
			          </div>
			        </div>';
		return $xhtml;
	}

	// Format Date
	public static function formatDate($format, $value){
		$result = '';
		if(!empty($value) && $value != '0000-00-00' ){
			$result = date($format, strtotime($value));
		}
		return $result;
	}
	
	// Level Nested
	public static function cmsLevelNested($level, $name) {
	    $line = "";
	    if ($level == 1) {
	        $line = '';
	    }
	    else {
	        for ($i = 0; $i < $level - 1; $i++) {
	            $line .= '|----';
	        }
	    }
	    return $line . $name;
	}
	
	public static function showButtonMove($id, $type = 'up', $valChild, $valParent, $options = null) {
	    $icon = 'fa-arrow-up';
	    if($type != 'up'){
	        $type = 'down';
	        $icon = 'fa-arrow-down';
	    }
	    if($valChild == $valParent)
	        return "<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
	        
	        return sprintf('<button type="button" onclick="javascript:moveNode(\'%s\',\'%s\')" class="btn btn-success btn-move-node"><i class="fa %s"></i></button>',
	            $id, $type, $icon);
	}
	
	public static function formatNumber($number) {
	    return number_format($number,0, ",", ".");
	}
	
	// CREATE SLUG
	public static function removeSpace($value)
	{
	    $value = trim($value);
	    $value = preg_replace('#(\s)+#', ' ', $value);
	    return $value;
	}
	public static function replaceSpace($value)
	{
	    $value = trim($value);
	    $value = str_replace(' ', '-', $value);
	    $value = preg_replace('#(-)+#', '-', $value);
	    return $value;
	}
	
	private static function removeCircumflex($value)
	{
	    /*a à ả ã á ạ ă ằ ẳ ẵ ắ ặ â ầ ẩ ẫ ấ ậ b c d đ e è ẻ ẽ é ẹ ê ề ể ễ ế ệ
	     f g h i ì ỉ ĩ í ị j k l m n o ò ỏ õ ó ọ ô ồ ổ ỗ ố ộ ơ ờ ở ỡ ớ ợ
	     p q r s t u ù ủ ũ ú ụ ư ừ ử ữ ứ ự v w x y ỳ ỷ ỹ ý ỵ z*/
	    $value = mb_strtolower($value);
	    
	    $characterA = '#(a|à|ả|ã|á|ạ|ă|ằ|ẳ|ẵ|ắ|ặ|â|ầ|ẩ|ẫ|ấ|ậ)#imsU';
	    $replaceA = 'a';
	    $value = preg_replace($characterA, $replaceA, $value);
	    
	    $characterD = '#(đ|Đ)#imsU';
	    $replaceD = 'd';
	    $value = preg_replace($characterD, $replaceD, $value);
	    
	    $characterE = '#(è|ẻ|ẽ|é|ẹ|ê|ề|ể|ễ|ế|ệ)#imsU';
	    $replaceE = 'e';
	    $value = preg_replace($characterE, $replaceE, $value);
	    
	    $characterI = '#(ì|ỉ|ĩ|í|ị)#imsU';
	    $replaceI = 'i';
	    $value = preg_replace($characterI, $replaceI, $value);
	    
	    $charaterO = '#(ò|ỏ|õ|ó|ọ|ô|ồ|ổ|ỗ|ố|ộ|ơ|ờ|ở|ỡ|ớ|ợ)#imsU';
	    $replaceCharaterO = 'o';
	    $value = preg_replace($charaterO, $replaceCharaterO, $value);
	    
	    $charaterU = '#(ù|ủ|ũ|ú|ụ|ư|ừ|ử|ữ|ứ|ự)#imsU';
	    $replaceCharaterU = 'u';
	    $value = preg_replace($charaterU, $replaceCharaterU, $value);
	    
	    $charaterY = '#(ỳ|ỷ|ỹ|ý)#imsU';
	    $replaceCharaterY = 'y';
	    $value = preg_replace($charaterY, $replaceCharaterY, $value);
	    
	    $charaterSpecial = '#(,|$|&)#imsU';
	    $replaceSpecial = '';
	    $value = preg_replace($charaterSpecial, $replaceSpecial, $value);
	    
	    
	    return $value;
	    
	}
	
		//Create Slug Ver1
	public static function createSlug($value)
	{
	    $value=self::removeCircumflex($value);
	    $value = self::removeSpace($value);
	    $value = self::replaceSpace($value);
	    $value= preg_replace('/[^a-z0-9-\s]/', '', $value);
	    $value= preg_replace('/([\-]+)/', '-', $value);
	    return strtolower($value);
	}

	//Create Slug Ver2
	static public function slugify($text)
	{
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  // trim
	  $text = trim($text, '-');

	  // remove duplicate -
	  $text = preg_replace('~-+~', '-', $text);

	  // lowercase
	  $text = strtolower($text);

	  if (empty($text)) {
	    return 'n-a';
	  }

	  return $text;
	}
}