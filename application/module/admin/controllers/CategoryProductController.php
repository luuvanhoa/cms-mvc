<?php
class CategoryProductController extends Controller{
    
    public function __construct($arrParams){
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('admin/main/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }
    
    // ACTION: LIST GROUP
    public function indexAction(){
        $this->_view->_title 		= 'Category Product Manager :: List';
        $this->_view->Items 		= $this->_model->listItem($this->_arrParam, null);
        //$this->_view->nodeParentInfo= $this->_model->itemInSelectbox($this->_arrParam, null);
        $this->_view->render('category-product/index');
    }
    
    // ACTION: ADD & EDIT GROUP
    public function formAction(){
        $this->_view->_title = 'Category Product :: Add';
        $this->_view->slbCategory		= $this->_model->itemInSelectbox($this->_arrParam, null);
        if(isset($this->_arrParam['id'])){
            $this->_view->_title = 'Category Product Manager :: Edit';
            $this->_arrParam['form'] = $this->_model->getInfoItem($this->_arrParam['id']);
            if(empty($this->_arrParam['form'])) URL::redirect('admin', 'categoryProduct', 'index');
        }
        
        if(@$this->_arrParam['form']['token'] > 0){
            $validate = new Validate($this->_arrParam['form']);
            $validate->addRule('name', 'string', array('min' => 3, 'max' => 255))
                     ->addRule('status', 'status', array('deny' => array('default')))
                     ->addRule('position', 'int', array('min' => 1, 'max' => 100))
                     ->addRule('position_footer', 'int', array('min' => 1, 'max' => 100))
                     ->addRule('meta_title', 'string', array('min' => 3, 'max' => 255))
                     ->addRule('meta_description', 'string', array('min' => 3, 'max' => 255));
            
            $validate->run();
            $this->_arrParam['form'] = $validate->getResult();
            if($validate->isValid() == false){
                $this->_view->errors = $validate->showErrors();
            }else{
                $task	= (!empty($this->_arrParam['form']['id'])) ? 'edit' : 'add';
                $id	= $this->_model->saveItem($this->_arrParam, array('task' => $task));
                if($this->_arrParam['type'] == 'save-close') 	URL::redirect('admin', 'categoryProduct', 'index');
                if($this->_arrParam['type'] == 'save-new') 		URL::redirect('admin', 'categoryProduct', 'form');
                if($this->_arrParam['type'] == 'save') 			URL::redirect('admin', 'categoryProduct', 'form', array('id' => $id));
            }
        }
        
        $this->_view->arrParam = $this->_arrParam;
        $this->_view->render('category-product/form');
    }
    
    // ACTION: AJAX STATUS (*)
    public function ajaxStatusAction(){
        $result = $this->_model->changeStatus($this->_arrParam, array('task' => 'change-ajax-status'));
        echo json_encode($result);
    }
    
    // ACTION: STATUS (*)
    public function statusAction(){
        $this->_model->changeStatus($this->_arrParam, array('task' => 'change-status'));
        URL::redirect('admin', 'categoryProduct', 'index');
    }
    
    // ACTION: DELETE (*)
    public function deleteAction(){
        $this->_model->deleteItem($this->_arrParam);
        URL::redirect('admin', 'categoryProduct', 'index');
    }
    
    
    // ACTION: ORDERING (*)
    public function orderingAction(){
        $this->_model->ordering($this->_arrParam);
        URL::redirect('admin', 'categoryProduct', 'index');
    }
    
    public function moveNodeAction(){
        $this->_model->moveItem($this->_arrParam);
        URL::redirect('admin', 'categoryProduct', 'index');
    }
}