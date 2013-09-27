<?php
App::uses('AppController', 'Controller');

class MessagesController extends AppController{		
	var $uses = array('Message','Jammeur','Keyword','KeywordsMessage','Father','Email');
	var $components = array('Parser');

	function index($id=1){
		$jammeurs=$this->Jammeur->find('list');
		$jammeurs[0]="Tous, même Gamin !";
		$this->set('jammeurs',$jammeurs);
		
		$keywords=$this->Keyword->find('all');
		foreach ($keywords as $keyword) {
			$words[]=$keyword['Keyword']['keyword'];
		}
		$this->set('words',$words);
	
		//Stats	
		foreach ($jammeurs as $key => $jammeur) {
			$stats[$key]['total']=$this->Message->find('count',array('conditions'=>array('jammeur_id'=>$key)));
			$stats[$key]['preums']=$this->Message->find('count',array('conditions'=>array(
				'jammeur_id'=>$key,
				'html LIKE'=>'%preum%'
				)));
			$stats[$key]['deuz']=$this->Message->find('count',array('conditions'=>array(
				'jammeur_id'=>$key,
				'html LIKE'=>'%deuz%'
				)));
			$stats[$key]['troiz']=$this->Message->find('count',array('conditions'=>array(
				'jammeur_id'=>$key,
				'html LIKE'=>'%troiz%'
				)));
		}
		$this->set('stats',$stats);
	}
	
	function getList(){
		$response = false;
		$this->layout = 'ajax';
		if(!empty($this->data)){
			$filters=json_decode($this->data,true);
			$conditions=array();
			
			if($filters['jammeur']>0){
				$conditions['Message.jammeur_id']=$filters['jammeur'];
			}	
			if(!empty($filters['startDate'])){
				$conditions['Message.timestamp >=']=date('Y-m-d H:i:s',strtotime($filters['startDate']."00:00:00"));
			}
			if(!empty($filters['endDate'])){
				$conditions['Message.timestamp <=']=date('Y-m-d H:i:s',strtotime($filters['endDate']."23:59:59"));
			}
			
			if($filters['id']!=""){
				$conditions['Message.id']=$filters['id'];
			}

			if(!empty($filters['characters'])){
				$conditions['CHAR_LENGTH(Message.html) > ']=$filters['characters'];
			}
			
			// Filter messages
			if($filters['keyword']!=""){
					$messages=$this->Message->find('all', array('conditions'=>$conditions));
					$keyword=$this->Keyword->findByKeyword($filters['keyword']);
				}

			else{
					$messages=$this->Message->find('all', array('conditions'=>$conditions,'order'=>'Message.timestamp DESC LIMIT 20'));
			}

			foreach ($messages as $key=>$message) {
				$match=null;	
				if($filters['keyword']!=""){					
					$match=$this->KeywordsMessage->find('first', array('conditions'=>array(
							'KeywordsMessage.message_id'=>$message['Message']['id'],
							'KeywordsMessage.keyword_id'=>$keyword['Keyword']['id']
						)));
				}
				if($filters['keyword']=="" || $match){	
					$response['Messages'][$key]['id']=$message['Message']['id'];
					$response['Messages'][$key]['timestamp']=$message['Message']['timestamp'];
					
					$jammeur=$this->Jammeur->read(null,$message['Message']['jammeur_id']);
					$response['Messages'][$key]['jammeur']=$jammeur['Jammeur']['name'];
					if(strlen($message['Message']['html'])>45){
						$response['Messages'][$key]['html']=substr($message['Message']['html'],0,45)."...";
					}
					else{
						$response['Messages'][$key]['html']=$message['Message']['html'];
					}
				}
			}
			
		}
		echo json_encode($response);
	}

	function view($id){
		$message=$this->Message->read(null,$id);
			if(!$message){
				$content['404']=true;
			}
		else{
			$content['404']=false;
			$content['id']=$id;
			$jammeur=$this->Jammeur->read(null,$message['Message']['jammeur_id']);
			$content['jammeur']=$jammeur['Jammeur']['name'];
			$content['timestamp']=$message['Message']['timestamp'];
			$content['html']=$message['Message']['html'];
			$keywords=$this->KeywordsMessage->find('all',array('conditions'=>array('message_id'=>$id)));
			if($keywords){
				foreach ($keywords as $keyword) {
					$word=$this->Keyword->read(null,$keyword['KeywordsMessage']['keyword_id']);	
					$content['keywords'][]=$word['Keyword']['keyword'];
				}
			}
			else{
				$content['keywords']=null;
			}
			
			// Get Father
			$fatherMatch=$this->Father->find('first',array('conditions'=>array(
				'children_id'=>$id
			)));
			
			if($fatherMatch) {
				$father=$this->Message->read(null,$fatherMatch['Father']['father_id']);
				$content['father']['id']=$father['Message']['id'];
				$content['father']['timestamp']=$father['Message']['timestamp'];
				
				$jammeur=$this->Jammeur->read(null,$father['Message']['jammeur_id']);
				$content['father']['jammeur']=$jammeur['Jammeur']['name'];
				
				if(strlen($father['Message']['html'])>45){
					$content['father']['html']=substr($father['Message']['html'],0,45)."...";
				}
				else{
					$content['father']['html']=$father['Message']['html'];
				}
			}
			else{
				$content['father']=null;
			}

			// Get Children
			$childrenMatches=$this->Father->find('all',array('conditions'=>array(
				'father_id'=>$id
			)));
			
			if($childrenMatches){
				foreach($childrenMatches as $key=>$childrenMatch){
					$child=$this->Message->read(null,$childrenMatch['Father']['children_id']);
					$content['children'][$key]['id']=$child['Message']['id'];
					$content['children'][$key]['timestamp']=$child['Message']['timestamp'];
					
					$jammeur=$this->Jammeur->read(null,$child['Message']['jammeur_id']);
					$content['children'][$key]['jammeur']=$jammeur['Jammeur']['name'];
					
					if(strlen($child['Message']['html'])>30){
						$content['children'][$key]['html']=substr($child['Message']['html'],0,30)."...";
					}
					else{
						$content['children'][$key]['html']=$child['Message']['html'];
					}
				}
			}
			else{
				$content['children'][0]=null;
			}
			}
			
			$this->set('content',$content);
	}

	function navigate($dir,$id){
		$message=$this->Message->read(null,$id);	
		if ($dir<0){
			$match=$this->Message->find('first',array('conditions'=>array(
									'Message.timestamp < '=>  $message['Message']['timestamp'],
									),
									'order'=>'Message.timestamp DESC'
									));
		}
		else{
			$match=$this->Message->find('first',array('conditions'=>array(
									'Message.timestamp > '=>  $message['Message']['timestamp'],
									),
									'order'=>'Message.timestamp ASC'
									));
		}	
			
		if($match){
			return $this->redirect(array('action' => 'view',$match['Message']['id']));
		}
		else{
			echo "not found";
			return $this->redirect(array('action' => 'view',$id));
		}
	
	}


	function automaticImport(){
		$current_path='C:/xampp/htdocs/github/jamsession/mails/new/';
		$new_path='C:/xampp/htdocs/github/jamsession/mails/parsed/';
		//$current_path='/home/import/Maildir/new/';
		//$new_path='/home/import/Maildir/parsed/';
		
		$jammeurs=$this->Jammeur->find('all');			
		foreach ($jammeurs as $jammeur) {
			foreach ($jammeur['Email'] as $email) {
				$addresses[]=$email['email'];	
			}
		}
		
		$folders=array_diff(scandir($current_path), array('..', '.'));
		$mails=array();
		foreach ($folders as $folder) {
			$folderMails=array_diff(scandir($current_path."/".$folder."/"), array('..', '.'));
			foreach ($folderMails as $key=>$folderMail) {
				$folderMails[$key]=$folder."/".$folderMail;
			}
			$mails=array_merge($mails,$folderMails);
			mkdir ($new_path.$folder);
		}
		foreach($mails as $mail){
		set_time_limit (30);
		try
  			{
			$content=file_get_contents($current_path.$mail);
			if(!is_null($content)){
			
				$tmpMessage=$this->Parser->parse($content,$addresses);
			
				if(!is_null($tmpMessage['email']) && !is_null($tmpMessage['dateTime']) && !is_null($tmpMessage['html'])){
								
					//ENTER MESSAGE IN DB
					$message=$this->Message->create();
					$email=$this->Email->find('first',array(
							'conditions'=>array('Email.email'=>$tmpMessage['email']
					)));
					$message['Message']['jammeur_id']=$email['Email']['jammeur_id'];
					$message['Message']['timestamp']=$tmpMessage['dateTime']; 
					$message['Message']['html']=$tmpMessage['html'];
					$message['Message']['father_html']=$tmpMessage['father_html'];
					$message=$this->Message->save($message);
					
					
					//SET KEYWORDS
					$keywords=$this->Keyword->find('all');
					foreach ($keywords as $keyword) {
						if (stripos($tmpMessage['html'],$keyword['Keyword']['keyword']) != false) {
						    $match=$this->KeywordsMessage->create();
							$match['KeywordsMessage']['message_id']=$message['Message']['id'];
							$match['KeywordsMessage']['keyword_id']=$keyword['Keyword']['id'];
							$this->KeywordsMessage->save($match);
						}
					}
					
					
					rename($current_path.$mail, $new_path.$mail);
				}
			
			}
			
		}
		catch(Exception $e)
		  {
		  echo 'Mail "'.$mail.'" could not be imported due to '.$e->getMessage();
		  }
		}
		
	}
	
	function import($id){
		$this->set('id',$id);			
		$current_path='C:/xampp/htdocs/github/jamsession/mails/new/';
		//$current_path='/home/import/Maildir/new/';
		
		$jammeurs=$this->Jammeur->find('all');			
		foreach ($jammeurs as $jammeur) {
			foreach ($jammeur['Email'] as $email) {
				$addresses[]=$email['email'];	
			}
		}

		
		$folders=array_diff(scandir($current_path), array('..'));
		$mails=array();
		foreach ($folders as $folder) {
			$mails=array_merge(array_diff(scandir($current_path."/".$folder."/"), array('..', '.')),$mails);
		}

		$this->set('count',count($mails));
		
		$mail=$mails[2+$id];

		set_time_limit (120);

		$content=file_get_contents($current_path.$mail);
		if(!is_null($content)){		
			$tmpMessage=$this->Parser->parse($content,$addresses);
			$tmpMessage['filename']=$mail;

			$this->set('tmpMessage',$tmpMessage);
			}

	}

	function manualImportSave(){
		
		$response = false;
		$this->layout = 'ajax';
		if(!empty($this->data)){
		$tmpMessage=json_decode($this->data,true);

		if(!is_null($tmpMessage['email']) && !is_null($tmpMessage['dateTime']) && !is_null($tmpMessage['html'])){

		//ENTER MESSAGE IN DB
		$message=$this->Message->create();
		$email=$this->Email->find('first',array(
						'conditions'=>array('Email.email'=>$tmpMessage['email']
				)));
		$message['Message']['jammeur_id']=$email['Email']['jammeur_id'];
		$message['Message']['timestamp']=$tmpMessage['dateTime']; 
		$message['Message']['html']=$tmpMessage['html'];
		$message['Message']['father_html']=$tmpMessage['father_html'];
		
		$response=$message=$this->Message->save($message);
		
		
		//SET KEYWORDS
		$keywords=$this->Keyword->find('all');
		foreach ($keywords as $keyword) {
			if (stripos($tmpMessage['html'],$keyword['Keyword']['keyword']) != false) {
			    $match=$this->KeywordsMessage->create();
				$match['KeywordsMessage']['message_id']=$message['Message']['id'];
				$match['KeywordsMessage']['keyword_id']=$keyword['Keyword']['id'];
				$this->KeywordsMessage->save($match);
			}
		}

		$current_path='C:/xampp/htdocs/github/jamsession/mails/new/';
		$new_path='C:/xampp/htdocs/github/jamsession/mails/parsed/';
		//$new_path='/home/import/Maildir/parsed/';
		rename($current_path.$tmpMessage['filename'], $new_path.$tmpMessage['filename']);
		}

		}
		echo json_encode($response);
	}

	function setFathers(){
		set_time_limit (300);
		$messages=$this->Message->find('all');
		foreach ($messages as $message) {
			$father=$this->Father->findByChildren_id($message['Message']['id']);
				if ($message['Message']['father_html']!="" && !$father) {
					echo "Message ".$message['Message']['id']." does not have father. Looking for : '".substr($message['Message']['father_html'],0,10)."'</br>";
					$match=$this->Message->find('first',array('conditions'=>array(
					'Message.html LIKE'=>substr($message['Message']['father_html'],0,10).'%',
					'Message.timestamp <= '=>  $message['Message']['timestamp'],
					'Message.timestamp >= '=>  date('Y-m-d H:i:s',strtotime($message['Message']['timestamp']." -30days"))
					),
					'order'=>'Message.timestamp DESC'
					));
					if($match){
						echo "Father Found ! Message is :'".$match['Message']['html']."'</br></br>";
						$child=$this->Father->create();
						$child['Father']['father_id']=$match['Message']['id'];
						$child['Father']['children_id']=$message['Message']['id'];
						$this->Father->save($child);
						// Clean 'Father field'
						$message['Message']['father_html']="";
						$this->Message->save($message);
					}
					else{
						echo "No Father Found...</br></br>";
					}
			}
			
		}	
	}
}
?>