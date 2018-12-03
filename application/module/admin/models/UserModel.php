<?php
class UserModel extends Model{
	
	private $_columns = array('id', 'username', 'email', 'fullname', 'password','created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'group_id', 'register_date', 'avatar');
	private $_userInfo;
	
	public function __construct(){
		parent::__construct();
		$this->setTable(TBL_USER);
		
		$userObj 			= Session::get('user');
		$this->_userInfo 	= $userObj['info'];
	}
	
	public function itemInSelectbox($arrParam, $option = null){
		if($option == null){
			$query 	= "SELECT `id`, `name` FROM `" . TBL_GROUP . "`";
			$result = $this->fetchPairs($query);
			$result['default'] = "-- Select Group --";
			ksort($result);
		}
		return $result;
	}
	
	public function listItem($arrParam, $option = null){
		$query[]	= "SELECT `u`.`id`, `u`.`username`, `u`.`email`, `u`.`status`, `u`.`fullname`, `u`.`ordering`, `u`.`created`, `u`.`created_by`, `u`.`modified`, `u`.`modified_by`,`u`.`avatar`,  `g`.`name` AS `group_name`";
		$query[]	= "FROM `$this->table` AS `u` LEFT JOIN `". TBL_GROUP . "` AS `g` ON `u`.`group_id` = `g`.`id`";
		$query[]	= "WHERE `u`.`id` > 0";
		
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
			$query	= "UPDATE `$this->table` SET `status` = $status, `modified` = '$modified', `modified_by` = '$modified_by'  WHERE `id` = '" . $id . "'";
			$this->execute($query);
			$result = array(
								'id'		=> $id, 
								'status'	=> $status, 
								'link'		=> URL::createLink('admin', 'user', 'ajaxStatus', array('id' => $id, 'status' => $status)),
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
				$query		= "UPDATE `$this->table` SET `status` = $status, `modified` = '$modified', `modified_by` = '$modified_by'  WHERE `id` IN ($ids)";
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
				Session::set('message', array('class' => 'error',  'content' => 'Please select the delete element!'));
			}
		}
	}

	public function getNameImage($id){
		$query 	= "SELECT `avatar` FROM `".TBL_USER."` WHERE `id` = $id";
		$result = $this->fetchRow($query);
		return  $result['avatar'];
	}
	
	public function infoItem($arrParam, $option = null){
		if($option == null){
			$query[]	= "SELECT `id`, `username`, `email`, `fullname`,`group_id`, `status`, `ordering`, `avatar`";
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
		
		require_once(LIBRARY_EXT_PATH.'Upload.php');
		$uploadObj = new Upload();
		if($option['task'] == 'add'){
			$arrParam['form']['avatar']			= $uploadObj->uploadFile($arrParam['form']['avatar'], 'avatar', 150, 150);
			$arrParam['form']['created']		= date('Y-m-d', time());
			$arrParam['form']['created_by']		= $userInfo['username'];
			$arrParam['form']['register_date']	= date('Y-m-d H:m:s', time());
			$arrParam['form']['register_id']  	= $_SERVER['REMOTE_ADDR'];
			$arrParam['form']['password']		= md5($arrParam['form']['password']);
			$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->insert($data);
			Session::set('message', array('class' => 'success', 'content' => 'Data saved successfully!'));
			return $this->lastID();
		}
		if($option['task'] == 'edit'){
			if($arrParam['form']['avatar']['name'] == null){
				unset($arrParam['form']['avatar']);
			}else{
				$uploadObj->removeFile('avatar', $arrParam['form']['avatar_hidden']);
				$uploadObj->removeFile('avatar', '150x150-'.$arrParam['form']['avatar_hidden']);
				$arrParam['form']['avatar']	= $uploadObj->uploadFile($arrParam['form']['avatar'], 'avatar', 150, 150);
			}
			// No change Username, Email
			unset($arrParam['form']['username']);
			unset($arrParam['form']['email']);
			
			$arrParam['form']['modified']	= date('Y-m-d', time());
			$arrParam['form']['modified_by']= $userInfo['username'];
			$arrParam['form']['register_date']= date('Y-m-d H:i', time());
			$arrParam['form']['register_id']  = $_SERVER['REMOTE_ADDR'];
			if($arrParam['form']['password'] != null){
				$arrParam['form']['password']	= md5($arrParam['form']['password']);
			}else{
				unset($arrParam['form']['password']);
			}
			$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->update($data, array(array('id', $arrParam['form']['id'])));
			Session::set('message', array('class' => 'success', 'content' => 'Data updated successfully!!'));
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
					$query	= "UPDATE `$this->table` SET `ordering` = $ordering, `modified` = '$modified', `modified_by` = '$modified_by'  WHERE `id` = '" . $id . "'";
					$this->execute($query);
				}
				Session::set('message', array('class' => 'success', 'content' => 'There are ' .$i. ' element is changed ordering!'));
			}
		}
	}
}