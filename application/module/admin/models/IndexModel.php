<?php
class IndexModel extends Model{
	public function __construct(){
		parent::__construct();
		$this->setTable(TBL_USER);
	}
	
	public function infoItem($arrParam, $option = null){
		if($option == null) {
			$username	= $arrParam['form']['username'];
			$password	= md5($arrParam['form']['password']);
			$query[]	= "SELECT `u`.`id`, `u`.`fullname`, `u`.`email`, `u`.`username`, `u`.`group_id`, `u`.`created`, `g`.`group_acp`, `u`.`avatar`, `g`.`privilege_id`";
			$query[]	= "FROM `user` AS `u` LEFT JOIN `group` AS g ON `u`.`group_id` = `g`.`id`";
			$query[]	= "WHERE `username` = '$username' AND `password` = '$password'";
			
			$query		= implode(" ", $query);
			$result		= $this->fetchRow($query);
			
			if($result['group_acp'] == 1){
				$arrPrivilege	= explode(',', $result['privilege_id']);
				foreach($arrPrivilege as $privilegeID) $strPrivilegeID	.= "'$privilegeID', ";
				
				$queryP[]	= "SELECT `id`, CONCAT(`module`, '-', `controller`, '-',`action`) AS `name`";
				$queryP[]	= "FROM `".TBL_PRIVELEGE."` AS p";
				$queryP[]	= "WHERE id IN ($strPrivilegeID'0')";
				
				$queryP		= implode(" ", $queryP);
				$result['privilege']	= $this->fetchPairs($queryP);
			}
			
			
			return $result;
		}
	}

	public function infoItemId($id, $option = null){
		if($option == null){
			$query[] = "SELECT `id`, `username`, `email`, `fullname`, `created`, `avatar`";
			$query[] = "FROM `".TBL_USER."`";
			$query[] = "WHERE `id` = '".$id."'";

			$query   = implode(" ", $query);
			$result  = $this->fetchRow($query);
		}
		return $result;
	}	

	public function updateItem($arrParam, $option = null){
		
		$userObj	= Session::get('user');
		$userInfo	= $userObj['info'];

		require_once(LIBRARY_EXT_PATH.'Upload.php');
		$uploadObj = new Upload();
		if(@$arrParam['form']['avatar']['name'] == null){
				unset($arrParam['form']['avatar']);
		}
		else{
			$uploadObj->removeFile('avatar', $arrParam['form']['avatar_hidden']);
			$uploadObj->removeFile('avatar', '150x150-'.$arrParam['form']['avatar_hidden']);
			$data['avatar']	= $uploadObj->uploadFile($arrParam['form']['avatar'], 'avatar', 150, 150);
		}
		$data['email'] 		= $arrParam['form']['email'];
		$data['fullname']	= $arrParam['form']['fullname'];
		$data['modified']	= date('Y-m-d', time());
		$data['modified_by']= $userInfo['username'];
		$this->update($data, array(array('id', $arrParam['form']['id'])));
		Session::set('message', array('class' => 'success', 'content' => 'Data updated successfully!'));
		return $arrParam['form']['id'];
	}
}