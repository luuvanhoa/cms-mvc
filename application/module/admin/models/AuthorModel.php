<?php
class AuthorModel extends Model{
	
	private $_columns = array('id', 'name','creation_time', 'modified_time',  'status', 'ordering', 'share_url', 'avatar',);
	private $_userInfo;
	
	public function __construct(){
		parent::__construct();
		$this->setTable(TBL_AUTHOR);
	}
	
	public function listItem($arrParam, $option = null){
		$query[]	= "SELECT `id`, `name`, `creation_time`, `modified_time`, `status`, `ordering`, `share_url`, `avatar`";
		$query[]	= "FROM `$this->table`";
		$query[]	= "WHERE `id` > 0";
		$query		= implode(" ", $query);
		$result		= $this->fetchAll($query);
		return $result;
	}
	
	public function changeStatus($arrParam, $option = null){
		if($option['task'] == 'change-ajax-status'){
			$status 		= ($arrParam['status'] == 0) ? 1 : 0;
			$modified_time	= date('Y-m-d H:m:s', time());
			$id				= $arrParam['id'];
			$query			= "UPDATE `$this->table` SET `status` = $status, `modified_time` = '$modified_time'  WHERE `id` = '" . $id . "'";
			$this->execute($query);
			$result = array(
								'id'		=> $id, 
								'status'	=> $status, 
								'link'		=> URL::createLink('admin', 'author', 'ajaxStatus', array('id' => $id, 'status' => $status)),
								'alert'		=> Helper::cmsMessage(array('class' => 'success', 'content' => 'You have successfully changed the status!')),
						); 
			return $result;
		}
	
		if($option['task'] == 'change-status'){
			$status 		= $arrParam['type'];
			$modified_time		= date('Y-m-d H:m:s', time());
			if(!empty($arrParam['cid'])){
				$ids		= $this->createWhereDeleteSQL($arrParam['cid']);
				$query		= "UPDATE `$this->table` SET `status` = $status, `modified_time` = '$modified_time' WHERE `id` IN ($ids)";
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
		$query 	= "SELECT `avatar` FROM `".TBL_AUTHOR."` WHERE `id` = $id";
		$result = $this->fetchRow($query);
		return  $result['avatar'];
	}
	
	public function infoItem($arrParam, $option = null){
		if($option == null){
			$query[]	= "SELECT `id`, `name`, `creation_time`, `modified_time`, `status`, `ordering`, `avatar`";
			$query[]	= "FROM `$this->table`";
			$query[]	= "WHERE `id` = '" . $arrParam['id'] . "'";
			$query		= implode(" ", $query);
			$result		= $this->fetchRow($query);
			return $result;
		}
	}
	
	public function saveItem($arrParam, $option = null){	
		require_once(LIBRARY_EXT_PATH.'Upload.php');
		$uploadObj = new Upload();
		if($option['task'] == 'add'){
			$arrParam['form']['avatar']			= $uploadObj->uploadFile($arrParam['form']['avatar'], 'author', 150, 150);
			$arrParam['form']['creation_time']	= date('Y-m-d H:m:s', time());
			$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->insert($data);
			Session::set('message', array('class' => 'success', 'content' => 'Data saved successfully!'));
			return $this->lastID();
		}
		if($option['task'] == 'edit'){
			if($arrParam['form']['avatar']['name'] == null){
				unset($arrParam['form']['avatar']);
			}else{
				$uploadObj->removeFile('author', $arrParam['form']['avatar_hidden']);
				$uploadObj->removeFile('author', '150x150-'.$arrParam['form']['avatar_hidden']);
				$arrParam['form']['avatar']	= $uploadObj->uploadFile($arrParam['form']['avatar'], 'author', 150, 150);
			}
			$arrParam['form']['modified_time']	= date('Y-m-d H:m:s', time());
			$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->update($data, array(array('id', $arrParam['form']['id'])));
			Session::set('message', array('class' => 'success', 'content' => 'Data updated successfully!!'));
			return $arrParam['form']['id'];
		}
	}
}