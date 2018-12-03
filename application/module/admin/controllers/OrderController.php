<?php
class OrderController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	// ACTION: LIST USER
	public function indexAction(){
		$this->_view->_title 		= 'Order Manager :: List';
		
		$this->_view->Items 		= $this->_model->listItem($this->_arrParam, null);
		$this->_view->render('order/index');
	}
	
	public function detailAction(){
	    $this->_view->_title 		= 'Order Detail :: List';
	    $this->_view->infoOrder     = $this->_model->infoItem($this->_arrParam['id'], null);
	    $this->_view->Items 		= $this->_model->listItemOrderDetail($this->_arrParam['id'], null);
	    $this->_view->render('order/detail');
	}
	
	// ACTION: ADD & EDIT GROUP
	public function formAction(){
		$this->_view->_title = 'Product Manager: Add';
		$this->_view->slbCategory		= $this->_model->itemInSelectbox($this->_arrParam, null);
		//$this->_view->slbGroup		= $this->_model->itemInSelectbox($this->_arrParam, null);
		
		if(isset($this->_arrParam['id'])){
			$this->_view->_title = 'Product Manager: Edit';
			$this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam);
			if(empty($this->_arrParam['form'])) URL::redirect('admin', 'product', 'index');
		}
		
		if(@$this->_arrParam['form']['token'] > 0){
			if(!empty($_FILES['image'])) $this->_arrParam['form']['image'] = $_FILES['image'];
			$task			= 'add';
			$queryName	= "SELECT `id` FROM `".TBL_PRODUCT."` WHERE `name` = '".@$this->_arrParam['form']['name']."'";
			if(!empty($this->_arrParam['form']['id'])){
				$task			 = 'edit';
				$queryName      .= " AND `id` <> '".$this->_arrParam['form']['id']."'";
			}
	
			$validate = new Validate($this->_arrParam['form']);
			$validate->addRule('name', 'string-notExistRecord', array('database' => $this->_model, 'query' => $queryName, 'min' => 3, 'max' => 25))
			         ->addRule('price', 'int', array('min' => 1, 'max' => 100000000000000))
					 ->addRule('ordering', 'int', array('min' => 1, 'max' => 100))
					 ->addRule('status', 'status', array('deny' => array('default')))
					 ->addRule('category_product_id', 'status', array('deny' => array('default')))
					 ->addRule('image', 'file', array('min' => 1, 'max' => 1000000, 'extension' => array('jpg', 'JPG', 'png')), false);
			$validate->run();
			$this->_arrParam['form'] = $validate->getResult();
			if($validate->isValid() == false){
				$this->_view->errors = $validate->showErrors();
			}else{
				$id	= $this->_model->saveItem($this->_arrParam, array('task' => $task));
				if($this->_arrParam['type'] == 'save-close') 	URL::redirect('admin', 'product', 'index');
				if($this->_arrParam['type'] == 'save-new') 		URL::redirect('admin', 'product', 'form');
				if($this->_arrParam['type'] == 'save') 			URL::redirect('admin', 'product', 'form', array('id' => $id));
			}
		}
		
		$this->_view->arrParam = $this->_arrParam;
		$this->_view->render('product/form');
	}
	
	// ACTION: AJAX STATUS (*)
	public function ajaxStatusAction(){
		$result = $this->_model->changeStatus($this->_arrParam, array('task' => 'change-ajax-status'));
		echo json_encode($result);
	}
	
	// ACTION: STATUS (*)
	public function statusAction(){
		$this->_model->changeStatus($this->_arrParam, array('task' => 'change-status'));
		URL::redirect('admin', 'order', 'index');
	}
	
	// ACTION: TRASH (*)
	public function deleteAction(){
		$this->_model->deleteItem($this->_arrParam);
		URL::redirect('admin', 'order', 'index');
	}
}