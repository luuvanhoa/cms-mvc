<?php
class CategoryArticleModel extends Model{
    private $_columns = array('id', 'name', 'catecode', 'created_at', 'created_by', 'modified_at', 'modified_by', 'status', 'show_on_fe', 'show_on_footer', 'position', 'position_footer', 'meta_title', 'meta_description');
    private $_userInfo;
    
    public function __construct(){
			parent::__construct();
			$this->setTable(TBL_CATEGORY_ARTICLE);
			
			$userObj 			= Session::get('user');
			$this->_userInfo 	= $userObj['info'];
    }

    public function listItem($arrParam, $option = null){
		$query[]	= "SELECT `id`, `name`, `catecode`, `show_on_fe`, `show_on_footer`, `meta_title`, `meta_description`, `status`, `created_at`, `created_by`, `modified_at`, `modified_by`";
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
            $query	= "UPDATE `$this->table` SET `status` = $status, `modified_at` = '$modified', `modified_by` = '$modified_by'  WHERE `id` = '" . $id . "'";
            $this->execute($query);
            $result = array(
                'id'		=> $id,
                'status'	=> $status,
                'link'		=> URL::createLink('admin', 'categoryArticle', 'ajaxStatus', array('id' => $id, 'status' => $status)),
                'alert'		=> Helper::cmsMessage(array('class' => 'success', 'content' => 'You changed the status successfully!')),
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
    
    public function infoItem($arrParam, $option = null){
        if($option == null){
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `id` = '" . $arrParam['id'] . "'";
            $query		= implode(" ", $query);
            $result		= $this->fetchRow($query);
            return $result;
        }
        if($option['task'] == 'get-catecode'){
            $query[]    = "SELECT `catecode`";
            $query[]    = "FROM `$this->table`";
            $query[]    = "WHERE `id` = '" . $arrParam['id'] . "'";
            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result['catecode'];
        }
    }
    
    public function deleteItem($arrParam, $option = null){
        if($option == null){
            if(!empty($arrParam['cid'])){
                $ids		= $this->createWhereDeleteSQL($arrParam['cid']);
                $query		= "DELETE FROM `$this->table` WHERE `id` IN ($ids)";
                $result = $this->execute($query);
                Session::set('message', array('class' => 'success','content' => 'There are ' . $result->rowCount(). ' elements deleted'));
            }else{
                Session::set('message', array('class' => 'error', 'content' => 'Please select the delete element!'));
            }
        }
    }
    
    public function saveItem($arrParam, $option = null){
        
        $userObj	= Session::get('user');
        $userInfo	= $userObj['info'];
        
        
        if($option['task'] == 'add'){
            $arrParam['form']['created_at']	= date('Y-m-d', time());
            $arrParam['form']['created_by']	= $userInfo['username'];
            
            //CATECODE
            if(!empty($arrParam['form']['catecode'])){
                $arrParam['form']['catecode'] = Helper::createSlug($arrParam['form']['catecode']);
            }else{
                $arrParam['form']['catecode'] = Helper::createSlug($arrParam['form']['name']);
            }

            $data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
            $this->insert($data);
            Session::set('message', array('class' => 'success', 'content' => 'Data saved successfully!'));
            return $this->lastID();
        }
        if($option['task'] == 'edit'){
            $arrParam['form']['modified_at']	= date('Y-m-d', time());
            $arrParam['form']['modified_by']= $userInfo['username'];
            
             //CATECODE
            if(!empty($arrParam['form']['catecode'])){
                $arrParam['form']['catecode'] = Helper::createSlug($arrParam['form']['catecode']);
            }else{
                $arrParam['form']['catecode'] = Helper::createSlug($arrParam['form']['name']);
            }

            //CHANGE SHARE_URL ARTICLE
            $catecodeOld     = $this->infoItem(array('id' => $arrParam['form']['id']), array('task' => 'get-catecode'));
            $catecodeNew     = $arrParam['form']['catecode'];
            $queryShare_url  = "UPDATE `".TBL_ARTICLE."` SET `share_url` = REPLACE(`share_url`, '/$catecodeOld/', '/$catecodeNew/') WHERE `category_orginal` = ".$arrParam['form']['id'];
            $this->execute($queryShare_url);
            //INSERT DATA
            $data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
            $this->update($data, array(array('id', $arrParam['form']['id'])));
            Session::set('message', array('class' => 'success', 'content' => 'Data updated successfully!'));
            return $arrParam['form']['id'];
        }
    }
}