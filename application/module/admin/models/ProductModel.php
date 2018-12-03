<?php
class ProductModel extends Model{
	
	private $_columns = array('id','name', 'price', 'discount_price', 'created_at', 'created_by', 'modified_at', 'modified_by', 'status', 'ordering', 'category_product_id', 'image', 'description', 'content');
	private $_userInfo;
	
	public function __construct(){
		parent::__construct();
		$this->setTable(TBL_PRODUCT);
		
		$userObj 			= Session::get('user');
		$this->_userInfo 	= $userObj['info'];
	}
	
	public function itemInSelectbox($arrParam, $option = null){
	    $itemResult = $this->getAllNode();
	    $arrParent = [];
	    $arrParent['default'] = "-- Select Category Product --";
	    if(count($itemResult) > 0)
	    {
	        foreach ($itemResult as $val) {
	            $level = $val['level'];
	            $line = "";
	            if ($level == 1) {
	                $line = '';
	            }
	            else {
	                for ($i = 1; $i < $level; $i++) {
	                    $line .= '|----';
	                }
	            }
	            
	            $arrParent[$val['id']] = $line . $val['name'];
	        }
	        ksort($arrParent);
	    }
	    return $arrParent;
	}
	
	public function getAllNode($option = null){
	    $query[]	= "SELECT *";
	    $query[]	= "FROM `".TBL_CATEGORY_PRODUCT."`";
	    $query[]	= "WHERE `name` <> 'Root'";
	    $query[]	= "ORDER BY `lft` ASC";
	    $query		= implode(" ", $query);
	    $result		= $this->fetchAll($query);
	    return $result;
	}
	
	public function getItem($arrParam, $option = null){
	    if($option['task'] == 'get-keyword'){
	        $result     = array();
	        $query[]    = "SELECT `name`";
	        $query[]    = "FROM `".TBL_KEYWORD_PRODUCT."`";
	        $query[]    = "WHERE `status` =  1";
	        $query      = implode(" ", $query);
	        $data       = $this->fetchAll($query);
	        foreach ($data as $value) {
	            $result[] = $value['name'];
	        }
	    }
	    
	    if($option['task'] == 'get-attr'){
	        $result     = array();
	        $query[]    = "SELECT `id`, `name`";
	        $query[]    = "FROM `".TBL_ATTRIBUTES."`";
	        $query[]    = "WHERE `status` =  1";
	        $query      = implode(" ", $query);
	        $data       = $this->fetchAll($query);
	        foreach ($data as $value) {
	            $result[$value['id']] = $value['name'];
	        }
	    }
	    return $result;
	}
	
	
	public function listItem($arrParam, $option = null){
		$query[]	= "SELECT `p`.`id`, `p`.`name`, `p`.`price`, `p`.`discount_price`, `p`.`status`, `p`.`image`, `p`.`ordering`, `p`.`created_at`, `p`.`created_by`, `p`.`modified_at`, `p`.`modified_by`,  `c`.`name` AS `category_name`";
		$query[]	= "FROM `$this->table` AS `p` LEFT JOIN `". TBL_CATEGORY_PRODUCT . "` AS `c` ON `p`.`category_product_id` = `c`.`id`";
		$query[]	= "WHERE `p`.`id` > 0";
		
		$query		= implode(" ", $query);
		$result		= $this->fetchAll($query);
		return $result;
	}
	
	public function changeStatus($arrParam, $option = null){
		if($option['task'] == 'change-ajax-status'){
			$status 		= ($arrParam['status'] == 0) ? 1 : 0;
			$modified_by	= $this->_userInfo['username'];
			$modified		= date('Y-m-d', time());
			$id				= $arrParam['id'];
			$query	= "UPDATE `$this->table` SET `status` = $status, `modified_at` = '$modified', `modified_by` = '$modified_by'  WHERE `id` = '" . $id . "'";
			$this->execute($query);
			$result = array(
								'id'		=> $id, 
								'status'	=> $status, 
								'link'		=> URL::createLink('admin', 'product', 'ajaxStatus', array('id' => $id, 'status' => $status)),
								'alert'		=> Helper::cmsMessage(array('class' => 'success', 'content' => 'You have successfully changed the status!')),
						); 
			return $result;
		}
	
		if($option['task'] == 'change-status'){
			$status 		= $arrParam['type'];
			$modified_by	= $this->_userInfo['username'];
			$modified		= date('Y-m-d', time());
			if(!empty($arrParam['cid'])){
				$ids		= $this->createWhereDeleteSQL($arrParam['cid']);
				$query		= "UPDATE `$this->table` SET `status` = $status, `modified_at` = '$modified', `modified_by` = '$modified_by'  WHERE `id` IN ($ids)";
				$result = $this->execute($query);
				Session::set('message', array('class' => 'success', 'content' => 'There are ' . $result->rowCount() . ' elements that are changed status!'));
			}else{
				Session::set('message', array('class' => 'error', 'content' => 'Please select the element to change the status!'));
			}
		}
	}
	
	public function deleteItem($arrParam, $option = null){
		if($option == null){
			if(!empty($arrParam['cid'])){
				$ids		= $this->createWhereDeleteSQL($arrParam['cid']);
				$query		= "DELETE FROM `$this->table` WHERE `id` IN ($ids)";
				$result = $this->execute($query);
				Session::set('message', array('class' => 'success', 'content' => 'There are ' . $result->rowCount(). ' elements deleted'));
				//DELETE IMAGE
                require_once(LIBRARY_EXT_PATH.'Upload.php');
                $uploadObj = new Upload();
				foreach ($arrParam['cid'] as $id) {
					$avatarName = $this->getNameImage($id);
					$uploadObj->removeFile('avatar', $avatarName);
					$uploadObj->removeFile('avatar', '150x150-'.$avatarName);
				}
			}else{
				Session::set('message', array('class' => 'error', 'content' => 'Please select the delete element!'));
			}
		}
	}

	public function getNameImage($id){
		$query 	= "SELECT `image` FROM `".TBL_PRODUCT."` WHERE `id` = $id";
		$result = $this->fetchRow($query);
		return  $result['image'];
	}
	
	public function infoItem($arrParam, $option = null){
		if($option == null){
			$query[]	= "SELECT *";
			$query[]	= "FROM `$this->table`";
			$query[]	= "WHERE `id` = '" . $arrParam['id'] . "'";
			$query		= implode(" ", $query);
			$result		= $this->fetchRow($query);
			return $result;
		}
	}
	
	public function saveItem($arrParam, $option = null){
		$userObj	= Session::get('user');
		$userInfo	= $userObj['info'];
		$arrParam['form']['discount_price']		= empty($arrParam['form']['discount_price']) ? 0 : $arrParam['form']['discount_price'];
		$arrParam['form']['slug']               = !empty($arrParam['form']['slug']) ? Helper::createSlug($arrParam['form']['slug']) : Helper::createSlug($arrParam['form']['name']);
		require_once(LIBRARY_EXT_PATH.'Upload.php');
		$uploadObj = new Upload();
		if($option['task'] == 'add'){
			$arrParam['form']['image']			= $uploadObj->uploadFile($arrParam['form']['image'], 'product', 150, 150);
			$arrParam['form']['created_at']		= date('Y-m-d', time());
			$arrParam['form']['created_by']		= $userInfo['username'];

			$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$product_id = $this->insert($data);
			//INSERT OBJECT_ARTICLE
			//TYPE = 1
			if(!empty($arrParam['form']['keyword'])){
				$arrKeyword = explode(",", $arrParam['form']['keyword']);
				foreach ($arrKeyword as $keyword) {
				    $idKeyword     	= $this->getIDTag($keyword)['id'];
				    $creation_time 	= date('Y:m:d H:m:s', time());
				    $dataObject 	= array('product_id' => $product_id, 'object_id' => $idKeyword, 'object_type' => 1, 'status' => 1, 'creation_time' => $creation_time);
				    $this->insert($dataObject, 'single', TBL_OBJECT_PRODUCT);
				}
			}

			//TYPE = 2
			if(!empty($arrParam['form']['attr'])){
				$arrAttr = array();
				$i = 0;
				foreach ($arrParam['form']['attr']['name'] as $name) {
					$arrAttr[$name] = $arrParam['form']['attr']['value'][$i];
					$i++;
				}
				foreach ($arrAttr as $name => $value) {
					$object_id 		= $name;
					$object_value   = $value; 
					$creation_time 	= date('Y:m:d H:m:s', time());
					$dataObject 	= array('product_id' => $product_id, 'object_id' => $object_id, 'object_value' => $object_value,'object_type' => 2, 'status' => 1, 'creation_time' => $creation_time);
					$this->insert($dataObject, 'single', TBL_OBJECT_PRODUCT);
				}
			}

			Session::set('message', array('class' => 'success', 'content' => 'Data saved successfully!'));
			return $product_id;
		}
		if($option['task'] == 'edit'){
			if($arrParam['form']['image']['name'] == null){
				unset($arrParam['form']['image']);
			}else{
				$uploadObj->removeFile('image', $arrParam['form']['image_hidden']);
				$uploadObj->removeFile('image', '150x150-'.$arrParam['form']['image_hidden']);
				$arrParam['form']['image']	= $uploadObj->uploadFile($arrParam['form']['image'], 'product', 150, 150);
			}
		
			$arrParam['form']['modified_at']	= date('Y-m-d', time());
			$arrParam['form']['modified_by']	= $userInfo['username'];
			$arrParam['form']['slug']         	= !empty($arrParam['form']['slug']) ? Helper::createSlug($arrParam['form']['slug']) : Helper::createSlug($arrParam['form']['name']);
			$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->update($data, array(array('id', $arrParam['form']['id'])));
			//UPDATE OBEJCT_PRODUCT
			$queryDelete = "DELETE FROM `".TBL_OBJECT_PRODUCT."` WHERE `product_id` = ".$arrParam['form']['id'];
            $this->execute($queryDelete);
			//TYPE = 1
			if(!empty($arrParam['form']['keyword'])){
				$arrKeyword = explode(",", $arrParam['form']['keyword']);
				foreach ($arrKeyword as $keyword) {
				    $idKeyword     = $this->getIDTag($keyword)['id'];
				    $creation_time = date('Y:m:d H:m:s', time());
				    $dataObject = array('product_id' => $arrParam['form']['id'], 'object_id' => $idKeyword, 'object_type' => 1, 'status' => 1, 'creation_time' => $creation_time);
				    $this->insert($dataObject, 'single', TBL_OBJECT_PRODUCT);
				}
			}

			//TYPE = 2
			if(!empty($arrParam['form']['attr'])){
				$arrAttr = array();
				$i = 0;
				foreach ($arrParam['form']['attr']['name'] as $name) {
					$arrAttr[$name] = $arrParam['form']['attr']['value'][$i];
					$i++;
				}
				foreach ($arrAttr as $name => $value) {
					$object_id 		= $name;
					$object_value   = $value; 
					$creation_time 	= date('Y:m:d H:m:s', time());
					$dataObject 	= array('product_id' => $arrParam['form']['id'], 'object_id' => $object_id, 'object_value' => $object_value,'object_type' => 2, 'status' => 1, 'creation_time' => $creation_time);
					$this->insert($dataObject, 'single', TBL_OBJECT_PRODUCT);
				}
			}
			Session::set('message', array('class' => 'success', 'content' => 'Data updated successfully!'));
			return $arrParam['form']['id'];
		}
	}
	
	public function ordering($arrParam, $option = null){
		if($option == null){
			if(!empty($arrParam['ordering'])){
				$i = 0;
				$modified_by	= $this->_userInfo['username'];
				$modified		= date('Y-m-d', time());
				foreach($arrParam['ordering'] as $id => $ordering){
					$i++;
					$query	= "UPDATE `$this->table` SET `ordering` = $ordering, `modified_at` = '$modified', `modified_by` = '$modified_by'  WHERE `id` = '" . $id . "'";
					$this->execute($query);
				}
				Session::set('message', array('class' => 'success', 'content' => 'There are ' .$i. ' element is changed ordering!'));
			}
		}
	}
	
	protected function getIDTag($tag_name){
	    $query = "SELECT `id` FROM `".TBL_KEYWORD_PRODUCT."` WHERE `name` = '$tag_name' LIMIT 0,1";
	    $result = $this->fetchRow($query);
	    return $result;
	}
}