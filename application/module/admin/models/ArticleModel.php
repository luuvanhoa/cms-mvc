<?php
class ArticleModel extends Model{
    private $_columns = array('id', 'title', 'description', 'content','publish_time', 'creation_time', 'update_time','thumbnail_url', 'share_url', 'category_orginal', 'catelist', 'status', 'ordering');
    private $_userInfo;
    
    public function __construct(){
		parent::__construct();
		$this->setTable(TBL_ARTICLE);
		
		$userObj 			= Session::get('user');
		$this->_userInfo 	= $userObj['info'];
    }

    public function infoItem($arrParam, $option = null){
        if($option == null){
            $query[]    = "SELECT *";
            $query[]    = "FROM `$this->table`";
            $query[]	= "WHERE `id` = '" . $arrParam['id'] . "'";
            $query		= implode(" ", $query);
            $result		= $this->fetchRow($query);
            return $result;
        }
    }
    
    public function itemInSelectbox($arrParam, $option = null){
        if($option == null){
            $query 	= "SELECT `id`, `name` FROM `" . TBL_CATEGORY_ARTICLE . "`";
            $result = $this->fetchPairs($query);
            $result['default'] = "-- Select Category --";
            ksort($result);
        }
        return $result;
    }

    public function getItem($arrParam, $option = null){
        if($option['task'] == 'get-keyword'){
            $result     = array();
            $query[]    = "SELECT `name`";
            $query[]    = "FROM `".TBL_TAG."`";
            $query[]    = "WHERE `status` =  1";
            $query      = implode(" ", $query);
            $data       = $this->fetchAll($query);
            foreach ($data as $value) {
                $result[] = $value['name'];
            }
        }

        if($option['task'] == 'get-author'){
            $result     = array();
            $query[]    = "SELECT `id`,`name`";
            $query[]    = "FROM `".TBL_AUTHOR."`";
            $query[]    = "WHERE `status` =  1";
            $query      = implode(" ", $query);
            $data       = $this->fetchAll($query);
            foreach ($data as $value) {
                $result[$value['id']] = $value['name'];
            }
        }

        if($option['task'] == 'get-keyword-select'){
            $result     = array();
            $query[]    = "SELECT `tag`.`name`";
            $query[]    = "FROM `".TBL_OBJECT_ARTICLE."` AS `ob`";
            $query[]    = "JOIN `".TBL_TAG."` AS `tag` ON `tag`.`id` = `ob`.`object_id`";
            $query[]    = "WHERE `ob`.`status` =  1";
            $query[]    = "AND `ob`.`object_type` = 1";
            $query[]    = "AND `ob`.`article_id` = ".$arrParam['id'];
            $query      = implode(" ", $query);
            $data       = $this->fetchAll($query);
            foreach ($data as $value) {
                $result[] = $value['name'];
            }
            $result = implode(",", $result);
        }

        if($option['task'] == 'get-author-select'){
            $result     = array();
            $query[]    = "SELECT `object_id`";
            $query[]    = "FROM `".TBL_OBJECT_ARTICLE."`";
            $query[]    = "WHERE `status` =  1";
            $query[]    = "AND `object_type` = 2";
            $query[]    = "AND `article_id` = ".$arrParam['id'];
            $query      = implode(" ", $query);
            $data       = $this->fetchAll($query);
            foreach ($data as $value) {
                $result[] = $value['object_id'];
            }
        }
        return $result;
    }
    
    public function listItem($arrParam, $option = null){
        $query[]    = "SELECT `ar`.`id`, `ar`.`title`, `ar`.`description`, `ar`.`content`, `ar`.`publish_time`, `ar`.`creation_time`, `ar`.`update_time`, `ar`.`thumbnail_url`, `ar`.`share_url`, `ar`.`category_orginal`, `ar`.`catelist`, `ar`.`status`, `ar`.`ordering`, `ca`.`name` AS `categoryName`";
        $query[]    = "FROM `$this->table` AS `ar`";
        $query[]    = "JOIN `".TBL_CATEGORY_ARTICLE."` AS `ca` ON `ca`.`id` = `ar`.`category_orginal`";
        $query		= implode(" ", $query);
        $result		= $this->fetchAll($query);
        return $result;
    }
    
    public function changeStatus($arrParam, $option = null){
        if($option['task'] == 'change-ajax-status'){
            //SHARE_URL
            if($arrParam['status'] == 0){
                $infoItem     = $this->infoItem($arrParam);
                $titleURL     = Helper::createSlug($infoItem['title']);
                $idArticle    = $arrParam['id'];
                $catecode     = $this->getCatecode($infoItem['category_orginal']);
                $share_url    = "/$catecode/$titleURL-$idArticle.html";
            }else{
                $share_url  = '';
            }
            $status 		= ($arrParam['status'] == 0) ? 1 : 0;
            $update_time	= date('Y-m-d H:m:s', time());
            $id				= $arrParam['id'];
            $query	= "UPDATE `$this->table` SET `status` = $status, `share_url` = '$share_url', `update_time` = '$update_time' WHERE `id` = '" . $id . "'";
            $this->execute($query);
    
            $result = array(
                'id'		=> $id,
                'status'	=> $status,
                'link'		=> URL::createLink('admin', 'article', 'ajaxStatus', array('id' => $id, 'status' => $status)),
                'alert'     => Helper::cmsMessage(array('class' => 'success', 'content' => 'You have successfully changed the pulish!')),
                'share_url' => $share_url,
            );
            return $result;
        }
        
        if($option['task'] == 'change-status'){
            $status 		= $arrParam['type'];
            $update_time		= date('Y-m-d H:m:s', time());
            if(!empty($arrParam['cid'])){
                $ids		= $this->createWhereDeleteSQL($arrParam['cid']);
                $query		= "UPDATE `$this->table` SET `status` = $status, `update_time` = '$update_time' WHERE `id` IN ($ids)";
                $result = $this->execute($query);
                foreach ($arrParam['cid'] as $id) {
                    if($status == 1){
                        $infoItem     = $this->infoItem(array('id' => $id));
                        $titleURL     = Helper::createSlug($infoItem['title']);
                        $idArticle    = $id;
                        $catecode     = $this->getCatecode($infoItem['category_orginal']);
                        $share_url    = "/$catecode/$titleURL-$idArticle.html";
                    }else{
                        $share_url = '';
                    }
                    $queryShareURL      = "UPDATE `$this->table` SET `share_url` = '$share_url' WHERE `id` = $id";
                    $this->execute($queryShareURL);
                }
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
				$query		= "UPDATE `$this->table` SET `status` = 2, `share_url` = '' WHERE `id` IN ($ids)";
				$result = $this->execute($query);
				Session::set('message', array('class' => 'success', 'content' => 'There are ' . $result->rowCount(). ' elements deleted'));
                /*//DELETE IMAGE
                require_once(LIBRARY_EXT_PATH.'Upload.php');
                $uploadObj = new Upload();
                foreach ($arrParam['cid'] as $id) {
                    $avatarName = $this->getNameImage($id);
                    $uploadObj->removeFile('avatar', $avatarName);
                    $uploadObj->removeFile('avatar', '150x150-'.$avatarName);
                    //DELETE OBEJCT_ARTICLE
                    $queryDelete = "DELETE FROM `".TBL_OBJECT_ARTICLE."` WHERE `article_id` = ".$id;
                    $this->execute($queryDelete);
                }*/
			}else{
				Session::set('message', array('class' => 'error', 'content' => 'Please select the delete element!'));
			}
		}
    }

    public function getNameImage($id){
        $query  = "SELECT `thumbnail_url` FROM `".TBL_ARTICLE."` WHERE `id` = $id";
        $result = $this->fetchRow($query);
        return  $result['thumbnail_url'];
    }
    
    public function saveItem($arrParam, $option = null){
        require_once(LIBRARY_EXT_PATH.'Upload.php');
        $uploadObj = new Upload();
		if($option['task'] == 'add'){
            $arrParam['form']['status']                = 0;              
            $arrParam['form']['thumbnail_url']         = $uploadObj->uploadFile($arrParam['form']['thumbnail_url'], 'thumbnail', 150, 150);
			$arrParam['form']['creation_time']	= date('Y-m-d H:m:s', time());
            $arrParam['form']['publish_time']   = date('Y-m-d', strtotime($arrParam['form']['publish_time']));
            //INSERT ACTICLE
			$data	       = array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$article_id    = $this->insert($data);
            //INSERT OBJECT_ARTICLE
            //TYPE = 1
            if(!empty($arrParam['form']['keyword'])){
                $arrKeyword = explode(",", $arrParam['form']['keyword']);
                foreach ($arrKeyword as $keyword) {
                   $idKeyword     = $this->getIDTag($keyword);
                   $creation_time = date('Y:m:d H:m:s', time());
                   $dataObject = array('article_id' => $article_id, 'object_id' => $idKeyword, 'object_type' => 1, 'status' => 1, 'creation_time' => $creation_time);
                   $this->insert($dataObject, 'single', TBL_OBJECT_ARTICLE);
                }
            }
            //TYPE = 2 
           if(!empty($arrParam['form']['author'])){
                $arrAuthor = $arrParam['form']['author'];
                foreach ($arrAuthor as $author) {
                   $idAuthor      = $author;
                   $creation_time = date('Y:m:d H:m:s', time());
                   $dataObject = array('article_id' => $article_id, 'object_id' => $idAuthor, 'object_type' => 2, 'status' => 1, 'creation_time' => $creation_time);
                   $this->insert($dataObject, 'single', TBL_OBJECT_ARTICLE);
                }
           }

			Session::set('message', array('class' => 'success', 'content' => 'Data saved successfully!'));
			return $article_id;
		}
		if($option['task'] == 'edit'){
            if($arrParam['form']['thumbnail_url']['name'] == null){
                unset($arrParam['form']['thumbnail_url']);
            }else{
                $uploadObj->removeFile('thumbnail', $arrParam['form']['thumbnail_url']);
                $uploadObj->removeFile('thumbnail', '150x150-'.$arrParam['form']['thumbnail_url']);
                $arrParam['form']['thumbnail_url'] = $uploadObj->uploadFile($arrParam['form']['thumbnail_url'], 'thumbnail', 150, 150);
            }
			$arrParam['form']['modified_time']	= date('Y-m-d H:m:s', time());
            //SHARE_URL <=> PUBLISH
            $titleURL     = Helper::createSlug($arrParam['form']['title']);
            $idArticle    = $arrParam['form']['id'];
            $catecode = $this->getCatecode($arrParam['form']['category_orginal']);
            if($arrParam['form']['status'] == 1){
                $arrParam['form']['share_url'] = "/$catecode/$titleURL-$idArticle.html";
            }else{
                $arrParam['form']['share_url'] = null;
            }
			$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->update($data, array(array('id', $arrParam['form']['id'])));
            //UPDATE OBJECT ARTICLE
            $queryDelete = "DELETE FROM `".TBL_OBJECT_ARTICLE."` WHERE `article_id` = ".$arrParam['form']['id'];
            $this->execute($queryDelete);
            //TYPE = 1
            if(!empty($arrParam['form']['keyword'])){
                $arrKeyword = explode(",", $arrParam['form']['keyword']);
                foreach ($arrKeyword as $keyword) {
                   $idKeyword     = $this->getIDTag($keyword);
                   $modified_time = date('Y:m:d H:m:s', time());
                   $dataObject = array('article_id' => $arrParam['form']['id'], 'object_id' => $idKeyword, 'object_type' => 1, 'status' => 1, 'modified_time' => $modified_time);
                   $this->insert($dataObject, 'single', TBL_OBJECT_ARTICLE);
                }
           }
            //TYPE = 2 
           if(!empty($arrParam['form']['author'])){
                $arrAuthor = $arrParam['form']['author'];
                foreach ($arrAuthor as $author) {
                   $idAuthor      = $author;
                   $creation_time = date('Y:m:d H:m:s', time());
                   $dataObject = array('article_id' => $arrParam['form']['id'], 'object_id' => $idAuthor, 'object_type' => 2, 'status' => 1, 'modified_time' => $modified_time);
                   $this->insert($dataObject, 'single', TBL_OBJECT_ARTICLE);
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
	            $update_time		= date('Y-m-d H:m:s', time());
	            foreach($arrParam['ordering'] as $id => $ordering){
	                $i++;
	                $query	= "UPDATE `$this->table` SET `ordering` = $ordering, `update_time` = '$update_time' WHERE `id` = '" . $id . "'";
	                $this->execute($query);
	            }
	            Session::set('message', array('class' => 'success', 'content' => 'There are ' .$i. ' element is changed ordering!'));
	        }
	    }
	}

    protected function getIDTag($tag_name){
        $query = "SELECT `id` FROM `".TBL_TAG."` WHERE `name` = '$tag_name' LIMIT 0,1";
        $result = $this->fetchRow($query);
        return $result['id'];
    }

    protected function getCatecode($category_id){
        $query = "SELECT `catecode` FROM `".TBL_CATEGORY_ARTICLE."` WHERE `id` = $category_id";
        $result = $this->fetchRow($query);
        return $result['catecode'];
    }
}