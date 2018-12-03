<?php
class IndexController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
	}
	
	public function loginAction(){
		$userInfo	= Session::get('user');
		if($userInfo['login'] == true && $userInfo['time'] + TIME_LOGIN >= time()){
			URL::redirect('admin', 'index', 'index');
		}
		
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('login.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
		
		$this->_view->_title 		= 'Login - Admin';
		if(@$this->_arrParam['form']['token'] > 0){
			$validate	= new Validate($this->_arrParam['form']);
			$username	= @$this->_arrParam['form']['username'];
			$password	= md5(@$this->_arrParam['form']['password']);
			$query		= "SELECT `id` FROM `user` WHERE `username` = '$username' AND `password` = '$password'";
			$validate->addRule('username', 'existRecord', array('database' => $this->_model, 'query' => $query));
			$validate->run();
			
			if($validate->isValid()==true){
				$infoUser		= $this->_model->infoItem($this->_arrParam);
				$arraySession	= array(
										'login'		=> true,
										'info'		=> $infoUser,
										'time'		=> time(),
										'group_acp'	=> $infoUser['group_acp'],
									);
				Session::set('user', $arraySession);
				URL::redirect('admin', 'index', 'index');
			}else{
				$this->_view->errors	= $validate->showErrorsLogin();
			}
		}
		
		$this->_view->render('index/login');
	}
	
	public function indexAction(){
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	
		$this->_view->_title 		= 'Index - Admin';
	
		$this->_view->render('index/index');
	}
	
	public function profileAction(){
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
		
		$this->_view->_title 		= 'Profile';
		/* UPDATE INFO USER*/
		if(@$this->_arrParam['form']['token'] > 0){
			if (!empty($_FILES['avatar'])) $this->_arrParam['form']['avatar'] = $_FILES['avatar']; 
			$queryEmail		= "SELECT `id` FROM `".TBL_USER."` WHERE `email` = '".$this->_arrParam['form']['email']. "' AND `id` <> '".$this->_arrParam['form']['id']."'";
			$validate = new Validate($this->_arrParam['form']);
			$validate->addRule('email', 'email-notExistRecord', array('database' => $this->_model, 'query' => $queryEmail))
					 ->addRule('fullname', 'string', array('min' => 3, 'max' => 50))
					 ->addRule('avatar', 'file', array('min' => 1, 'max' => 1000000, 'extension' => array('jpg', 'JPG', 'png', 'PNG')), false);
			$validate->run();
			$this->_arrParam['form'] = $validate->getResult();
			if($validate->isValid() == false){
				$this->_view->errors = $validate->showErrors();
			}else{
				$id	= $this->_model->updateItem($this->_arrParam);
				if($this->_arrParam['type'] == 'save-close') 	URL::redirect('admin', 'index', 'index');
			}
		}
		$userObj	= Session::get('user');
		$id 		= $userObj['info']['id'];
		$this->_view->infoItem = $this->_model->infoItemId($id);
		$this->_view->render('index/profile');
	}

	public function logoutAction(){
		Session::delete('user');
		URL::redirect('admin', 'index', 'login');
	}
}