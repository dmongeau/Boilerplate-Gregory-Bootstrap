<?php

switch($ACTION) {
	
	case 'logout':

		try {
			
			$this->auth->logout();
			
			if(!Gregory::isAJAX()) {
				if(isset($_REQUEST['next']) && !empty($_REQUEST['next'])) Gregory::redirect($_REQUEST['next']);
				else Gregory::redirect('/accueil.html');
			} else {
				Gregory::JSON(array('success'=>true));
			}
			
		} catch(Zend_Exception $e) {
			
			if(!Gregory::isAJAX()) $error = 'Il s\'est produit une erreur';
			else Gregory::JSON(array('success'=>false, 'error'=>'Il s\'est produit une erreur'));
			
		} catch(Exception $e) {
			
			if(!Gregory::isAJAX()) $error = $e->getMessage();
			else Gregory::JSON(array('success'=>false, 'error'=>$e->getMessage()));
			
		}
	
	break;
	
	default:

		if($this->auth->isLogged()) {
			if(isset($_REQUEST['next']) && !empty($_REQUEST['next'])) Gregory::redirect($_REQUEST['next']);
			else Gregory::redirect('/');	
		}
		
		if($_POST) {
			
			try {
				
				if(!isset($_POST['email']) || !isset($_POST['pwd']) || empty($_POST['email']) || empty($_POST['pwd'])) {
					throw new Exception('Vous devez entrer votre adresse courriel et votre mot de passe.');	
				}
				
				Kate::requireModel('User');
				
				$this->addFilter('auth.login.identity',array('User','filterIdentity'));
				$this->addAction('auth.login.valid',array('User','loggedIn'));
				
				$user = $this->auth->login(Bob::x('ne',$_POST,'email'),Bob::x('ne',$_POST,'pwd'),false);
				
				if((int)$user->tmpPwd == 1) {
					Gregory::redirect('/connexion/changement-mot-de-passe.html?next='.rawurlencode(Bob::x('ne',$_REQUEST,'next')));
				}
				
				if(!Gregory::isAJAX()) {
					if(isset($_REQUEST['next']) && !empty($_REQUEST['next'])) Gregory::redirect($_REQUEST['next']);
					else Gregory::redirect('/');
				} else {
					Gregory::JSON(array('success'=>true,'user'=>$user));
				}
				
			} catch(Zend_Exception $e) {
				
				if(!Gregory::isAJAX()) $this->addError('Il s\'est produit une erreur',500,$e);
				else Gregory::JSON(array('success'=>false, 'error'=>'Il s\'est produit une erreur'));
				
			} catch(Exception $e) {
				
				if(!Gregory::isAJAX()) $this->addError($e->getMessage(),$e->getCode(),$e);
				else Gregory::JSON(array('success'=>false, 'error'=>$e->getMessage()));
				
			}
			
		}
		
		include PATH_MODULE_LOGIN_PUBLIC.'/index.php';
	
	break;
	
}

