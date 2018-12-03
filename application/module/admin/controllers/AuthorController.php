<?php
class AuthorController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	// ACTION: LIST AUTHOR
	public function indexAction(){
		$this->_view->_title 		= 'Author Manager :: List';
		
		$this->_view->Items 		= $this->_model->listItem($this->_arrParam, null);
		$this->_view->render('author/index');
	}
	
	// ACTION: ADD & EDIT AUTHOR
	public function formAction(){
		$this->_view->_title = 'Author Manager: Add';
		$task = 'add';
		if(isset($this->_arrParam['id'])){
			$task = 'edit';
			$this->_view->_title = 'Author Manager: Edit';
			$this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam);
			if(empty($this->_arrParam['form'])) URL::redirect('admin', 'author', 'index');
		}
		
		if(@$this->_arrParam['form']['token'] > 0){
			if(!empty($_FILES['avatar'])) $this->_arrParam['form']['avatar'] = $_FILES['avatar'];
			$validate = new Validate($this->_arrParam['form']);
			$validate->addRule('name', 'string', array('min' => 3, 'max' => 30))
					 ->addRule('status', 'status', array('deny' => array('default')))
					 ->addRule('avatar', 'file', array('min' => 1, 'max' => 1000000, 'extension' => array('jpg', 'JPG', 'png')), false);
			$validate->run();
			$this->_arrParam['form'] = $validate->getResult();
			if($validate->isValid() == false){
				$this->_view->errors = $validate->showErrors();
			}else{
				$task = !empty($this->_arrParam['form']['id']) ? 'edit': 'add';
				$id	= $this->_model->saveItem($this->_arrParam, array('task' => $task));
				if($this->_arrParam['type'] == 'save-close') 	URL::redirect('admin', 'author', 'index');
				if($this->_arrParam['type'] == 'save-new') 		URL::redirect('admin', 'author', 'form');
				if($this->_arrParam['type'] == 'save') 			URL::redirect('admin', 'author', 'form', array('id' => $id));
			}
		}
		
		$this->_view->arrParam = $this->_arrParam;
		$this->_view->render('author/form');
	}
	
	// ACTION: AJAX STATUS (*)
	public function ajaxStatusAction(){
		$result = $this->_model->changeStatus($this->_arrParam, array('task' => 'change-ajax-status'));
		echo json_encode($result);
	}
	
	// ACTION: STATUS (*)
	public function statusAction(){
		$this->_model->changeStatus($this->_arrParam, array('task' => 'change-status'));
		URL::redirect('admin', 'author', 'index');
	}
	
	// ACTION: TRASH (*)
	public function deleteAction(){
		$this->_model->deleteItem($this->_arrParam);
		URL::redirect('admin', 'author', 'index');
	}
}