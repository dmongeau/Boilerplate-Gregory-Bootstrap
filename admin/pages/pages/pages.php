<?php
		
Kate::requireModel('Page');

$this->addScript('/statics/js/modules/pages.js');
$this->addStylesheet('/statics/css/modules/pages.css');

ini_set('display_errors',1);
error_reporting(E_ALL);

switch($ACTION) {
	
	case 'add':
	case 'edit':
		
		try {
			
			if(isset($_REQUEST['id'])) {
				$Item = new Page($_REQUEST['id']);
				$item = $Item->fetch();
				$documents = $Item->getDocuments();
			} else {
				$item = $_POST;
				$documents = array();
			}
		
			if($_POST) {
				
				try {
					
					
					$in = $_POST;
					if(!isset($Item)) {
						$in['author'] = $this->auth->getIdentity()->uid;
						$in['published'] = 1;
					} else {
						if(isset($in['author']))  unset($in['author']);
						if(isset($in['published']))  unset($in['published']);
					}
					
					if(!isset($Item)) $Item = new Page();
					$Item->setData($in);
					$Item->validate();
					$Item->save();
					
					
					/*
					 *
					 * Documents
					 *
					 */
					//Get inputs
					$documents = array();
					for($i = 0; $i < sizeof($_POST['documents_did']); $i++) {
						$file = Bob::create('array',$_FILES['documents_file'])->getByIndex($i);
						if(
							empty($_POST['documents_title'][$i]) || 
							(empty($_POST['documents_did'][$i]) && 
								(!isset($file['size']) || empty($file['size']) || (isset($file['error']) && !empty($file['error'])))
							)
						) {
							continue;	
						}
						$documents[$i] = array(
							'pid' => $Item->getPrimary(),
							'did' => $_POST['documents_did'][$i],
							'title' => $_POST['documents_title'][$i],
							'lang' => $_POST['documents_lang'][$i],
							'file' => $file,
							'published' => 1,
							'deleted' => 0
						);
					}
					
					//Update documents
					$dids = array();
					if(sizeof($documents)) {
						Kate::requireModel('Document');
						foreach($documents as $document) {
							try {
								if((int)$document['did'] > 0) $Document = new Document($document['did']);
								else $Document = new Document();
								$Document->setData($document);
								$Document->save();
								$file = $document['file'];
								if(
									isset($file['size']) && !empty($file['size']) && 
									(!isset($file['error']) || empty($file['error']))
								) {
									$Document->updateFile($file);
								}
								$dids[] = $Document->getPrimary();
							} catch(Exception $e) {
								
							}
						}
					}
					
					//delete other documents
					$deleteWhere = array();
					$deleteWhere[] = $this->db->quoteInto('pid = ?',$Item->getPrimary());
					if(sizeof($dids)) {
						$deleteWhere[] = 'did NOT IN('.$this->db->quote($dids).')';
					}
					$this->db->update('documents',array('deleted'=>1),implode(' AND ',$deleteWhere));
					
					
					if($FORMAT == 'json') {
						
						$item = $Item->fetch();
						Gregory::JSON(array('success'=> true, 'response' => $item));
						
					} else {
						
						$nextUrl = (isset($_REQUEST['next']) && !empty($_REQUEST['next'])) ? $_REQUEST['next']:'/pages/';
						if($Item->isNew()) $message = 'La page a été ajoutée avec succès';
						else $message = 'La page a été mise à jour avec succès';
						$this->redirectWithSuccessMessage($nextUrl,$message);
					}
				
				//Erreur dans le formulaire
				} catch(Exception $e) {
					
					$Item->cancel();
					if($Item->isNew()) unset($Item);
					
					if($FORMAT == 'json') {
						Gregory::JSON(array(
							'success' => false,
							'error' => $this->getMessagesByCategory('error')
						));
					}
				}
				
			}
			
		} catch(Exception $e) {
			$this->redirectWithErrorMessage('/pages/',$e->getMessage());
		}
		
		$this->addScript('/statics/ckeditor/ckeditor.js');
		$this->addScript('/statics/ckfinder/ckfinder.js');
		
		$this->addScript('/statics/js/modules/pages.form.js');
		$this->addStylesheet('/statics/css/modules/pages.form.css');
		
		include PATH_MODULE_PAGES_PUBLIC.'/form.php';
	
	break;
	
	case 'order':
		
		$this->setLayout(null);
			
		try {
			
			if(!isset($_REQUEST['ids']) || empty($_REQUEST['ids'])) throw new Exception('Aucun ID');
			
			$ids = explode(',',$_REQUEST['ids']);
			if(!sizeof($ids)) throw new Exception('Aucun ID');
			
			$i = 1;
			foreach($ids as $id) {
				$Page = new Page($id);
				$Page->setData(array(
					'order' => $i
				));
				$Page->save();
				$i++;
			}
			
			Gregory::JSON(array('success'=>true,'response'=>$ids));
			
		} catch(Exception $e) {
			Gregory::JSON(array('success'=>false,'error'=>$e->getMessage()));
		}
	
	break;
	
	case 'delete':
	
		try {
			
			$Item = new Page($_REQUEST['id']);
			$item = $Item->fetch();
			
			if(isset($_REQUEST['confirm']) && (int)$_REQUEST['confirm'] == 1) {
				
				$Item->delete();
				
				if($FORMAT == 'json') {
				
					Gregory::JSON(array(
						'success' => true,
						'response' => $item
					));
				
				} else {
					
					$nextUrl = (isset($_REQUEST['next']) && !empty($_REQUEST['next'])) ? $_REQUEST['next']:'/pages/';
					$message = 'La page a été supprimé avec succès';
					$this->redirectWithSuccessMessage($nextUrl,$message);
					
				}
				
			}
			
		} catch(Exception $e) {
			if($FORMAT == 'json') {
				Gregory::JSON(array(
					'success' => false,
					'error' => $e->getMessage()
				));
			} else {
				$this->redirectWithErrorMessage('/pages/',$e->getMessage());
			}
		}
		
		include PATH_MODULE_PAGES_PUBLIC.'/delete.php';
		
	break;
	
	default:
		
		$query = array(
			'deleted' => 0,
			'order by' => array('section asc','order asc')
		);
		
		
		$Items = new Page();
		$_items = $Items->getItems($query);
		
		
		//Build page tree
		$tree = array();
		foreach($this->data['sites'] as $siteKey => $site) {
			$tree[$siteKey] = array();
			foreach($site['sections'] as $sectionKey => $section) {
				$tree[$siteKey][$sectionKey] = $section;
				$tree[$siteKey][$sectionKey]['items'] = array();
			}
		}
		foreach($_items as $_item) {
			$parts = explode('_',$_item['section']);
			if(sizeof($parts) == 2 && isset($tree[$parts[0]][$parts[1]])) {
				$tree[$parts[0]][$parts[1]]['items'][] = $_item;
			}
		}
		
		include PATH_MODULE_PAGES_PUBLIC.'/index.php';
	
	break;
	
}

