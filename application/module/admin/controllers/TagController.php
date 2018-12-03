<?php
class TagController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	// ACTION: LIST TAG
	public function indexAction(){
		$this->_view->_title 		= 'Tag Manager :: List';
		$this->_view->Items 		= $this->_model->listItem($this->_arrParam, null);
		$this->_view->render('tag/index');
	}
	
	// ACTION: ADD & EDIT TAG
	public function formAction(){
		$this->_view->_title = 'Tag Manager :: Add';

		if(isset($this->_arrParam['id'])){
			$this->_view->_title = 'Tag Manager :: Edit';
			$this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam);
			if(empty($this->_arrParam['form'])) URL::redirect('admin', 'tag', 'index');
		}
		
		if(@$this->_arrParam['form']['token'] > 0){
			$validate = new Validate($this->_arrParam['form']);
			$queryName	= "SELECT `id` FROM `".TBL_TAG."` WHERE `name` = '".@$this->_arrParam['form']['name']."'";
			if(!empty($this->arrParam['form']['id'])){
				$queryName 	.= " AND `id` <> '".$this->_arrParam['form']['id']."'";
			}
			$validate->addRule('name', 'string-notExistRecord', array('min' => 3, 'max' => 255, 'database' => $this->_model, 'query' => $queryName))
					 ->addRule('status', 'status', array('deny' => array('default')));
			$validate->run();
			$this->_arrParam['form'] = $validate->getResult();
			if($validate->isValid() == false){
				$this->_view->errors = $validate->showErrors();
			}else{
				$task	= (!empty($this->_arrParam['form']['id'])) ? 'edit' : 'add';
				$id	= $this->_model->saveItem($this->_arrParam, array('task' => $task));
				if($this->_arrParam['type'] == 'save-close') 	URL::redirect('admin', 'tag', 'index');
				if($this->_arrParam['type'] == 'save-new') 		URL::redirect('admin', 'tag', 'form');
				if($this->_arrParam['type'] == 'save') 			URL::redirect('admin', 'tag', 'form', array('id' => $id));
			}
		}
		
		$this->_view->arrParam = $this->_arrParam;
		$this->_view->render('tag/form');
	}

	// ACTION: AJAX STATUS (*)
	public function ajaxStatusAction(){
		$result = $this->_model->changeStatus($this->_arrParam, array('task' => 'change-ajax-status'));
		echo json_encode($result);
	}
		
	// ACTION: STATUS (*)
	public function statusAction(){
		$this->_model->changeStatus($this->_arrParam, array('task' => 'change-status'));
		URL::redirect('admin', 'tag', 'index');
	}
	
	// ACTION: DELETE (*)
	public function deleteAction(){
		$this->_model->deleteItem($this->_arrParam);
		URL::redirect('admin', 'tag', 'index');
	}
}