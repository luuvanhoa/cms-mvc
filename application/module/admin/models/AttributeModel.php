<?php
class AttributeModel extends Model{
	
	private $_columns = array('id', 'name', 'created', 'created_by', 'modified', 'modified_by', 'status');
	private $_userInfo;
	
	public function __construct(){
		parent::__construct();
		$this->setTable(TBL_ATTRIBUTES);
		
		$userObj 			= Session::get('user');
		$this->_userInfo 	= $userObj['info'];
	}
	
	
	public function listItem($arrParam, $option = null){
		$query[]	= "SELECT `id`, `name`, `status`, `created`, `created_by`, `modified`, `modified_by`";
		$query[]	= "FROM `$this->table`";
		$query[]	= "WHERE `id` > 0";

		$query		= implode(" ", $query);
		$result		= $this->fetchAll($query);
		return $result;
	}
	
	public function changeStatus($arrParam, $option = null){
		if($option['task'] == 'change-ajax-status'){
			$status 		= ($arrParam['status'] == 0) ? 1 : 0;
			$modified_by	= $this->_userInfo['username'];
			$modified		= date('Y-m-d', time());
			$id		= $arrParam['id'];
			$query	= "UPDATE `$this->table` SET `status` = $status, `modified` = '$modified', `modified_by` = '$modified_by'  WHERE `id` = '" . $id . "'";
			$this->execute($query);
			$result = array(
								'id'		=> $id, 
								'status'	=> $status, 
								'link'		=> URL::createLink('admin', 'attribute', 'ajaxStatus', array('id' => $id, 'status' => $status)),
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
			}else{
				Session::set('message', array('class' => 'error', 'content' => 'Please select the delete element!'));
			}
		}
	}
	
	public function infoItem($arrParam, $option = null){
		if($option == null){
			$query[]	= "SELECT `id`, `name`, `status`";
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

		
		if($option['task'] == 'add'){
			$arrParam['form']['created']	= date('Y-m-d', time());
			$arrParam['form']['created_by']	= $userInfo['username'];			
			
			$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->insert($data);
			Session::set('message', array('class' => 'success', 'content' => 'Data saved successfully!'));
			return $this->lastID();
		}
		if($option['task'] == 'edit'){
			$arrParam['form']['modified']	= date('Y-m-d', time());
			$arrParam['form']['modified_by']= $userInfo['username'];

			$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->update($data, array(array('id', $arrParam['form']['id'])));
			Session::set('message', array('class' => 'success', 'content' => 'Data updated successfully!!'));
			return $arrParam['form']['id'];
		}
	}
}