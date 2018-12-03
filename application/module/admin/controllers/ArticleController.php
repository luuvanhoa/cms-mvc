<?php
class ArticleController extends Controller{
    
    public function __construct($arrParams){
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('admin/main/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }
    
    // ACTION: LIST ARTICLE
    public function indexAction(){
        $this->_view->_title 		= 'Article Manager :: List';
        $this->_view->Items 		= $this->_model->listItem($this->_arrParam, null);
        $this->_view->render('article/index');
    }
    
    
    // ACTION: ADD & EDIT ARTICLE
    public function formAction(){
        $this->_view->_title = 'Article :: Add';
        $this->_view->slbCategory		= $this->_model->itemInSelectbox($this->_arrParam, null);
        $this->_view->listKeyWord       = $this->_model->getItem($this->_arrParam, array('task' => 'get-keyword'));
        $this->_view->listAuthor        = $this->_model->getItem($this->_arrParam, array('task' => 'get-author'));
        if(isset($this->_arrParam['id'])){
            $this->_view->_title = 'Article Manager :: Edit';
            $this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam);
            $this->_arrParam['form']['keyword'] = $this->_model->getItem($this->_arrParam, array('task' => 'get-keyword-select'));
            $this->_arrParam['form']['author'] = $this->_model->getItem($this->_arrParam, array('task' => 'get-author-select'));
            if(empty($this->_arrParam['form'])) URL::redirect('admin', 'article', 'index');
        }
        
        if(@$this->_arrParam['form']['token'] > 0){
            if(!empty($_FILES['thumbnail'])) $this->_arrParam['form']['thumbnail_url'] = $_FILES['thumbnail'];
            $validate = new Validate($this->_arrParam['form']);
            $validate->addRule('title', 'string', array('min' => 3, 'max' => 255))
                    ->addRule('description', 'string', array('min' => 3, 'max' => 255))
                    ->addRule('content', 'string', array('min' => 3, 'max' => 3000))
                    ->addRule('publish_time', 'string', array('min' => 3, 'max' => 255))
                    ->addRule('ordering', 'int', array('min' => 1, 'max' => 100))
                    ->addRule('category_orginal', 'status', array('deny' => array('default')))
                    ->addRule('thumbnail_url', 'file', array('min' => 1, 'max' => 1000000, 'extension' => array('jpg', 'JPG', 'png', 'jpeg')), false);
            $validate->run();
            $this->_arrParam['form'] = $validate->getResult();
            if($validate->isValid() == false){
                $this->_view->errors = $validate->showErrors();
            }else{
                $task	= (!empty($this->_arrParam['form']['id'])) ? 'edit' : 'add';
                $id	= $this->_model->saveItem($this->_arrParam, array('task' => $task));
                if($this->_arrParam['type'] == 'save-close') 	URL::redirect('admin', 'article', 'index');
                if($this->_arrParam['type'] == 'save-new') 		URL::redirect('admin', 'article', 'form');
                if($this->_arrParam['type'] == 'save') 			URL::redirect('admin', 'article', 'form', array('id' => $id));
            }
        }
        $this->_view->arrParam = $this->_arrParam;
        $this->_view->render('article/form');
    }
    
    // ACTION: AJAX STATUS (*)
    public function ajaxStatusAction(){
        $result = $this->_model->changeStatus($this->_arrParam, array('task' => 'change-ajax-status'));
        echo json_encode($result);
    }
    
    // ACTION: STATUS (*)
    public function statusAction(){
        $this->_model->changeStatus($this->_arrParam, array('task' => 'change-status'));
        URL::redirect('admin', 'article', 'index');
    }
    
    // ACTION: DELETE (*)
    public function deleteAction(){
        $this->_model->deleteItem($this->_arrParam);
        URL::redirect('admin', 'article', 'index');
    }
    
    
    // ACTION: ORDERING (*)
    public function orderingAction(){
        $this->_model->ordering($this->_arrParam);
        URL::redirect('admin', 'article', 'index');
    }
}