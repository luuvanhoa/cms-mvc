<?php
class URL{
	
	public static function createLink($module, $controller, $action, $params = null, $linkRouter = null){
		if($linkRouter != null){
			return ROOT_URL.$linkRouter;
		}
		$linkParams = '';
		if(!empty($params)){
			foreach ($params as $key => $value){
				$linkParams .= "&$key=$value";
			}
		}
		$url = ROOT_URL.'index.php?module='.$module.'&controller='.$controller.'&action='.$action . $linkParams;
		return $url;
	} 
	
	public static function redirect($module, $controller, $action, $params = null, $linkRouter = null){
		$link	= self::createLink($module, $controller, $action, $params, $linkRouter);
		header('location: ' . $link);
		exit();
	}
	
	public static function checkRefreshPage($value, $module, $controller, $action, $params = null){
		if(Session::get('token') == $value){
			Session::delete('token');
			URL::redirect($module, $controller, $action, $params);
		}else{
			Session::set('token', $value);
		}
	}

	public static function filterURL($url){
		$url = URL::removeCircumflex($url);
		$url = URL::replaceSpace($url);
		return $url;
	}

	private static function replaceSpace($str){
		$str = trim($str);
		$str = str_replace(' ', '-', $str);
		$str = preg_replace("#(-)+#", '-' , $str);
		return $str;
	}

	private static function removeCircumflex($value){
		/*a à ả ã á ạ ă ằ ẳ ẵ ắ ặ â ầ ẩ ẫ ấ ậ b c d đ e è ẻ ẽ é ẹ ê ề ể ễ ế ệ
		 f g h i ì ỉ ĩ í ị j k l m n o ò ỏ õ ó ọ ô ồ ổ ỗ ố ộ ơ ờ ở ỡ ớ ợ
		p q r s t u ù ủ ũ ú ụ ư ừ ử ữ ứ ự v w x y ỳ ỷ ỹ ý ỵ z*/
		$value		= strtolower($value);
		
		$characterA	= '#(a|à|ả|ã|á|ạ|ă|ằ|ẳ|ẵ|ắ|ặ|â|ầ|ẩ|ẫ|ấ|ậ)#imsU';
		$replaceA	= 'a';
		$value = preg_replace($characterA, $replaceA, $value);
		
		$characterD	= '#(đ|Đ)#imsU';
		$replaceD	= 'd';
		$value = preg_replace($characterD, $replaceD, $value);
		
		$characterE	= '#(è|ẻ|ẽ|é|ẹ|ê|ề|ể|ễ|ế|ệ)#imsU';
		$replaceE	= 'e';
		$value = preg_replace($characterE, $replaceE, $value);
		
		$characterI	= '#(ì|ỉ|ĩ|í|ị)#imsU';
		$replaceI	= 'i';
		$value = preg_replace($characterI, $replaceI, $value);
		
		$charaterO = '#(ò|ỏ|õ|ó|ọ|ô|ồ|ổ|ỗ|ố|ộ|ơ|ờ|ở|ỡ|ớ|ợ)#imsU';
		$replaceCharaterO = 'o';
		$value = preg_replace($charaterO,$replaceCharaterO,$value);
		
		$charaterU = '#(ù|ủ|ũ|ú|ụ|ư|ừ|ử|ữ|ứ|ự)#imsU';
		$replaceCharaterU = 'u';
		$value = preg_replace($charaterU,$replaceCharaterU,$value);
		
		$charaterY = '#(ỳ|ỷ|ỹ|ý)#imsU';
		$replaceCharaterY = 'y';
		$value = preg_replace($charaterY,$replaceCharaterY,$value);
		
		$charaterSpecial = '#(,|$)#imsU';
		$replaceSpecial = '';
		$value = preg_replace($charaterSpecial,$replaceSpecial,$value);
		
		$charaterSpecial1 = '#(\.)#imsU';
		$replaceSpecial1 = '_';
		$value = preg_replace($charaterSpecial1,$replaceSpecial1,$value);
		
		
		return $value;
		
	}
}