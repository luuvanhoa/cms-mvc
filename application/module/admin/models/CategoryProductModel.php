<?php

class CategoryProductModel extends Model{
    private $_columns = array('id', 'name', 'catecode', 'lft', 'rgt', 'level', 'parent','created_at', 'created_by', 'modified_at', 'modified_by', 'status', 'show_on_fe', 'show_on_footer', 'position', 'position_footer', 'meta_title', 'meta_description');
    private $_userInfo;
    
    public function __construct(){
		parent::__construct();
		$this->setTable(TBL_CATEGORY_PRODUCT);
		
		$userObj 			= Session::get('user');
		$this->_userInfo 	= $userObj['info'];
    }

    public function countItemParentById($id)
    {
        $query[]	= "SELECT COUNT(`id`) AS `total`";
        $query[]	= "FROM `$this->table`";
        $query[]	= "WHERE `parent` = '".$id."'";
        
        $query		= implode(" ", $query);
        $result		= $this->fetchRow($query);
        return $result['total'];
    }
    
    public function itemInSelectbox($arrParam, $option = null){
        $itemResult = $this->getAllNode();
        $arrParent = [];
        $arrParent['default'] = "-- Select Category Parent --";
        if(count($itemResult) > 0)
        {
            foreach ($itemResult as $val) {
                $level = $val['level'];
                $line = "";
                if ($level == 0) {
                    $line = '';
                }
                else {
                    for ($i = 0; $i < $level; $i++) {
                        $line .= '|----';
                    }
                }
                
                $arrParent[$val['id']] = $line . $val['name'];
            }
            ksort($arrParent);
        }
        return $arrParent;
    }
    
    public function listItem($arrParam, $option = null){
		$query[]	= "SELECT `id`,`lft`, `rgt`, `parent`, `name`, `status`, `catecode`, `created_at`, `created_by`, `modified_at`, `modified_by`, `level`, `position`, `position_footer`, `meta_title`, `meta_description`";
		$query[]	= "FROM `$this->table`";
		$query[]	= "WHERE `name` <> 'Root'";
		$query[]	= "ORDER BY `lft` ASC";
		$query		= implode(" ", $query);
		$result		= $this->fetchAll($query);
		return $result;
    }
    
    public function getAllNode($option = null){
        $query[]	= "SELECT *";
        $query[]	= "FROM `$this->table`";
        //$query[]	= "WHERE `name` <> 'Root'";
        $query[]	= "ORDER BY `lft` ASC";
        $query		= implode(" ", $query);
        $result		= $this->fetchAll($query);
        return $result;
    }
    
    
    public function deleteItem($arrParam, $option = null){
		if($option == null){
			if(!empty($arrParam['cid'])){
				foreach($arrParam['cid'] as $id) {
				    $this->removeNode($id, ['type' => 'only']);
				}
				Session::set('message', array('class' => 'success', 'content' => 'There are ' . $result->rowCount(). ' elements deleted'));
			}else{
				Session::set('message', array('class' => 'error', 'content' => 'Please select the delete element!'));
			}
		}
    }
    
    public function deleteManyNode($node, $option = null){
        if($option == null){
            $query		= "DELETE FROM `$this->table` WHERE `lft` >= '".$node['lft']."' && `lft` <= '".$node['rgt']."'";
            $result = $this->execute($query);    
        }
    }
    
    public function getItemByWhere($option = null){
        if($option['type'] == 'update-left-gt') {
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `lft` > '" . $option['lft']. "'";
            $query		= implode(" ", $query);
            $result		= $this->fetchAll($query);
            return $result;
        }
        
        if($option['type'] == 'update-left-gte') {
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `lft` >= '" . $option['lft']. "'";
            $query		= implode(" ", $query);
            $result		= $this->fetchAll($query);
            return $result;
        }
        
        if($option['type'] == 'update-right-gt') {
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `rgt` > '" . $option['lft']. "'";
            $query		= implode(" ", $query);
            $result		= $this->fetchAll($query);
            return $result;
        }
        
        if($option['type'] == 'update-right-gte') {
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `rgt` >= '" . $option['lft']. "'";
            $query		= implode(" ", $query);
            $result		= $this->fetchAll($query);
            return $result;
        }
        
        if($option['type'] == 'node-on-branch') {
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `lft` >= '" . $option['lft']. "' && `lft` <= '" . $option['rgt']. "'";
            $query		= implode(" ", $query);
            $result		= $this->fetchAll($query);
            return $result;
        }
        
        if($option['type'] == 'node-on-tree-left') {
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `lft` > '" . $option['where']. "'";
            $query		= implode(" ", $query);
            $result		= $this->fetchAll($query);
            return $result;
        }
        
        if($option['type'] == 'node-on-tree-right') {
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `rgt` > '" . $option['where']. "'";
            $query		= implode(" ", $query);
            $result		= $this->fetchAll($query);
            return $result;
        }
        
        if($option['type'] == 'move-left-left') {
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `lft` > '" . $option['lft']. "' && `rgt` >= '" . $option['rgt']. "'";
            $query		= implode(" ", $query);
            $result		= $this->fetchAll($query);
            return $result;
        }
        
        if($option['type'] == 'move-right-left') {
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `lft` > '" . $option['lft']. "' && `rgt` > '" . $option['rgt']. "'";
            $query		= implode(" ", $query);
            $result		= $this->fetchAll($query);
            return $result;
        }
        
        if($option['type'] == 'move-before-left') {
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `lft` >= '" . $option['lft']. "' && `rgt` > '" . $option['rgt']. "'";
            $query		= implode(" ", $query);
            $result		= $this->fetchAll($query);
            return $result;
        }
        
        if($option['type'] == 'move-after-left') {
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `lft` > '" . $option['lft']. "' && `rgt` > '" . $option['rgt']. "'";
            $query		= implode(" ", $query);
            $result		= $this->fetchAll($query);
            return $result;
        }
        
        if($option['type'] == 'find-right-lte') {
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `rgt` <= '" . $option['where']. "'";
            $query		= implode(" ", $query);
            $result		= $this->fetchAll($query);
            return $result;
        }
        
        if($option['type'] == 'move-up') {
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `parent` = '" . $option['parent']. "' && `id` != '".$option['id']."' && `rgt` < '".$option['rgt']."'";
            $query[]	= "ORDER BY `lft` DESC";
            $query		= implode(" ", $query);
            $result		= $this->fetchRow($query);
            return $result;
        }
        
        if($option['type'] == 'move-down') {
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `parent` = '" . $option['parent']. "' && `id` != '".$option['id']."' && `rgt` > '".$option['lft']."'";
            $query[]	= "ORDER BY `lft` ASC";
            $query		= implode(" ", $query);
            $result		= $this->fetchRow($query);
            return $result;
        }
        
        if($option['type'] == 'get-list-child') {
            $query[]	= "SELECT *";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `parent` = '" . $option['parent']. "'";
            
            $query		= implode(" ", $query);
            $result		= $this->fetchAll($query);
            return $result;
        }
	}
	
	public function updateOne($option = null) {
	    if($option['type'] == 'left') {
	        $query		= "UPDATE `$this->table` SET `lft` = '".$option['set']."'  WHERE `id` = '" . $option['id'] . "'";
	        $result = $this->execute($query);
	    }
	    
	    if($option['type'] == 'right') {
	        $query		= "UPDATE `$this->table` SET `rgt` = '".$option['set']."'  WHERE `id` = '" . $option['id'] . "'";
	        $result = $this->execute($query);
	    }
	    
	    if($option['type'] == 'node-on-branch') {
	        $query		= "UPDATE `$this->table` SET `rgt` = '".$option['rgt']."',`lft` = '". $option['lft'] ."'  WHERE `id` = '" . $option['id'] . "'";
	        $result = $this->execute($query);
	    }
	    
	    if($option['type'] == 'update-move-left') {
	        $query		= "UPDATE `$this->table` SET `rgt` = '".$option['rgt']."',`lft` = '". $option['lft'] ."', `level` = '" .$option['level']."'  WHERE `id` = '" . $option['id'] . "'";
	        $result = $this->execute($query);
	    }
	    
	    if($option['type'] == 'update-move-left-parent') {
	        $query		= "UPDATE `$this->table` SET `parent` = '".$option['parent']."'  WHERE `id` = '" . $option['id'] . "'";
	        $result = $this->execute($query);
	    }
	}
	
	
	
	public function getInfoItem($id, $option = null){
	    if($option == null){
	        $query[]	= "SELECT *";
	        $query[]	= "FROM `$this->table`";
	        $query[]	= "WHERE `id` = '" . $id . "'";
	        $query		= implode(" ", $query);
	        $result		= $this->fetchRow($query);
	        return $result;
	    }
	}
    
	public function saveItem($arrParam, $option = null){
	    
	    if($option['task'] == 'add'){
	        $this->insertNode($arrParam, (int)$arrParam['form']['parent']);
	        Session::set('message', array('class' => 'success', 'content' => 'Data saved successfully!'));
	        return $this->lastID();
	    }
	    if($option['task'] == 'edit'){
	        //$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
	        $this->updateNode($arrParam, $arrParam['form']['id'], $arrParam['form']['parent']);
	        Session::set('message', array('class' => 'success', 'content' => 'Data updated successfully!'));
	        return $arrParam['form']['id'];
	    }
	}
	
	public function insertNode($arrParam, $nodeID, $options = null)
    {
        $userObj	= Session::get('user');
        $userInfo	= $userObj['info'];
        
        $nodeInfo = $this->getInfoItem($nodeID);
        
        $arrParam['form']['created_at']	= date('Y-m-d', time());
        $arrParam['form']['created_by']	= $userInfo['username'];
        $arrParam['form']['catecode'] = !empty($arrParam['form']['catecode']) ? Helper::createSlug($arrParam['form']['catecode']) : Helper::createSlug($arrParam['form']['name']);
        
        $data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
        switch ($options['position']) {
            case 'left':
                //$updateLeft = $this->collection->find(['left' => ['$gt' => $nodeInfo->left]]);
                //$updateRight = $this->collection->find(['right' => ['$gt' => $nodeInfo->left]]);
                $updateLeft = $this->getItemByWhere(array('type' => 'update-left-gt', 'lft' => $nodeInfo['lft']));
                $updateRight= $this->getItemByWhere(array('type' => 'update-right-gt', 'rgt' => $nodeInfo['lft']));
                
                $data['parent'] = $nodeInfo['id'];
                $data['level'] = $nodeInfo['level'] + 1;
                $data['lft'] = $nodeInfo['lft'] + 1;
                $data['rgt'] = $nodeInfo['lft'] + 2;
                break;
            case 'before':
                //$updateLeft = $this->collection->find(['left' => ['$gte' => $nodeInfo->left]]);
                //$updateRight = $this->collection->find(['right' => ['$gt' => $nodeInfo->left]]);
                $updateLeft = $this->getItemByWhere(array('type' => 'update-left-gte', 'lft' => $nodeInfo['lft']));
                $updateRight= $this->getItemByWhere(array('type' => 'update-right-gt', 'lft' => $nodeInfo['lft']));

                $data['parent'] = $nodeInfo['parent'];
                $data['level'] = $nodeInfo['level'];
                $data['lft'] = $nodeInfo['lft'];
                $data['rgt'] = $nodeInfo['lft'] + 1;
                break;
            case 'after':
                //$updateLeft = $this->collection->find(['left' => ['$gte' => $nodeInfo->right]]);
                //$updateRight = $this->collection->find(['right' => ['$gt' => $nodeInfo->right]]);
                $updateLeft = $this->getItemByWhere(array('type' => 'update-left-gte', 'lft' => $nodeInfo['rgt']));
                $updateRight= $this->getItemByWhere(array('type' => 'update-right-gt', 'lft' => $nodeInfo['rgt']));
                
                $data['parent'] = $nodeInfo['parent'];
                $data['level'] = $nodeInfo['level'];
                $data['lft'] = $nodeInfo['rgt'] + 1;
                $data['rgt'] = $nodeInfo['rgt'] + 2;
                break;
            case 'right':
            default:
                //$updateLeft = $this->collection->find(['left' => ['$gt' => $nodeInfo->right]]);
                //$updateRight = $this->collection->find(['right' => ['$gte' => $nodeInfo->right]]);
                
                $updateLeft = $this->getItemByWhere(array('type' => 'update-left-gt', 'lft' => $nodeInfo['rgt']));
                $updateRight= $this->getItemByWhere(array('type' => 'update-right-gte', 'lft' => $nodeInfo['rgt']));

                $data['parent'] = $nodeInfo['id'];
                $data['level'] = $nodeInfo['level'] + 1;
                $data['lft'] = $nodeInfo['rgt'];
                $data['rgt'] = $nodeInfo['rgt'] + 1;
                break;
        }

        if (!empty($updateLeft)) {
            foreach ($updateLeft as $left) {
                $this->updateOne(array('type' => 'left', 'set' => $left['lft'] + 2, 'id' => $left['id']));
                //$this->collection->updateOne(['id' => $left->id], ['$set' => ['left' => $left->left + 2]]);
            }
        }

        if (!empty($updateRight)) {
            foreach ($updateRight as $right) {
                $this->updateOne(array('type' => 'right', 'set' => $right['rgt'] + 2, 'id' => $right['id']));
                //$this->collection->updateOne(['id' => $right->id], ['$set' => ['right' => $right->right + 2]]);
            }
        }
        $this->insert($data);
        //Session::set('message', array('class' => 'success', 'content' => 'Data saved successfully!'));
        //return $this->lastID();
    }
    
    public function detachBranch($nodeMoveID, $options = null)
    {
        // Step 1
        $moveInfo= $this->getInfoItem($nodeMoveID);
        $moveLeft = $moveInfo['lft'];
        $moveRight = $moveInfo['rgt'];
        $totalNode = ($moveRight - $moveLeft + 1) / 2;
//         echo $totalNode;
//         die();
        // ================================== Node on branch ==================================
        if ($options == null) {
            $updateNode= $this->getItemByWhere(array('type' => 'node-on-branch', 'lft' => $moveLeft, 'rgt' => $moveRight));
            //$updateNode = $this->collection->find(['left' => ['$gte' => $moveLeft, '$lte' => $moveRight]]);
            if (!empty($updateNode)) {
                foreach ($updateNode as $node) {
                    $leftNew = ($node['lft'] - $moveLeft);
                    $rightNew = ($node['rgt'] - $moveRight);
                    $this->updateOne(array('type' => 'node-on-branch', 'lft' => $leftNew, 'rgt' => $rightNew, 'id' => $node['id']));
                    //$this->collection->updateOne(['id' => $node->id], ['$set' => ['left' => $leftNew, 'right' => $rightNew]]);
                }
            }
        }
        
        if ($options['task'] == 'remove-node') {
            $this->deleteManyNode($moveInfo);
        }
        
        // Node on tree LEFT
        $updateNode= $this->getItemByWhere(array('type' => 'node-on-tree-left', 'where' => $moveRight));
        //$updateNode = $this->collection->find(['left' => ['$gt' => $moveRight]]);
        if (!empty($updateNode)) {
            foreach ($updateNode as $node) {
                $leftNew = $node['lft'] - ($totalNode * 2);
                $this->updateOne(array('type' => 'left', 'set' => $leftNew, 'id' => $node['id']));
                //$this->collection->updateOne(['id' => $node->id], ['$set' => ['left' => $leftNew]]);
            }
        }
        
        // ================================== Node on tree (RIGHT) ==================================
        $updateNode= $this->getItemByWhere(array('type' => 'node-on-tree-right', 'where' => $moveRight));
        //$updateNode = $this->collection->find(['right' => ['$gt' => $moveRight]]);
        if (!empty($updateNode)) {
            foreach ($updateNode as $node) {
                $rightNew = $node['rgt'] - ($totalNode * 2);
                $this->updateOne(array('type' => 'right', 'set' => $rightNew, 'id' => $node['id']));
                //$this->collection->updateOne(['id' => $node->id], ['$set' => ['right' => $rightNew]]);
            }
        }
        
        return $totalNode;
    }
    
    public function moveNode($nodeMoveID, $nodeSelectionID, $options = null)
    {
        switch ($options['position']) {
            case 'left' :
                $this->moveLeft($nodeMoveID, $nodeSelectionID);
                break;
            case 'before' :
                $this->moveBefore($nodeMoveID, $nodeSelectionID);
                break;
            case 'after' :
                $this->moveAfter($nodeMoveID, $nodeSelectionID);
                break;
            case 'right' :
            default:
                $this->moveRight($nodeMoveID, $nodeSelectionID);
                break;
                
        }
    }
    
    public function moveLeft($nodeMoveID, $nodeSelectionID)
    {
        $totalNode = $this->detachBranch($nodeMoveID);
        $nodeSelectionInfo = $this->getInfoItem($nodeSelectionID);
        $nodeMoveInfo = $this->getInfoItem($nodeMoveID);
        //$nodeSelectionInfo = $this->collection->findOne(['id' => $nodeSelectionID]);
        //$nodeMoveInfo = $this->collection->findOne(['id' => $nodeMoveID]);
        
        // ========================= Node on tree (LEFT) ========================
        $updateLeft = $this->getItemByWhere(array('type' => 'move-left-left','lft' => $nodeSelectionInfo['lft'], 'rgt' => 0));
//         $updateLeft = $this->collection->find([
//             'left' => ['$gt' => $nodeSelectionInfo->left],
//             'right' => ['$gt' => 0]
//         ]);
        if (!empty($updateLeft)) {
            foreach ($updateLeft as $node) {
                $leftNew = $node['lft'] + ($totalNode * 2);
                $this->updateOne(array('type' => 'left', 'id' => $node['id'], 'set' => $leftNew));
                //$this->collection->updateOne(['id' => $node->id], ['$set' => ['left' => $leftNew]]);
            }
        }
        
        // ========================= Node on tree (RIGHT) =========================
        $updateRight= $this->getItemByWhere(array('type' => 'update-right-gte','lft' => $nodeSelectionInfo['lft']));
        //$updateRight = $this->collection->find(['right' => ['$gte' => $nodeSelectionInfo->left]]);
        if (!empty($updateRight)) {
            foreach ($updateRight as $node) {
                $rightNew = $node['rgt'] + ($totalNode * 2);
                $this->updateOne(array('type' => 'right', 'id' => $node['id'], 'set' => $rightNew));
                //$this->collection->updateOne(['id' => $node->id], ['$set' => ['right' => $rightNew]]);
            }
        }
        
        // ========================= Node on branch (LEVEL) =========================
        $updateLevel= $this->getItemByWhere(array('type' => 'find-right-lte','where' => 0));
        //$updateLevel = $this->collection->find(['right' => ['$lte' => 0]]);
        if (!empty($updateLevel)) {
            foreach ($updateLevel as $node) {
                // ========================= Node on branch (LEVEL) =========================
                $level = $node['level'] + $nodeSelectionInfo['level'] - $nodeMoveInfo['level'] + 1;
                // ========================= Node on branch (LEFT) ==========================
                $left = $node['lft'] + $nodeSelectionInfo['lft'] + 1;
                // ========================= Node on branch (RIGHT) =========================
                $right = $node['rgt'] + $nodeSelectionInfo['lft'] + 1 + $totalNode * 2 - 1;
                
                $this->updateOne(array('type' => 'update-move-left', 'id' => $node['id'], 'lft' => (int)$left, 'rgt' => (int)$right, 'level' => (int)$level));
//                 $this->collection->updateOne(['id' => $node->id], ['$set' => [
//                     'level' => (int)$level,
//                     'left' => (int)$left,
//                     'right' => (int)$right
//                 ]]);
            }
        }
        
        // ========================= Node move (PARENT) =========================
        $this->updateOne(array('type' => 'update-move-left-parent', 'id' => $nodeMoveInfo['id'], 'parent' => (int)$nodeSelectionInfo['id']));
        //$this->collection->updateOne(['id' => $nodeMoveInfo->id], ['$set' => ['parent' => (int)$nodeSelectionInfo->id]]);
    }
    
    public function moveRight($nodeMoveID, $nodeSelectionID)
    {
        $totalNode = $this->detachBranch($nodeMoveID);
        //die($totalNode);
        $nodeSelectionInfo = $this->getInfoItem($nodeSelectionID);
        $nodeMoveInfo = $this->getInfoItem($nodeMoveID);
        
        // ========================= Node on tree (LEFT) ========================
        $updateLeft = $this->getItemByWhere(array('type' => 'move-right-left','lft' => $nodeSelectionInfo['rgt'], 'rgt' => 0));
        if (!empty($updateLeft)) {
            foreach ($updateLeft as $node) {
                $leftNew = $node['lft'] + ($totalNode * 2);
                $this->updateOne(array('type' => 'left', 'id' => $node['id'], 'set' => $leftNew));
                //$this->collection->updateOne(['id' => $node->id], ['$set' => ['left' => $leftNew]]);
            }
        }
        
        // ========================= Node on tree (RIGHT) =========================
        $updateRight= $this->getItemByWhere(array('type' => 'update-right-gte','lft' => $nodeSelectionInfo['rgt']));
        
        if (!empty($updateRight)) {
            foreach ($updateRight as $node) {
                $rightNew = $node['rgt'] + ($totalNode * 2);
                $this->updateOne(array('type' => 'right', 'id' => $node['id'], 'set' => $rightNew));
            }
        }
        
        // ========================= Node on branch (LEVEL) =========================
        $updateLevel= $this->getItemByWhere(array('type' => 'find-right-lte','where' => 0));
        //$updateLevel = $this->collection->find(['right' => ['$lte' => 0]]);
        if (!empty($updateLevel)) {
            foreach ($updateLevel as $node) {
                // ========================= Node on branch (LEVEL) =========================
                $level = $node['level'] + $nodeSelectionInfo['level'] - $nodeMoveInfo['level'] + 1;
                // ========================= Node on branch (LEFT) ==========================
                $left = $node['lft'] + $nodeSelectionInfo['rgt'];
                // ========================= Node on branch (RIGHT) =========================
                $right = $node['rgt'] + $nodeSelectionInfo['rgt'] + $totalNode * 2 - 1;
                
                $this->updateOne(array('type' => 'update-move-left', 'id' => $node['id'], 'lft' => (int)$left, 'rgt' => (int)$right, 'level' => (int)$level));
            }
        }
        
        // ========================= Node move (PARENT) =========================
        $this->updateOne(array('type' => 'update-move-left-parent', 'id' => $nodeMoveInfo['id'], 'parent' => (int)$nodeSelectionInfo['id']));
//         $this->collection->updateOne(['id' => $nodeMoveInfo->id], ['$set' => ['parent' => (int)$nodeSelectionInfo->id]]);
    }
    
    public function moveBefore($nodeMoveID, $nodeSelectionID)
    {
        $totalNode = $this->detachBranch($nodeMoveID);
        $nodeSelectionInfo = $this->getInfoItem($nodeSelectionID);
        $nodeMoveInfo = $this->getInfoItem($nodeMoveID);
//         $nodeSelectionInfo = $this->collection->findOne(['id' => $nodeSelectionID]);
//         $nodeMoveInfo = $this->collection->findOne(['id' => $nodeMoveID]);
        
        // ========================= Node on tree (LEFT) ========================
        //$updateNode= $this->getItemByWhere(array('type' => 'node-on-branch', 'left' => $moveLeft, 'right' => $moveRight));
        $updateLeft = $this->getItemByWhere(array('type' => 'move-before-left','lft' => $nodeSelectionInfo['lft'], 'rgt' => 0));
//         $updateLeft = $this->collection->find([
//             'left' => ['$gte' => $nodeSelectionInfo->left],
//             'right' => ['$gt' => 0]
//         ]);
        if (!empty($updateLeft)) {
            foreach ($updateLeft as $node) {
                $leftNew = $node['lft'] + ($totalNode * 2);
                $this->updateOne(array('type' => 'left', 'id' => $node['id'], 'set' => $leftNew));
//                 $this->collection->updateOne(['id' => $node->id], ['$set' => ['left' => $leftNew]]);
            }
        }
        
        // ========================= Node on tree (RIGHT) =========================
        $updateRight= $this->getItemByWhere(array('type' => 'update-right-gt','lft' => $nodeSelectionInfo['lft']));
        //$updateRight = $this->collection->find(['right' => ['$gt' => $nodeSelectionInfo->left]]);
        if (!empty($updateRight)) {
            foreach ($updateRight as $node) {
                $rightNew = $node['rgt'] + ($totalNode * 2);
                $this->updateOne(array('type' => 'right', 'id' => $node['id'], 'set' => $rightNew));
//                 $this->collection->updateOne(['id' => $node->id], ['$set' => ['right' => $rightNew]]);
            }
        }
        
        // ========================= Node on branch (LEVEL) =========================
//         $updateLevel = $this->collection->find(['right' => ['$lte' => 0]]);
        $updateLevel= $this->getItemByWhere(array('type' => 'find-right-lte','where' => 0));
        if (!empty($updateLevel)) {
            foreach ($updateLevel as $node) {
                // ========================= Node on branch (LEVEL) =========================
                $level = $node['level'] + $nodeSelectionInfo['level'] - $nodeMoveInfo['level'];
                // ========================= Node on branch (LEFT) ==========================
                $left = $node['lft'] + $nodeSelectionInfo['lft'];
                // ========================= Node on branch (RIGHT) =========================
                $right = $node['rgt'] + $nodeSelectionInfo['lft'] + $totalNode * 2 - 1;
                
                $this->updateOne(array('type' => 'update-move-left', 'id' => $node['id'], 'lft' => (int)$left, 'rgt' => (int)$right, 'level' => (int)$level));
//                 $this->collection->updateOne(['id' => $node->id], ['$set' => [
//                     'level' => (int)$level,
//                     'left' => (int)$left,
//                     'right' => (int)$right
//                 ]]);
            }
        }   
        
        // ========================= Node move (PARENT) =========================
        $this->updateOne(array('type' => 'update-move-left-parent', 'id' => $nodeMoveInfo['id'], 'parent' => (int)$nodeSelectionInfo['parent']));
       // $this->collection->updateOne(['id' => $nodeMoveInfo->id], ['$set' => ['parent' => (int)$nodeSelectionInfo->parent]]);
    }
    
    public function moveAfter($nodeMoveID, $nodeSelectionID)
    {
        $totalNode = $this->detachBranch($nodeMoveID);
        $nodeSelectionInfo = $this->getInfoItem($nodeSelectionID);
        $nodeMoveInfo = $this->getInfoItem($nodeMoveID);
//         $nodeSelectionInfo = $this->collection->findOne(['id' => $nodeSelectionID]);
//         $nodeMoveInfo = $this->collection->findOne(['id' => $nodeMoveID]);
        
        // ========================= Node on tree (LEFT) ========================
        $updateLeft = $this->getItemByWhere(array('type' => 'move-after-left','lft' => $nodeSelectionInfo['rgt'], 'rgt' => 0));
//         $updateLeft = $this->collection->find([
//             'left' => ['$gt' => $nodeSelectionInfo->right],
//             'right' => ['$gt' => 0]
//         ]);
        if (!empty($updateLeft)) {
            foreach ($updateLeft as $node) {
                $leftNew = $node['lft'] + ($totalNode * 2);
                $this->updateOne(array('type' => 'left', 'id' => $node['id'], 'set' => $leftNew));
//                 $this->collection->updateOne(['id' => $node->id], ['$set' => ['left' => $leftNew]]);
            }
        }
        
        // ========================= Node on tree (RIGHT) =========================
        $updateRight= $this->getItemByWhere(array('type' => 'update-right-gt','lft' => $nodeSelectionInfo['rgt']));
//         $updateRight = $this->collection->find(['right' => ['$gt' => $nodeSelectionInfo->right]]);
        if (!empty($updateRight)) {
            foreach ($updateRight as $node) {
                $rightNew = $node['rgt'] + ($totalNode * 2);
                $this->updateOne(array('type' => 'right', 'id' => $node['id'], 'set' => $rightNew));
                //$this->collection->updateOne(['id' => $node->id], ['$set' => ['right' => $rightNew]]);
            }
        }
        
        // ========================= Node on branch (LEVEL) =========================
        $updateLevel= $this->getItemByWhere(array('type' => 'find-right-lte','where' => 0));
//         $updateLevel = $this->collection->find(['right' => ['$lte' => 0]]);
        if (!empty($updateLevel)) {
            foreach ($updateLevel as $node) {
                // ========================= Node on branch (LEVEL) =========================
                $level = $node['level'] + $nodeSelectionInfo['level'] - $nodeMoveInfo['level'];
                // ========================= Node on branch (LEFT) ==========================
                $left = $node['lft'] + $nodeSelectionInfo['rgt'] + 1;
                // ========================= Node on branch (RIGHT) =========================
                $right = $node['rgt'] + $nodeSelectionInfo['rgt'] + $totalNode * 2;
                
                $this->updateOne(array('type' => 'update-move-left', 'id' => $node['id'], 'lft' => (int)$left, 'rgt' => (int)$right, 'level' => (int)$level));
//                 $this->collection->updateOne(['id' => $node->id], ['$set' => [
//                     'level' => (int)$level,
//                     'left' => (int)$left,
//                     'right' => (int)$right
//                 ]]);
            }
        }
        
        // ========================= Node move (PARENT) =========================
        $this->updateOne(array('type' => 'update-move-left-parent', 'id' => $nodeMoveInfo['id'], 'parent' => (int)$nodeSelectionInfo['parent']));
//         $this->collection->updateOne(['id' => $nodeMoveInfo->id], ['$set' => ['parent' => (int)$nodeSelectionInfo->parent]]);
    }
    
    public function moveUp($nodeID, $options = null)
    {
        $nodeInfo= $this->getInfoItem($nodeID);
        //$nodeInfo = $this->collection->findOne(['id' => $nodeID]);
        $nodeSelection= $this->getItemByWhere(array('type' => 'move-up','parent' => $nodeInfo['parent'], 'id' => $nodeInfo['id'], 'rgt' => $nodeInfo['lft']));
        //$nodeSelection = $this->getNodeInfo($nodeInfo, array('task' => 'move-up'));
        if (!empty($nodeSelection)) $this->moveBefore($nodeID, $nodeSelection['id']);
    }
    
    public function moveDown($nodeID, $options = null)
    {
        $nodeInfo= $this->getInfoItem($nodeID);
        //$nodeInfo = $this->collection->findOne(['id' => $nodeID]);
        $nodeSelection= $this->getItemByWhere(array('type' => 'move-down','parent' => $nodeInfo['parent'], 'id' => $nodeInfo['id'], 'lft' => $nodeInfo['rgt']));
        //$nodeSelection = $this->getNodeInfo($nodeInfo, array('task' => 'move-down'));
        if (!empty($nodeSelection)) $this->moveAfter($nodeID, $nodeSelection['id']);
    }
    
    public function updateNode($arrParam, $nodeID, $nodeParentID = null, $options = null)
    {
        $userObj	= Session::get('user');
        $userInfo	= $userObj['info'];
        $parentID   = $this->getInfoItem($nodeID);
        if (is_numeric($nodeParentID) && $parentID['parent'] != $nodeParentID) {
            
            $nodeParentInfo= $this->getInfoItem((int)$nodeParentID);
            if (!empty($nodeParentInfo)) {
                $this->moveRight($nodeID, $nodeParentID);
                if ($this->countItemParentById($nodeID) > 0) {
                    //$listChildItem = $this->getItemByParentID($nodeID);
                    $listChildItem= $this->getItemByWhere(array('type' => 'get-list-child','parent' => $nodeID));
                    foreach ($listChildItem as $item) {
                        $this->moveRight($item['id'], $nodeID);
                    }
                }
            }
        }
        
        $arrParam['form']['modified_at']	= date('Y-m-d', time());
        $arrParam['form']['modified_by']	= $userInfo['username'];
        $arrParam['form']['catecode'] = !empty($arrParam['form']['catecode']) ? Helper::createSlug($arrParam['form']['catecode']) : Helper::createSlug($arrParam['form']['name']);
        $data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
        
        $this->update($data, array(array('id', $arrParam['form']['id'])));
    }
    
    public function removeNode($nodeID, $options)
    {
        switch ($options['type']) {
            case 'only':
                $this->removeNodeOnly($nodeID);
                break;
            case 'branch':
            default:
                $this->removeBranch($nodeID);
                break;
        }
        
    }
    
    public function removeBranch($nodeID)
    {
        $this->detachBranch($nodeID, array('task' => 'remove-node'));
    }
    
    public function removeNodeOnly($nodeID)
    {
        $nodeInfo= $this->getInfoItem($nodeID);
        $nodes= $this->getItemByWhere(array('type' => 'get-list-child','parent' => $nodeInfo['id']));
        //$nodes = $this->getListChilds($nodeInfo);
        
        if (!empty($nodes)) {
            foreach ($nodes as $node) {
                $this->moveRight($node['id'], $nodeInfo['parent']);
            }
        }
        
        $this->removeBranch($nodeID);
    }
    
    public function moveItem($arrParams = null, $options = null)
    {
        if ($options == null) {
            $arrParams['id'] = (int)$arrParams['id'];
            if ($arrParams['id'] > 0) {
                if ($arrParams['type'] == 'up') $this->moveUp($arrParams['id']);
                if ($arrParams['type'] == 'down') $this->moveDown($arrParams['id']);
                return true;
            }
        }
        return false;
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
                'alert'		=> Helper::cmsMessage(array('class' => 'success', 'content' => 'You have successfully changed the status')),
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
}